<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioNotificacionConfig extends Model
{
    protected $table = 'usuario_notificacion_config';
    protected $primaryKey = 'id_config';
    protected $fillable = [
        'fk_usuario',
        'frecuencia',
        'intervalo_horas',
        'ultima_entrega',
        'activo'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario', 'id_usuario');
    }

    /**
     * Determina el intervalo efectivo en horas según la configuración.
     */
    public function intervaloEfectivoHoras(): int
    {
        return match($this->frecuencia) {
            'diaria' => 24,
            'semanal' => 24 * 7,
            'mensual' => 24 * 30,
            default => 24,
        };
    }
}
