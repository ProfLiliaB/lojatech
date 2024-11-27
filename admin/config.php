<?php
function varificaValorMaximo($valMaior, $valMenor, $con) {
    if ($valMaior > valoMaximo($con) or $valMenor > $valMaior) {
        $valMaior = valoMaximo($con);
    }
    return $valMaior;
}
function valoMaximo($conexao) {
    $sql = "SELECT max(valor) as m FROM produto";
    $max = $conexao->prepare($sql);
    $max->execute();
    $r = $max->fetch();
    return floatval($r["m"]);
}
function calculaCompra($conexao, $id) {
    $sql = "SELECT SUM(valor) as t FROM compra_itens i, compra c WHERE c.id_compra = i.id_compra && c.id_compra = ?";
    $max = $conexao->prepare($sql);
    $max->execute([$id]);
    $r = $max->fetch();
    return $r['t'];
}
function maiorCompra($conexao) {
    $sql = "SELECT MAX(total_valor) AS val FROM (SELECT SUM(i.valor) AS total_valor FROM compra_itens i JOIN compra c ON c.id_compra = i.id_compra GROUP BY c.id_compra) AS maiorCompra";
    $max = $conexao->prepare($sql);
    $max->execute();
    $r = $max->fetch();
    return $r['val'];
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
define('CHAVE_API_MP', "");
define("DIRETORIO", "./upload");
