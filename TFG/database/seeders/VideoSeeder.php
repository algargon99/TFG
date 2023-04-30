<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Video;
use App\Models\Partitura;

class VideoSeeder extends Seeder
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
            Video::factory()->count(3)->create([
                "idPartitura"=> $partitura
            ]);
        }
    }
}
