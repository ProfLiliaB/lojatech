<?php
include_once "../conexao.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    $id_usuario = $_SESSION['id_usuario'];
    $id = $_POST['id']??'';
    $cep = $_POST['cep'];
    $rua = $_POST['rua'];
    $n = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $uf = $_POST['uf'];
    $comp = $_POST['complemento'];
    $msg = "Cadastrado com sucesso!";
    $data = [
        'usuario' => $id_usuario, 
        'cep' => $cep, 
        'rua' => $rua, 
        'n' => $n,
        'bairro' => $bairro,
        'cidade' => $cidade,
        'uf' => $uf,
        'comp' => $comp
    ];
    if($id) {
        $msg = "Alterado com sucesso!";
        $data['id'] = $id;
        $sql = "UPDATE endereco SET cep = :cep, rua = :rua, numero = :n, bairro = :bairro, cidade = :cidade, uf = :uf, complemento = :comp WHERE id_usuario = :usuario && id_endereco = :id";
    } else {
        $sql = "INSERT INTO endereco (id_usuario, cep, rua, numero, bairro, cidade, uf, complemento) VALUES (:usuario, :cep, :rua, :n, :bairro, :cidade, :uf, :comp)";
    }
    $acao = $conexao->prepare($sql);
    if ($acao->execute($data)) {
        echo $msg;
    } else {
        echo "Não foi possivel processar!";
    }
}