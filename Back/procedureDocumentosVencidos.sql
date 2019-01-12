/**
	author: Pedro Pequeno
	date: 11/01/2019
	updated: 11/01/2019
**/
CREATE PROCEDURE documentosVencidos 
@DTVALIDADE NVARCHAR(10),
@DIFERENCA INT, 
@SETORINICIO NVARCHAR(30) = '  ',
@SETORFINAL NVARCHAR(30) = 'ZZZZ',
@TIPOINICIO NVARCHAR(30) = '  ',
@TIPOFINAL NVARCHAR(30) = 'ZZZZ',
@RESPONSAVELINICIO NVARCHAR(30) = '  ',
@RESPONSAVELFINAL NVARCHAR(30) = 'ZZZZ'
AS
BEGIN
	SELECT * FROM (
		SELECT 
		d.id, d.nome, CONVERT(NVARCHAR, d.dataCadastrado,103) as cadastrado, 
		CONVERT(NVARCHAR, d.dataVencimento, 103) vencimento, 
		d.bloqueado, s.nome as setor, t.nome as tipo, u.nome as responsavel
		FROM (SELECT * FROM documento WHERE dataVencimento > CONVERT(DATE, @DTVALIDADE, 103)) d 
			INNER JOIN setor s ON s.id = d.idSetor 
			INNER JOIN tipo t on t.id = d.idTipo
			INNER JOIN responsavel r on r.idDocumento = d.id
			INNER JOIN usuario u on r.loginUsuario = u.login
			WHERE r.dateSaida IS NULL) AS documentos 
	WHERE documentos.bloqueado = 0 AND
		DATEDIFF(day, CONVERT(DATE, @DTVALIDADE, 103), documentos.vencimento) <= @DIFERENCA AND
		documentos.setor BETWEEN @SETORINICIO AND @SETORFINAL AND
		documentos.tipo BETWEEN @TIPOINICIO AND @TIPOFINAL AND
		documentos.responsavel BETWEEN @RESPONSAVELINICIO AND @RESPONSAVELFINAL
END 