<?php

namespace Database\Factories;

use App\Models\Partitura;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    protected $model = Video::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->sentence(3),
            'interprete' => $this->faker->name(),
            'year' => $this->faker->year(),
            'video' => $this->faker->imageUrl(),
            'idPartitura' => $this
        ];
    }
}
