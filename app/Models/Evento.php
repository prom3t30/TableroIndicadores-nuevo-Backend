<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evento extends Model
{
    use SoftDeletes;
    protected $table = 'evento';
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'fechaInicio',
        'fechaFin',
        'ubicacion',
        'link',
        'poster',
        'estado',
        'fechaPublicacion',
        'userPublico',
        'categoria',
        'create_at',
        'delete_at',
        'update_at',
    ];
}
