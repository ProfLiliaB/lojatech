<?php
function validarCPF($cpf) {
    $soma = 0;
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    // Verifica se o CPF possui 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }
    // Verifica se todos os dígitos são iguais
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }
    // Calcula o primeiro dígito verificador
    for ($i = 9, $j = 0; $i > 0; $i--, $j++) {
        $soma += $cpf[$j] * $i;
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;
    // Calcula o segundo dígito verificador
    for ($i = 10, $j = 0; $i > 1; $i--, $j++) {
        $soma += $cpf[$j] * $i;
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;
    // Verifica se os dígitos verificadores estão corretos
    if ($cpf[9] != $digito1 || $cpf[10] != $digito2) {
        return false;
    }
    // CPF válido
    return true;
}
