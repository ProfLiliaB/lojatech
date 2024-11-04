<?php
include_once "conexao.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pag = $_SESSION['pg'].'.php'??'./';
    if(!file_exists($pag)) {
        $pag = "./";
    }
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $selectEmail = $conexao->prepare("SELECT * FROM usuario WHERE email = :email");
    $selectEmail->bindParam('email', $email);
    $selectEmail->execute();
    $array = $selectEmail->fetch(PDO::FETCH_ASSOC);
    if ($array) {
        $senha_banco = $array['senha'];
        $email_banco = $array['email'];
        $nome = $array['nome'];
        $id_usuario =  $array['id_usuario'];
        if ($email == $email_banco && password_verify($senha, $senha_banco)) {
            session_start();
            $_SESSION['email'] = $email_banco;
            $_SESSION['nome'] = $nome;
            $_SESSION['id_usuario'] = $id_usuario;
            header('Location: '.$pag);
        } else {
            echo "Login ou senha inválidos.";
        }
    } else {
        echo "Login ou senha inválidos.";
    }
}
?>
