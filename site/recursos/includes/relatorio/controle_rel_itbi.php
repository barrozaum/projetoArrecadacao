<?php

function busca_natureza($pdo, $natureza) {

    // preparo para realizar o comando sql
    $sql = "SELECT * FROM Natureza_Transmissao WHERE Cod_Natureza = '$natureza'";
    $query = $pdo->prepare($sql);
    //executo o comando sql
    $query->execute();

    // Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['Desc_Natureza'];
    } else {
        return "";
    }
}


//die(print_r($_SESSION));

//parte ADQUIRINTE
$nome_ad = $_SESSION['NOME_COMPLETO_AD'];
$tipo_pessoa_ad = $_SESSION['TIPO_PESSOA_AD'];
$cpf_cnpj_ad = $_SESSION['CPF_CNPJ_PESSOA_AD'];
$identidade_ad = $_SESSION['IDENTIDADE_AD'];
$cep_end_ad = (int)$_SESSION['END_CEP_AD'];
$rua_ad = $_SESSION['END_RUA_AD'];
$bairro_end_ad = $_SESSION['END_BAIRRO_AD'];
$cidade_end_ad = $_SESSION['END_CIDADE_AD'];
$uf_end_ad = $_SESSION['END_UF_AD'];
$numero_end_ad = $_SESSION['END_NUM_AD'];
$complemento_end_ad = $_SESSION['END_COMP_AD'];


// parte TRANSMITENTE
$nome_tr = $_SESSION['NOME_COMPLETO_TR'];
$tipo_pessoa_tr = $_SESSION['TIPO_PESSOA_TR'];
$cpf_cnpj_tr = (int)$_SESSION['CPF_CNPJ_PESSOA_TR'];
$identidade_tr = $_SESSION['IDENTIDADE_TR'];
$cep_end_tr = $_SESSION['END_CEP_TR'];
$rua_tr = $_SESSION['END_RUA_TR'];
$bairro_end_tr = $_SESSION['END_BAIRRO_TR'];
$cidade_end_tr = $_SESSION['END_CIDADE_TR'];
$uf_end_tr = $_SESSION['END_UF_TR'];
$numero_end_tr = $_SESSION['END_NUM_TR'];
$complemento_end_tr = $_SESSION['END_COMP_TR'];



//parte ESPECIFICAÇÃO DO IMÓVEL
$inscricao = $_SESSION['IMOV_INSC'];
$area_terreno = (int)$_SESSION['IMOV_AREA_TERRENO'];
$area_construida = (int)$_SESSION['IMOV_AREA_CONSTRUIDA'];
$utilizacao = $_SESSION['IMOV_DESC_UTILIZACAO'];
$fracao_ideal = (int)$_SESSION['IMOV_FRACAO_IDEAL'];
$valor_venal = $_SESSION['IMOV_VALOR_VENAL'];
$imov_lograd = $_SESSION['IMOV_NOME_RUA'];
$imov_compl = $_SESSION['IMOV_COMPL'];
$imov_num = $_SESSION['IMOV_NUM'];
$imov_bairro = $_SESSION['IMOV_BAIRRO'];



//parte ESPECIFICAÇÃO DA TRANSAÇÃO
$natureza = $_SESSION['T_NATUREZA'] . " - " . busca_natureza($pdo, $_SESSION['T_NATUREZA']);
$valor_declarado = $_SESSION['T_VALOR_DECLARADO'];
$doc_legal = "";
$livro = "";
$folha = "";
$data_esp = $_SESSION['T_DATA_TRAN'];
$numero_proc_esp = $_SESSION['T_NUM_PROC'] . "/" . $_SESSION['T_ANO_PROC'];




//parte do lançamento do imposto
$base_calculo = $_SESSION['T_BASE_CALCULO'];
$aliquota = 1;
$valor_imposto = $_SESSION['T_VALOR_ITBI'];
$data_lancamento = $_SESSION['T_DATA_TRAN'];
$valor_multa = $_SESSION['T_VALOR_MULTA'];
$vencimento = $_SESSION['T_DATA_VENC'];
$valor_total = $_SESSION['T_VALOR_TOTAL_ITBI'];

// parte da observação
$obs_Itbi = $_SESSION['T_OBS_ITBI'];




// ultima parte
$num_ano_itbi = $_SESSION['ITBI_NUMERO'] . "/" . $_SESSION['ITBI_ANO'] . " - " . $_SESSION['usuario'] . " - " . date('d/m/Y');
