<?php
include_once "../conexao.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $msg = "Cadastrado com sucesso!";
    $id = $_POST['id'] ?? '';
    $nome = $_POST['nome'];
    $data = [
        'nome' => $nome  
    ];
    if($id) {
        $msg = "Alterado com sucesso!";
        $data['id'] = $id;
        $sql = "UPDATE categoria SET nome_categoria) = :nome WHERE id_categoria = :id";
    } else {
       $sql = "INSERT INTO categoria (nome_categoria) VALUES (:nome)";
    }
    $insert = $conexao->prepare($sql);
    if ($insert->execute($data)) {
        echo $msg;
    } else {
        echo "Não foi possivel cadastrar!";
    }
}