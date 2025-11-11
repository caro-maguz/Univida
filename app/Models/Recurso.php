<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    protected $table = 'recurso';
    protected $primaryKey = 'id_recurso';
    public $timestamps = false;
    protected $fillable = ['titulo', 'descripcion', 'enlace', 'fk_tipo_recurso', 'fk_admin'];

    // Accesor para obtener nombre de tipo directamente
    public function getTipoNombreAttribute()
    {
        return $this->tipoRecurso->nombre ?? null;
    }

    public function tipoRecurso()
    {
        return $this->belongsTo(TiposRecurso::class, 'fk_tipo_recurso', 'id_tipo_recurso');
    }

    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'fk_admin', 'id_admin');
    }
}
