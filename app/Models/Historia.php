<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{
    protected $table = 'historia';
    protected $primaryKey = 'id_historia';
    public $timestamps = true;
    
    protected $fillable = [
        'contenido', 
        'fk_usuario', 
        'anonimo',
        'estado', 
        'fk_moderador', 
        'fecha_moderacion', 
        'motivo_rechazo'
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_moderacion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario', 'id_usuario');
    }

    public function moderador()
    {
        return $this->belongsTo(Administrador::class, 'fk_moderador', 'id_admin');
    }

    // Compatibilidad con blades que usan $historia->id
    public function getIdAttribute()
    {
        return $this->id_historia;
    }
}