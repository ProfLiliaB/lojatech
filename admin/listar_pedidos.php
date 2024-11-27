<?php
//cadastrar_produto.php
// session_start();
// $status = isset($_SESSION['status']) ? $_SESSION['status']:0;
// if(isset($_SESSION['email']) && $status > 0) {
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <<link rel="shortcut icon" href="../img/tech_icon.ico" type="image/x-icon">
        <title>LojaTech Tecnologias e mais</title>
        <link rel="stylesheet" href="../icofont/icofont.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/menu.css">
        <link rel="stylesheet" href="../css/footer.css">
        <link rel="stylesheet" href="../css/produtos.css">
        <link rel="stylesheet" href="../css/carrinho.css">
        <link rel="stylesheet" href="../css/form.css">
</head>

<body>
    <header>
        <?php
        include_once "menu.php";
        include_once "../conexao.php";
        ?>
    </header>
    <main>
        <div class="conteudo_central">
            <?php
            //    $select = $conexao->prepare("SELECT * FROM pagto");
            //    $select->execute();
            //    if($select->rowCount() > 0) {
            //        while($rs = $select->fetch()){
            //           echo "<pre>";
            //           print_r($rs);
            //           echo "</pre>";
            //        }
            //    }
            $url = "https://api.mercadopago.com/v1/payments/search?criteria=asc&range=date_created&begin_date=NOW-30DAYS&end_date=NOW";
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
            echo "<pre>";
            print_r($dados);
            echo "</pre>";
            ?>
        </div>
    </main>
    <?php
    include_once "../footer.php";
    ?>
    <script src="../js/menu.js"></script>
</body>

</html>
<?php
// } else {
//     header('location: ../');
// }