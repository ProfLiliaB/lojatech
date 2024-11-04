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
            <?php
            /*
            Array
            (
                [msg] => successo
                [collection_id] => 1327853149
                [collection_status] => approved
                [payment_id] => 1327853149
                [status] => approved
                [external_reference] => null
                [payment_type] => credit_card
                [merchant_order_id] => 24342003400
                [preference_id] => 22727655-05d36998-a0f4-4d35-913a-9938775d94a1
                [site_id] => MLB
                [processing_mode] => aggregator
                [merchant_account_id] => null
            )
            */
            include_once "conexao.php";
            $novo_pagto = [
                'msg'                 => $_GET['msg'],
                'collection_status'   => $_GET['collection_status'],
                'payment_id'          => $_GET['payment_id'],
                'status'              => $_GET['status'],
                'external_reference'  => $_GET['external_reference'],
                'payment_type'        => $_GET['payment_type'],
                'merchant_order_id'   => $_GET['merchant_order_id'],
                'preference_id'       => $_GET['preference_id'],
                'site_id'             => $_GET['site_id'],
                'processing_mode'     => $_GET['processing_mode'],
                'merchant_account_id' => $_GET['merchant_account_id'],
                'compra_id'           => $_GET['external_reference']
            ];
            $sql = "INSERT INTO pagto (
                msg, collection_status, payment_id, status, external_reference,
                payment_type, merchant_order_id, preference_id, site_id,
                processing_mode, merchant_account_id, compra_id
            ) VALUES (
                :msg, :collection_status, :payment_id, :status, :external_reference,
                :payment_type, :merchant_order_id, :preference_id, :site_id,
                :processing_mode, :merchant_account_id, :compra_id
            )";
            $pagto = $conexao->prepare($sql);
            if ($pagto->execute($novo_pagto)) {
                echo '<div>Pagamento ' . $novo_pagto['status'] . ' <a href="detalhe_pedido.php?id=' . $novo_pagto['payment_id'] . '">Detalhes do pedido</a></div>';
                //echo '<div><a href="pedidos.php?id='.$_SESSION['id_usuario'].'">Meus Pedidos</a></div>';
            } else {
                echo "Erro finalizar o pagamento.";
            }
            ?>
        </div>
    </main>
    <?php
    include_once "footer.php";
    ?>
    <script src="js/menu.js"></script>
</body>

</html>