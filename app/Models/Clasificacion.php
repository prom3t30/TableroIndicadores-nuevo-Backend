<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clasificacion extends Model
{
    use SoftDeletes;
    protected $table = 'clasificacion';
    protected $fillable = ['Nombre', 'Descripcion', 'estado'];
}
