<?php

namespace Database\Factories;

use App\Models\Cantor;
use Illuminate\Database\Eloquent\Factories\Factory;

class CantorFactory extends Factory
{
    protected $model = Cantor::class;

    public function definition()
    {
        $voz = $this->faker->randomElement(['Soprano', 'Contralto', 'Tenor', 'Bajo']);

        return [
            'voz' => $voz,
            'idUsuario' => $this
        ];
    }
}
