<?php
// session_start();
// $status = isset($_SESSION['status']) ? $_SESSION['status'] : 0;
// if (isset($_SESSION['email']) && $status > 0) {


    // Conexão com o banco de dados - Não copiar o que está em cinza
    include_once "conexao.php";

// Dados do formulário
$id_categoria = $_POST["id_categoria"];
$nome_categoria = $_POST["nome_categoria"];

// Verificar se a imagem foi enviada
    // Adicionar o conteúdo da imagem ao array de dados para o update
    $novo = [
        'id_categoria' => $id_categoria,
        'nome_categoria' => $nome_categoria
    ];

    // Query de update com o campo imagem (como BLOB)
    $update = $conexao->prepare("UPDATE categoria SET 
        nome_cat = :nome_categoria 
        WHERE id_cat = :id_categoria");
    // Executa a query e verifica o resultado
    if ($update->execute($novo)) {
        header('location: listar_categorias.php?msg=Alterado com sucesso!');
    } else {
        header('location: listar_categorias.php?msg=Não foi possível alterar!');
    }


// } else {
//    header('location: login.php?msg=Você precisa estar logado para acessar esta página.');
// }
?>
