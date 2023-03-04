<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\UserSeeder;

class ExampleTest extends TestCase
{
    // use RefreshDatabase;


    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_user()
    {
        $this->seed(UserSeeder::class);
        $this->assertDatabaseCount('users', 1);
    }
}
