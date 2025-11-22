<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;

class EstadisticaController extends Controller
{
    public function index()
    {
        // Datos para gráficas usando vistas de la BD
        $casosAtendidos = Reporte::where('estado', 'cerrado')->count();
        $chatsActivos = Chat::where('estado', 'activo')->count();
        $usuariosTotales = 120; // Ejemplo - puedes obtenerlo de la BD

        // Obtener reportes recientes usando la vista
        $reportesRecientes = DB::table('vista_reportes_recientes')->limit(10)->get();
        
        // Obtener estado de reportes usando la vista
        $estadoReportes = DB::table('vista_estado_reportes')
            ->where('estado', '!=', 'cerrado')
            ->orderBy('dias_desde_reporte', 'desc')
            ->get();

        return view('psychologist.estadisticos', compact('casosAtendidos', 'chatsActivos', 'usuariosTotales', 'reportesRecientes', 'estadoReportes'));
    }
    
    public function estadisticasPorFecha(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', now()->subMonth()->format('Y-m-d'));
        $fechaFin = $request->input('fecha_fin', now()->format('Y-m-d'));
        
        // Usar el procedimiento almacenado para obtener estadísticas
        $estadisticas = DB::select('CALL estadisticas_reportes(?, ?)', [$fechaInicio, $fechaFin]);
        
        return response()->json($estadisticas);
    }
}
