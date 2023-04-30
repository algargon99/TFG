<?php

namespace Database\Seeders;

use App\Models\Partitura;
use App\Models\Coro;
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
        for ($i=0; $i < 10; $i++) { 
            Partitura::factory()->count(10)->create([
                "idCoro"=> Coro::factory()->create(),
            ]);    
        }
        
    }
}
