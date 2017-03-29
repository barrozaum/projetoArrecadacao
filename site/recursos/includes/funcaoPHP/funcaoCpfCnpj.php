<?php

//fnção para sumir com a mascara do cpf / cnpj
function FUN_TIRAR_MASCARA_CPF_CNPJ($valor) {
//   filtro pra tira pontos
    $valor = str_replace('.', '', $valor);
//    filtro pra tirar - 
    $valor = str_replace('-', '', $valor);
//   filtro pra tirar /
    $valor = str_replace('/', '', $valor);
//   retorna valor sem mascara
    return $valor;
}

function FUN_COLOCAR_MASCARA_CPF_CNPJ($valor) {
//    limpo o espaço em branco do valor que vem do banco de dados

    $valor = str_replace(' ', '', $valor);

//    verifico o tamanho do campo
//    11 - cpf
//    14 - cnpj 
//    aplico a mascara de acordo com o tamanho do campo


    if (strlen($valor) == 11) {
        return substr($valor, 0, 3) . "." . substr($valor, 3, 3) . "." . substr($valor, 6, 3) . "-" . substr($valor, 9, 2);
    } else {
        return substr($valor, 0, 2) . "." . substr($valor, 2, 3) . "." . substr($valor, 5, 3) . "/" . substr($valor, 8, 4) . "-" . substr($valor, 12, 2);
    }
}
