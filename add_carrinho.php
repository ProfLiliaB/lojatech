<?php
define('display_errors', 'off');
include_once "conexao.php";
$id = $_GET['id'];
$pg = $_GET['pg']??'';
$select = $conexao->prepare("SELECT * FROM produto WHERE id_produto = :id");
$select->bindParam('id', $id);
$select->execute();
if ($prod = $select->fetch(PDO::FETCH_ASSOC)) {
    $nome = $prod['nome_produto'] ?? "";
    $valor = $prod['valor'] ?? 0;
    $desc = $prod['descricao_produto'];
    $qtd = 1;
    session_start();
    if (empty($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id] = [
            'nome' => $nome,
            'descricao' => $desc,
            'valor' => $valor,
            'qtd' => $qtd
        ];
    } else {
        $_SESSION['carrinho'][$id]['qtd'] += $qtd;
    }
    if($pg) {
        header('location: '.$pg.'.php');
    } else {
        echo 'Adicionado ao Carrinho <a href="carrinho.php"><i class="fa fa-cart-arrow-down"></i></a>';
    }    
} else {
    if($pg) {
        header('location: '.$pg.'.php');
    } else {
        echo 'Erro <i class="fa fa-ban"></i>';
    }
}
