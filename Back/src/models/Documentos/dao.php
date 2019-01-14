<?php

function documento_cadastro($db, $documento)
{
    $str = $db->prepare("INSERT INTO documento (nome, idSetor, idTipo, dataCadastrado, dataVencimento, bloqueado) VALUES 
        (:nome, :idSetor, :idTipo, CONVERT(DATE, :dataCadastrado,103), :dataVencimento,  0)");
    $str->bindParam("nome", $documento["nome"]);
    $str->bindParam("idSetor", $documento["setor"]);
    $str->bindParam("idTipo", $documento["tipo"]);
    $data = date('d/m/Y');
    $str->bindParam("dataCadastrado", $data);
    $str->bindParam("dataVencimento", $documento["dataVencimento"]);

    $str->execute();

    $str = $db->prepare("SELECT * FROM documento WHERE nome = :nome");
    $str->bindParam("nome", $documento["nome"]);
    $str->execute();
    $documento = $str->fetchAll();
    if (count($documento) > 0) {
        return $documento[0];
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