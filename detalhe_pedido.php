<?php session_start(); ?>
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
        include_once "conexao.php";
        ?>
    </header>
    <main>
        <div class="conteudo_central">
            <?php
            include_once "conexao.php";
            $usuario = $_SESSION['id_usuario'];
            $payment_id = $_GET['id'] ?? '';
            if (!$payment_id) {
                header('location: minha_conta.php');
            }
            $selectPagto = $conexao->prepare("SELECT * FROM `pagto` WHERE payment_id = ?");
            $selectPagto->execute([$payment_id]);
            $rp = $selectPagto->fetch(PDO::FETCH_ASSOC);
            $id_compra = $rp['compra_id'];
            $select = $conexao->prepare("SELECT * FROM compra c, produto p, compra_itens i WHERE c.id_compra = i.id_compra &&  p.id_produto = i.id_produto && c.id_compra = ?");
            $select->execute([$id_compra]);
            while ($rs = $select->fetch()) {
                $valor_produto = $rs['valor'];
                $total_por_prod = floatval($rs['valor']) * floatval($rs['quantidade']);
                echo "
                    <div>
                        " . $rs['nome_produto'] . " R$ " . number_format($valor_produto, 2, ', ', ' . ') . "
                        X " . $rs['quantidade'] . " Total: R$ " . number_format($total_por_prod, 2, ', ', ' . ') . "
                    </div>";
            }
            $url = 'https://api.mercadopago.com/v1/payments/' . $payment_id;
            $access_token = '';
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $access_token
                ]
            ]);
            $response = curl_exec($ch);
            curl_close($ch);
            $dados = json_decode($response, true);
            // echo "<pre>";
            // print_r($dados);
            // echo "</pre>";
            $dados = json_decode($response, true);
            if (isset($dados['id'])) {
                echo "<h1>Detalhes do Pagamento</h1>";
                echo "<p>ID do Pagamento: " . htmlspecialchars($dados['id']) . "</p>";
                echo "<p>Status: " . htmlspecialchars($dados['status']) . "</p>";
                echo "<p>Produto: " . htmlspecialchars($dados['title']) . "</p>";
                // echo "<p>Valor unitário: " . $dados['unit_price'] . " X ".$dados['quantity']."</p>";
                echo "<p>Descrição: " . htmlspecialchars($dados['description']) . "</p>";
                echo "<p>Valor: " . number_format($dados['transaction_amount'], 2, ',','.') . "</p>";
                echo "<p>Email do Pagador: " . htmlspecialchars($dados['payer']['email']) . "</p>";
                echo "<p>Tipo de pagamento: " . $dados['payment_type_id']. " " . $dados['payment_method_id']. "</p>";
            } else {
                echo "<p>Erro ao buscar detalhes do pagamento.</p>";
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