CREATE DATABASE login;
USE login;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO usuarios (username, password) VALUES ('tako', '123456');

select * from usuarios;

CREATE TABLE musica (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cancion VARCHAR(255) NOT NULL,
    album VARCHAR(255),
    artista VARCHAR(255),
    duracion TIME,  -- formato HH:MM:SS
    genero VARCHAR(100),
    contenido_explicito BOOLEAN DEFAULT 0  -- 0 = No, 1 = Sí
);

INSERT INTO musica (cancion, album, artista, duracion, genero, contenido_explicito)
VALUES
('test', 'Alt', 'Artt', '00:02:50', 'Jazz', 0);

SELECT * FROM musica WHERE id = 1;




