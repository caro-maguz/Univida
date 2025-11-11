<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recurso;
use App\Models\TiposRecurso;
use Illuminate\Support\Facades\Storage;

class RecursoController extends Controller
{
    public function index()
    {
        $recursos = Recurso::with(['tipoRecurso', 'administrador'])->get();
        return view('psychologist.resources', compact('recursos'));
    }

    // Centro de recursos (vista para usuarios)
    public function centro()
    {
        $recursos = Recurso::with('tipoRecurso')->get();

        $protocolos = $recursos->filter(function ($r) {
            $n = strtolower($r->tipoRecurso->nombre ?? '');
            return str_contains($n, 'protocolo');
        });

        $emergencias = $recursos->filter(function ($r) {
            $n = strtolower($r->tipoRecurso->nombre ?? '');
            return str_contains($n, 'emergencia') || str_contains($n, 'contacto');
        });

        $educativos = $recursos->filter(function ($r) {
            $n = strtolower($r->tipoRecurso->nombre ?? '');
            return str_contains($n, 'educa') || str_contains($n, 'material');
        });

        return view('centro-recursos', compact('protocolos', 'emergencias', 'educativos'));
    }

    // =============== CRUD ADMIN ===============
    public function adminIndex()
    {
        if (!session('rol') || session('rol') !== 'admin') {
            return redirect()->route('login.user');
        }
        $recursos = Recurso::with('tipoRecurso')->orderByDesc('id_recurso')->get();
        return view('administrador.recursos.index', compact('recursos'));
    }

    public function create()
    {
        if (!session('rol') || session('rol') !== 'admin') {
            return redirect()->route('login.user');
        }
        $tipos = TiposRecurso::orderBy('nombre')->get();
        return view('administrador.recursos.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        if (!session('rol') || session('rol') !== 'admin') {
            return redirect()->route('login.user');
        }

        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'enlace' => 'nullable|url',
            'fk_tipo_recurso' => 'required|exists:tipos_recurso,id_tipo_recurso',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,txt,zip,ppt,pptx|max:10240',
        ]);

        // Si sube archivo, lo guardamos en storage/public/recursos y usamos su URL como enlace
        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('recursos', 'public');
            $data['enlace'] = Storage::url($path);
        }

        $data['fk_admin'] = session('id');

        Recurso::create($data);
        return redirect()->route('administrador.recursos.index')->with('success', 'Recurso creado correctamente');
    }

    public function edit($id)
    {
        if (!session('rol') || session('rol') !== 'admin') {
            return redirect()->route('login.user');
        }
        $recurso = Recurso::findOrFail($id);
        $tipos = TiposRecurso::orderBy('nombre')->get();
        return view('administrador.recursos.edit', compact('recurso', 'tipos'));
    }

    public function update(Request $request, $id)
    {
        if (!session('rol') || session('rol') !== 'admin') {
            return redirect()->route('login.user');
        }
        $recurso = Recurso::findOrFail($id);

        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'enlace' => 'nullable|url',
            'fk_tipo_recurso' => 'required|exists:tipos_recurso,id_tipo_recurso',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,txt,zip,ppt,pptx|max:10240',
        ]);

        if ($request->hasFile('archivo')) {
            $path = $request->file('archivo')->store('recursos', 'public');
            $data['enlace'] = Storage::url($path);
        }

        $recurso->update($data);
        return redirect()->route('administrador.recursos.index')->with('success', 'Recurso actualizado');
    }

    public function destroy($id)
    {
        if (!session('rol') || session('rol') !== 'admin') {
            return redirect()->route('login.user');
        }
        $recurso = Recurso::findOrFail($id);
        $recurso->delete();
        return redirect()->route('administrador.recursos.index')->with('success', 'Recurso eliminado');
    }

    // Método para descargar el archivo
    public function download($id)
    {
        $recurso = Recurso::findOrFail($id);
        
        // Si el enlace es externo (URL completa), redirigir
        if ($recurso->enlace && filter_var($recurso->enlace, FILTER_VALIDATE_URL) && !str_starts_with($recurso->enlace, url('/'))) {
            return redirect($recurso->enlace);
        }
        
        // Si es un archivo en storage
        if ($recurso->enlace && str_starts_with($recurso->enlace, '/storage/')) {
            $path = str_replace('/storage/', 'public/', $recurso->enlace);
            
            if (Storage::exists($path)) {
                return Storage::download($path, $recurso->titulo . '.' . pathinfo($path, PATHINFO_EXTENSION));
            }
        }
        
        // Si no hay archivo, redirigir al enlace o mostrar error
        if ($recurso->enlace) {
            return redirect($recurso->enlace);
        }
        
        abort(404, 'Archivo no encontrado');
    }
}