@extends('layouts.app')

@section('title', 'Editar Historia')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-3">
                <a href="{{ route('administrador.historias.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>

            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Editar Historia #{{ $historia->id }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('administrador.historias.update', $historia->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="contenido" class="form-label">
                                Contenido de la historia <span class="text-danger">*</span>
                            </label>
                            <textarea name="contenido" 
                                      id="contenido" 
                                      class="form-control @error('contenido') is-invalid @enderror" 
                                      rows="10" 
                                      required>{{ old('contenido', $historia->contenido) }}</textarea>
                            @error('contenido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Mínimo 10 caracteres</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Nota:</strong> Al editar una historia, solo se modifica el contenido. 
                            El estado de moderación permanece igual.
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('administrador.historias.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="card mt-3">
                <div class="card-body">
                    <h6 class="text-muted">Información de la historia:</h6>
                    <ul class="list-unstyled mb-0">
                        <li><strong>Estado:</strong> 
                            @if($historia->estado === 'pendiente')
                                <span class="badge bg-warning text-dark">Pendiente</span>
                            @elseif($historia->estado === 'aprobada')
                                <span class="badge bg-success">Aprobada</span>
                            @else
                                <span class="badge bg-danger">Rechazada</span>
                            @endif
                        </li>
                        <li><strong>Fecha de envío:</strong> {{ $historia->created_at->format('d/m/Y H:i') }}</li>
                        @if($historia->usuario)
                            <li><strong>Usuario:</strong> {{ $historia->usuario->nombre ?? 'Anónimo' }}</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
