<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coro extends Model
{
    use HasFactory;

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'idCoro', 'id');
    }

    public function partituras()
    {
        return $this->hasMany(Partitura::class, 'idCoro', 'id');
    }

    public function directores()
    {
        return $this->hasMany(Director::class, 'idCoro', 'id');
    }

    public function relUsuarioCoros()
    {
        return $this->hasMany(RelUsuarioCoro::class, 'coro_id', 'id');
    }
}
