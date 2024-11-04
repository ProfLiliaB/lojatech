<?php
include_once "conexao.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $erro = "";
    $nome = $_POST['nome'];

    $padraoSenha = '~^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*\(\)\_\+\[\]\{\}\|\:\"\<\>\.\,\/\?\-]).{8,}$~';

    if (empty($nome) OR strlen($nome) < 3) {
        $erro .= "Digite um nome<br>";
    }
    $email = $_POST['email'];
    if (empty($email)) {
        $erro .= "Digite um email<br>";
    } else {
        $selectEmail = $conexao->prepare("SELECT email FROM usuario WHERE email = :email");
        $selectEmail->bindParam('email', $email);
        $selectEmail->execute();
        if($selectEmail->rowCount()){
            $erro .= "Email já cadastrado!<br>";
        }
    }
    $cpf = $_POST['cpf'];
    if (!preg_match('~\d{11}~', $cpf)) {
        $erro .= "Digite o CPF com 11 digitos<br>";
    } else {
        $selectCPF = $conexao->prepare("SELECT cpf FROM usuario WHERE cpf = :cpf");
        $selectCPF->bindParam('cpf', $cpf);
        $selectCPF->execute();
        if($selectCPF->rowCount()){
            $erro .= "CPF já cadastrado, tente outro!";
        }
    }
    $senha = $_POST['senha'];
  
    if (!preg_match($padraoSenha, $senha)) {
        $erro .= "Digite no mínimo 8 caracteres<br>Com pelo menos uma letra maiuscula uma letra minuscula<br>Um caracter especial<br>E pelo menos um número";
    } else {
        $senhaCripto = password_hash($senha, PASSWORD_DEFAULT);
    }
    echo $erro;
    if ($erro == "") {
        $novo = [
            'nome' => $nome,
            'email' => $email,
            'cpf' => $cpf,
            'senha' => $senhaCripto
        ];
        $insert = $conexao->prepare("INSERT INTO usuario (nome, email, cpf, senha)
         VALUES (:nome, :email, :cpf, :senha)");
        if ($insert->execute($novo)) {
            //header('location: cadastro.php?status=ok');
            echo "cadastrado com sucesso!";
        } else {
            //header('location: cadastro.php?status=erro');
            echo "Erro ao cadastrar!";
        }
    }
}
