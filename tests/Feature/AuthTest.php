<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_auth_pages(): void
    {
        $this->get('/login')->assertStatus(200);
        $this->get('/register')->assertStatus(200);
        $this->get('/forgot-password')->assertStatus(200);
    }

    public function test_customer_can_register_and_role_is_forced(): void
    {
        $response = $this->post('/register', [
            'name' => 'Pelanggan Baru',
            'email' => 'baru@example.com',
            'phone' => '08123456789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $response->assertRedirect('/account');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'baru@example.com',
            'role' => 'customer',
            'phone' => '08123456789',
        ]);
    }

    public function test_customer_can_login_and_open_account_but_not_admin(): void
    {
        User::factory()->create([
            'email' => 'coba@example.com',
            'password' => 'password123',
            'role' => 'customer',
        ]);

        $this->post('/login', [
            'email' => 'coba@example.com',
            'password' => 'password123',
        ])->assertRedirect('/account');

        $this->get('/account')->assertStatus(200);
        $this->get('/account/profile')->assertStatus(200);
        $this->get('/admin')->assertStatus(403);
    }

    public function test_admin_can_open_admin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get('/admin')->assertStatus(200);
    }

    public function test_admin_login_redirects_straight_to_dashboard(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        $this->post('/login', [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ])->assertRedirect('/admin');

        $this->get('/admin')->assertStatus(200)->assertSee('Keluar akun', false);
    }

    public function test_guest_cannot_open_account(): void
    {
        $this->get('/account')->assertRedirect('/login');
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_profile_update_cannot_change_role(): void
    {
        $user = User::factory()->create(['role' => 'customer']);

        $this->actingAs($user)->patch('/account/profile', [
            'name' => 'Nama Baru',
            'email' => 'baru2@example.com',
            'phone' => '0899999999',
            'role' => 'admin',
        ])->assertRedirect('/account/profile');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Baru',
            'role' => 'customer',
        ]);
    }
}
