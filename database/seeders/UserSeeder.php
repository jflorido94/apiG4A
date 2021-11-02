<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->hasWallet()->create([
            'nick' => 'jflorido94',
            'name' => 'Javier',
            'surnames' => 'Florido Pavon',
            'is_admin' => true,
            'email' => 'jflorido94@hotmail.com',
        ]);
        User::factory(20)
            ->hasWallet()
            ->create();
    }
}
