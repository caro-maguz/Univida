<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntaTest extends Model
{
    protected $table = 'pregunta_test';
    protected $fillable = ['enunciado', 'fk_test'];

    public function test()
    {
        return $this->belongsTo(Test::class, 'fk_test');
    }
}