<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Director;
use App\Models\Usuario;

class DirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear 5 directores

        for ($i=0; $i < 5; $i++) {
            Director::factory()->create([
                "idUsuario" => Usuario::factory()->create()
            ]);
        }
    }
}
