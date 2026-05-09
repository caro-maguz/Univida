<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historia;

class HistoriaController extends Controller
{
    /**
     * Mostrar historias públicas (anónimas y aprobadas)
     */
    public function index()
    {
        // Solo mostrar historias aprobadas por el moderador
        $historias = Historia::where('anonimo', true)
            ->where('estado', 'aprobada')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('historias', compact('historias'));
    }

    /**
     * Ver más historias
     */
    public function mas()
    {
        // Solo historias aprobadas
        $historias = Historia::where('anonimo', true)
            ->where('estado', 'aprobada')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('historias-mas', compact('historias'));
    }

    /**
     * Mostrar formulario para enviar historia
     */
    public function showForm()
    {
        return view('historias-enviar');
    }

    /**
     * Guardar historia anónima
     */
    public function store(Request $request)
    {
        $request->validate([
            'historia' => 'required|string|min:10',
        ]);

        // Siempre guardar como anónimo, pero vinculado al usuario si está logueado
        $historia = Historia::create([
            'contenido' => $request->historia,
            'anonimo' => true,
            'fk_usuario' => session('id') ?? null,
            'estado' => 'pendiente', // Por defecto pendiente de moderación
        ]);

        return redirect()->route('historias')->with('success', 'Historia enviada con éxito 💙 Será revisada por un moderador antes de publicarse.');
    }
    public function moderar()
        {
            $historias = Historia::where('estado', 'pendiente')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('psychologist.historias.index', compact('historias'));
        }
}
