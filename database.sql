CREATE DATABASE IF NOT EXISTS laravel_master;

use laravel_master;

CREATE TABLE IF NOT EXISTS users(
    id              int(255) auto_increment not null,
    role            varchar(20),
    name            varchar(100),
    surname         varchar(200),
    nick            varchar(100),
    email           varchar(255),
    password        varchar(255),
    image           varchar(255),
    created_at       datetime,
    updated_at       datetime,
    remember_token  varchar(255),

    CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

INSERT INTO users VALUES (NULL, 'user', 'Achraf', 'El Ouakili','achra@achraf.com',null, curtime(), curtime(), null);
INSERT INTO users VALUES (NULL, 'user', 'Juan', 'Lopz','JuanLopex','Juan@Juan.com','pass',null, curtime(), curtime(), null) 

CREATE TABLE IF NOT EXISTS images(
id              int(255) auto_increment not null,
user_id         int(255),
image_path      varchar(255),
descriptio      text,
created_at       datetime,
updated_at       datetime,
CONSTRAINT pk_images PRIMARY KEY(id),
CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id) 
)ENGINE=InnoDb;

INSERT INTO images VALUES (NULL,1,'test.jpg','descripcion de prueba 1',curtime(), curtime());
INSERT INTO images VALUES (NULL,1,'playa.jpg','descripcion de prueba 2',curtime(), curtime());
INSERT INTO images VALUES (NULL,1,'arena.jpg','descripcion de prueba 3',curtime(), curtime());
INSERT INTO images VALUES (NULL,3,'familia.jpg','descripcion de prueba 4',curtime(), curtime());


CREATE TABLE IF NOT EXISTS Comments(
id              int(255) auto_increment not null,
user_id         int(255),
imege_id        int(255),
context         text,
created_at       datetime,
updated_at       datetime,
CONSTRAINT pk_comments PRIMARY KEY(id),
CONSTRAINT fk_comments_users FOREIGN KEY (user_id) REFERENCES users(id),
CONSTRAINT fk_comments_images FOREIGN KEY (imege_id) REFERENCES images(id)
) ENGINE=InnoDb;


INSERT INTO Comments VALUES (NULL,1,4,'Buena foto de familia !!!',curtime(), curtime());
INSERT INTO Comments VALUES (NULL,2,4,'Buena foto de Playa !!!',curtime(), curtime());
INSERT INTO Comments VALUES (NULL,2,4,'Que bueno',curtime(), curtime());


CREATE TABLE IF NOT EXISTS likes(
id              int(255) auto_increment not null,
user_id         int(255),
imege_id        int(255),
created_at       datetime,
updated_at       datetime,
CONSTRAINT pk_likes PRIMARY KEY(id),
CONSTRAINT fk_likes_users FOREIGN KEY (user_id) REFERENCES users(id),
CONSTRAINT fk_likes_images FOREIGN KEY (imege_id) REFERENCES images(id)
) ENGINE=InnoDb;

INSERT INTO likes VALUES (NULL,1,4,curtime(), curtime());
INSERT INTO likes VALUES (NULL,2,4,curtime(), curtime());
INSERT INTO likes VALUES (NULL,3,1,curtime(), curtime());
INSERT INTO likes VALUES (NULL,3,2,curtime(), curtime());
INSERT INTO likes VALUES (NULL,2,1,curtime(), curtime());


