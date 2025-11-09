<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $fillable = [
        'usuario_id',
        'psicologo_id',
        'estado',
        'iniciado_en',
        'finalizado_en'
    ];

    protected $casts = [
        'iniciado_en' => 'datetime',
        'finalizado_en' => 'datetime',
    ];

    // Relación con mensajes
    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }

    // Relación con usuario (AJUSTADA A TU ESTRUCTURA)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    // Relación con psicólogo (AJUSTADA A TU ESTRUCTURA)
    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class, 'psicologo_id', 'id_psicologo');
    }

    // Obtener el último mensaje
    public function ultimoMensaje()
    {
        return $this->hasOne(Mensaje::class)->latestOfMany();
    }
}