<?php
//padrão para criar uma conexãO
$host = "localhost";
$banco = "lojatechteste";
$user = "root";
$senha = "";
$conexao = new PDO("mysql:host=$host;dbname=$banco", $user, $senha);
if(!$conexao) { 
    echo "Deu, ruim";
}