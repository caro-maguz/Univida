@extends('layouts.app')

@section('title', 'Detalle de Historia')

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
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">📖 Historia #{{ $historia->id }}</h4>
                </div>
                <div class="card-body">
                    <!-- Estado -->
                    <div class="mb-4">
                        <h6 class="text-muted">Estado:</h6>
                        @if($historia->estado === 'pendiente')
                            <span class="badge bg-warning text-dark fs-6">
                                <i class="fas fa-clock"></i> Pendiente de moderación
                            </span>
                        @elseif($historia->estado === 'aprobada')
                            <span class="badge bg-success fs-6">
                                <i class="fas fa-check"></i> Aprobada
                            </span>
                        @else
                            <span class="badge bg-danger fs-6">
                                <i class="fas fa-times"></i> Rechazada
                            </span>
                        @endif
                    </div>

                    <!-- Contenido -->
                    <div class="mb-4">
                        <h6 class="text-muted">Contenido:</h6>
                        <div class="p-3 bg-light rounded border">
                            <p class="mb-0" style="white-space: pre-wrap;">{{ $historia->contenido }}</p>
                        </div>
                    </div>

                    <!-- Información del usuario -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Usuario:</h6>
                            <p>
                                @if($historia->usuario)
                                    {{ $historia->usuario->nombre ?? 'Anónimo' }}
                                @else
                                    <span class="text-muted">Sin usuario registrado</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Fecha de envío:</h6>
                            <p>{{ $historia->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    <!-- Información de moderación -->
                    @if($historia->moderador)
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted">Moderador:</h6>
                                <p>{{ $historia->moderador->nombre }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Fecha de moderación:</h6>
                                <p>{{ $historia->fecha_moderacion ? \Carbon\Carbon::parse($historia->fecha_moderacion)->format('d/m/Y H:i:s') : '-' }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Motivo de rechazo -->
                    @if($historia->estado === 'rechazada' && $historia->motivo_rechazo)
                        <div class="alert alert-danger">
                            <h6 class="alert-heading">Motivo del rechazo:</h6>
                            <p class="mb-0">{{ $historia->motivo_rechazo }}</p>
                        </div>
                    @endif

                    <!-- Acciones -->
                    <hr>
                    <div class="d-flex gap-2 justify-content-end">
                        @if($historia->estado === 'pendiente')
                            <form action="{{ route('administrador.historias.aprobar', $historia->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Aprobar
                                </button>
                            </form>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rechazarModal">
                                <i class="fas fa-times"></i> Rechazar
                            </button>
                        @endif

                        <a href="{{ route('administrador.historias.edit', $historia->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                        <form action="{{ route('administrador.historias.destroy', $historia->id) }}" 
                              method="POST"
                              onsubmit="return confirm('¿Estás seguro de eliminar esta historia?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para rechazar -->
<div class="modal fade" id="rechazarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('administrador.historias.rechazar', $historia->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Rechazar Historia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="motivo_rechazo" class="form-label">
                            Motivo del rechazo <span class="text-danger">*</span>
                        </label>
                        <textarea name="motivo_rechazo" 
                                  id="motivo_rechazo" 
                                  class="form-control" 
                                  rows="4" 
                                  required
                                  placeholder="Explica por qué se rechaza esta historia..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Rechazar Historia
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
