<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition()
    {

        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;

        return [
            'nombre' => $firstName,
            'apellidos' => $lastName,
            'direccion' => $this->faker->address,
            'telefono' => $this->faker->numerify('6########'),
            'correo' => $this->uniqueSafeEmail($firstName, $lastName),
            'fechaNacimiento' => $this->faker->dateTimeBetween('-100 years', '-18 years')->format('Y-m-d'),
            'archivo' => 'img/usuario/icono.png',
            'password' => bcrypt('password'),
            'admin' => '0',
        ];
    }

    public function uniqueSafeEmail($a, $b)
    {
        $i = 1;
        do {
            $email = strtolower(substr($a, 0, 3)) . '.' . strtolower($b) . $i . '@example.com';
            $i++;
        } while (Usuario::where('correo', $email)->exists());

        return $email;
    }
}
