<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\UserSeeder;
use App\Models\Customer;
use Database\Seeders\CustomerSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Session;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    function setUp() :void
    {
        parent::setUp();

        $this->seed([
            UserSeeder::class,
        ]);

        $this->post('/login', [
            'email' => 'test@test.com',
            'password' => '1234',
        ]);

        // Customer::factory(10)->create();
    }
    
    /**
     * Index
     * Customer/Indexの取得
     */
    function testGetCustomerIndex()
    {
        Customer::factory(10)->create();

        $this->get('customers')
            ->assertOk();


        list($query, $result) = Customer::searchCustomer(0);
        assertEquals(10, $query->count());
        assertFalse($result);


        $customer = Customer::first();
        $uri = "api/searchCustomers?search={$customer->tel}";

        $this->getJson($uri)
            ->assertStatus(200)
            ->assertJsonPath('data.data.0.name', $customer->name);
    }


    /**
     * Create
     * Customer/Createの取得
     */
    function test_get_customer_create_page()
    {
        $this->get('customers/create')
            ->assertOk();
    }

    /**
     * Store
     * 新規Customerの登録
     * redirectの確認(エラーメッセージの確認)
     */
    function test_register_new_customer()
    {
        $this->get('customers/create')
            ->assertOk();

        $response = $this->post('customers', [
            'name' => "試験タロウ",
            'kana' => "テストタロウ",
            'tel' => "09012345678",
            'email' => "testtaro@test.com",
            'postcode' => "1234567",
            'address' => "東京都テスト区テスト市",
            'birthday' => "2011-12-8",
            'gender' => 1,
            'memo' => ""
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('status', 'success');
        
        $response->assertStatus(302);
        $response->assertRedirect('customers');
    
        $this->assertDatabaseCount('customers', 1);
    }

    /**
     * Show
     * Customer/Showの取得
     * 存在しないCustomerIdをリクエストした際の検証
     */
    function test_get_customers_show()
    {
        Customer::factory(1)->create();

        $this->get('customers/1')
            ->assertOk();
    }


    /**
     * Edit
     * Customer/Editの取得
     * 存在しないCustomerIdをリクエストした際の検証
     */

    /**
     * Update
     * Updateの検証
     * validationの確認
     */

    /**
     * Destroy
     * Customerの削除
     */

     /**
      * UnLoggedInUserの検証
      */
      function test_verification_of_unlogged_in_users()
    {
        $this->assertAuthenticated();
        $this->post('logout');
        $this->assertGuest();

        // Index
        $this->get('customers')
            ->assertRedirect('login');

        // Create
        $this->get('customers/create')
            ->assertRedirect('login');

        // Store
        $response = $this->post('customers', [
            'name' => "試験タロウ",
            'kana' => "テストタロウ",
            'tel' => "09012345678",
            'email' => "testtaro@test.com",
            'postcode' => "1234567",
            'address' => "東京都テスト区テスト市",
            'birthday' => "2011-12-8",
            'gender' => 1,
            'memo' => ""
        ]);

        $this->assertDatabaseCount('customers', 0);
        $response->assertStatus(302);
        $response->assertRedirect('login');

        // Show
        Customer::factory(1)->create();

        $this->get('customers/1')
            ->assertRedirect('login');

        // Edit
        $this->get('customers/1/edit')
            ->assertRedirect('login');

        // Update
        $response = $this->put('customers/1', [
            'name' => '試験次郎'
        ]);

        $response->assertRedirect('login');

        // Destroy
        $response = $this->delete('customers/1');

        $response->assertRedirect('login');
        $this->assertDatabaseCount('customers', 1);
    }
}
