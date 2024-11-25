<?php
session_start();
//Verifica se o usuário está logado para finalizar o pagto
if ($_SESSION['id_usuario']) {
    //============================== Gravar a compra no banco ================================
    //inclui a conexão
    include_once 'conexao.php';
    //define a localização (fuso horário)
    date_default_timezone_set('America/Sao_Paulo');
    //define a data atual
    $data_atual = new DateTime('now');
    //pega o id da pessoa logada
    $id_usuario = $_SESSION['id_usuario'];
    //Prepara a sql para inserir a compra no banco
    $insert = $conexao->prepare("INSERT INTO compra (data_compra, id_usuario) VALUES (:data, :usuario)");
    //executa a query passando os parâmetros data e id do uruário
    $insert->execute([':data' => $data_atual->format('Y-m-d H:i:s'), ':usuario' => $id_usuario]);
    //grava na variavel o último id cadastrada no banco
    $compra_id = $conexao->lastInsertId();
    //============================== Seleciona os dados do usuário no banco ========================
    $selUsu = $conexao->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
    $selUsu->execute([$id_usuario]);
    $usu = $selUsu->fetch(PDO::FETCH_ASSOC);
    //============================ Dados para integrar pagto do Mercado Pago =======================
    //Endpoint do Mercado Pago
    $url = 'https://api.mercadopago.com/checkout/preferences';
    //Seu Token emitido pelo MP
    $access_token = 'TEST-5232080259225545-042515-bfeaf6dff3b3fd59594bb4d9ffe6525f-22727655';
    //Inicia o array de itens comprados
    $itens = [];
    //Se tiver sessão iniciada, verifica se existe dados dentro da sessão carrinho
    if (!empty($_SESSION['carrinho'])) {
        $total = 0; //inicializa o total a pagar
        //foreach (repetição) pega todos os produtos adicionados à sessão carrinho
        foreach ($_SESSION['carrinho'] as $id_prod => $produto) {
            $sub_total = $produto['valor'] * $produto['qtd']; //soma valor total por item
            $total += $sub_total; //Soma ao total a pagar
            //INSERE NA TABELA ITENS se a compra foi gravada corretamente
            if ($compra_id) {
                $insertItem = $conexao->prepare("INSERT INTO compra_itens (id_compra, id_produto, quantidade, valor) VALUES (:compra, :produto, :qtd, :valor)");
                $insertItem->execute([':compra' => $compra_id, ':produto' => $id_prod, ':qtd' => $produto['qtd'], ':valor' => $sub_total]);
                $_SESSION['carrinho'] = [];
            }
            //CRIA O ITEM PARA CADA PRODUTO
            $itens[] = [
                "id"          => $id_prod,
                "title"       => $produto['nome'],
                //"description" => $produto['descricao'],
                "quantity"    => $produto['qtd'],
                "currency_id" => "BRL",
                "unit_price"  => floatval($produto['valor'])
            ];
        }
        //CRIA O ARRAY PARA O CORPO DA REQUISIÇÃO
        $data = [
            "items" => $itens,
            "external_reference" => $compra_id,
            "transaction_amount" => floatval($total),
            "payer" => [
                "name" => $_SESSION['nome'],
                "surname" => $_SESSION['nome'],
                "email" => $_SESSION['email'],
                "identification" => [
                    "type" => "CPF",
                    "number" =>  $_SESSION['cpf']
                ],
                "date_created" => $data_atual->format('Y-m-d\TH:i:s\P') //"2024-04-01T00:00:00Z"
            ],
            "notification_url" => "http://localhost/loja/notificacao.php",
            "back_urls" => [
                "success" => "http://localhost/loja/retorno.php?msg=successo",
                "failure" => "http://localhost/loja/retorno.php?msg=failure",
                "pending" => "http://localhost/loja/retorno.php?msg=pending"
            ],
            "auto_return" => "approved"
        ];
        echo "<pre>";
        print_r($data);
        // $id_unico = uniqid('', true);
        // $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, [
        //     'accept: application/json',
        //     'content-type: application/json',
        //     'Authorization: Bearer ' . $access_token,
        //     'X-Idempotency-Key: ' . $id_unico
        // ]);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        // $response = curl_exec($ch);
        // curl_close($ch);
        // $dados = json_decode($response, true);
        // // echo "<pre>";
        // // print_r($dados);
        // if (isset($dados['sandbox_init_point'])) {
        //     header("Location: " . $dados['sandbox_init_point']);
        //     exit;
        // } else {
        //     echo "Erro ao processar pagamento";
        // }
    }
} else {
    $_SESSION['pg'] = "pagto";
    header("location: login.php");
}
