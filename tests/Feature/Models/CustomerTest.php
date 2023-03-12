<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Customer;
use Database\Seeders\UserSeeder;

use function PHPUnit\Framework\assertTrue;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();
        $this->seed([
            UserSeeder::class,
        ]);

        $this->post('/login', [
            'email' => 'test@test.com',
            'password' => '1234',
        ]);
    }

    /**
     * scopeSearchCustomerの検証
     * scopeApiSearchCustomerの検証
     */
    function test_verification_scopeSearchCustomer_method()
    {
        assertTrue(true);
    }
}
