# Cambio de Moderación de Historias

## Cambios Realizados

Se ha transferido la responsabilidad de moderar las historias anónimas del **Administrador** al **Psicólogo**.

### Archivos Modificados

#### 1. Modelo Historia (`app/Models/Historia.php`)
- Cambiada la relación `moderador()` de `Administrador` a `Psicologo`
- Ahora apunta a `psicologo(id_psicologo)` en lugar de `administrador(id_admin)`

#### 2. Nuevo Controlador (`app/Http/Controllers/PsicologoHistoriaController.php`)
- Creado nuevo controlador para gestión de historias por psicólogos
- Métodos incluidos:
  - `index()` - Listar todas las historias
  - `show($id)` - Ver detalle de una historia
  - `aprobar($id)` - Aprobar historia
  - `rechazar($id)` - Rechazar historia con motivo
  - `edit($id)` - Editar historia
  - `update($id)` - Actualizar historia
  - `destroy($id)` - Eliminar historia
- Utiliza `session('id')` para guardar el ID del psicólogo moderador

#### 3. Rutas (`routes/web.php`)
- Eliminadas las rutas de `administrador.historias.*`
- Agregadas nuevas rutas bajo `psychologist.historias.*`:
  ```php
  Route::middleware(['auth.psychologist'])->prefix('psychologist')->group(function () {
      Route::get('/historias', [PsicologoHistoriaController::class, 'index'])->name('psychologist.historias.index');
      Route::get('/historias/{id}', [PsicologoHistoriaController::class, 'show'])->name('psychologist.historias.show');
      Route::post('/historias/{id}/aprobar', [PsicologoHistoriaController::class, 'aprobar'])->name('psychologist.historias.aprobar');
      Route::post('/historias/{id}/rechazar', [PsicologoHistoriaController::class, 'rechazar'])->name('psychologist.historias.rechazar');
      Route::get('/historias/{id}/editar', [PsicologoHistoriaController::class, 'edit'])->name('psychologist.historias.edit');
      Route::put('/historias/{id}', [PsicologoHistoriaController::class, 'update'])->name('psychologist.historias.update');
      Route::delete('/historias/{id}', [PsicologoHistoriaController::class, 'destroy'])->name('psychologist.historias.destroy');
  });
  ```

#### 4. Vistas
- Creadas nuevas vistas en `resources/views/psychologist/historias/`:
  - `index.blade.php` - Lista de historias con estadísticas
  - `show.blade.php` - Detalle de historia individual
  - `edit.blade.php` - Formulario de edición
- Todas las rutas actualizadas de `administrador.historias.*` a `psychologist.historias.*`
- Enlace de retorno cambiado a `dashboard.psychologist`

#### 5. Dashboard del Psicólogo (`resources/views/dashboard-psychologist.blade.php`)
- Agregada nueva tarjeta "Gestión de Historias"
- Ícono: libro abierto (fas fa-book-open)
- Enlace: `route('psychologist.historias.index')`

### Base de Datos

#### Script SQL (`database/cambiar_moderador_historias.sql`)
Para aplicar los cambios en la base de datos, ejecutar:

```sql
-- 1. Limpiar moderadores existentes (opcional si hay datos)
UPDATE historia SET fk_moderador = NULL WHERE fk_moderador IS NOT NULL;

-- 2. Eliminar clave foránea antigua
ALTER TABLE historia DROP FOREIGN KEY historia_ibfk_1;

-- 3. Crear nueva clave foránea apuntando a psicólogo
ALTER TABLE historia
ADD CONSTRAINT fk_historia_moderador_psicologo
FOREIGN KEY (fk_moderador) REFERENCES psicologo(id_psicologo)
ON DELETE SET NULL
ON UPDATE CASCADE;
```

**IMPORTANTE:** Los registros existentes con `fk_moderador` que apunten a IDs de administrador quedarán huérfanos. Se recomienda ejecutar el UPDATE antes de cambiar la constraint.

### Flujo de Moderación

1. Usuario envía historia anónima (estado: `pendiente`)
2. Psicólogo accede a "Gestión de Historias" desde su dashboard
3. Psicólogo puede:
   - Ver lista de historias con filtros por estado
   - Aprobar historia (cambia estado a `aprobada`)
   - Rechazar historia con motivo (cambia estado a `rechazada`)
   - Editar contenido de historia
   - Eliminar historia
4. Al aprobar/rechazar, se guarda:
   - `fk_moderador`: ID del psicólogo (de sesión)
   - `fecha_moderacion`: Timestamp actual
   - `motivo_rechazo`: Solo si se rechaza

### Archivos Obsoletos

Los siguientes archivos quedan obsoletos pero se mantienen por compatibilidad:
- `app/Http/Controllers/AdminHistoriaController.php`
- `resources/views/administrador/historias/*.blade.php`

Se pueden eliminar si el administrador no necesita acceso a historias.

## Acceso

- **Psicólogo**: `https://tu-dominio.com/psychologist/historias`
- **Dashboard**: Tarjeta "Gestión de Historias"

## Permisos

Solo usuarios con rol `psicologo` (protegido por middleware `auth.psychologist`) pueden acceder a las rutas de moderación.
