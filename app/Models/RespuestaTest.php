<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestaTest extends Model
{
    protected $table = 'respuesta_test';
    protected $fillable = ['contenido', 'fk_pregunta', 'fk_test'];

    public function pregunta()
    {
        return $this->belongsTo(PreguntaTest::class, 'fk_pregunta');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'fk_test');
    }
}