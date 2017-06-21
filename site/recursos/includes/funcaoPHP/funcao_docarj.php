<?php

function FUNC_INSERIR_FINANCEIRO_DOCARJ($pdo, $num_docajr, $ano_docarj, $quantidade_parcela, $parcela_inicial, $vencimento, $valor) {
// 1 - recebi a data do vencimento e passei para a variavel auxiliar_data
// 2 - converti a data recebida para o formato americano e inseri no banco 
// 3 - criada uma função para para inserir 1 mês a mais na data do vencimento, ou seja toda vez que passar no loop 
// a data vai para a variavel auxiliar e a data auxiliar será acrescentado mais 1 mes 
// 4 -  converto a data auxiliar em data americana e insiro no banco

    $auxiliar_data = $vencimento;
    $data_vencimento = dataAmericano($vencimento);
    $inserir_parcela = $parcela_inicial;


    for ($i = 0; $i < $quantidade_parcela; $i++) {



        $sql_inserir = "INSERT INTO financeiro_Dam";
        $sql_inserir = $sql_inserir . "(Num_Dam, Ano_Dam, Parcela, Valor, Vencimento, Cod_Situacao_divida)";
        $sql_inserir = $sql_inserir . " VALUES ";
        $sql_inserir = $sql_inserir . "('$num_docajr', '$ano_docarj', '{$inserir_parcela}', '$valor', '$data_vencimento', '01')";
        $auxiliar_data = acrescentar_periodo_a_data($auxiliar_data);
        
        $data_vencimento = dataAmericano(dataBrasileiro($auxiliar_data));

        $parcela_inicial++;
        if ($parcela_inicial < 10) {
            $inserir_parcela = "0" . $parcela_inicial;
        } else {
            $inserir_parcela = $parcela_inicial;
        }
        if (!$executa1 = $pdo->query($sql_inserir)) {
            return FALSE;
        }
    }
    return TRUE;
}

function FUNC_EXCLUIR_FINANCEIRO_DOCARJ($pdo, $num_docajr, $ano_docarj) {
    $sql_delete = "DELETE FROM financeiro_Dam WHERE Num_Dam = '{$num_docajr}' AND Ano_Dam = '{$ano_docarj}'";
    $query = $pdo->prepare($sql_delete);
    if ($query->execute()) {
        return true;
    } else {
        return false;
    }
}


