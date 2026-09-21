<?php

namespace Tests\Feature;

use Database\Seeders\NirwanaSampleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $this->seed(NirwanaSampleSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_nav_marks_current_page_as_active(): void
    {
        $this->seed(NirwanaSampleSeeder::class);

        $this->get('/services')->assertStatus(200)->assertSee('aria-current="page"', false);
        $this->get('/')->assertStatus(200)->assertSee('aria-current="page"', false);
        $this->get('/')->assertStatus(200)->assertSee('aria-label="Navigasi bawah"', false);
    }
}
