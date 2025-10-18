<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    protected $table = 'recurso';
    protected $fillable = ['titulo', 'descripcion', 'enlace', 'fk_tipo_recurso', 'fk_admin'];

    public function tipoRecurso()
    {
        return $this->belongsTo(TiposRecurso::class, 'fk_tipo_recurso');
    }

    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'fk_admin');
    }
}
