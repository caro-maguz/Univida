-- Corregir codificación de la tabla notificacion y tipo_notificacion
USE univida;

-- Convertir tabla notificacion a UTF8MB4
ALTER TABLE notificacion 
  CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Convertir tabla tipo_notificacion a UTF8MB4
ALTER TABLE tipo_notificacion 
  CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Actualizar registros existentes con la codificación correcta
UPDATE tipo_notificacion SET 
  nombre = 'Nuevo Reporte',
  descripcion = 'Notificación de confirmación de reporte recibido'
WHERE nombre LIKE '%Nuevo%';

UPDATE tipo_notificacion SET 
  nombre = 'Asignación Psicólogo',
  descripcion = 'Notificación cuando se asigna un psicólogo'
WHERE nombre LIKE '%Asignaci%';

UPDATE tipo_notificacion SET 
  nombre = 'Chat Iniciado',
  descripcion = 'Notificación cuando se inicia un chat'
WHERE nombre LIKE '%Chat%';

UPDATE tipo_notificacion SET 
  nombre = 'Mensaje Recibido',
  descripcion = 'Notificación de nuevo mensaje en chat'
WHERE nombre LIKE '%Mensaje%';

-- Actualizar notificaciones existentes
UPDATE notificacion SET 
  mensaje = 'Tu reporte ha sido recibido y será atendido pronto.'
WHERE mensaje LIKE '%reporte%' AND mensaje LIKE '%recibido%';

SELECT 'Codificación corregida. Las tildes ahora se mostrarán correctamente.' AS Resultado;
