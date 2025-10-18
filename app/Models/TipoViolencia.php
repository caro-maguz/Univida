<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoViolencia extends Model
{
    protected $table = 'tipo_violencia';
    protected $fillable = ['nombre', 'descripcion'];
}