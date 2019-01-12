/**
	author: Pedro Pequeno
	date: 10/01/2019
	updated: 10/01/2019
**/
CREATE PROCEDURE inicializarBanco
AS
INSERT INTO setor (nome)
VALUES ('administrativo'),('financeiro'), ('recursos humanos'), 
	('comercial'), ('operacional'), ('TI'), ('qualidade');