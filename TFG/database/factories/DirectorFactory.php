<?php

namespace Database\Factories;

use App\Models\Director;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class DirectorFactory extends Factory
{
    protected $model = Director::class;

    public function definition()
    {
        return [
            'escuela' => $this->faker->company(),
            'idUsuario' => Usuario::factory()->create()->id,
        ];
    }
}
