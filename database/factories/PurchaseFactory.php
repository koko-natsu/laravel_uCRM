<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $created_at = $this->faker->dateTimeThisDecade('+2 years');

        return [
            'customer_id' => rand(1, Customer::count()),
            'status'      => $this->faker->boolean,
            'created_at'  => $created_at,
        ];
    }
}