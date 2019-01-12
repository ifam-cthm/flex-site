<?php

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