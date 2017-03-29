<?php

function busca_divida_ano($pdo, $insc, $ano) {
    $sql_divida_ano = "SELECT * ";
    $sql_divida_ano = $sql_divida_ano . " FROM financeiro_imob";
    $sql_divida_ano = $sql_divida_ano . " WHERE inscricao_imob = '$insc'";
    $sql_divida_ano = $sql_divida_ano . " AND  ano_divida = '$ano'";
    $query = $pdo->prepare($sql_divida_ano);
    //executo o comando sql
    $query->execute();

    $sit_div = 0;
    // Faço uma comparação para saber se a busca trouxe algum resultado
    for ($i = 0; $dados = $query->fetch(); $i++) {
        if ($dados['cod_situacao_divida'] > 03) {
            $sit_div = 1;
            break;
        }
    }

    return $sit_div;
}

function limpar_composicao_divida($pdo, $inscricao, $ano) {
    $sql_limpa_composicao_divida = "DELETE FROM  composicao_divida_imob";
    $sql_limpa_composicao_divida = $sql_limpa_composicao_divida . " WHERE inscricao_imob = '$inscricao' ";
    $sql_limpa_composicao_divida = $sql_limpa_composicao_divida . " AND ano_divida = '$ano'";
    $query = $pdo->prepare($sql_limpa_composicao_divida);
    //executo o comando sql
    $query->execute();
}

function limpar_valor_venal($pdo, $inscricao, $ano) {
    $sql_limpa_valor_venal = "DELETE FROM  valor_venal";
    $sql_limpa_valor_venal = $sql_limpa_valor_venal . " WHERE inscricao_imob = '$inscricao' ";
    $sql_limpa_valor_venal = $sql_limpa_valor_venal . " AND ano = '$ano'";
    $query = $pdo->prepare($sql_limpa_valor_venal);
    //executo o comando sql
    $query->execute();

    limpar_composicao_divida($pdo, $inscricao, $ano);
}

function limpar_divida_do_ano($pdo, $inscricao, $ano) {
    $sql_limpa_divida = "DELETE FROM financeiro_imob";
    $sql_limpa_divida = $sql_limpa_divida . " WHERE inscricao_imob = '$inscricao' ";
    $sql_limpa_divida = $sql_limpa_divida . " AND ano_divida = '$ano'";
    $query = $pdo->prepare($sql_limpa_divida);
    //executo o comando sql
    $query->execute();

    limpar_valor_venal($pdo, $inscricao, $ano);
}

function quantidade_parcelas($ano_divida) {
    $ano_corrente = date('Y');

    if ($ano_divida >= $ano_corrente) {
        return 6;
    } else {
        return 99;
    }
}

function calcular_desconto($valor, $desconto) {
    if ($desconto != 0) {
        return inserirDinheiro($valor) - ((inserirDinheiro($valor) * $desconto) / 100);
    } else {
        return inserirDinheiro($valor);
    }
}

function cadastrar_valor_venal($pdo, $inscricao, $ano) {
    global $valor_venal_territorial;
    global $valor_venal_predial;
    $aliquota = 1;
    $data_calculo = dataAmericano(date('d/m/Y'));
    $data_hora_calculo = $data_calculo . " " . date('H:i:s');
    $ip_estacao = $_SERVER['REMOTE_ADDR'];
    $usuario_estacao = $_SESSION['usuario'];

    $total = inserirDinheiro($valor_venal_predial) + inserirDinheiro($valor_venal_territorial);
    $sql_valor_venal = "INSERT INTO Valor_Venal ";
    $sql_valor_venal = $sql_valor_venal . " (inscricao_imob ,";
    $sql_valor_venal = $sql_valor_venal . "  ano ,";
    $sql_valor_venal = $sql_valor_venal . "  valor ,";
    $sql_valor_venal = $sql_valor_venal . "  aliquota ,";
    $sql_valor_venal = $sql_valor_venal . "  Data_Calculo ,";
    $sql_valor_venal = $sql_valor_venal . "  USUARIO,";
    $sql_valor_venal = $sql_valor_venal . "  USUARIO_ADM,";
    $sql_valor_venal = $sql_valor_venal . "  ESTACAO,";
    $sql_valor_venal = $sql_valor_venal . "  DIA_HORA)";
    $sql_valor_venal = $sql_valor_venal . "  VALUES";
    $sql_valor_venal = $sql_valor_venal . "  ('$inscricao',";
    $sql_valor_venal = $sql_valor_venal . "  '$ano' ,";
    $sql_valor_venal = $sql_valor_venal . "  '$total' ,";
    $sql_valor_venal = $sql_valor_venal . "  '$aliquota' ,";
    $sql_valor_venal = $sql_valor_venal . "  '$data_calculo' ,";
    $sql_valor_venal = $sql_valor_venal . "  '$usuario_estacao' ,";
    $sql_valor_venal = $sql_valor_venal . "  '$usuario_estacao' ,";
    $sql_valor_venal = $sql_valor_venal . "  '$ip_estacao' ,";
    $sql_valor_venal = $sql_valor_venal . "  '$data_hora_calculo' )";
    $query = $pdo->prepare($sql_valor_venal);
    //executo o comando $sql_valor_venal
    $query->execute();
}

function cadastrar_composicao_divida($pdo, $inscricao, $ano, $parcela) {
    $cod_divida = "01";
    $sub_divida = "00";
    global $taxa_coleta_de_lixo_com_desconto;
    global $valor_tem_manutencao_esgoto_com_desconto;
    global $valor_iptu_em_ufir_com_desconto;


    if ($ano >= 2004) {

        if ($parcela == 99) {
            $valor_taxa_lixo = inserirDinheiro($taxa_coleta_de_lixo_com_desconto);
            $valor_taxa_man_esg = inserirDinheiro($valor_tem_manutencao_esgoto_com_desconto);
            $valor_iptu_ufir = inserirDinheiro($valor_iptu_em_ufir_com_desconto);
            $parcela = $parcela;
        } else {
            $valor_taxa_lixo = inserirDinheiro($taxa_coleta_de_lixo_com_desconto) / 6;
            $valor_taxa_man_esg = inserirDinheiro($valor_tem_manutencao_esgoto_com_desconto) / 6;
            $valor_iptu_ufir = inserirDinheiro($valor_iptu_em_ufir_com_desconto) / 6;
            $parcela = "0" . $parcela;
        }

        $sql_tx_lixo = "INSERT INTO composicao_divida_imob";
        $sql_tx_lixo = $sql_tx_lixo . "(inscricao_imob, ";
        $sql_tx_lixo = $sql_tx_lixo . "ano_divida, ";
        $sql_tx_lixo = $sql_tx_lixo . "cod_divida, ";
        $sql_tx_lixo = $sql_tx_lixo . "sub_divida, ";
        $sql_tx_lixo = $sql_tx_lixo . "parcela, ";
        $sql_tx_lixo = $sql_tx_lixo . "cod_divida_imob, ";
        $sql_tx_lixo = $sql_tx_lixo . "valor) ";
        $sql_tx_lixo = $sql_tx_lixo . "VALUES";
        $sql_tx_lixo = $sql_tx_lixo . "('$inscricao',";
        $sql_tx_lixo = $sql_tx_lixo . "'$ano',";
        $sql_tx_lixo = $sql_tx_lixo . "'$cod_divida',";
        $sql_tx_lixo = $sql_tx_lixo . "'$sub_divida',";
        $sql_tx_lixo = $sql_tx_lixo . "'$parcela',";
        $sql_tx_lixo = $sql_tx_lixo . "'32',";
        $sql_tx_lixo = $sql_tx_lixo . "'$valor_taxa_lixo')";
        $query = $pdo->prepare($sql_tx_lixo);
        $query->execute();

        $sql_tx_man_esg = "INSERT INTO composicao_divida_imob";
        $sql_tx_man_esg = $sql_tx_man_esg . "(inscricao_imob, ";
        $sql_tx_man_esg = $sql_tx_man_esg . "ano_divida, ";
        $sql_tx_man_esg = $sql_tx_man_esg . "cod_divida, ";
        $sql_tx_man_esg = $sql_tx_man_esg . "sub_divida, ";
        $sql_tx_man_esg = $sql_tx_man_esg . "parcela, ";
        $sql_tx_man_esg = $sql_tx_man_esg . "cod_divida_imob, ";
        $sql_tx_man_esg = $sql_tx_man_esg . "valor) ";
        $sql_tx_man_esg = $sql_tx_man_esg . "VALUES";
        $sql_tx_man_esg = $sql_tx_man_esg . "('$inscricao',";
        $sql_tx_man_esg = $sql_tx_man_esg . "'$ano',";
        $sql_tx_man_esg = $sql_tx_man_esg . "'$cod_divida',";
        $sql_tx_man_esg = $sql_tx_man_esg . "'$sub_divida',";
        $sql_tx_man_esg = $sql_tx_man_esg . "'$parcela',";
        $sql_tx_man_esg = $sql_tx_man_esg . "'33',";
        $sql_tx_man_esg = $sql_tx_man_esg . "'$valor_taxa_man_esg')";
        $query = $pdo->prepare($sql_tx_man_esg);


        $query->execute();

        $sql_taxa_iptu = "INSERT INTO composicao_divida_imob";
        $sql_taxa_iptu = $sql_taxa_iptu . "(inscricao_imob, ";
        $sql_taxa_iptu = $sql_taxa_iptu . "ano_divida, ";
        $sql_taxa_iptu = $sql_taxa_iptu . "cod_divida, ";
        $sql_taxa_iptu = $sql_taxa_iptu . "sub_divida, ";
        $sql_taxa_iptu = $sql_taxa_iptu . "parcela, ";
        $sql_taxa_iptu = $sql_taxa_iptu . "cod_divida_imob, ";
        $sql_taxa_iptu = $sql_taxa_iptu . "valor) ";
        $sql_taxa_iptu = $sql_taxa_iptu . "VALUES";
        $sql_taxa_iptu = $sql_taxa_iptu . "('$inscricao',";
        $sql_taxa_iptu = $sql_taxa_iptu . "'$ano',";
        $sql_taxa_iptu = $sql_taxa_iptu . "'$cod_divida',";
        $sql_taxa_iptu = $sql_taxa_iptu . "'$sub_divida',";
        $sql_taxa_iptu = $sql_taxa_iptu . "'$parcela',";
        $sql_taxa_iptu = $sql_taxa_iptu . "'01',";
        $sql_taxa_iptu = $sql_taxa_iptu . "'$valor_iptu_ufir')";
        $query = $pdo->prepare($sql_taxa_iptu);
        $query->execute();
        
        
    } else {
        global $taxa_coleta_de_lixo_sem_desconto;
        global $valor_tem_manutencao_esgoto_sem_desconto;
        global $valor_iptu_total_ufir_sem_desconto;
        print "asdas" . $valor_iptu_total_ufir_sem_desconto;

        $valor_taxa_lixo = inserirDinheiro($taxa_coleta_de_lixo_sem_desconto);
        $valor_taxa_man_esg = inserirDinheiro($valor_tem_manutencao_esgoto_sem_desconto);
        $valor_iptu_ufir = inserirDinheiro($valor_iptu_total_ufir_sem_desconto);
        $parcela = $parcela;
        $sql_tx_lixo = "INSERT INTO composicao_divida_imob";
        $sql_tx_lixo = $sql_tx_lixo . "(inscricao_imob, ";
        $sql_tx_lixo = $sql_tx_lixo . "ano_divida, ";
        $sql_tx_lixo = $sql_tx_lixo . "cod_divida, ";
        $sql_tx_lixo = $sql_tx_lixo . "sub_divida, ";
        $sql_tx_lixo = $sql_tx_lixo . "parcela, ";
        $sql_tx_lixo = $sql_tx_lixo . "cod_divida_imob, ";
        $sql_tx_lixo = $sql_tx_lixo . "valor) ";
        $sql_tx_lixo = $sql_tx_lixo . "VALUES";
        $sql_tx_lixo = $sql_tx_lixo . "('$inscricao',";
        $sql_tx_lixo = $sql_tx_lixo . "'$ano',";
        $sql_tx_lixo = $sql_tx_lixo . "'$cod_divida',";
        $sql_tx_lixo = $sql_tx_lixo . "'$sub_divida',";
        $sql_tx_lixo = $sql_tx_lixo . "'$parcela',";
        $sql_tx_lixo = $sql_tx_lixo . "'32',";
        $sql_tx_lixo = $sql_tx_lixo . "'$taxa_coleta_de_lixo_sem_desconto')";
        $query = $pdo->prepare($sql_tx_lixo);
        $query->execute();

        $sql_tx_man_esg = "INSERT INTO composicao_divida_imob";
        $sql_tx_man_esg = $sql_tx_man_esg . "(inscricao_imob, ";
        $sql_tx_man_esg = $sql_tx_man_esg . "ano_divida, ";
        $sql_tx_man_esg = $sql_tx_man_esg . "cod_divida, ";
        $sql_tx_man_esg = $sql_tx_man_esg . "sub_divida, ";
        $sql_tx_man_esg = $sql_tx_man_esg . "parcela, ";
        $sql_tx_man_esg = $sql_tx_man_esg . "cod_divida_imob, ";
        $sql_tx_man_esg = $sql_tx_man_esg . "valor) ";
        $sql_tx_man_esg = $sql_tx_man_esg . "VALUES";
        $sql_tx_man_esg = $sql_tx_man_esg . "('$inscricao',";
        $sql_tx_man_esg = $sql_tx_man_esg . "'$ano',";
        $sql_tx_man_esg = $sql_tx_man_esg . "'$cod_divida',";
        $sql_tx_man_esg = $sql_tx_man_esg . "'$sub_divida',";
        $sql_tx_man_esg = $sql_tx_man_esg . "'$parcela',";
        $sql_tx_man_esg = $sql_tx_man_esg . "'33',";
        $sql_tx_man_esg = $sql_tx_man_esg . "'$valor_tem_manutencao_esgoto_sem_desconto')";
        $query = $pdo->prepare($sql_tx_man_esg);


        $query->execute();

        $sql_taxa_iptu = "INSERT INTO composicao_divida_imob";
        $sql_taxa_iptu = $sql_taxa_iptu . "(inscricao_imob, ";
        $sql_taxa_iptu = $sql_taxa_iptu . "ano_divida, ";
        $sql_taxa_iptu = $sql_taxa_iptu . "cod_divida, ";
        $sql_taxa_iptu = $sql_taxa_iptu . "sub_divida, ";
        $sql_taxa_iptu = $sql_taxa_iptu . "parcela, ";
        $sql_taxa_iptu = $sql_taxa_iptu . "cod_divida_imob, ";
        $sql_taxa_iptu = $sql_taxa_iptu . "valor) ";
        $sql_taxa_iptu = $sql_taxa_iptu . "VALUES";
        $sql_taxa_iptu = $sql_taxa_iptu . "('$inscricao',";
        $sql_taxa_iptu = $sql_taxa_iptu . "'$ano',";
        $sql_taxa_iptu = $sql_taxa_iptu . "'$cod_divida',";
        $sql_taxa_iptu = $sql_taxa_iptu . "'$sub_divida',";
        $sql_taxa_iptu = $sql_taxa_iptu . "'$parcela',";
        $sql_taxa_iptu = $sql_taxa_iptu . "'01',";
        $sql_taxa_iptu = $sql_taxa_iptu . "'$valor_iptu_ufir')";
        $query = $pdo->prepare($sql_taxa_iptu);
        $query->execute();

        

//                                    print "". $sql_tx_lixo . "<br />";
//                                    print "". $sql_tx_man_esg . "<br />";
//                                    print "". $sql_taxa_iptu . "<br />";
    }
    
    
}

function cadastrar_divida_ano($pdo, $inscricao, $ano_atual, $valor_iptu_total_s_desconto, $desconto_industria) {

   

    $cod_divida = '01';
    $sub_divida = '00';
    $cod_tipo_moeda = '02';
    $parcela = quantidade_parcelas($ano_atual);
    $calendario[0] = "30/04/" . date('Y') . "";
    $calendario[1] = "31/05/" . date('Y');
    $calendario[2] = "30/06/" . date('Y');
    $calendario[3] = "31/07/" . date('Y');
    $calendario[4] = "31/08/" . date('Y');
    $calendario[5] = "30/09/" . date('Y');
    $calendario[6] = "31/12/" . $ano_atual;
    $cod_situacao_divida = "01";

    if ($ano_atual >= 2004) {
        $valor = calcular_desconto($valor_iptu_total_s_desconto, $desconto_industria);
    } else {
        $valor = inserirDinheiro($valor_iptu_total_s_desconto);
    }


    if ($parcela == 99) {

        $sql_inserir_divida = "INSERT INTO financeiro_imob";
        $sql_inserir_divida = $sql_inserir_divida . " (inscricao_imob, ";
        $sql_inserir_divida = $sql_inserir_divida . " ano_divida, ";
        $sql_inserir_divida = $sql_inserir_divida . " cod_divida, ";
        $sql_inserir_divida = $sql_inserir_divida . " sub_divida, ";
        $sql_inserir_divida = $sql_inserir_divida . " cod_tipo_moeda, ";
        $sql_inserir_divida = $sql_inserir_divida . " parcela, ";
        $sql_inserir_divida = $sql_inserir_divida . " vencimento, ";
        $sql_inserir_divida = $sql_inserir_divida . " valor, ";
        $sql_inserir_divida = $sql_inserir_divida . " vlr_base, ";
        $sql_inserir_divida = $sql_inserir_divida . " cod_situacao_divida, ";
        $sql_inserir_divida = $sql_inserir_divida . " tem_composicao) ";
        $sql_inserir_divida = $sql_inserir_divida . " VALUES";
        $sql_inserir_divida = $sql_inserir_divida . "('$inscricao',";
        $sql_inserir_divida = $sql_inserir_divida . " '$ano_atual',";
        $sql_inserir_divida = $sql_inserir_divida . " '$cod_divida',";
        $sql_inserir_divida = $sql_inserir_divida . " '$sub_divida',";
        $sql_inserir_divida = $sql_inserir_divida . " '$cod_tipo_moeda',";
        $sql_inserir_divida = $sql_inserir_divida . " '$parcela',";
        $sql_inserir_divida = $sql_inserir_divida . "'" . dataAmericano($calendario[6]) . "',";
        $sql_inserir_divida = $sql_inserir_divida . " '$valor',";
        $sql_inserir_divida = $sql_inserir_divida . " '0.00',";
        $sql_inserir_divida = $sql_inserir_divida . " '$cod_situacao_divida',";
        $sql_inserir_divida = $sql_inserir_divida . " 'S')";
        $query = $pdo->prepare($sql_inserir_divida);
        //executo o comando sql
        $query->execute();


        cadastrar_valor_venal($pdo, $inscricao, $ano_atual);
        
        cadastrar_composicao_divida($pdo, $inscricao, $ano_atual, $parcela);
    }

    if ($parcela != 99) {
        $cont = 0;
        for ($i = 0; $i < $parcela; $i++) {
            $cont++;
            $sql_inserir_divida = "INSERT INTO financeiro_imob";
            $sql_inserir_divida = $sql_inserir_divida . " (inscricao_imob, ";
            $sql_inserir_divida = $sql_inserir_divida . " ano_divida, ";
            $sql_inserir_divida = $sql_inserir_divida . " cod_divida, ";
            $sql_inserir_divida = $sql_inserir_divida . " sub_divida, ";
            $sql_inserir_divida = $sql_inserir_divida . " cod_tipo_moeda, ";
            $sql_inserir_divida = $sql_inserir_divida . " parcela, ";
            $sql_inserir_divida = $sql_inserir_divida . " vencimento, ";
            $sql_inserir_divida = $sql_inserir_divida . " valor, ";
            $sql_inserir_divida = $sql_inserir_divida . " vlr_base, ";
            $sql_inserir_divida = $sql_inserir_divida . " cod_situacao_divida, ";
            $sql_inserir_divida = $sql_inserir_divida . " tem_composicao) ";
            $sql_inserir_divida = $sql_inserir_divida . " VALUES";
            $sql_inserir_divida = $sql_inserir_divida . "('$inscricao',";
            $sql_inserir_divida = $sql_inserir_divida . " '$ano_atual',";
            $sql_inserir_divida = $sql_inserir_divida . " '$cod_divida',";
            $sql_inserir_divida = $sql_inserir_divida . " '$sub_divida',";
            $sql_inserir_divida = $sql_inserir_divida . " '$cod_tipo_moeda',";
            $sql_inserir_divida = $sql_inserir_divida . " '0$cont',";
            $sql_inserir_divida = $sql_inserir_divida . "'" . dataAmericano($calendario[$i]) . "',";
            $sql_inserir_divida = $sql_inserir_divida . "'" . $valor / $parcela . "',";
            $sql_inserir_divida = $sql_inserir_divida . " '0.00',";
            $sql_inserir_divida = $sql_inserir_divida . " '$cod_situacao_divida',";
            $sql_inserir_divida = $sql_inserir_divida . " 'S')";



            $query = $pdo->prepare($sql_inserir_divida);
            //executo o comando sql
            $query->execute();
            if ($i == 0) {
                cadastrar_valor_venal($pdo, $inscricao, $ano_atual);
            }
            cadastrar_composicao_divida($pdo, $inscricao, $ano_atual, $cont);
        }
    }
}
