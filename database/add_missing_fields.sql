-- Agregar campos faltantes para mantener todas las funcionalidades
USE univida;

-- TABLA HISTORIA: agregar campos para moderación
ALTER TABLE historia 
ADD COLUMN estado ENUM('pendiente', 'aprobada', 'rechazada') DEFAULT 'pendiente' AFTER contenido,
ADD COLUMN fk_moderador INT NULL AFTER estado,
ADD COLUMN fecha_moderacion DATETIME NULL AFTER fk_moderador,
ADD COLUMN motivo_rechazo TEXT NULL AFTER fecha_moderacion,
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER motivo_rechazo,
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at,
ADD FOREIGN KEY (fk_moderador) REFERENCES administrador(id_admin) ON DELETE SET NULL;

-- TABLA MENSAJE_CHAT: agregar campos para funcionalidad completa
ALTER TABLE mensaje_chat
ADD COLUMN tipo_remitente ENUM('sistema', 'usuario', 'psicologo') NOT NULL DEFAULT 'usuario' AFTER emisor,
ADD COLUMN leido BOOLEAN DEFAULT FALSE AFTER contenido,
ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER fecha_hora,
ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at;

-- Actualizar mensajes existentes para compatibilidad
UPDATE mensaje_chat SET tipo_remitente = emisor WHERE tipo_remitente IS NULL OR tipo_remitente = '';
UPDATE mensaje_chat SET created_at = fecha_hora WHERE created_at IS NULL;

SELECT 'Campos agregados exitosamente' AS Resultado;
