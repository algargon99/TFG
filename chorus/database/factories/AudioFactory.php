<?php

namespace Database\Factories;

use App\Models\Audio;
use Illuminate\Database\Eloquent\Factories\Factory;

class AudioFactory extends Factory
{
    protected $model = Audio::class;

    public function definition()
    {
        return [
            'obra' => $this->faker->sentence(3),
            'duracion' => $this->faker->numberBetween(60, 600),
            'voz' => $this->faker->randomElement(['Soprano', 'Contralto', 'Tenor', 'Bajo']),
            'interprete' => $this->faker->name,
            'audio' => 'audio/ejemplo.mp3',
            'idPartitura' => $this
        ];
    }
}
