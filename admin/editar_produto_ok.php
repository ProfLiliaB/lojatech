<?php
// session_start();
// $status = isset($_SESSION['status']) ? $_SESSION['status'] : 0;
// if (isset($_SESSION['email']) && $status > 0) {
include_once "conexao.php";
$id_produto = $_POST["id_produto"];
$nome_produto = $_POST["nome_produto"];
$valor_produto = $_POST["valor_produto"];
$descricao_produto = $_POST["descricao_produto"];
$novo = [
    'id_produto' => $id_produto,
    'nome_produto' => $nome_produto,
    'valor_produto' => $valor_produto,
    'descricao_produto' => $descricao_produto,
];
$update = $conexao->prepare("UPDATE produto SET nome_produto = :nome_produto, valor = :valor_produto, descricao_produto = :descricao_produto WHERE id_produto = :id_produto");
if ($update->execute($novo)) {
    header('location: listar_produtos.php?msg=Alterado com sucesso!');
} else {
    header('location: listar_produtos.php?msg=Não foi possível alterar!');
}
// } else {
//    header('location: login.php?msg=Você precisa estar logado para acessar esta página.');
// }
