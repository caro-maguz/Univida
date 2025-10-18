<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use App\Models\Chat;

class EstadisticaController extends Controller
{
    public function index()
    {
        // Datos para gráficas (puedes ajustar según necesidad)
        $casosAtendidos = Reporte::where('estado', 'cerrado')->count();
        $chatsActivos = Chat::where('estado', 'activo')->count();
        $usuariosTotales = 120; // Ejemplo - puedes obtenerlo de la BD

        return view('psychologist.estadisticos', compact('casosAtendidos', 'chatsActivos', 'usuariosTotales'));
    }
}