<?php
session_start();
if ($_SESSION['id_usuario']) {
    $id_usuario = $_SESSION['id_usuario'];
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
            include_once "admin/config.php";
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
                <div class="grid">
                    <h3>Meus pedidos</h3>
                    <?php
                    $url = "https://api.mercadopago.com/v1/payments/search?sort=date_created&criteria=desc&external_reference=ID_REF&range=date_created&begin_date=NOW-30DAYS&end_date=NOW&payer.id=$id_usuario";
                    $ch = curl_init();
                    curl_setopt_array($ch, [
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => [
                            'Content-Type: application/json',
                            'Authorization: Bearer ' . CHAVE_API_MP
                        ]
                    ]);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $dados = json_decode($response, true);
                    echo "<pre>";
                    print_r($dados);
                    echo "</pre>";
                    ?>
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