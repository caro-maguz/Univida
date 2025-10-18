<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;

class ReporteController extends Controller
{
    public function index()
    {
        $reportes = Reporte::with(['usuario', 'tipoViolencia', 'psicologo'])->orderBy('fecha', 'desc')->get();
        return view('psychologist.reporte', compact('reportes'));
    }
}