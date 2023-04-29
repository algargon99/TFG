<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cantor;

class CantorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cantor::factory()->count(10)->create();
    }
}
