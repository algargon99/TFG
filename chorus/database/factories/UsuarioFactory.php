<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName,
            'direccion' => $this->faker->address,
            'telefono' => $this->faker->numerify('6########'),
            'correo' => $this->faker->unique()->safeEmail,
            'fechaNacimiento' => $this->faker->dateTimeBetween('-100 years', '-18 years')->format('Y-m-d'),
            'password' => bcrypt('password')
        ];
    }
}
