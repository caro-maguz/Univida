<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioRecurso extends Model
{
    protected $table = 'usuario_recurso';
    protected $fillable = ['fk_usuario', 'fk_recurso', 'fecha_consulta'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario');
    }

    public function recurso()
    {
        return $this->belongsTo(Recurso::class, 'fk_recurso');
    }
}