<?php

function get_grafico_documentosXusuarios($db)
{
    $str = $db->prepare("
select u.nome, count(r.idDocumento) as quantidade from responsavel r
INNER JOIN usuario u ON (u.login = r.loginUsuario)
WHERE r.dateSaida IS NULL group by (u.nome)");
    $str->execute();
    $usuarios = array();
    $documentos = array();
    foreach ($str->fetchAll() as $resultado) {
        array_push($usuarios, $resultado["nome"]);
        array_push($documentos, $resultado["quantidade"]);
    }
    $retorno = array(
        "usuarios" => $usuarios,
        "quantidades" => $documentos
    );
    return $retorno;
}

function get_grafico_documentosXtipos($db)
{
    $str = $db->prepare("
    select t.nome, count(d.id) as quantidade from  documento d
    INNER JOIN tipo t ON (d.idTipo = t.id)
    WHERE t.bloqueado = 0 AND d.bloqueado = 0 group by (t.nome)");
    $str->execute();
    $tipos = array();
    $documentos = array();
    foreach ($str->fetchAll() as $resultado) {
        array_push($tipos, $resultado["nome"]);
        array_push($documentos, $resultado["quantidade"]);
    }
    $retorno = array(
        "tipos" => $tipos,
        "quantidades" => $documentos
    );
    return $retorno;
}

function documento_cadastro($db, $documento)
{
    $str = $db->prepare("INSERT INTO documento (nome, idSetor, idTipo, dataCadastrado, dataVencimento, bloqueado) VALUES 
        (:nome, :idSetor, :idTipo, CONVERT(DATE, :dataCadastrado,103), 
        :dataVencimento,  0)");
    $str->bindParam("nome", $documento["nome"]);
    $str->bindParam("idSetor", $documento["setor"]);
    $str->bindParam("idTipo", $documento["tipo"]);
    $data = date('d/m/Y');
    $str->bindParam("dataCadastrado", $data);
    $str->bindParam("dataVencimento", $documento["dataVencimento"]);
    $str->execute();

    $str = $db->prepare("SELECT TOP 1 * FROM documento ORDER BY id DESC");
    $str->execute();
    $documentoC = $str->fetchAll();


    if (count($documentoC) > 0) {
        $str = $db->prepare("INSERT INTO responsavel (loginUsuario, idDocumento, dateEntrada)
        VALUES (:login, :id, CONVERT(DATE, :data,103))");
        $str->bindParam("login", $documento["responsavel"]);
        $str->bindParam("id", $documentoC[0]["id"]);
        $str->bindParam("data", $data);
        $str->execute();
        return $documentoC[0];
    } else {
        return array();
    }
}


function documento_atualizacao($db, $documento)
{
    $str = $db->prepare("UPDATE documento SET nome = :nome, 
    idSetor = :idSetor, idTipo = :idTipo, dataCadastrado = :dataCadastrado, 
    dataVencimento = :dataVencimento
    WHERE id = :id");
    $str->bindParam("id", $documento["id"]);
    $str->bindParam("nome", $documento["nome"]);
    $str->bindParam("idSetor", $documento["setor"]);
    $str->bindParam("idTipo", $documento["tipo"]);
    $data = date('d/m/Y');
    $str->bindParam("dataCadastrado", $data);
    $str->bindParam("dataVencimento", $documento["dataVencimento"]);
    $str->execute();

    $str = $db->prepare("SELECT * FROM responsavel WHERE idDocumento = :idDocumento AND dateSaida IS NULL");
    $str->bindParam("idDocumento", $documento["id"]);
    $str->execute();
    $documentoC = $str->fetchAll();

    if ($documentoC[0]["loginUsuario"] != $documento["responsavel"]) {
        $str = $db->prepare("UPDATE responsavel SET dateSaida = CONVERT(date, :dateSaida, 103)  WHERE id = :id");
        $str->bindParam("id", $documentoC[0]["id"]);
        $str->bindParam("dateSaida", $data);
        $str->execute();
        $str = $db->prepare("INSERT INTO responsavel (loginUsuario, idDocumento, dateEntrada)
        VALUES (:login, :id, CONVERT(DATE, :data,103))");
        $str->bindParam("login", $documento["responsavel"]);
        $str->bindParam("id", $documento["id"]);
        $str->bindParam("data", $data);
        $str->execute();
    }

    $str = $db->prepare("SELECT * FROM documento WHERE id = :id");
    $str->bindParam("id", $documento["id"]);
    $str->execute();
    $documentoC = $str->fetchAll();
    if (count($documentoC) > 0) {
        return $documentoC[0];
    } else {
        return array();
    }
}

function get_documentos_vencidos($db, $filtro)
{
    $data = $filtro["data"];
    $diferenca = $filtro["diferenca"];
    $str = $db->prepare("EXEC documentosVencidos :data, :diferenca, :s1, :s2, :t1, :t2, :r1, :r2");
    $dia = $data[6] . $data[7];
    $mes = $data[4] . $data[5];
    $ano = $data[0] . $data[1] . $data[2] . $data[3];
    $dataFormat = "$dia/$mes/$ano";
    $str->bindParam("data", $dataFormat);
    $str->bindParam("diferenca", $diferenca);
    $str->bindParam("s1", $filtro["s1"]);
    $str->bindParam("s2", $filtro["s2"]);
    $str->bindParam("t1", $filtro["t1"]);
    $str->bindParam("t2", $filtro["t2"]);
    $str->bindParam("r1", $filtro["r1"]);
    $str->bindParam("r2", $filtro["r2"]);
    $str->execute();
    $retorno = $str->fetchAll();
    return $retorno;
}

function get_documentos_encontrados($db, $filtro)
{
    $str = $db->prepare("EXEC documentosEncontrados :nome, :s1, :s2, :t1, :t2, :r1, :r2");
    $str->bindParam("nome", $filtro["nome"]);
    $str->bindParam("s1", $filtro["s1"]);
    $str->bindParam("s2", $filtro["s2"]);
    $str->bindParam("t1", $filtro["t1"]);
    $str->bindParam("t2", $filtro["t2"]);
    $str->bindParam("r1", $filtro["r1"]);
    $str->bindParam("r2", $filtro["r2"]);
    $str->execute();
    $retorno = $str->fetchAll();
    return $retorno;
}


function get_documentos($db)
{
    $str = $db->prepare("SELECT d.id, d.nome nome, s.nome setor, t.nome tipo, 
    CONVERT(NVARCHAR, dataCadastrado, 103) dataCadastrado,
    CONVERT(NVARCHAR, dataVencimento, 103) dataVencimento, u.nome responsavel FROM documento d 
    INNER JOIN setor s on s.id = d.idSetor
    INNER JOIN tipo t on t.id = d.idTipo
    INNER JOIN responsavel r on d.id = r.idDocumento
    INNER JOIN usuario u on u.login = r.loginUsuario
    AND r.dateSaida IS NULL
     WHERE d.bloqueado = 0");
    $str->execute();
    return $str->fetchAll();
}

function get_documento_byId($db, $id)
{
    $str = $db->prepare("SELECT d.id, d.nome nome, s.id setor, t.id tipo,  
    CONVERT(NVARCHAR, dataCadastrado, 120) dataCadastrado,
    CONVERT(NVARCHAR, dataVencimento, 120) dataVencimento, 
    u.login responsavel FROM documento d 
    INNER JOIN setor s on s.id = d.idSetor
    INNER JOIN tipo t on t.id = d.idTipo  
    INNER JOIN responsavel r on d.id = r.idDocumento
    INNER JOIN usuario u on u.login = r.loginUsuario
    WHERE d.id = :id AND d.bloqueado = 0 AND r.dateSaida IS NULL");
    $str->bindParam("id", $id);
    $str->execute();
    return $str->fetchAll();
}


function documento_delete($db, $id)
{
    $str = $db->prepare("UPDATE documento SET bloqueado = 1 WHERE id = :id");
    $str->bindParam("id", $id);
    $str->execute();
    return "ok!";
}