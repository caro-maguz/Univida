<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajeChatJuridico extends Model
{
    protected $table = 'mensaje_chat_juridico';

    protected $primaryKey = 'id_mensaje';

    public $timestamps = false;

    protected $fillable = [
        'fk_chat',
        'mensaje',
        'emisor', // usuario o consultor
        'fecha'
    ];

    // Relación con chat
    public function chat()
    {
        return $this->belongsTo(ChatJuridico::class, 'fk_chat', 'id_chat');
    }
}