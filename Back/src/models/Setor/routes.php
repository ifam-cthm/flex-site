<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'dao.php';
// Routes

$app->get('/setores', function ($request, $response) {
    $retorno = get_setores($this->db);
    return $this->response->withJson($retorno);
});