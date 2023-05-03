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
            'obra' => $this->faker->sentence,
            'duracion' => $this->faker->numberBetween(60, 600),
            'interprete' => $this->faker->name,
            'audio' => 'https://example.com/audio.mp3',
            'idPartitura' => $this
        ];
    }
}
