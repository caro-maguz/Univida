<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $fillable = ['nombre', 'correo', 'contrasena', 'telefono', 'tipo_usuario', 'anonimo'];
}