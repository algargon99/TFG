<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Usuario::factory()->create([
            'admin' => '1',
            'correo' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]);
    }
}
