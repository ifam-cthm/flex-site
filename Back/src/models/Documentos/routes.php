<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'dao.php';
// Routes

$app->post('/documento', function ($request, $response, $args) {
    $documento = $request->getParsedBody();
    $retorno = documento_cadastro($this->db, $documento);
    return $this->response->withJson($retorno);
});

$app->post('/documentosvencidos', function($request, $response, $args){
    $filtro = $request->getParsedBody();
    $retorno = get_documentos_vencidos($this->db, $filtro);
    return $this->response->withJson($retorno);
});