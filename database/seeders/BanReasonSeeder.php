<?php

namespace Database\Seeders;

use App\Models\BanReason;
use Illuminate\Database\Seeder;

class BanReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BanReason::factory(10)->create();
    }
}
