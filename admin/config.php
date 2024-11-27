<?php
function varificaValorMaximo($valMaior, $valMenor, $con): float
{
    if ($valMaior > valoMaximo($con) or $valMenor > $valMaior) {
        $valMaior = valoMaximo($con);
    }
    return $valMaior;
}
function valoMaximo($conexao): float
{
    $sql = "SELECT max(valor) as m FROM produto";
    $max = $conexao->prepare($sql);
    $max->execute();
    $r = $max->fetch();
    return floatval($r["m"]);
}
function imagemPrincipal($id, $con) {
    $selectImg = $con->prepare("SELECT * FROM imagem WHERE status_imagem = 1 && id_produto = ?");
    $selectImg->execute([$id]);
    if ($selectImg->rowCount()) {
        $imagem = $selectImg->fetch();
        return $imagem['nome_imagem'];
    } else {
        return false;
    }
}

define("DIRETORIO", "./upload");
