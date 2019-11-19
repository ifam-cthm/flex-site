<?php

    function get_ativos_id($db,$id){
        $str = $db->prepare("SELECT * FROM ativo a, adicionalAtivo aa WHERE aa.id=:id and aa.idAtivo=a.id");
        $str->bindParam("id", $id);
        $str->execute();
        return $str->fetchAll();
    }
    function get_ativos($db){
        $str = $db->prepare("SELECT * FROM ativo, adicionalAtivo");
        $str->execute();
        return $str->fetchAll();
    }
    function ativo_alterar($db, $ativo){
        $str = $db->prepare("UPDATE adicionalAtivo SET
        idLinha=:idLinha, idSetor=:idSetor, idAtivo=:idAtivo, registro=:registro,
        descricao=:descricao, marca=:marca, modelo=:modelo, serie=:serie,
        ativoFixo=:ativoFixo, faixaMedicao:=faixaMedicao,calibracao=:calibracao,
        proximaCalibracao=:proximaCalibracao");
        $str->bindParam("id", $ativo["id"]);
        $str->bindParam("idLinha", $ativo["idLinha"]);
        $str->bindParam("idSetor", $ativo["idSetor"]);
        $str->bindParam("idAtivo", $ativo["idAtivo"]);
        $str->bindParam("registro", $ativo["registro"]);
        $str->bindParam("descricao", $ativo["descricao"]);
        $str->bindParam("marca", $ativo["marca"]);
        $str->bindParam("modelo", $ativo["modelo"]);
        $str->bindParam("serie", $ativo["serie"]);
        $str->bindParam("ativoFixo", $ativo["ativoFixo"]);
        $str->bindParam("faixaMedicao", $ativo["faixaMedicao"]);
        $str->bindParam("calibracao", $ativo["calibracao"]);
        $str->bindParam("proximaCalibracao", $ativo["proximaCalibracao"]);
        $str->execute();
        $str = $db->prepare("SELECT TOP 1 * FROM adicionalAtivo ORDER BY id DESC");
        $str->execute();
        return $str->fetchAll();
    }
    function ativo_delete($db, $id){
        $str = $db->prepare("SELECT * FROM adicionalAtivo WHERE id=:id");
        $str->bindParam("id", $id);
        $str->execute();
        return $str->fetchAll();
    }
    function ativo_cadastro($db, $ativo){
                $str = $db->prepare("INSERT INTO adicionalAtivo
                (idLinha,idSetor,idAtivo,registro
                ,descricao,marca,modelo,serie,ativoFixo,faixaMedicao,
                calibracao,proximaCalibracao)VALUES(idLinha=:idLinha,
                idSetor=:idSetor,idAtivo=:idAtivo,registro=:registro,
                descricao=:descricao,
                marca=:marca,modelo=:modelo,
                serie=:serie,ativoFixo=:ativoFixo,faixaMedicao=:faixaMedicao,
                calibracao=:calibracao,
                proximaCalibracao=:proximaCalibracao)");
                $str->bindParam("id", $ativo["id"]);
                $str->bindParam("idLinha", $ativo["idLinha"]);
                $str->bindParam("idSetor", $ativo["idSetor"]);
                $str->bindParam("idAtivo", $ativo["idAtivo"]);
                $str->bindParam("registro", $ativo["registro"]);
                $str->bindParam("descricao", $ativo["descricao"]);
                $str->bindParam("marca", $ativo["marca"]);
                $str->bindParam("modelo", $ativo["modelo"]);
                $str->bindParam("serie", $ativo["serie"]);
                $str->bindParam("ativoFixo", $ativo["ativoFixo"]);
                $str->bindParam("faixaMedicao", $ativo["faixaMedicao"]);
                $str->bindParam("calibracao", $ativo["calibracao"]);
                $str->bindParam("proximaCalibracao", $ativo["proximaCalibracao"]);
                $str->execute();
                $str = $db->prepare("SELECT TOP 1 * FROM adicionalAtivo ORDER BY id DESC");
                $str->execute();
                return $str->fetchAll();
    }
