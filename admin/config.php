<?php
function varificaValorMaximo($valMaior, $valMenor, $con): float {
    if($valMaior > valoMaximo($con) OR $valMenor > $valMaior) {
        $valMaior = valoMaximo($con);
    }
    return $valMaior;
}
function valoMaximo($conexao):float {
    $sql = "SELECT max(valor) as m FROM produto";
    $max = $conexao->prepare($sql);
    $max->execute();
    $r = $max->fetch();
    return floatval($r["m"]);
}