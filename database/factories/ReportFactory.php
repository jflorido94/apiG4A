<?php

namespace Database\Factories;

use App\Models\BanReason;
use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Report::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'request'=>$this->faker->text(),
            'respond'=>$this->faker->optional()->sentence(),
            'is_warning'=>$this->faker->boolean(25),

            'user_id' => rand(1,User::count()),
            'ban_reason_id' => rand(1,BanReason::count()),

            'reportable_id'=>rand(1,10),
            'reportable_type'=>$this->faker->randomElement(['App\Models\Transaction', 'App\Models\Product']),


        ];
    }
}
