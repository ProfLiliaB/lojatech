<?php
include_once "../conexao.php";
$query = $conexao->prepare("SELECT COUNT(*) AS total FROM notifica WHERE lido_notifica = 0");
$query->execute();
$resultado = $query->fetch(PDO::FETCH_ASSOC);
echo $resultado['total'];