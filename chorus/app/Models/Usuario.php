<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellidos',
        'direccion',
        'telefono',
        'correo',
        'fechaNacimiento'

    ];

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

    public function usuarios()
    {
        return $this->hasMany(Coro::class, 'idUsuario', 'id');
    }

}
