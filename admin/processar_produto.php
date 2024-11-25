<?php
include_once "../conexao.php";
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $msg = "Cadastro realizado com sucesso!";
    $id = $_POST['id']??'';
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $id_categoria = $_POST['id_categoria'];
    $descricao = $_POST['descricao'];
    $estoque = $_POST['estoque'];
    $novo = [
        'nome'=> $nome,
        'valor'=> $valor,
        'descr'=> $descricao,
        'id_cat'=> $id_categoria,
        'estoque' => $estoque
    ];
    if($id){
        $novo['id'] = $id;
        $msg = "Cadastro alterado com sucesso!";
        $sql = "UPDATE produto SET nome_produto = :nome, descricao_produto = :descr, valor = :valor, id_categoria = :id_cat, estoque = :estoque WHERE id_produto = :id";
    } else {
        $sql = "INSERT INTO produto (nome_produto, valor, descricao_produto, id_categoria, estoque) VALUES (:nome, :valor, :descr, :id_cat, :estoque)";
    }
    $acao = $conexao->prepare($sql);
    if($acao->execute($novo)){
        echo $msg;
    } else {
        echo "Não foi possivel processar o pedido!";
    }
}