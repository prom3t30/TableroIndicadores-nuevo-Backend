<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetaLineaCentro extends Model
{
    use SoftDeletes;
    protected $table = 'metalineacentro';
    protected $fillable = [
        'id',
        'metaxLinea_id',
        'centro_id',
        'metaCentro',
        'saved',
        'usuarioCreacion',
        'create_at',
        'update_at',
        'delete_at',
    ];
}
