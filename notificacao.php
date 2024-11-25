<?php
// Configuração para capturar o conteúdo da notificação
$data = file_get_contents("php://input");
$notificacao = json_decode($data, true);
include_once "conexao.php";
// Verificar o tipo de notificação
if (isset($notificacao['type']) && $notificacao['type'] === 'payment') {
    $payment_id = $notificacao['data']['id']; // ID do pagamento enviado pelo Mercado Pago
    // Faça uma requisição para obter detalhes do pagamento
    $access_token = 'TEST-5232080259225545-042515-bfeaf6dff3b3fd59594bb4d9ffe6525f-22727655';
    $url = "https://api.mercadopago.com/v1/payments/$payment_id?access_token=$access_token";
    // Requisição para buscar detalhes do pagamento
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $payment_info = json_decode($response, true);
    // Verificar o status do pagamento e atualizar no banco
    //if ($payment_info['status'] === 'approved') {
        $compra_id = $payment_info['external_reference'];// ID da compra
        $status = $payment_info['status']; //Status do pagamento (approved, pending, etc.)
        // Atualize o status do pagamento no banco conforme o status recebido
        $update = $conexao->prepare("UPDATE compra SET status_compra = :stts WHERE id = :id");
        $update->execute(["id"=> $compra_id, "stts"=> $status]);
        http_response_code(200); // Confirma ao MP que a notificação foi recebida
    //}
} else {
    $add = $conexao->prepare("INSERT INTO notifica (nome_notifica, status_notifica) VALUES (:tipo, :stts)");
    $add->execute(["tipo"=> $notificacao['type'], "stts"=> $payment_info['status']]);
    http_response_code(200);// Confirma ao MP que a notificação foi recebida
}