<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'dao.php';
// Routes

$app->get('/metas', function ($request, $response, $args) {
    $metas = get_metas($this->db);
    return $this->response->withJson($metas);
});

$app->get('/metas/{ano}', function ($request, $response, $args) {
    $metas = get_metas_ano($this->db, $args["ano"]);
    return $this->response->withJson($metas);
});

$app->post('/metas', function ($request, $response, $args) {
    $meta = $request->getParsedBody();
    $salvo = inserir_meta($this->db, $meta);
    return $this->response->withJson($salvo);
});