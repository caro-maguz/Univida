<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoViolencia extends Model
{
    protected $table = 'tipo_violencia';
    // PK personalizada
    protected $primaryKey = 'id_tipo_violencia';
    public $timestamps = false;
    protected $keyType = 'int';
    protected $fillable = ['nombre', 'descripcion'];
}