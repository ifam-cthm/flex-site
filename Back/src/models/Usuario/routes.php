<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'dao.php';
// Routes

$app->post('/login', function ($request, $response, $args) {
    $login = $request->getParsedBody();
    $retorno = login($this->db, $login);
    return $this->response->withJson($retorno);
});

$app->post('/usuario', function ($request, $response, $args) {
    $usuario = $request->getParsedBody();
    $retorno = usuario_cadastro($this->db, $usuario);
    return $this->response->withJson($retorno);
});

$app->post('/responsavel', function ($request, $response, $args) {
    $responsavel = $request->getParsedBody();
    $retorno = responsavel_cadastro($this->db, $responsavel);
    return $this->response->withJson($retorno);
});

$app->post('/usuario/administrador', function ($request, $response, $args) {
    $usuario = $request->getParsedBody();
    $retorno = usuario_cadastroAdministrador($this->db, $usuario);
    return $this->response->withJson($retorno);
});

$app->get("/responsaveis", function ($request, $response, $args) {
    $retorno = get_responsaveis($this->db);
    return $this->response->withJson($retorno);
});


$app->get('/iniciar', function ($request, $response) {
    $retorno = iniciar($this->db);
    return $this->response->withJson($retorno);
});