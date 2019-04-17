<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'dao.php';
// Routes
$app->get("/usuario", function ($request, $response, $args) {
    $retorno = get_usuarios($this->db);
    return $this->response->withJson($retorno);
});
$app->post("/saveConfig", function ($request, $response, $args) {
    $filtros = $request->getParsedBody();
    $retorno = salvar_filtros($this->db, $filtros);
    return $this->response->withJson($retorno);
});
$app->get("/usuario/{login}", function ($request, $response, $args) {
    $retorno = get_usuarios_byLogin($this->db, $args["login"]);
    return $this->response->withJson($retorno);
});

$app->post('/usuario', function ($request, $response, $args) {
    $usuario = $request->getParsedBody();
    $retorno = usuario_cadastro($this->db, $usuario);
    return $this->response->withJson($retorno);
});

$app->put('/usuario/{login}', function ($request, $response, $args) {
    $usuario = $request->getParsedBody();
    $retorno = usuario_atualizar($this->db, $usuario);
    return $this->response->withJson($retorno);
});

$app->post('/usuario/administrador', function ($request, $response, $args) {
    $usuario = $request->getParsedBody();
    $retorno = usuario_cadastroAdministrador($this->db, $usuario);
    return $this->response->withJson($retorno);
});
/////////////////////////////////////////////////////////////////////////////////////////////////////
$app->get("/responsaveis", function ($request, $response, $args) {
    $retorno = get_responsaveis($this->db);
    return $this->response->withJson($retorno);
});

$app->get('/iniciar', function ($request, $response) {
    $retorno = iniciar($this->db);
    return $this->response->withJson($retorno);
});

$app->post('/login', function ($request, $response, $args) {
    $login = $request->getParsedBody();
    $retorno = login($this->db, $login);
    return $this->response->withJson($retorno);
});


$app->get("/verificarExistADM", function ($request, $response, $args) {
    $retorno = verificarADM($this->db);
    return $this->response->withJson($retorno);
});

$app->get("/menu/{login}", function ($request, $response, $args) {
    $usuario = get_usuarios_byLogin($this->db, $args["login"]);

    $arrayCadastro = array(
        array(
            "title" => "Setores",
            "path" => "ListarSetores"
        ),
        array(
            "title" => "Tipo de documentos",
            "path" => "ListarTipos"
        ),
        array(
            "title" => "Documentos",
            "path" => "ListaDocumentos"
        ),
        array(
            "title" => "Usuarios",
            "path" => "ListaUsuarios"
        ),
    );

    $arrayDocumentos = array(
        array(
            "icon" => "insert_drive_file",
            "title" => "Documentos",
            "path" => "DocumentosVencidos"
        ),
        array(
            "icon" => "insert_drive_file",
            "title" => "Buscar documentos",
            "path" => " BuscaDocumentos"
        ),
    );

    $arrayNot = array(
        array(
            "title" => "Configurar Notificações",
            "path" => "ConfigurarNotificacoes"
        ),
        array(
            "title" => "Notificações",
            "path" => ""
        ),
    );

    $array = null;
    if ($usuario[0]["administrador"] == "1") {
        $array = array(
            "cadastro" => $arrayCadastro,
            "notificacoes" => $arrayNot,
            "documentos" => $arrayDocumentos
        );
    } else {
        $array = array(
            "cadastro" => array(),
            "notificacoes" => $arrayNot,
            "documentos" => $arrayDocumentos
        );
    }
    return $this->response->withJson($array);
});
