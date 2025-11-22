CREATE DATABASE IF NOT EXISTS univida
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE univida;


CREATE TABLE tipo_notificacion (
  id_tipo_notificacion INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE tipo_violencia (
  id_tipo_violencia INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT
) ENGINE=InnoDB;

CREATE TABLE tipos_recurso (
  id_tipo_recurso INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT
) ENGINE=InnoDB;

CREATE TABLE administrador (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(150) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE psicologo (
  id_psicologo INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(150) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  telefono VARCHAR(30),
  disponible BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB;

CREATE TABLE usuario (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(150) UNIQUE,
  contrasena VARCHAR(255),
  telefono VARCHAR(30), 
  tipo_usuario ENUM('usuario','psicologo','administrador') NOT NULL DEFAULT 'usuario',
  anonimo BOOLEAN DEFAULT FALSE
) ENGINE=InnoDB;

CREATE TABLE recurso (
  id_recurso INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(200) NOT NULL,
  descripcion TEXT,
  enlace VARCHAR(500),
  fk_tipo_recurso INT,
  fk_admin INT,
  FOREIGN KEY (fk_tipo_recurso) REFERENCES tipos_recurso(id_tipo_recurso)
    ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (fk_admin) REFERENCES administrador(id_admin)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE usuario_recurso (
  id_usuario_recurso INT AUTO_INCREMENT PRIMARY KEY,
  fk_usuario INT NOT NULL,
  fk_recurso INT NOT NULL,
  fecha_consulta DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (fk_usuario) REFERENCES usuario(id_usuario)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (fk_recurso) REFERENCES recurso(id_recurso)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;



CREATE TABLE reporte (
  id_reporte INT AUTO_INCREMENT PRIMARY KEY,
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
  descripcion TEXT NOT NULL,
  anonimo BOOLEAN DEFAULT FALSE,
  fk_usuario INT,
  fk_tipo_violencia INT,
  fk_psicologo INT,
  estado ENUM('nuevo','en_proceso','cerrado') DEFAULT 'nuevo',
  FOREIGN KEY (fk_usuario) REFERENCES usuario(id_usuario)
    ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (fk_tipo_violencia) REFERENCES tipo_violencia(id_tipo_violencia)
    ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (fk_psicologo) REFERENCES psicologo(id_psicologo)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE chat (
  id_chat INT AUTO_INCREMENT PRIMARY KEY,
  fecha_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
  fecha_fin DATETIME,
  estado ENUM('activo','cerrado') DEFAULT 'activo',
  fk_usuario INT NOT NULL,
  fk_psicologo INT NOT NULL,
  FOREIGN KEY (fk_usuario) REFERENCES usuario(id_usuario)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (fk_psicologo) REFERENCES psicologo(id_psicologo)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE mensaje_chat (
  id_mensaje INT AUTO_INCREMENT PRIMARY KEY,
  contenido TEXT NOT NULL,
  fecha_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
  emisor ENUM('usuario','psicologo','sistema') NOT NULL,
  fk_chat INT NOT NULL,
  FOREIGN KEY (fk_chat) REFERENCES chat(id_chat)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


CREATE TABLE test (
  id_test INT AUTO_INCREMENT PRIMARY KEY,
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
  resultado VARCHAR(255),
  fk_usuario INT,
  FOREIGN KEY (fk_usuario) REFERENCES usuario(id_usuario)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE pregunta_test (
  id_pregunta INT AUTO_INCREMENT PRIMARY KEY,
  enunciado TEXT NOT NULL,
  fk_test INT,
  FOREIGN KEY (fk_test) REFERENCES test(id_test)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE respuesta_test (
  id_respuesta INT AUTO_INCREMENT PRIMARY KEY,
  contenido TEXT NOT NULL,
  fk_pregunta INT,
  fk_test INT,
  FOREIGN KEY (fk_pregunta) REFERENCES pregunta_test(id_pregunta)
    ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (fk_test) REFERENCES test(id_test)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


CREATE TABLE historia (
  id_historia INT AUTO_INCREMENT PRIMARY KEY,
  contenido TEXT NOT NULL,
  fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
  fk_usuario INT,
  FOREIGN KEY (fk_usuario) REFERENCES usuario(id_usuario)
    ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;



CREATE TABLE notificacion (
  id_notificacion INT AUTO_INCREMENT PRIMARY KEY,
  fecha_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
  mensaje VARCHAR(500) NOT NULL,
  fk_tipo_notificacion INT,
  fk_usuario INT NOT NULL,
  leida BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (fk_tipo_notificacion) REFERENCES tipo_notificacion(id_tipo_notificacion)
    ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (fk_usuario) REFERENCES usuario(id_usuario)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


-- Datos iniciales
INSERT INTO tipo_violencia (nombre) VALUES 
('Física'),
('Psicológica'),
('Sexual');

INSERT INTO tipos_recurso (nombre) VALUES 
('Protocolos'),
('Contactos de emergencia'),
('Material educativo');

INSERT INTO tipo_notificacion (nombre, descripcion) VALUES 
('Nuevo Reporte', 'Notificación de confirmación de reporte recibido'),
('Asignación Psicólogo', 'Notificación cuando se asigna un psicólogo'),
('Chat Iniciado', 'Notificación cuando se inicia un chat'),
('Mensaje Recibido', 'Notificación de nuevo mensaje en chat');



CREATE TABLE IF NOT EXISTS usuario_notificacion_config (
    id_config INT AUTO_INCREMENT PRIMARY KEY, 
    fk_usuario INT UNSIGNED NOT NULL, 
    frecuencia ENUM('diaria','semanal','mensual','personalizada') DEFAULT 'diaria', 
    intervalo_horas INT UNSIGNED NULL, 
    ultima_entrega DATETIME NULL, 
    activo TINYINT(1) DEFAULT 1, 
    created_at TIMESTAMP NULL, 
    updated_at TIMESTAMP NULL, 
    UNIQUE(fk_usuario));

CREATE TABLE IF NOT EXISTS frases_motivacionales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto VARCHAR(500) NOT NULL,
    activo TINYINT(1) DEFAULT 1, 
    created_at TIMESTAMP NULL, 
    updated_at TIMESTAMP NULL);





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



-- PROCEDIMIENTOS ALMACENADOS


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



-- TRIGGERS (DISPARADORES)


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

-- VISTAS


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


