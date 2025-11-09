<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // 🚫 Evita los errores de created_at y updated_at

    protected $fillable = [
        'nombre',
        'correo',
        'contrasena',
        'telefono',
        'tipo_usuario',
        'anonimo'
    ];
    public function chats()
    {
        return $this->hasMany(Chat::class, 'usuario_id', 'id_usuario');
    }
}