<?php
// Dados do cálculo
$dados = [
    'nCdEmpresa' => '', // Código da empresa (deixe vazio para pessoa física)
    'sDsSenha' => '', // Senha da empresa (deixe vazio para pessoa física)
    'nCdServico' => '40010', // Código do serviço (SEDEX)
    'sCepOrigem' => '11689320', // CEP de origem
    'sCepDestino' => '06317110', // CEP de destino
    'nVlPeso' => '1', // Peso em kg
    'nCdFormato' => '1', // Formato do pacote (1 = caixa/pacote)
    'nVlComprimento' => '20', // Comprimento em cm
    'nVlAltura' => '10', // Altura em cm
    'nVlLargura' => '15', // Largura em cm
    'nVlDiametro' => '0', // Diâmetro (0 para caixas)
    'sCdMaoPropria' => 'N', // Mão própria (S ou N)
    'nVlValorDeclarado' => '50', // Valor declarado
    'sCdAvisoRecebimento' => 'N', // Aviso de recebimento (S ou N)
    'StrRetorno' => 'xml', // Formato da resposta (xml ou json)
];

// Monta a URL
$url = 'https://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?' . http_build_query($dados);

// Inicializa cURL
$curl = curl_init();

// Configurações do cURL
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
]);

// Executa a requisição
$response = curl_exec($curl);

// Verifica erros
if (curl_errno($curl)) {
    echo 'Erro no cURL: ' . curl_error($curl);
    exit;
}

// Fecha a conexão cURL
curl_close($curl);

// Processa a resposta
$xml = simplexml_load_string($response);
if ($xml && $xml->cServico) {
    echo 'Serviço: SEDEX' . PHP_EOL;
    echo 'Valor do Frete: R$ ' . $xml->cServico->Valor . PHP_EOL;
    echo 'Prazo de Entrega: ' . $xml->cServico->PrazoEntrega . ' dias úteis' . PHP_EOL;
} else {
    echo 'Erro ao calcular frete';
}
