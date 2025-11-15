<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historia;

class PsicologoHistoriaController extends Controller
{
    // Verificar que el usuario sea psicólogo
    private function verificarPsicologo()
    {
        if (!session('rol') || session('rol') !== 'psicologo') {
            abort(403, 'Acceso no autorizado');
        }
    }

    /**
     * Mostrar todas las historias
     */
    public function index()
    {
        $this->verificarPsicologo();
        
        $historias = Historia::with('usuario')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('psychologist.historias.index', compact('historias'));
    }

    /**
     * Ver detalle de una historia
     */
    public function show($id)
    {
        $this->verificarPsicologo();
        
        $historia = Historia::with('usuario')->findOrFail($id);
        
        return view('psychologist.historias.show', compact('historia'));
    }

    /**
     * Aprobar una historia
     */
    public function aprobar($id)
    {
        $this->verificarPsicologo();
        
        $historia = Historia::findOrFail($id);
        $historia->update([
            'estado' => 'aprobada',
            'fk_moderador' => session('id'),
            'fecha_moderacion' => now()
        ]);
        
        return redirect()->route('psychologist.historias.index')
            ->with('success', 'Historia aprobada correctamente');
    }

    /**
     * Rechazar una historia
     */
    public function rechazar(Request $request, $id)
    {
        $this->verificarPsicologo();
        
        $request->validate([
            'motivo_rechazo' => 'required|string|min:10'
        ]);
        
        $historia = Historia::findOrFail($id);
        $historia->update([
            'estado' => 'rechazada',
            'fk_moderador' => session('id'),
            'fecha_moderacion' => now(),
            'motivo_rechazo' => $request->motivo_rechazo
        ]);
        
        return redirect()->route('psychologist.historias.index')
            ->with('success', 'Historia rechazada correctamente');
    }

    /**
     * Editar una historia
     */
    public function edit($id)
    {
        $this->verificarPsicologo();
        
        $historia = Historia::findOrFail($id);
        
        return view('psychologist.historias.edit', compact('historia'));
    }

    /**
     * Actualizar una historia
     */
    public function update(Request $request, $id)
    {
        $this->verificarPsicologo();
        
        $request->validate([
            'contenido' => 'required|string|min:10'
        ]);
        
        $historia = Historia::findOrFail($id);
        $historia->update([
            'contenido' => $request->contenido
        ]);
        
        return redirect()->route('psychologist.historias.index')
            ->with('success', 'Historia actualizada correctamente');
    }

    /**
     * Eliminar una historia
     */
    public function destroy($id)
    {
        $this->verificarPsicologo();
        
        $historia = Historia::findOrFail($id);
        $historia->delete();
        
        return redirect()->route('psychologist.historias.index')
            ->with('success', 'Historia eliminada correctamente');
    }
}
