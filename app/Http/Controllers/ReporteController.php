<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use App\Models\Psicologo;
use App\Models\TipoViolencia;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    // Mostrar formulario de reporte con tipos de violencia

    
    public function createViolencia()
    {
        $tiposViolencia = TipoViolencia::all();
        return view('reporte', compact('tiposViolencia'));
    }





    
    // Listar reportes para psicólogo
    public function index()
    {
        // Opción 1: Usar vista de la BD para obtener información completa
        $reportes = DB::table('vista_estado_reportes')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('psychologist.reporte', compact('reportes'));
    }
    
    // Método adicional: Obtener reportes recientes
    public function reportesRecientes()
    {
        // Usar vista para reportes de últimos 30 días
        $reportes = DB::table('vista_reportes_recientes')->get();
        
        return response()->json($reportes);
    }



    // Guardar reporte
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'fk_tipo_violencia' => 'required|integer',
            'fecha' => 'nullable|date'
        ]);
        
        // Forzar anonimato en todos los reportes. Si el usuario está autenticado, vincular el alias (fk_usuario).
        $fkUsuario = session('id') ?? (auth()->user()->id_usuario ?? null);
        
        // Opción 1: Usar procedimiento almacenado (con validaciones en BD)
        try {
            DB::statement('CALL crear_reporte(?, ?, ?, ?, @id, @msg)', [
                $request->descripcion,
                true, // anonimo
                $fkUsuario,
                $request->fk_tipo_violencia
            ]);
            
            $resultado = DB::select('SELECT @id as id_reporte, @msg as mensaje');
            
            if ($resultado[0]->id_reporte) {
                // Asignar psicólogo disponible después de crear el reporte
                $psicologo = Psicologo::where('disponible', true)->first();
                if ($psicologo) {
                    Reporte::where('id_reporte', $resultado[0]->id_reporte)
                        ->update(['fk_psicologo' => $psicologo->id_psicologo]);
                }
                
                return redirect()->back()->with('success', $resultado[0]->mensaje);
            } else {
                return redirect()->back()->with('error', $resultado[0]->mensaje);
            }
        } catch (\Exception $e) {
            Log::error('Error al crear reporte con procedimiento: ' . $e->getMessage());
            
            // Fallback: Método tradicional si falla el procedimiento
            $psicologo = Psicologo::where('disponible', true)->first();
            $reporte = Reporte::create([
                'fecha' => $request->fecha ? $request->fecha : now(),
                'descripcion' => $request->descripcion,
                'anonimo' => 1,
                'fk_tipo_violencia' => $request->fk_tipo_violencia,
                'fk_usuario' => $fkUsuario,
                'fk_psicologo' => $psicologo ? $psicologo->id_psicologo : null,
                'estado' => 'nuevo',
            ]);
            
            return redirect()->back()->with('success', 'Reporte enviado con éxito');
        }
    }

    // Marcar reporte como cerrado (resuelto)
    public function cerrarReporte(Request $request, $id)
    {
        try {
            Log::info('Iniciando cerrarReporte', [
                'id' => $id,
                'session' => session()->all(),
                'request' => $request->all()
            ]);

            // Verificar si hay sesión de psicólogo
            if (!session('psicologo_id')) {
                Log::error('Intento de cerrar reporte sin sesión de psicólogo');
                return response()->json(['success' => false, 'error' => 'No autorizado'], 401);
            }

            // Intentar encontrar y cerrar el reporte
            $reporte = Reporte::find($id);
            if (!$reporte) {
                Log::error('Reporte no encontrado', ['id' => $id]);
                return response()->json(['success' => false, 'error' => 'Reporte no encontrado'], 404);
            }

            $reporte->estado = 'cerrado';
            $reporte->save();

            Log::info('Reporte cerrado exitosamente', ['id' => $id]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Registrar el error para diagnóstico y devolver JSON para que el frontend lo muestre
            Log::error('Error cerrando reporte', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false, 
                'error' => 'Error interno al cerrar el reporte', 
                'details' => $e->getMessage()
            ], 500);
        }
    }

}