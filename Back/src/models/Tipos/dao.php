<?php

function get_tipos($db)
{
    $str = $db->prepare("SELECT id, nome FROM tipo 
        WHERE bloqueado = 0");
    $str->execute();
    $retorno = $str->fetchAll();
    return $retorno;
}