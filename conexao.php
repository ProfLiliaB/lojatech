<?php
//padrão para criar uma conexãO
$host = "localhost";
$banco = "loja";
$user = "root";
$senha = "";
try {
    $conexao = new PDO("mysql:host=$host;dbname=$banco", $user, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    if (!$conexao) {
        echo "Eita, deu ruim";
    }
} catch (PDOException $e) {
    echo 'Connection Error: ' . $e->getMessage();
}