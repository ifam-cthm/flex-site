<?php

function get_tipos($db)
{
    $str = $db->prepare("SELECT id, nome, bloqueado, descricao FROM tipo");
    $str->execute();
    $retorno = $str->fetchAll();
    return $retorno;
}

function get_tipos_id($db, $id)
{
    $str = $db->prepare("SELECT id, nome, bloqueado, descricao FROM tipo where id = :id");
    $str->bindParam("id", $id);
    $str->execute();
    $retorno = $str->fetchAll();
    return $retorno;
}

function inserir_tipos($db, $tipos)
{
    $str = $db->prepare("INSERT INTO tipo (nome, bloqueado, descricao)
        VALUES (:nome, 0, :descricao)");
    $str->bindParam("nome", $tipos["nome"]);
    $str->bindParam("descricao", $tipos["descricao"]);
    $str->execute();
    return true;
}

function update_tipos($db, $tipo, $tipos)
{
    $str = $db->prepare("UPDATE tipo SET nome = :nome, descricao = :descricao
    WHERE id = :id");
    $str->bindParam("nome", $tipos["nome"]);
    $str->bindParam("descricao", $tipos["descricao"]);
    $str->bindParam("id", $tipo);
    $str->execute();
    return true;
}

function recuperarTipos($db, $tipo)
{
    $str = $db->prepare("UPDATE tipo SET bloqueado = 0 where id = :id");
    $str->bindParam("id", $tipo);
    $str->execute();
    return true;
}

function deleteTipos($db, $tipo)
{
    $str = $db->prepare("UPDATE tipo SET bloqueado = 1 where id = :id");
    $str->bindParam("id", $tipo);
    $str->execute();
    return true;
}
