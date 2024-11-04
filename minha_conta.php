<?php 
if($_SESSION['id_usuario']) {
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/tech_icon.ico" type="image/x-icon">
    <title>LojaTech Tecnologias e mais</title>
    <link rel="stylesheet" href="icofont/icofont.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/produtos.css">
    <link rel="stylesheet" href="css/carrinho.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <header>
        <?php
        include_once "menu.php";
        ?>
    </header>
    <main>
        <div class="conteudo_central">
            <div class="grid">
                <div>Minha conta</div>
                <div>Nome:</div>
                <div>Nome da pessoa</div>
                <div>Email:</div>
                <div>Email da pessoa</div>
            </div>
        </div>        
    </main>
    <?php
        include_once "footer.php";
    ?>
    <script src="js/menu.js"></script>
</body>

</html>
<?php
} else {
    $_SESSION['pg'] = "minha_conta";
    header('location: login.php');
}
?>