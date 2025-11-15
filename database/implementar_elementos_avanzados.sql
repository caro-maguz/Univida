-- Agrega funciones, procedimientos, triggers y vistas
--              SIN alterar datos ni estructura existente

USE univida;


-- PASO 1: DATOS NECESARIOS

-- Insertar tipos de notificación si no existen (para triggers)
INSERT IGNORE INTO tipo_notificacion (nombre, descripcion) VALUES 
('Nuevo Reporte', 'Notificación de confirmación de reporte recibido'),
('Asignación Psicólogo', 'Notificación cuando se asigna un psicólogo'),
('Chat Iniciado', 'Notificación cuando se inicia un chat'),
('Mensaje Recibido', 'Notificación de nuevo mensaje en chat');


-- PASO 2: FUNCIONES ALMACENADAS


-- Eliminar funciones si existen (para evitar errores)
DROP FUNCTION IF EXISTS correo_ya_registrado;
DROP FUNCTION IF EXISTS validar_correo_institucional;

-- Función: Verificar si un correo ya está registrado
DELIMITER $$
CREATE FUNCTION correo_ya_registrado(correo_input VARCHAR(150))
RETURNS BOOLEAN
DETERMINISTIC
READS SQL DATA
BEGIN
    DECLARE existe BOOLEAN DEFAULT FALSE;
    
    IF EXISTS (SELECT 1 FROM usuario WHERE correo = correo_input) THEN
        SET existe = TRUE;
    ELSEIF EXISTS (SELECT 1 FROM psicologo WHERE correo = correo_input) THEN
        SET existe = TRUE;
    ELSEIF EXISTS (SELECT 1 FROM administrador WHERE correo = correo_input) THEN
        SET existe = TRUE;
    END IF;
    
    RETURN existe;
END$$
DELIMITER ;

-- Función: Validar correo institucional (uniautonoma.edu.co)
DELIMITER $$
CREATE FUNCTION validar_correo_institucional(correo_input VARCHAR(150))
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    RETURN correo_input LIKE '%@uniautonoma.edu.co';
END$$
DELIMITER ;


-- ============================================================================
-- PASO 3: PROCEDIMIENTOS ALMACENADOS
-- ============================================================================

-- Eliminar procedimientos si existen
DROP PROCEDURE IF EXISTS crear_reporte;
DROP PROCEDURE IF EXISTS cerrar_chat;
DROP PROCEDURE IF EXISTS estadisticas_reportes;

-- Procedimiento: Crear reporte con validaciones
DELIMITER $$
CREATE PROCEDURE crear_reporte(
    IN p_descripcion TEXT,
    IN p_anonimo BOOLEAN,
    IN p_fk_usuario INT,
    IN p_fk_tipo_violencia INT,
    OUT p_id_reporte INT,
    OUT p_mensaje VARCHAR(255)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SET p_mensaje = 'Error al crear el reporte';
        SET p_id_reporte = NULL;
        ROLLBACK;
    END;
    
    START TRANSACTION;
    
    -- Validar que la descripción no esté vacía
    IF p_descripcion IS NULL OR TRIM(p_descripcion) = '' THEN
        SET p_mensaje = 'La descripción no puede estar vacía';
        SET p_id_reporte = NULL;
        ROLLBACK;
    ELSE
        -- Insertar el reporte
        INSERT INTO reporte (descripcion, anonimo, fk_usuario, fk_tipo_violencia, estado)
        VALUES (p_descripcion, p_anonimo, p_fk_usuario, p_fk_tipo_violencia, 'nuevo');
        
        SET p_id_reporte = LAST_INSERT_ID();
        SET p_mensaje = 'Reporte creado exitosamente';
        
        COMMIT;
    END IF;
END$$
DELIMITER ;

-- Procedimiento: Cerrar chat y actualizar estado
DELIMITER $$
CREATE PROCEDURE cerrar_chat(
    IN p_id_chat INT,
    OUT p_mensaje VARCHAR(255)
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        SET p_mensaje = 'Error al cerrar el chat';
        ROLLBACK;
    END;
    
    START TRANSACTION;
    
    UPDATE chat 
    SET estado = 'cerrado', fecha_fin = CURRENT_TIMESTAMP
    WHERE id_chat = p_id_chat AND estado = 'activo';
    
    IF ROW_COUNT() > 0 THEN
        SET p_mensaje = 'Chat cerrado exitosamente';
        COMMIT;
    ELSE
        SET p_mensaje = 'Chat no encontrado o ya está cerrado';
        ROLLBACK;
    END IF;
END$$
DELIMITER ;

-- Procedimiento: Obtener estadísticas de reportes
DELIMITER $$
CREATE PROCEDURE estadisticas_reportes(
    IN p_fecha_inicio DATE,
    IN p_fecha_fin DATE
)
BEGIN
    SELECT 
        tv.nombre AS tipo_violencia,
        COUNT(r.id_reporte) AS total_reportes,
        SUM(CASE WHEN r.estado = 'nuevo' THEN 1 ELSE 0 END) AS nuevos,
        SUM(CASE WHEN r.estado = 'en_proceso' THEN 1 ELSE 0 END) AS en_proceso,
        SUM(CASE WHEN r.estado = 'cerrado' THEN 1 ELSE 0 END) AS cerrados,
        SUM(CASE WHEN r.anonimo = TRUE THEN 1 ELSE 0 END) AS anonimos
    FROM reporte r
    LEFT JOIN tipo_violencia tv ON r.fk_tipo_violencia = tv.id_tipo_violencia
    WHERE DATE(r.fecha) BETWEEN p_fecha_inicio AND p_fecha_fin
    GROUP BY tv.id_tipo_violencia, tv.nombre
    ORDER BY total_reportes DESC;
END$$
DELIMITER ;


-- ============================================================================
-- PASO 4: TRIGGERS (DISPARADORES)
-- ============================================================================

-- Eliminar triggers si existen
DROP TRIGGER IF EXISTS validar_fecha_reporte_before_insert;
DROP TRIGGER IF EXISTS notificar_nuevo_reporte_after_insert;

-- Trigger: Validar que la fecha del reporte no sea futura
DELIMITER $$
CREATE TRIGGER validar_fecha_reporte_before_insert
BEFORE INSERT ON reporte
FOR EACH ROW
BEGIN
    IF NEW.fecha > CURRENT_TIMESTAMP THEN
        SET NEW.fecha = CURRENT_TIMESTAMP;
    END IF;
END$$
DELIMITER ;

-- Trigger: Crear notificación automática al crear un reporte
DELIMITER $$
CREATE TRIGGER notificar_nuevo_reporte_after_insert
AFTER INSERT ON reporte
FOR EACH ROW
BEGIN
    DECLARE tipo_notif INT;
    
    -- Obtener el ID del tipo de notificación
    SELECT id_tipo_notificacion INTO tipo_notif 
    FROM tipo_notificacion 
    WHERE nombre = 'Nuevo Reporte' 
    LIMIT 1;
    
    -- Crear notificación solo si no es anónimo
    IF NEW.fk_usuario IS NOT NULL AND NEW.anonimo = FALSE THEN
        INSERT INTO notificacion (mensaje, fk_tipo_notificacion, fk_usuario, leida)
        VALUES (
            'Tu reporte ha sido recibido y será atendido pronto.',
            tipo_notif,
            NEW.fk_usuario,
            FALSE
        );
    END IF;
END$$
DELIMITER ;


-- ============================================================================
-- PASO 5: VISTAS
-- ============================================================================

-- Eliminar vistas si existen
DROP VIEW IF EXISTS vista_estado_reportes;
DROP VIEW IF EXISTS vista_reportes_recientes;

-- Vista: Estado de reportes
CREATE VIEW vista_estado_reportes AS
SELECT 
    r.id_reporte,
    r.fecha,
    r.estado,
    r.anonimo,
    u.nombre AS nombre_usuario,
    u.correo AS correo_usuario,
    tv.nombre AS tipo_violencia,
    p.nombre AS psicologo_asignado,
    p.correo AS correo_psicologo,
    DATEDIFF(CURRENT_DATE, DATE(r.fecha)) AS dias_desde_reporte
FROM reporte r
LEFT JOIN usuario u ON r.fk_usuario = u.id_usuario
LEFT JOIN tipo_violencia tv ON r.fk_tipo_violencia = tv.id_tipo_violencia
LEFT JOIN psicologo p ON r.fk_psicologo = p.id_psicologo;

-- Vista: Reportes recientes (últimos 30 días)
CREATE VIEW vista_reportes_recientes AS
SELECT 
    r.id_reporte,
    r.fecha,
    r.descripcion,
    r.estado,
    tv.nombre AS tipo_violencia,
    u.nombre AS usuario,
    p.nombre AS psicologo
FROM reporte r
LEFT JOIN tipo_violencia tv ON r.fk_tipo_violencia = tv.id_tipo_violencia
LEFT JOIN usuario u ON r.fk_usuario = u.id_usuario
LEFT JOIN psicologo p ON r.fk_psicologo = p.id_psicologo
WHERE r.fecha >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)
ORDER BY r.fecha DESC;


-- ============================================================================
-- VERIFICACIÓN FINAL
-- ============================================================================

SELECT '========================================' AS '';
SELECT 'IMPLEMENTACIÓN COMPLETADA' AS '';
SELECT '========================================' AS '';

SELECT 'FUNCIONES CREADAS:' AS '';
SHOW FUNCTION STATUS WHERE Db = 'univida';

SELECT '' AS '';
SELECT 'PROCEDIMIENTOS CREADOS:' AS '';
SHOW PROCEDURE STATUS WHERE Db = 'univida';

SELECT '' AS '';
SELECT 'TRIGGERS CREADOS:' AS '';
SELECT TRIGGER_NAME, EVENT_MANIPULATION, EVENT_OBJECT_TABLE 
FROM information_schema.TRIGGERS 
WHERE TRIGGER_SCHEMA = 'univida';

SELECT '' AS '';
SELECT 'VISTAS CREADAS:' AS '';
SELECT TABLE_NAME 
FROM information_schema.VIEWS 
WHERE TABLE_SCHEMA = 'univida';

SELECT '' AS '';
SELECT '========================================' AS '';
SELECT 'Implementación exitosa. Todo listo!' AS '';
SELECT '========================================' AS '';
