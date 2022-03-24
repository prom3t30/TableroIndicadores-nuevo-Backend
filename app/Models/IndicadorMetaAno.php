<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndicadorMetaAno extends Model
{
    use SoftDeletes;
    protected $table = 'indicadormetaano';
    protected $fillable = ['year', 'indicador_id', 'metaGlobal'];

    public function indicador()
    {
        return $this->belongsTo(Indicadores::class);
    }
}
