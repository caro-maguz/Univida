<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatJuridico extends Model
{
    // Nombre de la tabla
    protected $table = 'chat_juridico';

    // Clave primaria
    protected $primaryKey = 'id_chat';

    // Sin timestamps automáticos
    public $timestamps = false;

    // Campos asignables
    protected $fillable = [
        'fk_usuario',
        'fk_consultor',
        'estado'
    ];

    // 🔵 Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'fk_usuario', 'id_usuario');
    }

    // 🔵 Relación con consultor jurídico
    public function consultor()
    {
        return $this->belongsTo(\App\Models\ConsultorJuridico::class, 'fk_consultor', 'id_consultor');
    }

    // 🔵 Relación con mensajes del chat
    public function mensajes()
    {
        return $this->hasMany(\App\Models\MensajeChatJuridico::class, 'fk_chat', 'id_chat');
    }
}