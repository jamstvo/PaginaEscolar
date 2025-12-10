-- Archivo: create_schema.sql
-- Crea las tablas según el esquema solicitado
CREATE DATABASE IF NOT EXISTS gd;
USE gd;

-- Tabla usuario
CREATE TABLE IF NOT EXISTS usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  correo VARCHAR(255) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  rol ENUM('admin','docente') NOT NULL DEFAULT 'docente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla docente
CREATE TABLE IF NOT EXISTS docente (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  telefono VARCHAR(50),
  especialidad VARCHAR(100),
  status ENUM('activo','inactivo') NOT NULL DEFAULT 'activo',
  FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla grupo
CREATE TABLE IF NOT EXISTS grupo (
  id INT AUTO_INCREMENT PRIMARY KEY,
  semestre TINYINT UNSIGNED DEFAULT 1,
  especialidad VARCHAR(100) NOT NULL,
  generacion VARCHAR(50),
  anio_inicio YEAR NOT NULL,
  tutor_id INT DEFAULT NULL,
  status ENUM('activo','egresado') NOT NULL DEFAULT 'activo',
  FOREIGN KEY (tutor_id) REFERENCES docente(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla materia
CREATE TABLE IF NOT EXISTS materia (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  tipo VARCHAR(50)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla horario
CREATE TABLE IF NOT EXISTS horario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_grupo INT NOT NULL,
  id_docente INT NOT NULL,
  id_materia INT NOT NULL,
  dia VARCHAR(20) NOT NULL,
  hora_inicio TIME NOT NULL,
  hora_fin TIME NOT NULL,
  status ENUM('activo','eliminado') NOT NULL DEFAULT 'activo',
  FOREIGN KEY (id_grupo) REFERENCES grupo(id) ON DELETE CASCADE,
  FOREIGN KEY (id_docente) REFERENCES docente(id) ON DELETE SET NULL,
  FOREIGN KEY (id_materia) REFERENCES materia(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Índices sugeridos
CREATE INDEX IF NOT EXISTS idx_horario_grupo ON horario(id_grupo);
CREATE INDEX IF NOT EXISTS idx_horario_docente ON horario(id_docente);

-- Fin
