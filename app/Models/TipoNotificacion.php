<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoNotificacion extends Model
{
    protected $table = 'tipo_notificacion';
    protected $fillable = ['nombre', 'descripcion'];
}