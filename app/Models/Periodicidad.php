<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periodicidad extends Model
{
    use SoftDeletes;
    protected $table = 'periodicidad';
    protected $fillable = ['Nombre', 'Descripcion'];
}
