<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';
    protected $fillable = ['fecha_inicio', 'fecha_fin', 'estado', 'fk_usuario', 'fk_psicologo'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario');
    }

    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class, 'fk_psicologo');
    }
}