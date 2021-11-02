<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'chat_id' => rand(1,Chat::count()),
            'user_id' => rand(1,User::count()),

        ];
    }
}
