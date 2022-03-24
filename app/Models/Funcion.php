<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Funcion extends Model
{
    use SoftDeletes;
    protected $table = 'funcions';
    protected $fillable = ['Nombre', 'Descripcion', 'estado'];
}
