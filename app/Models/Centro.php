<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Centro extends Model
{
    use SoftDeletes;
    protected $table = 'centros';
    protected $fillable = ['Nombre', 'Descripcion', 'ResponsableCentro'];

    //realcion con la tabla MetaLineaCentro
    public function metalineacentro()
    {
        return $this->hasMany(MetaLineaCentro::class, 'centro_id', 'id');
        // return $this->hasMany('App\Models\MetaLineaCentro');
    }
}
