<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'dao.php';
// Routes


//Cadastro
$app->post('/ativo', function ($request, $response, $args) {
    $ativo = $request->getParsedBody();
    $retorno = ativo_cadastro($this->db, $ativo);
    return $this->response->withJson($retorno);
});
//Deletar
$app->delete('/ativo/{id}', function ($request, $response, $args) {
    $retorno = ativo_delete($this->db, $args["id"]);
    return $this->response->withJson($retorno);
});

//Alterar
$app->put('/ativo/{id}', function ($request, $response, $args) {
    $ativo = $request->getParsedBody();
    $retorno = ativo_alterar($this->db, $ativo);
    return $this->response->withJson($retorno);
});

//Selecionar todos
$app->get('/ativo', function ($request, $response, $args) {
    $retorno = get_ativos($this->db);
    return $this->response->withJson($retorno);
});

//Procurar via id
$app->get('/ativo/{id}', function ($request, $response, $args) {
    $retorno = get_ativos_id($this->db,$args["id"]);
    return $this->response->withJson($retorno);
});
