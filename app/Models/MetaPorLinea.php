<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetaPorLinea extends Model
{
    use SoftDeletes;
    protected $table = 'metaxlinea';
    protected $fillable = ['id', 'indicador_id', 'linea_id', 'metaLinea', 'estado', 'year'];
}
