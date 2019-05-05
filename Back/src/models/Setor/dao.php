<?php

function get_setores($db)
{
    $str = $db->prepare("SELECT id, nome, bloqueado FROM setor 
        ");
    $str->execute();
    $retorno = $str->fetchAll();
    return $retorno;
}

function get_setores_id($db, $id)
{
    $str = $db->prepare("SELECT id, nome, bloqueado FROM setor where id = :id");
    $str->bindParam("id", $id);
    $str->execute();
    $retorno = $str->fetchAll();
    return $retorno;
}


function get_setores_name($db, $nome)
{
    $str = $db->prepare("SELECT id, nome, bloqueado FROM setor where nome = :nome");
    $str->bindParam("nome", $nome);
    $str->execute();
    $retorno = $str->fetchAll();
    return $retorno;
}

function get_setores_id_name($db, $id, $nome)
{
    $str = $db->prepare("SELECT id, nome, bloqueado FROM setor where nome = :nome AND id <> :id");
    $str->bindParam("nome", $nome);
    $str->bindParam("id", $id);
    $str->execute();
    $retorno = $str->fetchAll();
    return $retorno;
}


function inserir_setor($db, $setor)
{
    $str = $db->prepare("INSERT INTO setor (nome, bloqueado)
    VALUES (:nome, 0);");
    $str->bindParam("nome", $setor["nome"]);
    $str->execute();
    return true;
}

function update_setor($db, $id, $setor)
{
    $str = $db->prepare("UPDATE setor SET nome = :nome WHERE id = :id");
    $str->bindParam("nome", $setor["nome"]);
    $str->bindParam("id", $id);
    $str->execute();
    return true;
}

function recuperarSetor($db, $id)
{
    $str = $db->prepare("UPDATE setor SET bloqueado = 0 WHERE id = :id");
    $str->bindParam("id", $id);
    $str->execute();
    return true;
}


function deleteSetor($db, $id)
{
    $str = $db->prepare("UPDATE setor SET bloqueado = 1 WHERE id = :id");
    $str->bindParam("id", $id);
    $str->execute();
    return true;
}
