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