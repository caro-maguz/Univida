<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntaTest extends Model
{
    protected $table = 'pregunta_test';
    protected $primaryKey = 'id_pregunta';
    protected $fillable = ['enunciado', 'fk_test'];
    public $timestamps = false;

    public function test()
    {
        return $this->belongsTo(Test::class, 'fk_test', 'id_test');
    }

    public function respuestas()
    {
        return $this->hasMany(RespuestaTest::class, 'fk_pregunta', 'id_pregunta');
    }
}