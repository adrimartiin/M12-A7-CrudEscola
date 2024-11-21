CREATE DATABASE bd_gestio;

USE bd_gestio;

/*---- CREACIÓN DE LAS TABLAS -----*/

CREATE TABLE tbl_usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre_usuario VARCHAR(50) NOT NULL,
    email_usuario VARCHAR(60) NOT NULL,
    telf_usuario CHAR(9) NOT NULL,
    rol_usuario ENUM('Admin', 'Alumno') DEFAULT 'Alumno' NOT NULL
);

CREATE TABLE tbl_materias (
    id_materia INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre_materia VARCHAR(50) NOT NULL,
    horas_materia TIME NOT NULL
);

CREATE TABLE tbl_notas (
    id_nota INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    id_usuario INT NOT NULL,
    id_materia INT NOT NULL,
    nota_alumno_materia DECIMAL(3,2) NOT NULL
);

/* ---- ALTER TABLES PARA LAS FK ----- */
ALTER TABLE tbl_notas ADD FOREIGN KEY (id_usuario) REFERENCES tbl_usuario(id_usuario);
ALTER TABLE tbl_notas ADD FOREIGN KEY (id_materia) REFERENCES tbl_materias(id_materia);

/*---- INSERTAR DATOS EN LAS TABLAS -----*/

/* Datos para tbl_usuario */
INSERT INTO tbl_usuario (nombre_usuario, email_usuario, telf_usuario, rol_usuario)
VALUES 
('Juan Pérez', 'juan.perez@gmail.com', '600123456', 'Alumno'),
('Ana García', 'ana.garcia@gmail.com', '600987654', 'Alumno'),
('Luis Martínez', 'luis.martinez@gmail.com', '600456789', 'Alumno'),
('María López', 'maria.lopez@gmail.com', '600654321', 'Alumno'),
('Pedro Sánchez', 'pedro.sanchez@gmail.com', '600111222', 'Alumno'),
('Laura Fernández', 'laura.fernandez@gmail.com', '600333444', 'Alumno'),
('Carlos Gómez', 'carlos.gomez@gmail.com', '600555666', 'Alumno'),
('Sofía Ruiz', 'sofia.ruiz@gmail.com', '600777888', 'Alumno'),
('David Jiménez', 'david.jimenez@gmail.com', '600999000', 'Alumno'),
('Director Rodríguez', 'director.rodriguez@gmail.com', '600112233', 'Admin');

/* Datos para tbl_materias */
INSERT INTO tbl_materias (nombre_materia, horas_materia)
VALUES
('Matemáticas', 60),  
('Lengua Española', 90), 
('Historia', 75),  
('Inglés', 60),  
('Física', 80), 
('Química', 60),  
('Geografía', 90), 
('Biología', 70),  
('Programación', 60);  

/* Datos para tbl_notas */
INSERT INTO tbl_notas (id_usuario, id_materia, nota_alumno_materia)
VALUES
(1, 1, 8.5),  
(2, 2, 7.0),  
(3, 3, 6.5),  
(4, 4, 9.0),  
(5, 5, 5.5),  
(6, 6, 6.0),  
(7, 7, 7.5),  
(8, 8, 8.0),  
(9, 9, 9.5),  
(10, 1, 10.0); 
