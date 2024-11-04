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
            include_once "conexao.php";
            $usuario = $_SESSION['id_usuario'];
            $select = $conexao->prepare("SELECT * FROM compra c, produto p, compra_itens i WHERE c.id_compra = i.id_compra && p.id_produto = i.id_produto && id_usuario = ?");
            $select->execute([$usuario]);
            if ($select->rowCount() > 0) {
                $rs = $select->fetch();
                $selectPagto = $conn->prepare("SELECT * FROM `pagto` WHERE compra_id = ?");
                $selectPagto->execute([$rs['id_compra']]);
                $rp = $selectPagto->fetch(PDO::FETCH_ASSOC);
                $payment_id = $rp['payment_id'];
                
                // $url = 'https://api.mercadopago.com/v1/payments/' . $payment_id;
                // $access_token = 'TEST-5232080259225545-042515-bfeaf6dff3b3fd59594bb4d9ffe6525f-22727655';
                // $ch = curl_init();
                // curl_setopt_array($ch, [
                //     CURLOPT_URL => $url,
                //     CURLOPT_RETURNTRANSFER => true,
                //     CURLOPT_HTTPHEADER => [
                //         'Content-Type: application/json',
                //         'Authorization: Bearer ' . $access_token
                //     ]
                // ]);
                // $response = curl_exec($ch);
                // curl_close($ch);
                // $dados = json_decode($response, true);
                // echo "<pre>";
                // print_r($dados);
                // echo "</pre>";
            }
            $valor_produto = $rs['valor'];
            $total_por_prod = floatval($rs['valor']) * floatval($rs['quantidade']);
            echo "
            <div>
                {$rs['nome_produto']} R$ ". number_format($valor_produto, 2, ', ', ' . ')."
                 X {$rs['quantidade']} Total: R$ ". number_format($total_por_prod, 2, ', ', ' . ')."
            </div>";
            ?>
            
        </div>
    </main>
    <?php
    include_once "footer.php";
    ?>
    <script src="js/menu.js"></script>
</body>

</html>