<?php

function dataBrasileiro($data) {

    if ($data == "" || $data == "1900-01-01 00:00:00.000") {
        return "00/00/0000";
    } else {
        $partes_data = explode("-", $data);
        $ano = $partes_data[0];
        $mes = $partes_data[1];
        $resto_data = explode(" ", $partes_data[2]);
        $dia = $resto_data[0];


        $data_brasil = $dia . "/" . $mes . "/" . $ano;

        return $data_brasil;
    }
}

function dataAmericano($data) {
    if ($data == "" || $data == "00/00/0000") {
        return null;
    } else {
        $partes_data = explode("/", $data);
        $dia = $partes_data[0];
        $mes = $partes_data[1];
        $ano = $partes_data[2];

        //servidor web
        return $mes . "-" . $dia . "-" . $ano;
    }
}

function calcular_diferentes_datas_dias($date1, $date2) {


    // DATA FUTURA
    $partes_data = explode("/", $date1);
    $dia2 = $partes_data[0];
    $mes2 = $partes_data[1];
    $ano2 = $partes_data[2];

//            DATA ATUAL
    $partes_data = explode("/", $date2);
    $dia1 = $partes_data[0];
    $mes1 = $partes_data[1];
    $ano1 = $partes_data[2];


    $data1 = date_create($ano2 . "-" . $mes2 . "-" . $dia2);
    $data2 = date_create($ano1 . "-" . $mes1 . "-" . $dia1);

    if (compara_data_maior($date1, $date2) == 1) {


        $intervalo = $data1->diff($data2);
        return $intervalo->days;
    } else {

        return 0;
    }
}

function calcular_diferentes_datas_meses($date1, $date2) {

    // DATA PRA AGENDAR
    $partes_data = explode("/", $date1);
    $dia2 = $partes_data[0];
    $mes2 = $partes_data[1];
    $ano2 = $partes_data[2];
//            DATA ATUAL
    $partes_data = explode("/", $date2);
    $dia1 = $partes_data[0];
    $mes1 = $partes_data[1];
    $ano1 = $partes_data[2];


    $data1 = date_create($ano2 . "-" . $mes2 . "-" . $dia2);
    $data2 = date_create($ano1 . "-" . $mes1 . "-" . $dia1);

    if (compara_data_maior($date1, $date2) == 1) {


        $intervalo = $data1->diff($data2);
        return $intervalo->days;
    } else {

        return 0;
    }
}

//saber qual data é maior
// Entrada data padrão brasil
function compara_data_maior($data1, $data2) {


    $partes_data_dia1 = explode("/", $data1);
    $dia1 = $partes_data_dia1[0];
    $mes1 = $partes_data_dia1[1];
    $ano1 = $partes_data_dia1[2];

    $partes_data_dia2 = explode("/", $data2);
    $dia2 = $partes_data_dia2[0];
    $mes2 = $partes_data_dia2[1];
    $ano2 = $partes_data_dia2[2];


    $timestamp_data1 = mktime(0, 0, 0, $mes1, $dia1, $ano1);
    $timestamp_data2 = mktime(0, 0, 0, $mes2, $dia2, $ano2);


    if ($timestamp_data1 <= $timestamp_data2) {
        return 1;
    } else {
        return 0;
    }
}

function validar_estrutura_data($data_brasil) {
    // DATA Brasil
    $partes_data = explode("/", $data_brasil);
    $dia = $partes_data[0];
    $mes = $partes_data[1];
    $ano = $partes_data[2];

    if (checkdate($mes, $dia, $ano)) {
        return true;
    } else {
        return false;
    }
}

//data deve vir no formato brasileiro
function acrescentar_periodo_a_data($data, $periodo = "1 months"){
    $data_formatada = str_replace("/", "-", $data);
    return date('d-m-Y', strtotime($periodo , strtotime($data_formatada)));
 
}