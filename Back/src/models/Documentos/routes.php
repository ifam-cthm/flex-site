<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'dao.php';
// Routes

$app->post('/documentosvencidos', function($request, $response, $args){
    $filtro = $request->getParsedBody();
    $retorno = get_documentos_vencidos($this->db, $filtro);
    return $this->response->withJson($retorno);
});