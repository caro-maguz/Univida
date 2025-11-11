<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposRecurso extends Model
{
    protected $table = 'tipos_recurso';
    protected $primaryKey = 'id_tipo_recurso';
    public $timestamps = false;
    protected $fillable = ['nombre', 'descripcion'];
}
