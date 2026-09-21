<?php

namespace Tests\Feature;

use App\Models\Barber;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\NirwanaSampleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private function openDate(): string
    {
        $day = Carbon::tomorrow();
        while ((int) $day->format('w') === 0) {
            $day->addDay();
        }

        return $day->format('Y-m-d');
    }

    public function test_guest_can_view_booking_but_cannot_store(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $this->get('/booking')->assertStatus(200);
        $this->post('/bookings', [])->assertRedirect('/login');
    }

    public function test_availability_returns_slots(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $service = Service::where('slug', 'classic-haircut-sample')->firstOrFail();
        $barber = Barber::where('slug', 'arya-sample')->firstOrFail();

        $res = $this->postJson('/booking/availability', [
            'service_id' => $service->id,
            'barber_id' => $barber->id,
            'date' => $this->openDate(),
        ]);

        $res->assertStatus(200)->assertJsonStructure(['slots']);
        $this->assertNotEmpty($res->json('slots'));
    }

    public function test_customer_can_create_booking_and_duplicate_rejected(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $user = User::factory()->create(['role' => 'customer']);
        $other = User::factory()->create(['role' => 'customer']);
        $service = Service::where('slug', 'classic-haircut-sample')->firstOrFail();
        $barber = Barber::where('slug', 'arya-sample')->firstOrFail();
        $date = $this->openDate();

        $payload = [
            'service_id' => $service->id,
            'barber_id' => $barber->id,
            'date' => $date,
            'start' => '10:00',
            'notes' => 'Tolong rapi.',
        ];

        $res = $this->actingAs($user)->post('/bookings', $payload);
        $res->assertStatus(302);
        $this->assertStringStartsWith(url('/booking/confirmation?reference=NG-'), $res->headers->get('Location'));
        $this->assertDatabaseCount('bookings', 1);

        // Bentrok: overlap 10:00 sampai 10:45 dengan 10:30.
        $this->actingAs($other)->post('/bookings', [
            'service_id' => $service->id,
            'barber_id' => $barber->id,
            'date' => $date,
            'start' => '10:30',
        ])->assertSessionHasErrors('start');
        $this->assertDatabaseCount('bookings', 1);
    }

    public function test_any_barber_assigns_free_barber(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $user = User::factory()->create(['role' => 'customer']);
        $service = Service::where('slug', 'classic-haircut-sample')->firstOrFail();

        $res = $this->actingAs($user)->post('/bookings', [
            'service_id' => $service->id,
            'barber_id' => null,
            'date' => $this->openDate(),
            'start' => '11:00',
        ]);
        $res->assertStatus(302);
        $this->assertStringStartsWith(url('/booking/confirmation?reference=NG-'), $res->headers->get('Location'));

        $booking = Booking::first();
        $this->assertNotNull($booking->barber_id);
        $this->assertEquals('pending', $booking->status);
        $this->assertStringStartsWith('NG-', $booking->reference);
    }

    public function test_appointments_scoped_to_owner_and_cancel_rules(): void
    {
        $this->seed(NirwanaSampleSeeder::class);
        $user = User::factory()->create(['role' => 'customer']);
        $other = User::factory()->create(['role' => 'customer']);
        $service = Service::where('slug', 'classic-haircut-sample')->firstOrFail();
        $barber = Barber::where('slug', 'arya-sample')->firstOrFail();
        $date = $this->openDate();

        $mine = Booking::create([
            'reference' => Booking::makeReference(),
            'user_id' => $user->id,
            'service_id' => $service->id,
            'barber_id' => $barber->id,
            'appointment_date' => $date,
            'start_time' => '13:00:00',
            'end_time' => '13:45:00',
            'status' => 'pending',
        ]);

        $done = Booking::create([
            'reference' => Booking::makeReference(),
            'user_id' => $user->id,
            'service_id' => $service->id,
            'barber_id' => $barber->id,
            'appointment_date' => Carbon::yesterday()->format('Y-m-d'),
            'start_time' => '10:00:00',
            'end_time' => '10:45:00',
            'status' => 'completed',
        ]);

        $this->actingAs($user)->get('/account/appointments')->assertStatus(200)->assertSee($mine->reference);
        $this->actingAs($other)->get('/account/appointments')->assertStatus(200)->assertDontSee($mine->reference);

        // Konfirmasi milik orang lain 404.
        $this->actingAs($other)->get('/booking/confirmation?reference='.$mine->reference)->assertStatus(404);

        // Batal milik sendiri berhasil.
        $this->actingAs($user)->patch("/account/appointments/{$mine->id}/cancel")->assertRedirect('/account/appointments');
        $this->assertEquals('cancelled', $mine->fresh()->status);

        // Completed tidak bisa batal.
        $this->actingAs($user)->patch("/account/appointments/{$done->id}/cancel")->assertSessionHasErrors('booking');

        // Batal milik orang lain 404.
        $this->actingAs($other)->patch("/account/appointments/{$mine->id}/cancel")->assertStatus(404);
    }
}
