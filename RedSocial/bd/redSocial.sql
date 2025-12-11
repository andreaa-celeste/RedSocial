CREATE TABLE Usuario (
    id_usuario        INT AUTO_INCREMENT PRIMARY KEY,
    email             VARCHAR(255) UNIQUE NOT NULL,
    contraseña        VARCHAR(255) NOT NULL,
    nombre            VARCHAR(255) NOT NULL,
    foto_perfil       VARCHAR(255),
    fecha_nacimiento  DATE,
    genero            ENUM('Mujer', 'Hombre', 'Prefiero no contestar'),
    ciudad            VARCHAR(255),
    biografia         TEXT,
    rol               ENUM('usuario','admin') DEFAULT 'usuario',
    fecha_registro    DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Registro_Pendiente (
    id_registro       INT AUTO_INCREMENT PRIMARY KEY,
    email             VARCHAR(255) UNIQUE NOT NULL,
    contraseña        VARCHAR(255) NOT NULL,
    nombre            VARCHAR(255) NOT NULL,
    fecha_nacimiento  DATE,
    genero            ENUM('Mujer', 'Hombre', 'Prefiero no contestar'),
    token             VARCHAR(64) NOT NULL
);

CREATE TABLE Post (
    id_post           INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario        INT NOT NULL,
    contenido_texto   TEXT NOT NULL,
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    imagen            VARCHAR(255),
    archivo_adjunto   VARCHAR(255),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);


CREATE TABLE Comentario (
    id_comentario     INT AUTO_INCREMENT PRIMARY KEY,
    id_post           INT NOT NULL,
    id_usuario        INT NOT NULL,
    contenido         TEXT NOT NULL,
    fecha_publicacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_post) REFERENCES Post(id_post),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Reaccion (
    id_usuario    INT NOT NULL,
    id_post       INT NOT NULL,
    tipo_reaccion ENUM('like','dislike') NOT NULL,
    PRIMARY KEY (id_usuario, id_post),
    FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_post) REFERENCES Post(id_post)
);

CREATE TABLE Seguir_Usuario (
    id_seguidor  INT NOT NULL,
    id_seguido   INT NOT NULL,
    estado       ENUM('pendiente','aceptado') NOT NULL,
    PRIMARY KEY (id_seguidor, id_seguido),
    FOREIGN KEY (id_seguidor) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (id_seguido)  REFERENCES Usuario(id_usuario)
);
