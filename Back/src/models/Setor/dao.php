<?php

function get_setores($db)
{
    $str = $db->prepare("SELECT id, nome FROM setor 
        WHERE bloqueado = 0");
    $str->execute();
    $retorno = $str->fetchAll();
    return $retorno;
}