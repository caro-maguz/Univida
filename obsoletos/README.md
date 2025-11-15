# Carpeta de obsoletos

Esta carpeta contiene archivos movidos por no tener referencias activas en el código o por ser scripts de datos antiguos que pueden causar confusión.

Fecha: 2025-11-13

Movidos en esta iteración:
- app/Models/UsuarioRecurso.php (sin uso en el runtime actual)
- app/Models/Mensaje.php (modelo legado, tabla `mensajes` no presente; hoy se usa `mensaje_chat`)

Eliminados en una pasada previa (registrados aquí para trazabilidad):
- resources/views/login-psychologist.blade.php (vista de login antigua no referenciada)
- resources/views/login-admin.blade.php (vista de login antigua no referenciada)
- resources/views/resources.blade.php (reemplazada por `centro-recursos.blade.php`)
- database/update_preguntas.sql (parches de preguntas obsoletos)
- database/fix_encoding.sql (script de encoding/datos obsoleto)

Si necesitas recuperar alguno, considera revisar el historial de Git.