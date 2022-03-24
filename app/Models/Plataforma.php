<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plataforma extends Model
{
    use SoftDeletes;
    protected $table = 'plataforma';
    protected $fillable = ['Nombre', 'Descripcion'];
}
