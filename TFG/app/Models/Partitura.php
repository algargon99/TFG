<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partitura extends Model
{
    use HasFactory;
    public function coro()
    {
        return $this->belongsTo(Coro::class, 'idCoro');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'idPartitura');
    }

    public function audios()
    {
        return $this->hasMany(Audio::class, 'idPartitura');
    }
}
