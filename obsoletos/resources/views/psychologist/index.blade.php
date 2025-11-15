@extends('dashboard-psychologist')

@section('content')
<div class="main">
    <div class="section-header">
        <h2 style="font-size: 24px; color: #0d47a1;">Gestión de Psicólogos</h2>
        <a href="{{ route('psicologos.create') }}" class="btn btn-success" style="background: #2e7d32; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
            <i class="fas fa-plus"></i> Registrar Psicólogo
        </a>
    </div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    
    * {
      font-family: 'Delius', cursive;
    }
</style>

    @if(session('success'))
        <div style="background: #e8f5e9; color: #2e7d32; padding: 12px; border-radius: 8px; margin: 20px 0;">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table style="width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <thead style="background: #e3f2fd;">
                <tr>
                    <th style="padding: 16px; text-align: left; color: #0d47a1;">Nombre</th>
                    <th style="padding: 16px; text-align: left; color: #0d47a1;">Correo</th>
                    <th style="padding: 16px; text-align: left; color: #0d47a1;">Teléfono</th>
                    <th style="padding: 16px; text-align: left; color: #0d47a1;">Disponible</th>
                    <th style="padding: 16px; text-align: left; color: #0d47a1;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($psicologos as $psicologo)
                <tr style="border-bottom: 1px solid #f0f0f0;">
                    <td style="padding: 16px;">{{ $psicologo->nombre }}</td>
                    <td style="padding: 16px;">{{ $psicologo->correo }}</td>
                    <td style="padding: 16px;">{{ $psicologo->telefono ?? 'No especificado' }}</td>
                    <td style="padding: 16px;">
                        @if($psicologo->disponible)
                            <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 12px; border-radius: 20px; font-size: 12px;">Disponible</span>
                        @else
                            <span style="background: #ffebee; color: #c62828; padding: 4px 12px; border-radius: 20px; font-size: 12px;">No disponible</span>
                        @endif
                    </td>
                    <td style="padding: 16px;">
                        <a href="{{ route('psicologos.edit', $psicologo->id_psicologo) }}" 
                           style="color: #1976d2; margin-right: 10px; text-decoration: none;">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('psicologos.destroy', $psicologo->id_psicologo) }}" 
                              method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('¿Estás seguro de eliminar este psicólogo?')"
                                    style="background: none; border: none; color: #c62828; cursor: pointer;">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
