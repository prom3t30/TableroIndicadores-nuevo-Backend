<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Privilegio extends Model
{
    use SoftDeletes;
    protected $fillable = ['rol_id', 'pantalla_id', 'funcion_id', 'estado'];

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    public function pantalla()
    {
        return $this->belongsTo(Pantalla::class);
    }

    public function funcion()
    {
        return $this->belongsTo(Funcion::class);
    }
}
