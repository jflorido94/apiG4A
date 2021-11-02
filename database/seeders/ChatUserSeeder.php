<?php

namespace Database\Seeders;

use Database\Factories\ChatUserFactory;
use Illuminate\Database\Seeder;

class ChatUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ChatUserFactory::factory(75)->create();
    }
}
