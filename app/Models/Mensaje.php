<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $table = 'mensajes';

    protected $fillable = [
        'chat_id',
        'tipo_remitente',
        'remitente_id',
        'mensaje',
        'leido'
    ];

    protected $casts = [
        'leido' => 'boolean',
    ];

    // Relación con chat
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}