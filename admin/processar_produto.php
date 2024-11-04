<?php
// Conexão com o banco de dados - Não copiar o que está em cinza
include_once "conexao.php";


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $valor = $_POST['valor'];
    $id_categoria = $_POST['id_categoria']; // pegamos o parametro
    $descricao = $_POST['descricao'];
    $novo = [
        'nome'=> $nome,
        'valor'=> $valor,
        'descr'=> $descricao,
        'id_categoria'=> $id_categoria // inserimos no array
        
    ];
    echo "INSERT INTO produtos 
    (nome_produto, valor_produto, descricao_produto, id_categoria)
     VALUES (:nome, :valor, :descr, :id_categoria)";
    $insert = $conexao->prepare("INSERT INTO produtos 
    (nome_produto, valor_produto, descricao_produto, id_categoria)
     VALUES (:nome, :valor, :descr, :id_categoria)"); // Gravamos
    // $insert->bindParam('nome', $nome); 
    // $insert->bindParam('valor', $valor);
    // $insert->bindParam('descr', $descricao);
    if($insert->execute($novo)){//retorna true | false
        header('location: listar_produtos.php?msg=Cadastrado com sucesso!');
    } else {
        header('location: listar_produtos.php?msg=Não foi possivel cadastrar!');
    }
}