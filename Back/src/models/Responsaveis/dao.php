<?php


function get_metas($db)
{
    $str = $db->prepare("SELECT * FROM Metas");
    $str->execute();
    $metas = $str->fetchAll();
    return $metas;
}

function get_metas_ano($db, $ano)
{
    $str = $db->prepare("SELECT * FROM Metas WHERE ano = :ano");
    $str->bindParam("ano", $ano);
    $str->execute();
    $metas = $str->fetchAll();
    return $metas;
}

function inserir_meta($db, $meta)
{
    if (count(get_metas_ano($db, $meta["ano"]))> 0) {
        $str = $db->prepare("UPDATE Metas 
        SET janeiro = :janeiro, fevereiro = :fevereiro, 
            marco = :marco, abril = :abril, maio = :maio, junho = :junho, julho = :julho, 
            agosto = :agosto, setembro = :setembro, outubro = :outubro, 
            novembro = :novembro, dezembro = :dezembro, geral = :geral
            WHERE ano = :ano");
        $str->bindParam("ano", $meta["ano"]);
        $str->bindParam("janeiro", str_replace(",", ".", str_replace(".", "", $meta["janeiro"])));
        $str->bindParam("fevereiro", str_replace(",", ".", str_replace(".", "", $meta["fevereiro"])));
        $str->bindParam("marco", str_replace(",", ".", str_replace(".", "", $meta["marco"])));
        $str->bindParam("abril", str_replace(",", ".", str_replace(".", "", $meta["abril"])));
        $str->bindParam("maio", str_replace(",", ".", str_replace(".", "", $meta["maio"])));
        $str->bindParam("junho", str_replace(",", ".", str_replace(".", "", $meta["junho"])));
        $str->bindParam("julho", str_replace(",", ".", str_replace(".", "", $meta["julho"])));
        $str->bindParam("agosto", str_replace(",", ".", str_replace(".", "", $meta["agosto"])));
        $str->bindParam("setembro", str_replace(",", ".", str_replace(".", "", $meta["setembro"])));
        $str->bindParam("outubro", str_replace(",", ".", str_replace(".", "", $meta["outubro"])));
        $str->bindParam("novembro", str_replace(",", ".", str_replace(".", "", $meta["novembro"])));
        $str->bindParam("dezembro", str_replace(",", ".", str_replace(".", "", $meta["dezembro"])));
        $str->bindParam("geral", str_replace(",", ".", str_replace(".", "", $meta["geral"])));
        $str->execute();
        return "Atualizado com sucesso!";
    } else {
        $str = $db->prepare("INSERT INTO Metas 
            (ano, janeiro, fevereiro, marco, abril, maio, junho, julho, agosto, 
            setembro, outubro, novembro, dezembro, geral) VALUES
            (:ano, :janeiro, :fevereiro, :marco, :abril, :maio, :junho, :julho, :agosto, 
            :setembro, :outubro, :novembro, :dezembro, :geral)");
        $str->bindParam("ano", $meta["ano"]);
        $str->bindParam("janeiro", str_replace(",", ".", str_replace(".", "", $meta["janeiro"])));
        $str->bindParam("fevereiro", str_replace(",", ".", str_replace(".", "", $meta["fevereiro"])));
        $str->bindParam("marco", str_replace(",", ".", str_replace(".", "", $meta["marco"])));
        $str->bindParam("abril", str_replace(",", ".", str_replace(".", "", $meta["abril"])));
        $str->bindParam("maio", str_replace(",", ".", str_replace(".", "", $meta["maio"])));
        $str->bindParam("junho", str_replace(",", ".", str_replace(".", "", $meta["junho"])));
        $str->bindParam("julho", str_replace(",", ".", str_replace(".", "", $meta["julho"])));
        $str->bindParam("agosto", str_replace(",", ".", str_replace(".", "", $meta["agosto"])));
        $str->bindParam("setembro", str_replace(",", ".", str_replace(".", "", $meta["setembro"])));
        $str->bindParam("outubro", str_replace(",", ".", str_replace(".", "", $meta["outubro"])));
        $str->bindParam("novembro", str_replace(",", ".", str_replace(".", "", $meta["novembro"])));
        $str->bindParam("dezembro", str_replace(",", ".", str_replace(".", "", $meta["dezembro"])));
        $str->bindParam("geral", str_replace(",", ".", str_replace(".", "", $meta["geral"])));
        $str->execute();
        return "Salvo com sucesso!";

    }
}
