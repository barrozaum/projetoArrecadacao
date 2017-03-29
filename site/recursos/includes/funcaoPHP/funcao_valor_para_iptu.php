<?php

function valor_metro_terreno($pdo, $zona_imob, $situacao_terreno) {

    $sql_metro_terreno = "SELECT * ";
    $sql_metro_terreno = $sql_metro_terreno . " FROM Valor_M2_Terreno ";
    $sql_metro_terreno = $sql_metro_terreno . " WHERE Zona_Fiscal = '$zona_imob'";
    $sql_metro_terreno = $sql_metro_terreno . " AND Cod_Utilizacao ='$situacao_terreno'";

    $query = $pdo->prepare($sql_metro_terreno);
    //executo o comando sql
    $query->execute();

    // Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['vlr_m2_terreno'];
    } else {
        return 0;
    }
}

function valor_metro_construcao($pdo, $zona_imob, $cod_utilizacao, $cod_cat) {

    
    $sql_metro_construcao = "SELECT * ";
    $sql_metro_construcao = $sql_metro_construcao . " FROM Valor_M2_Construcao ";
    $sql_metro_construcao = $sql_metro_construcao . " WHERE Zona_Fiscal = '$zona_imob'";
    $sql_metro_construcao = $sql_metro_construcao . " AND Cod_Utilizacao ='$cod_utilizacao'";
    $sql_metro_construcao = $sql_metro_construcao . " AND Cod_Categoria ='$cod_cat'";

    $query = $pdo->prepare($sql_metro_construcao);
    //executo o comando sql
    $query->execute();

    // Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['Vlr_M2_Construcao'];
    } else {
        return 0;
    }
}

function valor_venal_terreno($valor_m2_terreno, $area_terreno) {
  

    return mostrarDinheiro4Casas(inserirDinheiro($valor_m2_terreno) * $area_terreno);
}

function valor_venal_construcao($valor_m2_construcao, $area_construcao) {
   
    return mostrarDinheiro4Casas(inserirDinheiro($valor_m2_construcao) * $area_construcao);
}

function valor_taxa_coleta_lixo($pdo, $tipo_coleta) {
   

    $tx_coleta = "SELECT * ";
    $tx_coleta = $tx_coleta . " FROM Tipo_Coleta";
    $tx_coleta = $tx_coleta . " WHERE Cod_Tipo_Coleta = '$tipo_coleta'";


    $query = $pdo->prepare($tx_coleta);
    //executo o comando sql
    $query->execute();

    // Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return mostrarDinheiro4Casas($dados['Valor']);
    } else {
        return 0;
    }
}

function tem_manutencao_esgoto($tem_manutencao_esgoto) {
    if ($tem_manutencao_esgoto == "S") {
        return mostrarDinheiro4Casas(4.8200);
    } else {
        return 0;
    }
}

function valor_iptu_ufir($valor_territorial, $valor_predial, $tipo_isencao) {

    if ($tipo_isencao > 1) {
        return mostrarDinheiro4Casas(0);
    } else {


        $valor_iptu_territorial = (inserirDinheiro($valor_territorial) * 1) / 100;
        $valor_iptu_predial = (inserirDinheiro($valor_predial) * 1) / 100;
        $iptu = $valor_iptu_territorial + $valor_iptu_predial;

        return mostrarDinheiro4Casas($iptu);
    }
}

function valor_iptu_total_ufir($valor_iptu, $valor_taxas) {

    $valor_iptu = inserirDinheiro($valor_iptu);
    $valor_taxas = inserirDinheiro($valor_taxas);

    $iptu_ufir = $valor_iptu + $valor_taxas;

    return mostrarDinheiro4Casas($iptu_ufir);
}

function valor_taxas_total($taxa_coleta_lixo, $tem_manutencao_esgoto, $valor_te, $valor_tip) {
     $taxa_coleta_lixo = inserirDinheiro($taxa_coleta_lixo);
    $tem_manutencao_esgoto = inserirDinheiro($tem_manutencao_esgoto);
    $valor_te = inserirDinheiro($valor_te);
    $valor_tip = inserirDinheiro($valor_tip);

    $valor_taxas = $taxa_coleta_lixo + $tem_manutencao_esgoto + $valor_te + $valor_tip;

    return mostrarDinheiro4Casas($valor_taxas);
}

// {Desconto Aplicado a Industrias conforme Lei. Comp. 049/2004}
function desconto_industria($pdo, $inscricao, $tem_desconto_industria) {
    if ($tem_desconto_industria == "N") {
        return 0;
    } else {
        $sql_desconto = "SELECT Tipo_Enquadramento, Data_Enquadramento";
        $sql_desconto = $sql_desconto . " FROM CAD_COMERCIAL";
        $sql_desconto = $sql_desconto . " WHERE INSCRICAO_IMOB = '$inscricao'";

        $query = $pdo->prepare($sql_desconto);
        //executo o comando sql
        $query->execute();

        if (($dados = $query->fetch()) == true) {
            if ($dados['Tipo_Enquadramento'] >= '1')
                return 50;
            else
                return 80;
        } else {
            return 80;
        }
    }
}

function aplicar_desconto($valor, $valor_desconto, $tem_desconto_industria) {

    if ($tem_desconto_industria == "N") {
        return $valor;
    } else {
        if ($valor_desconto == 0) {
            return $valor;
        } else {
            return mostrarDinheiro4Casas(inserirDinheiro($valor) - ((inserirDinheiro($valor) * $valor_desconto) / 100));
        }
    }
}
