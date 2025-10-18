@extends('dashboard-psychologist')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    
    * {
      font-family: 'Delius', cursive;
    }
</style>
<div class="main">
    <div class="section-header">
        <h2 style="font-size: 24px; color: #0d47a1;">Editar Psicólogo</h2>
        <a href="{{ route('psicologos.index') }}" class="btn btn-secondary" style="background: #757575; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="form-container" style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.07);">
        <form method="POST" action="{{ route('psicologos.update', $psicologo->id_psicologo) }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Nombre completo</label>
                <input type="text" name="nombre" required 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;"
                       value="{{ old('nombre', $psicologo->nombre) }}">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Correo institucional</label>
                <input type="email" name="correo" required 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;"
                       value="{{ old('correo', $psicologo->correo) }}">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Nueva contraseña (opcional)</label>
                <input type="password" name="contrasena" 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;"
                       placeholder="Dejar vacío para no cambiar">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">Teléfono</label>
                <input type="text" name="telefono" 
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;"
                       value="{{ old('telefono', $psicologo->telefono) }}">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: flex; align-items: center; font-weight: 600; color: #333;">
                    <input type="checkbox" name="disponible" 
                           {{ old('disponible', $psicologo->disponible) ? 'checked' : '' }}
                           style="margin-right: 10px; width: 18px; height: 18px;">
                    Disponible para atender casos
                </label>
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="submit" style="background: #0d47a1; color: white; padding: 12px 30px; border: none; border-radius: 8px; font-size: 16px; cursor: pointer;">
                    Actualizar Psicólogo
                </button>
                <a href="{{ route('psicologos.index') }}" style="background: #757575; color: white; padding: 12px 30px; border: none; border-radius: 8px; font-size: 16px; text-decoration: none; text-align: center;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection