<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cantor;
use App\Models\Usuario;

class CantorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear 20 cantores
        for ($i=0; $i < 20; $i++) {
            Cantor::factory()->create([
                "idUsuario" => Usuario::factory()->create()
            ]);
        }
    }
}
