<?php

use Illuminate\Database\Seeder;
use App\Models\Coro;

class CoroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear 10 coros de ejemplo
        Coro::factory()->count(10)->create();
    }
}
