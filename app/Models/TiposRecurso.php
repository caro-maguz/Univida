<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiposRecurso extends Model
{
    protected $table = 'tipos_recurso';
    protected $fillable = ['nombre', 'descripcion'];
}
