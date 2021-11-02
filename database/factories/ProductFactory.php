<?php

namespace Database\Factories;

use App\Models\Condition;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'=> $this->faker->sentence(),
            'description'=> $this->faker->text(),
            'image'=> $this->faker->imageUrl(640,480,'technics'),
            'price'=> $this->faker->randomFloat(2,0,1000),

            'user_id' => rand(1,User::count()),
            'condition_id' => rand(1,Condition::count()),

        ];
    }
}
