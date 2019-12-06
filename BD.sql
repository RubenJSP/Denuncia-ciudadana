CREATE DATABASE denuncias;
USE denuncias;

CREATE TABLE users(idUser INT auto_increment PRIMARY KEY, nombre VARCHAR(100) NOT NULL, apellidoPaterno VARCHAR(100) NOT NULL, apellidoMaterno VARCHAR(100) NOT NULL, eMail VARCHAR(100) NOT NULL UNIQUE, pass
VARCHAR(16) NOT NULL, fechaDeNacimiento DATE NOT NULL, tipo INT(2) NOT NULL) ENGINE = INNODB;

CREATE TABLE denuncias(idDenuncia INT AUTO_INCREMENT PRIMARY KEY, latitud VARCHAR(100) NOT NULL, longitud VARCHAR(100) NOT NULL, tipo ENUM('Bache','Animal','Arroyo','Fuego','Reparación') not null, 
	descripcion varchar(1000), img varchar(500), fechaRegistro datetime not null, idUser INT, FOREIGN KEY(idUser) REFERENCES users(idUser), estatus VARCHAR(100) NOT NULL);
    
CREATE TABLE comentarios(idComentario INT AUTO_INCREMENT PRIMARY KEY, mensaje BLOB NOT NULL,idDenuncia INT(7), FOREIGN KEY(idDenuncia) REFERENCES denuncias(idDenuncia) ,idUser INT, FOREIGN KEY(idUser) REFERENCES users(idUser)) ENGINE = INNODB;

INSERT INTO users (nombre,apellidoPaterno,apellidoMaterno,eMail,pass,fechaDeNacimiento,tipo) VALUES ('Ruben Jasahel','Sandoval','Perez','rubenl@admin.com','123456a$','1995-04-06',2);
