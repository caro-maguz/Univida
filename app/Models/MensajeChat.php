<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajeChat extends Model
{
    protected $table = 'mensaje_chat';
    protected $fillable = ['contenido', 'fecha_hora', 'emisor', 'fk_chat'];

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'fk_chat');
    }
}