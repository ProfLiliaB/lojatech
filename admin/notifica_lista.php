<?php
include_once "../conexao.php";
$query = $conexao->prepare("SELECT * FROM notifica ORDER BY data_notifica DESC LIMIT 5");
$query->execute();
while($r = $query->fetch(PDO::FETCH_ASSOC)) {
    echo '<li>'.$r['nome_notifica'].' '.$r['status_notifica'].'<li>';
}