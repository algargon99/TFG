<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    public function coros()
    {
        return $this->belongsToMany(Coro::class, 'rel_usuario_coros', 'usuario_id', 'coro_id');
    }

}
