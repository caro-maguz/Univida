<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'test';
    protected $primaryKey = 'id_test';
    protected $fillable = ['fecha', 'resultado', 'fk_usuario'];
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario');
    }

    public function respuestas()
    {
        return $this->hasMany(RespuestaTest::class, 'fk_test', 'id_test');
    }
}