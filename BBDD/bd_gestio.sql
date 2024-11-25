CREATE DATABASE bd_gestio;

USE bd_gestio;

/* ---- CREACIÓN DE LAS TABLAS CON CLAVES FORÁNEAS ---- */

CREATE TABLE tbl_usuario (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre_usuario VARCHAR(50) NOT NULL,
    password_usuario VARCHAR(50) NOT NULL,
    email_usuario VARCHAR(60) NOT NULL,
    telf_usuario CHAR(9) NOT NULL,
    dni_usuario CHAR(9) NOT NULL,
    rol_usuario ENUM('Admin', 'Alumno', 'Profesor') DEFAULT 'Alumno' NOT NULL
);

CREATE TABLE tbl_materias (
    id_materia INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre_materia VARCHAR(50) NOT NULL,
    horas_materia VARCHAR(50) NOT NULL
);

CREATE TABLE tbl_notas (
    id_nota INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    id_usuario INT NOT NULL,
    id_materia INT NOT NULL,
    nota_alumno_materia DECIMAL(4,2) NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES tbl_usuario(id_usuario),
    FOREIGN KEY (id_materia) REFERENCES tbl_materias(id_materia)
);

/* ---- INSERCIÓN DE DATOS ---- */

/* Datos para tbl_usuario */
INSERT INTO tbl_usuario (nombre_usuario, password_usuario, email_usuario, telf_usuario, dni_usuario, rol_usuario)
VALUES
('jperez', 'qweQWE123', 'juan.perez@gmail.com', '600123456', '12345678A', 'Alumno'),
('agarcia', 'qweQWE123', 'ana.garcia@gmail.com', '600987654', '23456789B', 'Alumno'),
('lmartinez', 'qweQWE123', 'luis.martinez@gmail.com', '600456789', '34567890C', 'Alumno'),
('mlopez', 'qweQWE123', 'maria.lopez@gmail.com', '600654321', '45678901D', 'Alumno'),
('psanchez', 'qweQWE123', 'pedro.sanchez@gmail.com', '600111222', '56789012E', 'Alumno'),
('lfernandez', 'qweQWE123', 'laura.fernandez@gmail.com', '600333444', '67890123F', 'Alumno'),
('cgomez', 'qweQWE123', 'carlos.gomez@gmail.com', '600555666', '78901234G', 'Alumno'),
('sruiz', 'qweQWE123', 'sofia.ruiz@gmail.com', '600777888', '89012345H', 'Alumno'),
('djimenez', 'qweQWE123', 'david.jimenez@gmail.com', '600999000', '90123456I', 'Alumno'),
('ltorres', 'qweQWE123', 'lucia.torres@gmail.com', '600222333', '01234567J', 'Alumno'),
('jhernandez', 'qweQWE123', 'javier.hernandez@gmail.com', '600444555', '11234567K', 'Alumno'),
('imorales', 'qweQWE123', 'isabel.morales@gmail.com', '600666777', '21234567L', 'Alumno'),
('agutierrez', 'qweQWE123', 'alberto.gutierrez@gmail.com', '600888999', '31234567M', 'Alumno'),
('pcastro', 'qweQWE123', 'patricia.castro@gmail.com', '600000111', '41234567N', 'Alumno'),
('mserrano', 'qweQWE123', 'miguel.serrano@gmail.com', '600222444', '51234567O', 'Alumno'),
('mgomez', 'qweQWE123', 'marta.gomez@gmail.com', '600555777', '61234567P', 'Alumno'),
('rvargas', 'qweQWE123', 'raul.vargas@gmail.com', '600888111', '71234567Q', 'Alumno'),
('csanchez', 'qweQWE123', 'carla.sanchez@gmail.com', '600333666', '81234567R', 'Alumno'),
('aortega', 'qweQWE123', 'andres.ortega@gmail.com', '600555999', '91234567S', 'Alumno'),
('eperez', 'qweQWE123', 'elena.perez@gmail.com', '600111444', '01345678T', 'Alumno'),
('pnavarro', 'qweQWE123', 'pablo.navarro@gmail.com', '600444888', '11345678U', 'Alumno'),
('nortiz', 'qweQWE123', 'natalia.ortiz@gmail.com', '600777222', '21345678V', 'Alumno'),
('dgil', 'qweQWE123', 'daniela.gil@gmail.com', '600000333', '31345678W', 'Alumno'),
('iramos', 'qweQWE123', 'ivan.ramos@gmail.com', '600222555', '41345678X', 'Alumno'),
('rflores', 'qweQWE123', 'rocio.flores@gmail.com', '600666999', '51345678Y', 'Alumno'),
('smendez', 'qweQWE123', 'sergio.mendez@gmail.com', '600999222', '61345678Z', 'Alumno'),
('pdominguez', 'qweQWE123', 'paula.dominguez@gmail.com', '600333999', '71345678A', 'Alumno'),
('haguilar', 'qweQWE123', 'hector.aguilar@gmail.com', '600555111', '81345678B', 'Alumno'),
('mleon', 'qweQWE123', 'marina.leon@gmail.com', '600777333', '91345678C', 'Alumno'),
('agonzalez', 'qweQWE123', 'alejandro.gonzalez@gmail.com', '612345622', '22345318J', 'Admin'),
('halda', 'qweQWE123', 'hugo.alda@gmail.com', '436892504', '00318318J', 'Admin'),
('amartin', 'qweQWE123', 'adri.martin@gmail.com', '708421504', '00318318J', 'Admin'),
('kruiz', 'qweQWE123', 'kilian.ruiz@gmail.com', '381007698', '59234712B', 'Admin'),
('fmartinez', 'qweQWE123', 'fatima.martinez@gmail.com', '123456789', '57921632C', 'Profesor'),
('aplans', 'qweQWE123', 'agnes.plans@gmail.com', '896874891', '30092312T', 'Profesor'),
('aDeSantos', 'qweQWE123', 'alberto.DeSantos@gmail.com', '674986789', '08921794K', 'Profesor');



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

