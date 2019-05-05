<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'dao.php';
// Routes

$app->get('/setor', function ($request, $response) {
    $retorno = get_setores($this->db);
    return $this->response->withJson($retorno);
});

$app->get('/setorByName/{nome}', function ($request, $response, $args) {
    $retorno = get_setores_name($this->db, $args["nome"]);
    return $this->response->withJson($retorno);
});
$app->get('/setorByName/{id}/{nome}', function ($request, $response, $args) {
    $retorno = get_setores_id_name($this->db, $args["id"], $args["nome"]);
    return $this->response->withJson($retorno);
});

$app->get('/setor/{id}', function ($request, $response, $args) {
    $retorno = get_setores_id($this->db, $args["id"]);
    return $this->response->withJson($retorno);
});

$app->post('/setor', function ($request, $response, $args) {
    $setor = $request->getParsedBody();
    $retorno = inserir_setor($this->db, $setor);
    return $this->response->withJson($retorno);
});

$app->put('/setor/{setor}', function ($request, $response, $args) {
    $setor = $request->getParsedBody();
    $retorno = update_setor($this->db, $args["setor"], $setor);
    return $this->response->withJson($retorno);
});

$app->delete('/setor/{setor}', function ($request, $response, $args) {
    $retorno = deleteSetor($this->db, $args["setor"]);
    return $this->response->withJson($retorno);
});


$app->get('/setorRecuperar/{setor}', function ($request, $response, $args) {
    $retorno = recuperarSetor($this->db, $args["setor"]);
    return $this->response->withJson($retorno);
});
