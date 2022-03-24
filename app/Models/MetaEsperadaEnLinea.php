<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetaEsperadaEnLinea extends Model
{
    use SoftDeletes;
    protected $table = 'ejecucionindicador';
    protected $fillable = ['metaXLinea_id', 'year', 'mes', 'valorejecucionesperada', 'valorejecucionrealizada', 'estado'];
}
