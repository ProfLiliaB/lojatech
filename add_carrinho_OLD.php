<?php
// Conexão com o banco
include_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $id_produto = $_POST['id_produto'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];

    // Verificar se já existe uma compra (carrinho) para o usuário
    $sql = "SELECT id_usuario FROM compra WHERE id_usuario = :id_usuario";
    $stmt = $conexao->prepare($sql);
    $stmt->execute([':id_usuario' => $id_usuario]);
    
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Se o usuário não possui compra, inserir nova compra
    if (!$usuario) {
        $sql_insert = "INSERT INTO compra (id_usuario, data_compra) VALUES (:id_usuario, CURRENT_DATE)";
        $insert = $conexao->prepare($sql_insert);
        $insert->execute([':id_usuario' => $id_usuario]);
    }

    // Buscar o id_compra associado ao usuário
    $sql = "SELECT id_compra FROM compra WHERE id_usuario = :id_usuario ORDER BY id_compra DESC LIMIT 1";
    $stmt2 = $conexao->prepare($sql);
    $stmt2->execute([':id_usuario' => $id_usuario]);
    
    $compra = $stmt2->fetch(PDO::FETCH_ASSOC);
    $id_compra = $compra['id_compra'];

    // Inserir produto no carrinho (tabela de itens de compra)
    $sql_insert_produto = "INSERT INTO compra_itens (id_compra, id_produto, quantidade, valor)
                           VALUES (:id_compra, :id_produto, :quantidade, :valor)";
    $stmt_produto = $conexao->prepare($sql_insert_produto);
    $stmt_produto->execute([
        ':id_compra' => $id_compra,
        ':id_produto' => $id_produto,
        ':quantidade' => $quantidade,
        ':valor' => $valor
    ]);

}

header('location: index.php');
?>
