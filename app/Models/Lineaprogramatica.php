<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lineaprogramatica extends Model
{
    use SoftDeletes;
    protected $table = 'lineaprogramatica';
    protected $fillable = ['Nombre', 'Descripcion', 'ResponsableLinea'];
}
