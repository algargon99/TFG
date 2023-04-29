<?php

namespace Database\Factories;

use App\Models\Cantor;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class CantorFactory extends Factory
{
    protected $model = Cantor::class;

    public function definition()
    {
        $voz = $this->faker->randomElement(['soprano', 'contralto', 'tenor', 'bajo']);

        return [
            'voz' => $voz,
            'idUsuario' => function () {
                return Usuario::factory()->create()->id;
            },
        ];
    }
}
