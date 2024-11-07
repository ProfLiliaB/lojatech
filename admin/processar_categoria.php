<?php
include_once "conexao.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $insert = $conexao->prepare("INSERT INTO categorias (nome_categoria) VALUES (?)");
    if ($insert->execute([$nome])) {
        header('location: listar_categorias.php?msg=Cadastrado com sucesso!');
    } else {
        header('location: listar_categorias.php?msg=Não foi possivel cadastrar!');
    }
}