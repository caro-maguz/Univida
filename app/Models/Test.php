<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'test';
    protected $fillable = ['fecha', 'resultado', 'fk_usuario'];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario');
    }
}