<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProyectoEvaluar extends Model
{
    use SoftDeletes;
    protected $table = 'proyectoevaluar';
    protected $fillable = [
        'codigoProyecto',
        'proyectoConsecutivo',
        'proyectoTitulo',
        'codigoRegional',
        'nombreRegional',
        'codigoCentro',
        'nombreCentro',
        'lineaProgramaticaDescripcion',
        'mesa',
        'laboratorio',
        'laboratorioNombre',
        'responsableRegional',
        'evaluado',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
