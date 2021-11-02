<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\State;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount'=> $this->faker->randomFloat(2,0,1000),

            'user_id' => rand(1,User::count()),
            'product_id' =>$this->faker->unique()->numberBetween(1,Product::count()),
            'state_id' => rand(1,State::count()),

        ];
    }
}
