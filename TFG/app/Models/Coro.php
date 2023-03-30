<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coro extends Model
{
    use HasFactory;

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'rel_usuario_coros', 'coro_id', 'usuario_id');
    }
}
