<?php

use App\Models\Cantor;
use Illuminate\Database\Seeder;
use App\Models\Coro;
use App\Models\Director;
use App\Models\Partitura;
use App\Models\Usuario;

class CoroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear 10 coros de ejemplo
        Coro::factory()->count(10)->create()->each(function ($coro) {
            // Para cada coro creado, crear 5 partituras y 10 usuarios
            $partituras = Partitura::factory()->count(5)->create()->create([
                'coro_id' => $coro->id,
            ]);

            $usuarios = Usuario::factory()->count(10)->create()->create()->each(function ($usuario) use ($coro) {
                // Asignar a cada usuario creado al coro actual y asignarles un rol aleatorio
                $rol = rand(1, 3);
                switch ($rol) {
                    case 1:
                        $cantor = Cantor::factory()->create([
                            'voz' => 'Soprano',
                            'usuario_id' => $usuario->id,
                        ]);
                        $coro->cantores()->save($cantor);
                        break;
                    case 2:
                        $cantor = Cantor::factory()->create([
                            'voz' => 'Tenor',
                            'usuario_id' => $usuario->id,
                        ]);
                        $coro->cantores()->save($cantor);
                        break;
                    case 3:
                        $director = Director::factory()->create([
                            'escuela' => 'Universidad Nacional',
                            'usuario_id' => $usuario->id,
                        ]);
                        $coro->directores()->save($director);
                        break;
                }
            });

            // Asignar las partituras a cada usuario
            foreach ($partituras as $partitura) {
                $usuarios->random()->partituras()->save($partitura);
            }
        });
    }
}
