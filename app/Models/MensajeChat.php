<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeChat extends Model
{
    use HasFactory;

    protected $table = 'mensaje_chat';

    protected $primaryKey = 'id_mensaje';

    // TU TABLA NO TIENE created_at NI updated_at
    public $timestamps = true;

    protected $fillable = [
        'fk_chat',
        'contenido',
        'emisor',
        'fecha_hora'
    ];

    protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
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