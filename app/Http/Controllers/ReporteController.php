<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use App\Models\Psicologo;
use App\Models\TipoViolencia;

class ReporteController extends Controller
{
    public function createViolencia()
    {
        // Obtener todos los tipos de violencia de la DB
        $tiposViolencia = TipoViolencia::all();

        // Enviar a la vista
        return view('reporte', compact('tiposViolencia'));
    }

    // Listar reportes para psicólogo
    public function index()
    {
        // Preferir el psicólogo autenticado por sesión; si no hay, mostrar todos
        $psicologoId = session('id') ?? (auth()->user()->id_psicologo ?? null);

        if ($psicologoId) {
            $reportes = Reporte::where('fk_psicologo', $psicologoId)
                ->with(['usuario', 'tipoViolencia'])
                ->orderBy('fecha', 'desc')
                ->get();
        } else {
            $reportes = Reporte::with(['usuario', 'tipoViolencia'])->orderBy('fecha', 'desc')->get();
        }

        // Reutilizar la vista existente para psicólogo
        return view('psychologist.reporte', compact('reportes'));
    }

    // Mostrar formulario de reporte (no usado directamente pero se deja)
    public function create()
    {
        return view('reportes.create');
    }

    // Guardar reporte
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'fk_tipo_violencia' => 'required|integer',
            'fecha' => 'nullable|date'
        ]);

        // Asignar psicólogo disponible (ejemplo: el primero disponible)
        $psicologo = Psicologo::where('disponible', true)->first();

        $reporte = Reporte::create([
            'fecha' => $request->fecha ? $request->fecha : now(),
            'descripcion' => $request->descripcion,
            'anonimo' => $request->has('anonimo') ? 1 : 0,
            'fk_tipo_violencia' => $request->fk_tipo_violencia,
            'fk_usuario' => session('id') ?? (auth()->user()->id_usuario ?? null),
            'fk_psicologo' => $psicologo ? $psicologo->id_psicologo : null,
            'estado' => 'nuevo',
        ]);

        return redirect()->back()->with('success', 'Reporte enviado con éxito');
    }

}
