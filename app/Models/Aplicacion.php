<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aplicacion extends Model
{
    use SoftDeletes;
    protected $table = 'aplicaciones';
    protected $fillable = ['Nombre', 'Descripcion'];
}
