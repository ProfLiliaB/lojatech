<?php
session_start();
$id = "";
$pg = $_GET['pg'] ?? '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_SESSION['carrinho'])) {
        if ($_SESSION['carrinho'][$id]) {
            $qtd = intval($_SESSION['carrinho'][$id]['qtd']);
            if ($qtd > 1) {
                $_SESSION['carrinho'][$id]['qtd'] -= 1;
            } else {
                unset($_SESSION['carrinho'][$id]);
            }
        }
    } else {
        $_SESSION['carrinho'] = [];
    }
} else {
    $_SESSION['carrinho'] = [];
}
if ($pg) {
    header("location: $pg.php");
} else {
    echo 'Carrinho vazio <i class="fa fa-cart"></i>';
}