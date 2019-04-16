<?php


function get_responsaveis($db)
{
    $str = $db->prepare("SELECT nome, login FROM usuario");
    $str->execute();
    return $str->fetchAll();
}
function salvar_filtros($db, $filtros){
    $str = $db->prepare("UPDATE usuario SET isNotificationModal = :isNotificationModal, isNotificationEmail = :isNotificationEmail
    timeNotificationModal = :timeNotificationModal WHERE login=:login");
    $str->bindParam("isNotificationModal", $filtros["isNotificationModal"]);
    $str->bindParam("isNotificationEmail", $filtros["isNotificationEmail"]);
    $str->bindParam("timeNotificationModal", $filtros["timeNotificationModal"]);
    $str->bindParam("login", $filtros["login"]);
    $str->execute();
    $str = $db->prepare("SELECT timeNotificationModal FROM usuario u WHERE u.login=:login");
    $str->bindParam("login", $filtros["login"]);
    $retorno = $str->fetchAll();
    if(count($retorno)!=0){
        return $retorno[0];
    }else{
        return array();
    }
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
    $str = $db->prepare("SELECT u.nome, u.login, u.email FROM usuario u INNER JOIN setor s ON s.id = u.idSetor 
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
    $str = $db->prepare("INSERT INTO usuario (nome, login, senha, idSetor, email, administrador) VALUES 
        (:nome, :login, :senha, :idSetor, :email, :administrador)");
    $str->bindParam("nome", $usuario["nome"]);
    $str->bindParam("login", $usuario["login"]);
    $str->bindParam("senha", $usuario["senha"]);
    $str->bindParam("idSetor", $usuario["idSetor"]);
    $str->bindParam("email", $usuario["email"]);
    $str->bindParam("administrador", $usuario["administrador"]);
    $str->execute();

    $str = $db->prepare("SELECT u.nome, u.login FROM usuario u INNER JOIN setor s ON s.id = u.idSetor 
        WHERE u.login = :login");
    $str->bindParam("login", $usuario["login"]);
    $str->execute();
    $usuario = $str->fetchAll();
    if (count($usuario) > 0) {
        return $usuario[0];
    } else {
        return array();
    }
}

function get_usuarios($db)
{
    $str = $db->prepare("SELECT login, u.nome, s.nome setor, 
    CASE u.administrador  
        WHEN '0' THEN 'NÃO'
        ELSE 'SIM'
        END administrador
    FROM usuario u 
    INNER JOIN setor s on idSetor = s.id WHERE u.bloqueado = 0");
    $str->execute();
    return $str->fetchAll();
}

function get_usuarios_byLogin($db, $login)
{
    $str = $db->prepare("SELECT login, u.nome, idSetor
    FROM usuario u WHERE u.bloqueado = 0 AND 
    login = :login");
    $str->bindParam("login", $login);
    $str->execute();
    return $str->fetchAll();
}


function usuario_atualizar($db, $usuario)
{
    $str = $db->prepare("UPDATE usuario SET nome = :nome, idSetor = :idSetor 
        WHERE login = :login");
    $str->bindParam("nome", $usuario["nome"]);
    $str->bindParam("login", $usuario["login"]);
    $str->bindParam("idSetor", $usuario["idSetor"]);
    $str->execute();

    if (isset($usuario["senha"]) && $usuario["senha"] != "") {
        $str = $db->prepare("UPDATE usuario SET senha = :senha
        WHERE login = :login");
        $str->bindParam("senha", $usuario["senha"]);
        $str->bindParam("login", $usuario["login"]);
        $str->execute();
    }
    $str = $db->prepare("SELECT u.nome, u.login FROM usuario u INNER JOIN setor s ON s.id = u.idSetor 
        WHERE u.login = :login");
    $str->bindParam("login", $usuario["login"]);
    $str->execute();
    $usuario = $str->fetchAll();
    if (count($usuario) > 0) {
        return $usuario[0];
    } else {
        return array();
    }
}