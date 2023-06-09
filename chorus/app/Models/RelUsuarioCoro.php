<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelUsuarioCoro extends Model
{
    use HasFactory;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function coro()
    {
        return $this->belongsTo(Coro::class, 'coro_id');
    }
}
