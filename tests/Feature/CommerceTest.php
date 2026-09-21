<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\NirwanaSampleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommerceTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_cart_or_checkout(): void
    {
        $this->get('/cart')->assertRedirect('/login');
        $this->get('/checkout')->assertRedirect('/login');
        $this->post('/cart/items', [])->assertRedirect('/login');
    }

    public function test_add_to_cart_and_totals(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $user = User::factory()->create(['role' => 'customer']);
        $pomade = Product::where('slug', 'pomade-classic-sample')->firstOrFail();

        $this->actingAs($user)->post('/cart/items', [
            'product_id' => $pomade->id,
            'quantity' => 2,
        ])->assertRedirect('/cart');

        $this->actingAs($user)->get('/cart')->assertStatus(200)->assertSee('Rp 170.000');
        $this->assertDatabaseHas('cart_items', [
            'user_id' => $user->id,
            'product_id' => $pomade->id,
            'quantity' => 2,
        ]);
    }

    public function test_reject_over_stock_and_inactive(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $user = User::factory()->create(['role' => 'customer']);
        $oil = Product::where('slug', 'beard-oil-sample')->firstOrFail();
        $clay = Product::where('slug', 'clay-matte-sample')->firstOrFail();

        $this->actingAs($user)->post('/cart/items', [
            'product_id' => $oil->id,
            'quantity' => 5,
        ])->assertSessionHasErrors('product');

        $this->actingAs($user)->post('/cart/items', [
            'product_id' => $clay->id,
            'quantity' => 1,
        ])->assertSessionHasErrors('product');

        $this->assertDatabaseCount('cart_items', 0);
    }

    public function test_checkout_creates_snapshot_reduces_stock_clears_cart(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $user = User::factory()->create(['role' => 'customer']);
        $pomade = Product::where('slug', 'pomade-classic-sample')->firstOrFail();
        $oil = Product::where('slug', 'beard-oil-sample')->firstOrFail();

        $this->actingAs($user)->post('/cart/items', ['product_id' => $pomade->id, 'quantity' => 1]);
        $this->actingAs($user)->post('/cart/items', ['product_id' => $oil->id, 'quantity' => 2]);

        $res = $this->actingAs($user)->post('/checkout', [
            'customer_name' => 'Pembeli',
            'customer_phone' => '0811111111',
            'fulfillment' => 'pickup',
            'payment_method' => 'qris',
        ]);
        $res->assertStatus(302);
        $this->assertStringStartsWith(url('/checkout/success?reference=NO-'), $res->headers->get('Location'));

        $order = Order::with('items')->firstOrFail();
        $this->assertEquals(85000 + 2 * 95000, $order->subtotal);
        $this->assertEquals(0, $order->shipping_fee);
        $this->assertEquals($order->subtotal, $order->total);
        $this->assertEquals('pending', $order->status);
        $this->assertCount(2, $order->items);

        // Snapshot tetap walau produk berubah setelahnya.
        $pomade->update(['name' => 'Pomade Ganti', 'price' => 1]);
        $this->assertEquals('Pomade Classic (SAMPLE)', $order->items->firstWhere('product_id', $pomade->id)->product_name_snapshot);
        $this->assertEquals(85000, $order->items->firstWhere('product_id', $pomade->id)->unit_price);

        // Stock berkurang atomically: 12-1 dan 2-2.
        $this->assertEquals(11, $pomade->fresh()->stock);
        $this->assertEquals(0, $oil->fresh()->stock);

        // Cart bersih.
        $this->assertDatabaseCount('cart_items', 0);

        // Owner bisa lihat, orang lain 404.
        $this->actingAs($user)->get('/account/orders')->assertStatus(200)->assertSee($order->reference);
        $this->actingAs($user)->get('/account/orders/'.$order->id)->assertStatus(200);
        $other = User::factory()->create(['role' => 'customer']);
        $this->actingAs($other)->get('/account/orders/'.$order->id)->assertStatus(404);
    }

    public function test_delivery_requires_address_and_fee(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $user = User::factory()->create(['role' => 'customer']);
        $pomade = Product::where('slug', 'pomade-classic-sample')->firstOrFail();

        $this->actingAs($user)->post('/cart/items', ['product_id' => $pomade->id, 'quantity' => 1]);

        $this->actingAs($user)->post('/checkout', [
            'customer_name' => 'Pembeli',
            'customer_phone' => '0811111111',
            'fulfillment' => 'delivery',
            'shipping_address' => null,
            'payment_method' => 'transfer',
        ])->assertSessionHasErrors('shipping_address');

        $this->actingAs($user)->post('/checkout', [
            'customer_name' => 'Pembeli',
            'customer_phone' => '0811111111',
            'fulfillment' => 'delivery',
            'shipping_address' => 'Jl. Contoh 1',
            'payment_method' => 'transfer',
        ])->assertStatus(302);

        $order = Order::firstOrFail();
        $this->assertEquals(15000, $order->shipping_fee);
        $this->assertEquals($order->subtotal + 15000, $order->total);
    }
}
