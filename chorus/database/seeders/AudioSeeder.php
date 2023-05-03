<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Audio;
use App\Models\Partitura;

class AudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $partituras = Partitura::all();

        foreach ($partituras as $partitura) {
            Audio::factory()->count(3)->create([
                "idPartitura"=> $partitura
            ]);
        }
    }
}
