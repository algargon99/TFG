<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Director;

class DirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear 10 directores con datos aleatorios
        Director::factory()->count(10)->create();

        // Crear un director específico con datos personalizados
        Director::factory()->create([
            'nombre' => 'Juan',
            'apellidos' => 'Pérez Gómez',
            'escuela' => 'Conservatorio Nacional de Música',
            'telefono' => '555-1234',
            'correo' => 'juanperez@gmail.com',
            'fechaNacimiento' => '1980-05-12',
            // El idUsuario se asigna automáticamente
        ]);
    }
}
