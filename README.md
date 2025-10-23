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
    nombre VARCHAR(150) NOT NULL,
    categoria VARCHAR(100),
    disponibilidad VARCHAR(50),
    estado VARCHAR(50),
    observaciones TEXT
);
create table prestamo (
    id int primary key auto_increment,
    insumo_id int,
    fecha_inicio timestamp default current_timestamp,
    fecha_final datetime as (timestamp(date(fecha_inicio), '22:00:00')) stored,
    destinatario varchar(75) not null,
    activo boolean default false,
    foreign key (insumo_id) references insumo(id)
    );