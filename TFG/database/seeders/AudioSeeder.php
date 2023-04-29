<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Audio;

class AudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $audios = [
            [
                'obra' => 'Cantata de Santa María de Iquique',
                'duracion' => 120,
                'interprete' => 'Quilapayún',
                'audio' => 'https://ejemplo.com/audio1.mp3',
                'partitura_id' => 1
            ],
            [
                'obra' => 'La Llorona',
                'duracion' => 90,
                'interprete' => 'Chavela Vargas',
                'audio' => 'https://ejemplo.com/audio2.mp3',
                'partitura_id' => 2
            ],
            
        ];

        foreach ($audios as $audio) {
            Audio::factory()->create($audio);
        }
    }
}
