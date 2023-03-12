<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\UserSeeder;
use Database\Seeders\ItemSeeder;
use App\Models\Item;

use function PHPUnit\Framework\assertTrue;

class ItemControllerTest extends TestCase
{

    use RefreshDatabase;

    public function setUp() :void
    {
        parent::setUp();
        $this->seed([
            UserSeeder::class,
            ItemSeeder::class,
        ]);

        $this->post('/login', [
            'email' => 'test@test.com',
            'password' => '1234',
        ]);
    }


    /**
     * Index
     * Items/Indexの取得
     */
    function test_get_items_index()
    {
        $this->get('items')
            ->assertOk();

        $this->assertDatabaseCount('items', 3);
    }

    function test_not_get_index_page_by_unlogged_in_user()
    {
        $this->post('logout');
        $this->assertGuest();

        $response = $this->get('customers');
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }


    /**
     * Create
     * Items/Createの取得
     */
    function test_get_items_create()
    {
        $this->get('items/create')
            ->assertOk();
    }

    function test_not_get_create_page_by_unlogged_in_user()
    {
        $this->post('logout');
        $this->assertGuest();

        $response = $this->get('items/create');
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    /**
     * Store
     * ValidDataでのItemの登録
     * InvalidDataでのItemの登録(入力必須)
     * InvalidDataでのItemの登録(入力最大値)
     * NotLoggedUserでのItemの登録
     */
    function test_valid_item()
    {
       $response = $this->post('items', [
        'name' => 'Okinawa',
        'memo' => 'Trip',
        'price' => '300000',
        'is_selling' => 1,
       ]);

       $response->assertValid();
       $this->assertDatabaseCount('items', 4);
    }

    function test_invalid_item_of_required()
    {
       $response = $this->post('items', [
        'name' => '',
        'memo' => '',
        'price' => '',
        'is_selling' => 1,
       ]);

        $response->assertInvalid([
            'name' =>  '名は必ず入力してください。',
            'memo' =>  'メモは必ず入力してください。',
            'price' => '価格は必ず入力してください。',
        ]);
    }

    function test_invalid_item_of_maximum_value()
    {
       $response = $this->post('items', [
        'name' => str_repeat('a', 51),
        'memo' => str_repeat('a', 256),
        'price' => 1000,
        'is_selling' => 1,
       ]);

        $response->assertInvalid([
            'name' =>  '名は、50文字以下で指定してください。',
            'memo' =>  'メモは、255文字以下で指定してください。',
        ]);
    }

    function test_registration_by_not_logged_in_user()
    {
        $this->assertAuthenticated();
        $this->post('logout');
        $this->assertGuest();

        $this->post('items', [
            'name' => 'Okinawa',
            'memo' => 'Trip',
            'price' => '300000',
            'is_selling' => 1,
        ]);

        $this->assertDatabaseCount('items', 3);
    }

    /**
     * Show
     * Items/Showの取得
     */
    function test_get_items_show_page()
    {
        $item = Item::find(1);
        $this->get("items/{$item->id}")
            ->assertOk();
    }

    function test_not_get_show_page_by_unlogged_in_user()
    {
        $this->post('logout');
        $this->assertGuest();

        $response = $this->get('items/1');
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

     /**
      * Edit
      * Items/Editの取得
      */
    function test_get_items_edit_page()
    {
        $item = Item::find(1);
        $this->get("items/{$item->id}/edit")
            ->assertOk();
    }

    function test_not_get_edit_page_by_unlogged_in_user()
    {
        $this->post('logout');
        $this->assertGuest();

        $response = $this->get('items/1/edit');
        $response->assertStatus(302);
        $response->assertRedirect('login');
    }

    /**
     * Update
     * ValidDataでのItemの登録
     * InvalidDataでのItemの登録(入力必須)
     * InvalidDataでのItemの登録(入力最大値)
     * NotLoggedUserでのItemの登録
     */
    function test_update_valid_item()
    {
        $item = Item::find(1);
        assertTrue($item->name === 'カット');
        
        $response = $this->put("items/{$item->id}", [
            'name' => 'Okinawa',
            'memo' => 'Trip',
            'price' => '300000',
            'is_selling' => 1,
        ]);

        $response->assertValid();
        $updated_item = Item::find(1);
        assertTrue($updated_item->name === 'Okinawa');
    }

    function test_non_update_invalid_item_of_required()
    {
        $item = Item::find(1);

        $response = $this->put("items/{$item->id}", [
            'name' => '',
            'memo' => '',
            'price' => '',
            'is_selling' => 1,
        ]);

        $response->assertInvalid([
            'name' =>  '名は必ず入力してください。',
            'memo' =>  'メモは必ず入力してください。',
            'price' => '価格は必ず入力してください。',
        ]);
    }

    function test_non_update_invalid_item_of_maximum_value()
    {
        $item = Item::find(1);

        $response = $this->put("items/{$item->id}", [
            'name' => str_repeat('a', 51),
            'memo' => str_repeat('a', 256),
            'price' => 1000,
            'is_selling' => 1,
        ]);

        $response->assertInvalid([
            'name' =>  '名は、50文字以下で指定してください。',
            'memo' =>  'メモは、255文字以下で指定してください。',
        ]);
    }

    function test_updating_by_not_logged_in_user()
    {
        $this->post('logout');
        $this->assertGuest();

        $item = Item::find(1);

        $this->put("items/{$item->id}", [
            'name' => 'Okinawa',
            'memo' => 'Trip',
            'price' => '300000',
            'is_selling' => 1,
        ]);

        $this->assertDatabaseCount('items', 3);
    }

    /**
     * Destroy
     * Itemの削除
     * NotLoggedUserでのItemの削除
     */
    function test_delete_anItem()
    {
        $this->assertDatabaseCount('items', 3);
        $this->delete("items/1");
        $this->assertDatabaseCount('items', 2);
    }

    function test_not_delete_by_logged_in_user()
    {
        $this->assertAuthenticated();
        $this->post('logout');
        $this->assertGuest();
        
        $this->assertDatabaseCount('items', 3);
        $this->delete("items/1");
        $this->assertDatabaseCount('items', 3);
    }
}
