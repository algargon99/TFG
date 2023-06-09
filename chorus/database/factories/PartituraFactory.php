<?php

namespace Database\Factories;

use App\Models\Partitura;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PartituraFactory extends Factory
{
    protected $model = Partitura::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->sentence(2),
            'autor' => $this->faker->name(),
            'anio' => $this->faker->year(),
            'voces' => $this->faker->randomNumber(1)+1,
            'archivo' => 'pdf/birthday.pdf',
            'idCoro' => $this
        ];
    }
}
