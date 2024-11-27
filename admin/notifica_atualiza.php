<?php
//$id = $_POST['id'] ?? null;
if ($notificacao_id) {
    $query = $conexao->prepare("UPDATE notifica SET status_lido = 1");
    $query->execute();
    echo json_encode(['status' => 'sucesso']);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'ID não fornecido']);
}