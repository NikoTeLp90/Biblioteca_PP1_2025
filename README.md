# QUERY PARA CREAR LA DB

CREATE DATABASE biblioteca;
USE biblioteca;
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    dni VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    contrasenia VARCHAR(255) NOT NULL,  -- campo largo para almacenar el hash
    cargo VARCHAR(100)
);
CREATE TABLE insumo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) UNIQUE NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    categoria VARCHAR(100),
    disponibilidad VARCHAR(50),
    estado VARCHAR(50),
    observaciones TEXT
);
CREATE TABLE prestamo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_insumo INT NOT NULL,
    id_usuario INT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_final DATE NOT NULL,
    fecha_devolucion DATE,
    devuelto BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_insumo) REFERENCES insumo(id),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);
