<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Indicadores extends Model
{
    use SoftDeletes;
    protected $table = 'indicador';
    protected $fillable = [
        'categoria_id',
        'clasificacion_id',
        'cliente_id',
        'periodicidad_id',
        'plataforma_id',
        'unidad_id',
        'descripcion',
        'estado',
        'usuarioCreacion',
        'usuarioModificacion',
        'created_at',
        'update_at'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function clasificacion()
    {
        return $this->belongsTo(Clasificacion::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function periodicidad()
    {
        return $this->belongsTo(Periodicidad::class);
    }

    public function plataforma()
    {
        return $this->belongsTo(Plataforma::class);
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class);
    }
}
