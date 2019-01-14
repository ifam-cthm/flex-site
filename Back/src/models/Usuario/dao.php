<?php


function get_responsaveis($db)
{
    $str = $db->prepare("SELECT nome, login FROM usuario");
    $str->execute();
    return $str->fetchAll();
}

function iniciar($db)
{
    $str = $db->prepare("SELECT count(*) AS setores FROM setor");
    $str->execute();
    $retorno = $str->fetchAll();
    if ($retorno[0]["setores"] == 0) {
        $str = $db->prepare("EXEC inicializarBanco");
        $str->execute();
    }
    $str = $db->prepare("SELECT count(*) AS usuarios FROM usuario");
    $str->execute();
    $retorno = $str->fetchAll();
    return $retorno[0];
}

function login($db, $login)
{
    $str = $db->prepare("SELECT u.nome, u.login FROM usuario u INNER JOIN setor s ON s.id = u.idSetor 
        WHERE u.login = :login AND u.senha = :senha AND u.bloqueado != 1");
    $str->bindParam("login", $login["login"]);
    $str->bindParam("senha", $login["senha"]);
    $str->execute();
    $usuario = $str->fetchAll();
    if (count($usuario) > 0) {
        return $usuario[0];
    } else {
        return array();
    }
}

function usuario_cadastroAdministrador($db, $usuario)
{
    $str = $db->prepare("INSERT INTO usuario (nome, login, senha, idSetor, administrador) VALUES 
        (:nome, :login, :senha, :idSetor, 1)");
    $str->bindParam("nome", $usuario["nome"]);
    $str->bindParam("login", $usuario["login"]);
    $str->bindParam("senha", $usuario["senha"]);
    $str->bindParam("idSetor", $usuario["idSetor"]);
    $str->execute();

    $str = $db->prepare("SELECT u.nome, u.login FROM usuario u INNER JOIN setor s ON s.id = u.idSetor 
        WHERE u.login = :login");
    $str->bindParam("login", $usuario["login"]);
    $str->execute();
    $usuarios = $str->fetchAll();
    if (count($usuarios) > 0) {
        return $usuarios[0];
    } else {
        return array();
    }
}

function usuario_cadastro($db, $usuario)
{
    $str = $db->prepare("INSERT INTO usuario (nome, login, senha, idSetor) VALUES 
        (:nome, :login, :senha, :idSetor)");
    $str->bindParam("nome", $login["nome"]);
    $str->bindParam("login", $login["login"]);
    $str->bindParam("senha", $login["senha"]);
    $str->bindParam("idSetor", $login["idSetor"]);
    $str->execute();

    $str = $db->prepare("SELECT u.nome, u.login FROM usuario u INNER JOIN setor s ON s.id = u.idSetor 
        WHERE u.login = :login");
    $str->bindParam("login", $login["login"]);
    $str->execute();
    $usuario = $str->fetchAll();
    if (count($usuario) > 0) {
        return $usuario[0];
    } else {
        return array();
    }
}

function responsavel_cadastro($db, $responsavel)
{
    $str = $db->prepare("INSERT INTO responsavel (loginUsuario, idDocumento, dateEntrada) VALUES 
        (:loginUsuario, :idDocumento, CONVERT(DATE, :dateEntrada,103))");
    $str->bindParam("loginUsuario", $responsavel["loginUsuario"]);
    $str->bindParam("idDocumento", $responsavel["idDocumento"]);
    $data = date('d/m/Y');
    $str->bindParam("dateEntrada", $data);
    $str->execute();

    $str = $db->prepare("SELECT r.loginUsuario, r.idDocumento FROM responsavel r 
        WHERE r.loginUsuario = :loginUsuario and r.idDocumento = :idDocumento");
    $str->bindParam("loginUsuario", $login["loginUsuario"]);
    $str->bindParam("idDocumento", $login["idDocumento"]);
    $str->execute();
    $usuario = $str->fetchAll();
    if (count($usuario) > 0) {
        return $usuario[0];
    } else {
        return array();
    }
}