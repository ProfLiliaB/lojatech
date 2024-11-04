<?php
// 
                // Conexão com o banco de dados - Não copiar o que está em cinza
                include_once "conexao.php";


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];

    $novo = [
        'nome'=> $nome
    ];
    $insert = $conexao->prepare("INSERT INTO categorias 
    (nome_categoria) VALUES (:nome)");
    // $insert->bindParam('nome', $nome); 
    // $insert->bindParam('valor', $valor);
    // $insert->bindParam('descr', $descricao);
    if($insert->execute($novo)){//retorna true | false
        header('location: listar_categorias.php?msg=Cadastrado com sucesso!');
    } else {
        header('location: listar_categorias.php?msg=Não foi possivel cadastrar!');
    }
}
?>