<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reporte'; // Nombre exacto de la tabla
    protected $fillable = ['fecha', 'descripcion', 'anonimo', 'fk_usuario', 'fk_tipo_violencia', 'fk_psicologo', 'estado'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario');
    }

    public function tipoViolencia()
    {
        return $this->belongsTo(TipoViolencia::class, 'fk_tipo_violencia');
    }

    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class, 'fk_psicologo');
    }
}
