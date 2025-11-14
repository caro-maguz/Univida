<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeChat extends Model
{
    use HasFactory;

    protected $table = 'mensaje_chat';
    protected $primaryKey = 'id_mensaje';
    public $timestamps = true;

    protected $fillable = [
        'fk_chat',
        'contenido',
        'emisor',
        'tipo_remitente',
        'fecha_hora',
        'leido'
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'leido' => 'boolean'
    ];

    // Compatibilidad con vistas que usan 'mensaje' e 'id'
    public function getMensajeAttribute()
    {
        return $this->contenido;
    }

    public function getIdAttribute()
    {
        return $this->id_mensaje;
    }

    // Relación con chat
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'fk_chat', 'id_chat');
    }
}