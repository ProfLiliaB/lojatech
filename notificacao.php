<?php
// Configuração para capturar o conteúdo da notificação
$data = file_get_contents("php://input");
$notificacao = json_decode($data, true);
include_once "conexao.php";
include_once "admin/config.php";
    // echo "<pre>";
    // print_r($notificacao);
    $payment_id = $notificacao['data']['id']; // ID do pagamento enviado pelo Mercado Pago
    //requisição para obter detalhes do pagamento
    $url = "https://api.mercadopago.com/v1/payments/$payment_id?access_token=".CHAVE_API_MP;
    // Requisição para buscar detalhes do pagamento
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $retorno = json_decode($response, true);
    $status = $retorno['status'];
    if($status) {
        $add = $conexao->prepare("INSERT INTO notifica (nome_notifica, status_notifica, pay_id) VALUES (:tipo, :stts, :id)");
        $add->execute(["tipo" => $notificacao['type'], "stts" => $status, 'id' => $payment_id]);
        // Verifica o status do pagamento e atualizar no banco
        $compra_id = $retorno['external_reference']; // ID da compra
        // Atualize o status do pagamento no banco conforme o status recebido
        $update = $conexao->prepare("UPDATE compra SET status_compra = :stts WHERE id_compra = :id");
        $update->execute(["id" => $compra_id, "stts" => $status]);
        http_response_code(200); // Confirma ao MP que a notificação foi recebida
    }
    

