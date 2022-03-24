<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AjusteMetaLinea extends Model
{
    use SoftDeletes;
    protected $table = 'ajustemetalinea';
    protected $fillable = [
        'metaXLinea_id',
        'metaOriginal',
        'metaAjustado',
        'year',
        'fechaCambioDate',
        'aprobacion',
        'fechaCreacion',
        'fechaUltimaModificacion',
        'usuarioCreacion',
        'usuarioModificacion',
        'estado',
        'created_at',
        'update_at'
    ];
    public function metaxlinea()
    {
        return $this->belongsTo(MetaPorLinea::class);
    }
}
