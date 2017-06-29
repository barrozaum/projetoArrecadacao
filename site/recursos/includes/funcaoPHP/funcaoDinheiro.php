<?php

function mostrarDinheiro($valor) {
    return number_format($valor, 2, ",", ".");
}

function mostrarDinheiro4Casas($valor) {
    return number_format($valor, 4, ",", ".");
}

function mostrarDinheiro5Casas($valor) {
    return number_format($valor, 5, ",", ".");
}

function mostrarDinheiroSoNumero($valor) {
    return number_format($valor, 2, "", "");
}

function inserirDinheiro($valor) {
   
    $valor = str_replace(".", "", $valor);
    return str_replace(",", ".", $valor);
}