<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaEvento extends Model
{
    use SoftDeletes;
    protected $table = 'categoriaevento';
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'create_at',
        'update_at',
        'delete_at',
    ];
}
