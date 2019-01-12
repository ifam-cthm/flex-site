<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'dao.php';
// Routes

$app->get('/tipos', function ($request, $response) {
    $retorno = get_tipos($this->db);
    return $this->response->withJson($retorno);
});