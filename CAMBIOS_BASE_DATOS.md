# Resumen de Cambios en Base de Datos - UniVida

## Fecha: 13 de Noviembre 2024

### Objetivo
Corregir la estructura de base de datos para que todas las funcionalidades de los tres roles (Usuario, Psicólogo, Administrador) estén disponibles sin perder ninguna característica.

---

## 📊 TABLAS MODIFICADAS

### 1. **Tabla: historia**
**Campos agregados:**
- `estado` - ENUM('pendiente', 'aprobada', 'rechazada') DEFAULT 'pendiente'
- `fk_moderador` - INT NULL (FK a administrador.id_admin)
- `fecha_moderacion` - DATETIME NULL
- `motivo_rechazo` - TEXT NULL
- `created_at` - TIMESTAMP (Laravel timestamps)
- `updated_at` - TIMESTAMP (Laravel timestamps)

**Funcionalidad restaurada:**
✅ Moderación de historias por administradores
✅ Aprobación/Rechazo con motivos
✅ Tracking de fechas de moderación
✅ Identificación del moderador responsable

---

### 2. **Tabla: mensaje_chat**
**Campos agregados:**
- `tipo_remitente` - ENUM('sistema', 'usuario', 'psicologo')
- `leido` - BOOLEAN DEFAULT FALSE
- `created_at` - TIMESTAMP (Laravel timestamps)
- `updated_at` - TIMESTAMP (Laravel timestamps)

**Campos existentes mantenidos:**
- `emisor` - ENUM('usuario', 'psicologo', 'sistema')
- `fecha_hora` - DATETIME

**Funcionalidad restaurada:**
✅ Tracking completo de mensajes con timestamps
✅ Identificación del tipo de remitente para las vistas
✅ Estado de lectura de mensajes
✅ Compatible con fecha_hora para backwards compatibility

---

### 3. **Tabla: chat**
**Campos modificados:**
- `fk_psicologo` - Cambiado a NULL (permite chats sin psicólogo asignado)

**Funcionalidad restaurada:**
✅ Usuarios pueden iniciar chats antes de que un psicólogo los tome
✅ Chats en "espera" para asignación
✅ Sistema de cola para psicólogos

---

## 🔧 MODELOS ACTUALIZADOS

### Historia.php
```php
- Habilitado timestamps (created_at, updated_at)
- Agregados campos fillable: estado, fk_moderador, fecha_moderacion, motivo_rechazo
- Agregada relación: moderador() -> Administrador
- Casts para fechas correctos
```

### MensajeChat.php
```php
- Habilitado timestamps (created_at, updated_at)
- Agregados campos fillable: tipo_remitente, leido
- Mantenido fecha_hora para compatibilidad
- Cast para leido como boolean
```

### Chat.php
```php
- Sin cambios (ya estaba correcto)
```

---

## 🎮 CONTROLADORES ACTUALIZADOS

### AdminHistoriaController.php
**Funciones restauradas:**
- ✅ `aprobar($id)` - Aprueba historias y registra moderador
- ✅ `rechazar($id)` - Rechaza historias con motivo
- Ambas actualizan: estado, fk_moderador, fecha_moderacion

### ChatController.php
**Cambios principales:**
- ✅ Cambiado `use App\Models\Mensaje` → `use App\Models\MensajeChat`
- ✅ Actualizados todos los campos de base de datos:
  - `chat_id` → `fk_chat`
  - `id` → `id_chat`
  - `usuario_id` → `fk_usuario`
  - `psicologo_id` → `fk_psicologo`
  - `mensaje` → `contenido`
  - `remitente_id` → campo eliminado (se usa tipo_remitente)
  
**Funciones corregidas:**
- ✅ `mostrarChat()` - Vista de chat del usuario
- ✅ `enviarMensaje()` - Envío de mensajes del usuario
- ✅ `obtenerNuevosMensajes()` - Polling de mensajes
- ✅ `finalizarChat()` - Cerrar chat (estado 'cerrado')
- ✅ `index()` - Lista de chats para psicólogo
- ✅ `verChat()` - Detalle de chat con mensajes
- ✅ `tomarChat()` - Psicólogo toma un chat en espera
- ✅ `psicologoEnviarMensaje()` - Envío de mensajes del psicólogo
- ✅ `abrirChatParaUsuario()` - Iniciar chat con usuario específico

---

## 📝 FUNCIONALIDADES POR ROL

### 👤 USUARIO
✅ Crear historias (automáticamente en estado 'pendiente')
✅ Ver sus propias historias
✅ Ver estado de moderación de sus historias
✅ Iniciar chat de apoyo
✅ Enviar mensajes en el chat
✅ Recibir respuestas de psicólogos
✅ Finalizar chat

### 👨‍⚕️ PSICÓLOGO
✅ Ver lista de chats en espera
✅ Ver sus chats activos
✅ Ver historial de chats cerrados
✅ Tomar chats de la cola
✅ Enviar mensajes en chats
✅ Abrir chat directo con un usuario
✅ Ver detalles de chats

### 👨‍💼 ADMINISTRADOR
✅ Ver todas las historias con su estado
✅ Ver historias pendientes de moderación
✅ Aprobar historias
✅ Rechazar historias con motivo
✅ Ver quién moderó cada historia
✅ Ver fecha de moderación
✅ Editar historias si es necesario
✅ Eliminar historias

---

## 🔍 VALIDACIÓN

**Script SQL ejecutado:**
```sql
database/add_missing_fields.sql
```

**Cache limpiado:**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

**Errores de código:** ✅ 0 errores

---

## ⚠️ NOTAS IMPORTANTES

1. **Compatibilidad:** Se mantuvieron campos originales como `fecha_hora` y `emisor` para no romper código existente.

2. **Timestamps:** Todos los modelos ahora usan Laravel timestamps correctamente.

3. **Estados de historia:**
   - `pendiente` - Recién creada, esperando moderación
   - `aprobada` - Aprobada por un administrador
   - `rechazada` - Rechazada con motivo por un administrador

4. **Estados de chat:**
   - `activo` - Chat en curso
   - `cerrado` - Chat finalizado

5. **Tipos de remitente en mensajes:**
   - `usuario` - Mensaje del usuario
   - `psicologo` - Mensaje del psicólogo
   - `sistema` - Mensaje automático del sistema

---

## ✅ CONCLUSIÓN

Todas las funcionalidades de los tres roles han sido **restauradas y están operativas**:

- ✅ No se eliminó ninguna funcionalidad
- ✅ No se eliminaron tablas
- ✅ Solo se agregaron campos necesarios
- ✅ Se mantiene compatibilidad con código existente
- ✅ Todos los controladores actualizados
- ✅ Todos los modelos alineados con la base de datos

El sistema está listo para uso completo con todas sus características.
