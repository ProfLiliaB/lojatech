<?php
//padrão para criar uma conexãO
$host = "localhost";
$banco = "lojatechteste";
$user = "root";
$senha = "";
$conexao = new PDO("mysql:host=$host;dbname=$banco", $user, $senha);
// a parte de laranja do PDO é padrao não pode ser mudado só se usa essa conexão com o PDO//
if(!$conexao) { //! se for verdadeiro  torne falso se ão for verdadeiro apareça deu ruim
    echo "Deu, ruim";
}