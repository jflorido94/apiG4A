<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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

            ConditionSeeder::class,
            ProductSeeder::class,

            StateSeeder::class,
            TransactionSeeder::class,
            ReviewSeeder::class,

            BanReasonSeeder::class,
            ReportSeeder::class,

            // ChatSeeder::class,
            // ChatUserSeeder::class,
            // MessageSeeder::class,

        ]);
    }
}
