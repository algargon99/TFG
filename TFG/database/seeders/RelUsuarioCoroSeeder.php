<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RelUsuarioCoro;
use App\Models\Usuario;
use App\Models\Coro;

class RelUsuarioCoroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarios = Usuario::all();
        $coros = Coro::all();


        foreach ($coros as $coro) {
            foreach ($usuarios as $usuario) {
                if (rand(0, 1)) {
                    RelUsuarioCoro::factory()->create([
                        'usuario_id' => $usuario,
                        'coro_id' => $coro,
                    ]);
                }
            }
        }
    }
}
