<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Item;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ItemSeeder::class,
            RankSeeder::class,
        ]);

        Customer::factory(1000)->create();

        $items = Item::all();

        Purchase::factory(30000)->create()
        ->each(function(Purchase $purchase) use ($items) {
           $purchase->items()->attach(
            $items->random(rand(1,3))->pluck('id')->toArray(),
            /* random(rand(1,3))は1-3のどれかではなく、1-3個摘出する */
            /* > $items->random(rand(1,3))->pluck('id')->toArray();
                = [ 
                    1,
                    3,
                ] */
            ['quantity' => rand(1,5)],
           );
        });
    }
}
