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
        // Obtener una colección de todas las partituras existentes
        $partituras = Partitura::all();

        // Definir un array con los datos de ejemplo de los videos
        $videos = [
            [
                'nombre' => 'Agnus Dei',
                'interprete' => 'Michael W. Smith',
                'year' => 1990,
                'video' => 'https://www.youtube.com/watch?v=PNPj2r2Ct0Y',
            ],
            [
                'nombre' => 'Cristo yo te amo',
                'interprete' => 'En Espíritu y en Verdad',
                'year' => 2012,
                'video' => 'https://www.youtube.com/watch?v=JET7RzydRFQ',
            ],
            [
                'nombre' => 'Aleluya',
                'interprete' => 'Leonard Cohen',
                'year' => 1984,
                'video' => 'https://www.youtube.com/watch?v=ttEMYvpoR-k',
            ],
        ];

        // Recorrer los datos y crear un video para cada uno, asignando una partitura aleatoria
        foreach ($videos as $videoData) {
            $partitura = $partituras->random();
            $video = new Video($videoData);
            $video->partitura()->associate($partitura);
            $video->save();
        }
    }
}
