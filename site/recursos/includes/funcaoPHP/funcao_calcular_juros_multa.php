<?php

function calcula_multa($situacao, $ano_divida, $vencimento, $valor_base) {
//     verifico a situação da divida
    if ($situacao == 1 || $situacao == 2 || $situacao == 3) {
//        Ano corrente
        $ano_corrente = date('Y');
//        se ano da divida menor que ano corrente calcula multas
        if ($ano_divida < $ano_corrente) {
//            se o ano da divida é menor que o ano atual aplico 15 %
            return $valor_base * 0.15;
        } else {
//            data do dia atual
            $data_corrente = date('d/m/Y');
//           calculo diferenca da data do vencimento da divida com a data atual
            $diferenca_dias = calcular_diferentes_datas_dias($vencimento, $data_corrente);

            if ($diferenca_dias === 0) {
//             se datas igual n tem multa
                return $valor_base * 0;
            } else if ($diferenca_dias > 0 && $diferenca_dias < 61) {
//              se a diferenca de dia maior que 0 e menor que 61 aplico 5% 
                return $valor_base * 0.05;
            } else if ($diferenca_dias > 60 && $diferenca_dias < 121) {
                // se a diferenca de dia maior que 60 e menor que 121 aplico 10%
                return $valor_base * 0.10;
            } else if ($diferenca_dias > 120) {
//              se a diferenca de dia maior que 120  aplico 15%
                return $valor_base * 0.15;
            }
        }
    }
}

function calcula_juros($situacao, $vencimento, $valor_base) {
//    verifico a situação da divida
    if ($situacao == 1 || $situacao == 2 || $situacao == 3) {
//        data atual
        $data_corrente = date('d/m/Y');
//        a porcentagema aplicada é a quantidade de dias diferentes
//        multiplicado pelo valor base 
//        dividido por 100
        $percentagem_juros = calcular_diferentes_datas_meses($vencimento, $data_corrente) / 30;
        return ($valor_base * $percentagem_juros) / 100;
    }
}
