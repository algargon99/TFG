<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    public function cantor()
    {
        return $this->hasOne(Cantor::class, 'idUsuario');
    }

    public function director()
    {
        return $this->hasOne(Director::class, 'idUsuario');
    }

    public function relUsuarioCoro()
    {
        return $this->hasMany(RelUsuarioCoro::class, 'usuario_id');
    }

}
