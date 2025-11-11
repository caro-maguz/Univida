<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoNotificacion extends Model
{
    protected $table = 'tipo_notificacion';
    protected $primaryKey = 'id_tipo_notificacion';
    public $timestamps = false;
    protected $fillable = ['nombre', 'descripcion'];
}