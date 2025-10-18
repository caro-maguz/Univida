<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificacion';
    protected $fillable = ['fecha_hora', 'mensaje', 'fk_tipo_notificacion', 'fk_usuario', 'leida'];

    public function tipoNotificacion()
    {
        return $this->belongsTo(TipoNotificacion::class, 'fk_tipo_notificacion');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario');
    }
}