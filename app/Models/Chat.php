<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chat';
    protected $primaryKey = 'id_chat';
    public $timestamps = false;

    protected $fillable = [
        'fk_usuario',
        'fk_psicologo',
        'estado',
        'fecha_inicio',
        'fecha_fin'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    // Compatibilidad con vistas antiguas (iniciado_en, finalizado_en, id)
    public function getIniciadoEnAttribute()
    {
        return $this->fecha_inicio;
    }

    public function getFinalizadoEnAttribute()
    {
        return $this->fecha_fin;
    }

    public function getIdAttribute()
    {
        return $this->id_chat;
    }

    // Ultima actividad (para blades que usaban updated_at)
    public function getUpdatedAtAttribute()
    {
        // Usar fecha del último mensaje, si no existe usar fecha_inicio
        if ($this->relationLoaded('ultimoMensaje') && $this->ultimoMensaje) {
            return $this->ultimoMensaje->created_at ?? $this->ultimoMensaje->fecha_hora;
        }
        // Cargar rápido si no estaba eager loaded
        if (!$this->relationLoaded('ultimoMensaje')) {
            $ultimo = $this->ultimoMensaje()->first();
            if ($ultimo) {
                return $ultimo->created_at ?? $ultimo->fecha_hora;
            }
        }
        return $this->fecha_inicio;
    }

    // Relación con mensajes
    public function mensajes()
    {
        return $this->hasMany(MensajeChat::class, 'fk_chat', 'id_chat');
    }

    // Relación con usuario 
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario', 'id_usuario');
    }

    // Relación con psicólogo 
    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class, 'fk_psicologo', 'id_psicologo');
    }

    // Obtener el último mensaje
    public function ultimoMensaje()
    {
        return $this->hasOne(MensajeChat::class, 'fk_chat', 'id_chat')->latestOfMany('fecha_hora');
    }
}