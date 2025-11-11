<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historia;

class HistoriaController extends Controller
{
    /**
     * Mostrar historias públicas (anónimas o del usuario actual)
     */
    public function index()
    {
        // Mostrar historias anónimas + historias del usuario logueado (si está logueado)
        $usuarioId = session('id');
        $historias = Historia::where('anonimo', true)
            ->orWhere(function ($query) use ($usuarioId) {
                if ($usuarioId) {
                    $query->where('usuario_id', $usuarioId);
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('historias', compact('historias'));
    }

    /**
     * Ver más historias
     */
    public function mas()
    {
        $historias = Historia::where('anonimo', true)
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
            'usuario_id' => session('id') ?? null,
        ]);

        return redirect()->route('historias')->with('success', 'Historia enviada con éxito 💙');
    }
}
