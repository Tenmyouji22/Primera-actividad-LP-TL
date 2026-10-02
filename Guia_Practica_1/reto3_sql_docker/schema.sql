-

CREATE TABLE estudiantes (
    id      SERIAL       PRIMARY KEY,
    nombre  VARCHAR(100) NOT NULL,
    correo  VARCHAR(150) NOT NULL UNIQUE,
    edad    INTEGER      NOT NULL CHECK (edad BETWEEN 1 AND 120)
);

CREATE TABLE materias (
    id        SERIAL       PRIMARY KEY,
    codigo    VARCHAR(10)  NOT NULL UNIQUE,
    nombre    VARCHAR(100) NOT NULL,
    creditos  INTEGER      NOT NULL CHECK (creditos > 0)
);

-- Relación N:M entre estudiantes y materias
CREATE TABLE inscripciones (
    estudiante_id  INTEGER       NOT NULL REFERENCES estudiantes (id) ON DELETE CASCADE,
    materia_id     INTEGER       NOT NULL REFERENCES materias (id)    ON DELETE CASCADE,
    nota           NUMERIC(4, 2) CHECK (nota BETWEEN 0 AND 20),
    PRIMARY KEY (estudiante_id, materia_id)
);

-- Registros de prueba (en una base nueva los id empiezan en 1)
INSERT INTO estudiantes (nombre, correo, edad) VALUES
    ('Ana Rodríguez',     'ana.rodriguez@correo.com',     21),
    ('Luis Pérez',        'luis.perez@correo.com',        23),
    ('Valentina Márquez', 'valentina.marquez@correo.com', 20);

INSERT INTO materias (codigo, nombre, creditos) VALUES
    ('BD-101',  'Bases de Datos',  4),
    ('PRG-201', 'Programación II', 5);

INSERT INTO inscripciones (estudiante_id, materia_id, nota) VALUES
    (1, 1, 17.50),
    (1, 2, 18.00),
    (2, 1, 12.00),
    (3, 2, 19.10);


