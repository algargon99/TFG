<?php

namespace Database\Seeders;

use App\Models\Partitura;
use Illuminate\Database\Seeder;

class PartituraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partitura::factory()->count(50)->create();
    }
}
