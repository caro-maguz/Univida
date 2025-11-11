<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FraseMotivacional extends Model
{
    protected $table = 'frases_motivacionales';
    protected $fillable = ['texto', 'activo'];
}
