<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{
    protected $table = 'historias';
    protected $fillable = ['contenido', 'anonimo', 'usuario_id', 'estado', 'moderador_id', 'fecha_moderacion', 'motivo_rechazo'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    public function moderador()
    {
        return $this->belongsTo(Administrador::class, 'moderador_id', 'id_admin');
    }

    // Scope para historias aprobadas
    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobada');
    }

    // Scope para historias pendientes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }
}