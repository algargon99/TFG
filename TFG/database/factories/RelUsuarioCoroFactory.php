<?php

namespace Database\Factories;

use App\Models\RelUsuarioCoro;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelUsuarioCoroFactory extends Factory
{
    protected $model = RelUsuarioCoro::class;

    public function definition()
    {
        return [
            'usuario_id' => $this,
            'coro_id' => $this,
        ];
    }
}
