create database agendaBD;

use agendaBD;

create table usuarios(id int primary key auto_increment, username varchar(255), email varchar(255), contrasenia char(60));

create table contactos(idContacto int primary key auto_increment, contactname varchar(255), phoneNo varchar(15), idUsuario int, foreign key (idUsuario) references usuarios(id) on update cascade on delete cascade);


