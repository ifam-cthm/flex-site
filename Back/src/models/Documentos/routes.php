<?php

use Slim\Http\Request;
use Slim\Http\Response;

require 'dao.php';
// Routes

$app->get("/get_grafico_documentosXusuarios", function ($request, $response, $args) {
    $retorno = get_grafico_documentosXusuarios($this->db);
    return $this->response->withJson($retorno);
});

$app->get("/get_grafico_documentosXtipos", function ($request, $response, $args) {
    $retorno = get_grafico_documentosXtipos($this->db);
    return $this->response->withJson($retorno);
});


$app->post('/documento', function ($request, $response, $args) {
    $documento = $request->getParsedBody();
    $retorno = documento_cadastro($this->db, $documento);
    return $this->response->withJson($retorno);
});

$app->post('/documentosvencidos', function ($request, $response, $args) {
    $filtro = $request->getParsedBody();
    $retorno = get_documentos_vencidos($this->db, $filtro);
    return $this->response->withJson($retorno);
});

$app->post('/documentosencontrados', function ($request, $response, $args) {
    $filtro = $request->getParsedBody();
    $retorno = get_documentos_encontrados($this->db, $filtro);
    return $this->response->withJson($retorno);
});

$app->get("/documentos", function ($request, $response, $args) {
    $retorno = get_documentos($this->db);
    return $this->response->withJson($retorno);
});

$app->get("/documentos/{id}", function ($request, $response, $args) {
    $retorno = get_documento_byId($this->db, $args["id"]);
    return $this->response->withJson($retorno);
});

$app->put("/documentos/{id}", function ($request, $response, $args) {
    $documento = $request->getParsedBody();
    $retorno = documento_atualizacao($this->db, $documento);
    return $this->response->withJson($retorno);
});

$app->delete("/documentos/{id}", function ($request, $response, $args) {
    $retorno = documento_delete($this->db, $args["id"]);
    return $this->response->withJson($retorno);
});



$app->get("/documentos_vencimento", function ($request, $response, $args) {
    $retorno = exec('0 8 * * * ' + procurar_documentos_proximo_vencimento($this->db));
    foreach ($retorno as $aux) {
        email(
            $aux["usuario.email"],
            $aux["usuario.nome"],
            "Documento perto de vencer",
            "O documento" . $aux["documento.nome"] . "está há" . "" . "de vencer"
        );
    }
    return $this->response->withJson($retorno);
});
