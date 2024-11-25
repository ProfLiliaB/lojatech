<?php
include_once "conexao.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();
    $pag = isset($_SESSION['pg'])?$_SESSION['pg'].'.php':'';
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
        $id_usuario =  $array['id_usuario'];
        if (($email == $email_banco) && ($senha == $senha_banco)) {
        //if ($email == $email_banco && password_verify($senha, $senha_banco)) {
            //session_start();
            $_SESSION['email'] = $email_banco;
            $_SESSION['nome'] = $array['nome'];
            $_SESSION['cpf'] = $array['cpf'];
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
