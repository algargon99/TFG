<?php

namespace Database\Factories;

use App\Models\Coro;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoroFactory extends Factory
{
    protected $model = Coro::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->company,
            'ciudad' => $this->faker->city,
            'direccion' => $this->faker->address,
            'tipo' => $this->faker->randomElement(['Cámara', 'Gospel', 'Polifónico']),
            'estilo' => $this->faker->randomElement(['Rock', 'Pop', 'Jazz', 'Clásico']),
            'descripcion' => $this->faker->paragraphs(4, true)
        ];
    }
}
