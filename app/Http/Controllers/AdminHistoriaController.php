<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historia;

class AdminHistoriaController extends Controller
{
    // Verificar que el usuario sea administrador
    private function verificarAdmin()
    {
        if (!session('rol') || session('rol') !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }
    }

    /**
     * Mostrar todas las historias (pendientes, aprobadas, rechazadas)
     */
    public function index()
    {
        $this->verificarAdmin();
        
        $historias = Historia::with(['usuario', 'moderador'])
            ->orderByRaw("FIELD(estado, 'pendiente', 'aprobada', 'rechazada')")
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('administrador.historias.index', compact('historias'));
    }

    /**
     * Ver detalle de una historia
     */
    public function show($id)
    {
        $this->verificarAdmin();
        
        $historia = Historia::with(['usuario', 'moderador'])->findOrFail($id);
        
        return view('administrador.historias.show', compact('historia'));
    }

    /**
     * Aprobar una historia
     */
    public function aprobar($id)
    {
        $this->verificarAdmin();
        
        $historia = Historia::findOrFail($id);
        $historia->update([
            'estado' => 'aprobada',
            'moderador_id' => session('id'),
            'fecha_moderacion' => now(),
            'motivo_rechazo' => null
        ]);
        
        return redirect()->route('administrador.historias.index')
            ->with('success', 'Historia aprobada correctamente');
    }

    /**
     * Rechazar una historia
     */
    public function rechazar(Request $request, $id)
    {
        $this->verificarAdmin();
        
        $request->validate([
            'motivo_rechazo' => 'required|string|min:10'
        ]);
        
        $historia = Historia::findOrFail($id);
        $historia->update([
            'estado' => 'rechazada',
            'moderador_id' => session('id'),
            'fecha_moderacion' => now(),
            'motivo_rechazo' => $request->motivo_rechazo
        ]);
        
        return redirect()->route('administrador.historias.index')
            ->with('success', 'Historia rechazada');
    }

    /**
     * Editar una historia
     */
    public function edit($id)
    {
        $this->verificarAdmin();
        
        $historia = Historia::findOrFail($id);
        
        return view('administrador.historias.edit', compact('historia'));
    }

    /**
     * Actualizar una historia
     */
    public function update(Request $request, $id)
    {
        $this->verificarAdmin();
        
        $request->validate([
            'contenido' => 'required|string|min:10'
        ]);
        
        $historia = Historia::findOrFail($id);
        $historia->update([
            'contenido' => $request->contenido
        ]);
        
        return redirect()->route('administrador.historias.index')
            ->with('success', 'Historia actualizada correctamente');
    }

    /**
     * Eliminar una historia
     */
    public function destroy($id)
    {
        $this->verificarAdmin();
        
        $historia = Historia::findOrFail($id);
        $historia->delete();
        
        return redirect()->route('administrador.historias.index')
            ->with('success', 'Historia eliminada correctamente');
    }
}
