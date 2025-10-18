<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recurso;

class RecursoController extends Controller
{
    public function index()
    {
        $recursos = Recurso::with(['tipoRecurso', 'administrador'])->get();
        return view('psychologist.resources', compact('recursos'));
    }
}