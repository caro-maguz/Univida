<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psicologo extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'psicologo';

    // Nombre de la clave primaria
    protected $primaryKey = 'id_psicologo';

    // Desactivar timestamps (created_at / updated_at)
    public $timestamps = false;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'correo',
        'contrasena'
    ];
    public function chats()
    {
        return $this->hasMany(Chat::class, 'psicologo_id', 'id_psicologo');
    }
}
