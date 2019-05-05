<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'dao.php';
// Routes

$app->get('/tipos', function ($request, $response) {
    $retorno = get_tipos($this->db);
    return $this->response->withJson($retorno);
});

$app->get('/tipos/{tipo}', function ($request, $response, $args) {
    $retorno = get_tipos_id($this->db, $args["tipo"]);
    return $this->response->withJson($retorno);
});

$app->post('/tipos', function ($request, $response) {
    $tipo = $request->getParsedBody();
    $retorno = inserir_tipos($this->db, $tipo);
    return $this->response->withJson($retorno);
});
$app->put('/tipos/{tipo}', function ($request, $response, $args) {
    $tipo = $request->getParsedBody();
    $retorno = update_tipos($this->db, $args["tipo"], $tipo);
    return $this->response->withJson($retorno);
});


$app->get('/tiposByName/{nome}', function ($request, $response, $args) {
    $retorno = get_tipos_name($this->db, $args["nome"]);
    return $this->response->withJson($retorno);
});
$app->get('/tipoByName/{id}/{nome}', function ($request, $response, $args) {
    $retorno = get_tipos_id_name($this->db, $args["id"], $args["nome"]);
    return $this->response->withJson($retorno);
});


$app->get('/tiposRecuperar/{tipos}', function ($request, $response, $args) {
    $retorno = recuperarTipos($this->db, $args["tipos"]);
    return $this->response->withJson($retorno);
});

$app->delete('/tipos/{tipos}', function ($request, $response, $args) {
    $retorno = deleteTipos($this->db, $args["tipos"]);
    return $this->response->withJson($retorno);
});
