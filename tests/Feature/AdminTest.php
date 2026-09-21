<?php

namespace Tests\Feature;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\NirwanaSampleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    public function test_customer_cannot_access_admin(): void
    {
        $this->seed(NirwanaSampleSeeder::class);

        // Guest dulu sebelum actingAs menempel ke request berikutnya.
        $this->get('/admin')->assertRedirect('/login');

        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer)->get('/admin')->assertStatus(403);
        $this->actingAs($customer)->get('/admin/services')->assertStatus(403);
        $this->actingAs($customer)->get('/admin/bookings')->assertStatus(403);
    }

    public function test_admin_dashboard_loads(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $this->actingAs($this->admin())->get('/admin')->assertStatus(200)->assertSee('Dashboard');
    }

    public function test_admin_can_crud_service(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/services', [
            'name' => 'Layanan Tes',
            'price' => 60000,
            'duration_minutes' => 40,
            'is_active' => '1',
        ])->assertRedirect('/admin/services');

        $service = Service::where('name', 'Layanan Tes')->firstOrFail();
        $this->assertEquals('layanan-tes', $service->slug);

        $this->actingAs($admin)->patch('/admin/services/'.$service->id, [
            'name' => 'Layanan Tes',
            'price' => 65000,
            'duration_minutes' => 40,
            'is_active' => '1',
        ])->assertRedirect('/admin/services');

        $this->assertEquals(65000, $service->fresh()->price);
    }

    public function test_admin_can_update_product_stock(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $admin = $this->admin();
        $product = Product::where('slug', 'pomade-classic-sample')->firstOrFail();

        $this->actingAs($admin)->patch('/admin/products/'.$product->id, [
            'name' => $product->name,
            'price' => $product->price,
            'stock' => 25,
            'is_active' => '1',
        ])->assertRedirect('/admin/products');

        $this->assertEquals(25, $product->fresh()->stock);
    }

    public function test_admin_booking_transitions_validated(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $admin = $this->admin();
        $customer = User::factory()->create(['role' => 'customer']);
        $service = Service::firstOrFail();
        $barber = Barber::firstOrFail();

        $booking = Booking::create([
            'reference' => Booking::makeReference(),
            'user_id' => $customer->id,
            'service_id' => $service->id,
            'barber_id' => $barber->id,
            'appointment_date' => date('Y-m-d', strtotime('+2 days')),
            'start_time' => '10:00:00',
            'end_time' => '10:45:00',
            'status' => 'pending',
        ]);

        // Langsung ke completed ditolak.
        $this->actingAs($admin)->patch('/admin/bookings/'.$booking->id.'/status', [
            'status' => 'completed',
        ])->assertSessionHasErrors('status');

        $this->actingAs($admin)->patch('/admin/bookings/'.$booking->id.'/status', [
            'status' => 'confirmed',
        ])->assertRedirect('/admin/bookings/'.$booking->id);

        $this->assertEquals('confirmed', $booking->fresh()->status);
    }

    public function test_admin_order_transitions_validated(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $admin = $this->admin();
        $customer = User::factory()->create(['role' => 'customer']);

        $order = Order::create([
            'reference' => Order::makeReference(),
            'user_id' => $customer->id,
            'subtotal' => 85000,
            'shipping_fee' => 0,
            'total' => 85000,
            'fulfillment' => 'pickup',
            'payment_method' => 'qris',
            'payment_status' => 'pending',
            'status' => 'pending',
            'customer_name' => 'Tes',
            'customer_phone' => '081111',
        ]);

        $this->actingAs($admin)->patch('/admin/orders/'.$order->id.'/status', [
            'status' => 'ready',
        ])->assertSessionHasErrors('status');

        $this->actingAs($admin)->patch('/admin/orders/'.$order->id.'/status', [
            'status' => 'confirmed',
            'payment_status' => 'paid',
        ])->assertRedirect('/admin/orders/'.$order->id);

        $fresh = $order->fresh();
        $this->assertEquals('confirmed', $fresh->status);
        $this->assertEquals('paid', $fresh->payment_status);
    }
}
