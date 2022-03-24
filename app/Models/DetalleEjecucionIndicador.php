<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleEjecucionIndicador extends Model
{
    use SoftDeletes;
    protected $table = 'detalleejecucionindicador';
    protected $fillable = [

        'ejecucionIndicador_id',
        'centro_id',
        'valorEjecucionRealizada',
        'estado'
    ];
}
