-- FUNCIONES ALMACENADAS

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

-- Función: Validar teléfono (10 dígitos)
DELIMITER $$
CREATE FUNCTION validar_telefono(telefono_input VARCHAR(30))
RETURNS BOOLEAN
DETERMINISTIC
BEGIN
    RETURN telefono_input REGEXP '^[0-9]{10}$';
END$$
DELIMITER ;

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
    
    -- crear notificación
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


-- Validar correo institucional al registrar/actualizar usuarios
DELIMITER $$

DROP TRIGGER IF EXISTS validar_correo_usuario_bi $$
CREATE TRIGGER validar_correo_usuario_bi
BEFORE INSERT ON usuario
FOR EACH ROW
BEGIN
    IF NEW.correo IS NULL OR TRIM(NEW.correo) = '' THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'El correo es obligatorio';
    END IF;

    IF NOT validar_correo_institucional(NEW.correo) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Debes usar un correo institucional (@uniautonoma.edu.co)';
    END IF;

    IF correo_ya_registrado(NEW.correo) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Este correo ya está registrado';
    END IF;
END $$

DROP TRIGGER IF EXISTS validar_correo_usuario_bu $$
CREATE TRIGGER validar_correo_usuario_bu
BEFORE UPDATE ON usuario
FOR EACH ROW
BEGIN
    IF NEW.correo IS NOT NULL AND NEW.correo <> OLD.correo THEN
        IF NOT validar_correo_institucional(NEW.correo) THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Debes usar un correo institucional (@uniautonoma.edu.co)';
        END IF;

        IF correo_ya_registrado(NEW.correo) THEN
            SIGNAL SQLSTATE '45000'
                SET MESSAGE_TEXT = 'Este correo ya está registrado';
        END IF;
    END IF;
END $$

DELIMITER ;

-- Vista: Estado de reportes
CREATE OR REPLACE VIEW vista_estado_reportes AS
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
CREATE OR REPLACE VIEW vista_reportes_recientes AS
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


