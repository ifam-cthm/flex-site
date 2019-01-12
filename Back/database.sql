/**
	author: Pedro Pequeno
	date: 10/01/2019
	updated: 10/01/2019
**/
CREATE DATABASE flex_ged;
USE flex_ged;
CREATE TABLE tipo(
	id INT IDENTITY,
	nome NVARCHAR(30) UNIQUE NOT NULL,
	descricao NVARCHAR(50),
	bloqueado BIT NOT NULL DEFAULT 0,
	PRIMARY KEY(id)
);

CREATE TABLE setor(
	id INT IDENTITY,
	nome NVARCHAR(30) UNIQUE NOT NULL,
	bloqueado BIT NOT NULL DEFAULT 0,
	PRIMARY KEY(id)
);

CREATE TABLE documento(
	id INT IDENTITY,
	nome NVARCHAR(50) UNIQUE NOT NULL,
	idSetor INT NOT NULL,
	idTipo INT NOT NULL,
	dataCadastrado DATE NOT NULL, 
	dataVencimento DATE NOT NULL,
	bloqueado BIT NOT NULL DEFAULT 0,
	FOREIGN KEY(idTipo) REFERENCES tipo(id),
	FOREIGN KEY(idSetor) REFERENCES setor(id),
	PRIMARY KEY(id)
);

CREATE table usuario(
	nome varchar(50) NOT NULL,
	login NVARCHAR(30),
	senha NVARCHAR(50),
	idSetor INT NOT NULL,
	administrador BIT NOT NULL DEFAULT 0,
	bloqueado BIT NOT NULL DEFAULT 0,
	FOREIGN KEY(idSetor) REFERENCES setor(id),
	PRIMARY KEY(login)
);

CREATE TABLE responsavel(
	id INT IDENTITY,
	loginUsuario NVARCHAR(30) NOT NULL,
	idDocumento INT NOT NULL,
	dateEntrada DATE NOT NULL,
	dateSaida DATE,
	FOREIGN KEY(loginUsuario) REFERENCES usuario(login),
	FOREIGN KEY(idDocumento) REFERENCES documento(id),
	PRIMARY KEY(id)
);


