<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{
    protected $table = 'historia';
    protected $fillable = ['contenido', 'fecha', 'fk_usuario'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario');
    }
}