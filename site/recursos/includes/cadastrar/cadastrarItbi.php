<?php
//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//  BIBLIOTECA PARA VALIDAR O TIPO DA PESSOA (FISICA/JURIDICA)
    include_once '../funcaoPHP/funcaoPessoaFisica_Juridica.php';
//   BIBLIOTECA PARA FORMATAR DINHEIRO
    include_once '../funcaoPHP/funcaoDinheiro.php';
//   BIBLIOTECA PARA FORMATAR DATA
    include_once '../funcaoPHP/funcaoData.php';
//   BIBLIOTECA PARA FORMATAR CPF_CNPJ
    include_once '../funcaoPHP/funcaoCpfCnpj.php';



//ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();

// biblioteca para validar string informada    
    include ('../funcaoPHP/function_letraMaiscula.php');
//  _Letra_Maiscula
    $l = "_LETRA_MAISCULA";

// aplica filtro nos campos enviados(LetraMaiuscula)
    $itbi_numero = letraMaiuscula($_POST['txt_numero_itbi']);
    $itbi_ano = letraMaiuscula($_POST['txt_ano_itbi']);
//    --> DADOS ADQUIRENTE
    $ad_nome_completo = letraMaiuscula($_POST['txt_nome_completo_adquirinte']);
    $ad_tipo_pessoa = letraMaiuscula($_POST['txt_tipo_pessoa_adquirinte']);
    $ad_cpf_cnpj = letraMaiuscula($_POST['txt_cpf_cnpj_adquirinte']);
    $ad_identidade = letraMaiuscula($_POST['txt_identidade_adquirinte']);
    $ad_cep = letraMaiuscula($_POST['txt_cep_adquirinte']);
    $ad_rua = letraMaiuscula($_POST['txt_rua_adquirinte']);
    $ad_bairro = letraMaiuscula($_POST['txt_bairro_adquirinte']);
    $ad_cidade = letraMaiuscula($_POST['txt_cidade_adquirinte']);
    $ad_uf = letraMaiuscula($_POST['txt_uf_adquirinte']);
    $ad_numero = letraMaiuscula($_POST['txt_numero_endereco_adquirinte']);
    $ad_complemento = letraMaiuscula($_POST['txt_complemento_endereco_adquirinte']);
//    --> DADOS TRANSMITENTE
    $tr_nome_completo = letraMaiuscula($_POST['txt_nome_completo_transmitente']);
    $tr_tipo_pessoa = letraMaiuscula($_POST['txt_tipo_pessoa_transmitente']);
    $tr_cpf_cnpj = letraMaiuscula($_POST['txt_cpf_cnpj_transmitente']);
    $tr_identidade = letraMaiuscula($_POST['txt_identidade_transmitente']);
    $tr_cep = letraMaiuscula($_POST['txt_cep_transmitente']);
    $tr_rua = letraMaiuscula($_POST['txt_rua_transmitente']);
    $tr_bairro = letraMaiuscula($_POST['txt_bairro_transmitente']);
    $tr_cidade = letraMaiuscula($_POST['txt_cidade_transmitente']);
    $tr_uf = letraMaiuscula($_POST['txt_uf_transmitente']);
    $tr_numero = letraMaiuscula($_POST['txt_numero_endereco_transmitente']);
    $tr_complemento = letraMaiuscula($_POST['txt_complemento_endereco_transmitente']);
//    --> DADOS IMOVEL
    $inscricao_imovel = letraMaiuscula($_POST['txt_num_inscricao']);
    $prorietario_imovel = letraMaiuscula($_POST['txt_proprietario_imovel']);
    $area_terreno_imovel = letraMaiuscula($_POST['txt_area_terreno']);
    $area_construida_imovel = letraMaiuscula($_POST['txt_area_construida']);
    $fracao_ideal_imovel = letraMaiuscula($_POST['txt_fracao_ideal']);
    $utilizacao_imovel = letraMaiuscula($_POST['txt_utilizacao']);
    $codigo_utilizacao_imovel = letraMaiuscula($_POST['txt_codigo_utilizacao_imovel']);
    $valor_venal_imovel = letraMaiuscula($_POST['txt_valor_venal']);
    $logradouro_imovel = letraMaiuscula($_POST['txt_logradouro_imovel']);
    $codigo_logradouro_imovel = letraMaiuscula($_POST['txt_codigo_rua_imovel']);
    $numero_endereco_imovel = letraMaiuscula($_POST['txt_numero_endereco_imovel']);
    $complemento_imovel = letraMaiuscula($_POST['txt_complemento_endereco_imovel']);
    $quadra_imovel = letraMaiuscula($_POST['txt_quadra_endereco_imovel']);
    $lote_imovel = letraMaiuscula($_POST['txt_lote_endereco_imovel']);
    $bairro_imovel = letraMaiuscula(substr($_POST['txt_bairro_imovel'], 0, 20));
    $codigo_bairro_imovel = letraMaiuscula($_POST['txt_codigo_bairro_imovel']);
//    --> DADOS NATUREZA TRANSAÇÃO
    $natureza_trans = letraMaiuscula($_POST['txt_natureza']);
    $numero_processo_trans = letraMaiuscula($_POST['txt_numero_processo']);
    $ano_processo_trans = letraMaiuscula($_POST['txt_ano_processo']);
    $imunidade_trans = letraMaiuscula($_POST['txt_imunidade']);
    $valor_declarado_trans = letraMaiuscula($_POST['txt_valor_declarado']);
    $base_calculo_trans = letraMaiuscula($_POST['txt_base_calculo']);
    $valor_multa_trans = letraMaiuscula($_POST['txt_valor_multa']);
    $valor_itbi_trans = letraMaiuscula($_POST['txt_valor_itbi']);
    $valor_total_trans = letraMaiuscula($_POST['txt_valor_total']);
    $data_trans = letraMaiuscula($_POST['txt_data_transacao']);
    $vencimento_trans = letraMaiuscula($_POST['txt_vencimento']);
    $multa_trans = letraMaiuscula($_POST['txt_multa']);
    $declarante_trans = letraMaiuscula($_POST['txt_declarante']);
    $obs_itbi_trans = letraMaiuscula($_POST['txt_obs_itbi']);

//    validação dos campos
//    NUMERO-ITBI
    if ((strlen($itbi_numero) > 0 && strlen($itbi_numero) < 7) || is_int($itbi_numero) === TRUE) {
        $numero_itbi = $itbi_numero;
        $_SESSION['ITBI_NUMERO'] = $itbi_numero;
    } else {
        $array_erros['txt_num_itbi'] = 'POR FAVOR ENTRE COM UM NUMERO ITBI VÁLIDO ';
    }

//    ANO-ITBI
    if ((strlen($itbi_ano) > 0 && strlen($itbi_ano) < 7) || is_int($itbi_ano) === TRUE) {
        $ano_itbi = $itbi_ano;
        $_SESSION['ITBI_ANO'] = $itbi_ano;
    } else {
        $array_erros['txt_ano_itbi'] = 'POR FAVOR ENTRE COM UM ANO DE ITBI VÁLIDO ';
    }

//    DADOS ADQUIRENTE
//   ADQUIRENTE -- NOME COMPLETO
    if ((strlen($ad_nome_completo) > 0 && strlen($ad_nome_completo) < 51)) {
        $nome_completo_ad = $ad_nome_completo;
        $_SESSION['NOME_COMPLETO_AD'] = $ad_nome_completo;
    } else {
        $array_erros['txt_adquirente_itbi'] = 'POR FAVOR ENTRE COM O NOME DO ADQUIRENTE VÁLIDO ';
    }

//   ADQUIRENTE -- TIPO_PESSOA    
    if ((strlen($ad_tipo_pessoa) > 5 && strlen($ad_tipo_pessoa) < 9)) {
        $tipo_pessoa_ad = FUN_INSERIR_TIPO_PESSOA($ad_tipo_pessoa);
        $_SESSION['TIPO_PESSOA_AD'] = $ad_tipo_pessoa;
    } else {
        $array_erros['txt_adquirente_tipo_pessoa'] = 'POR FAVOR ENTRE COM O TIPO PESSOA ADQUIRENTE VÁLIDO ';
    }


//   ADQUIRENTE -- CPF_CNPJ   
    if ((strlen($ad_cpf_cnpj) > 13 && strlen($ad_cpf_cnpj) < 19)) {
        $cpf_cnpj_ad = FUN_TIRAR_MASCARA_CPF_CNPJ($ad_cpf_cnpj);
        $_SESSION['CPF_CNPJ_PESSOA_AD'] = $ad_cpf_cnpj;
    } else {
        $array_erros['txt_adquirente_cpf_cnpj'] = 'POR FAVOR ENTRE COM O CPF/CNPJ DO ADQUIRENTE VÁLIDO ';
    }


    //   ADQUIRENTE -- IDENTIDADE   
    if ((strlen($ad_identidade) > 2 && strlen($ad_identidade) < 21)) {
        $identidade_ad = $ad_identidade;
        $_SESSION['IDENTIDADE_AD'] = $ad_identidade;
    } else {
        $array_erros['txt_adquirente_identidade'] = 'POR FAVOR ENTRE COM IDENTIDADE ADQUIRENTE VÁLIDA ';
    }


    //   ADQUIRENTE -- CEP   
    if ((strlen($ad_cep) == 8) || is_int($ad_cep) === TRUE) {
        $cep_ad = $ad_cep;
        $_SESSION['END_CEP_AD'] = $ad_cep;
    } else {
        $array_erros['txt_adquirente_cep'] = 'POR FAVOR ENTRE COM CEP ADQUIRENTE VÁLIDO ';
    }

    //   ADQUIRENTE -- RUA
    if ((strlen($ad_rua) > 2) && strlen($ad_rua) < 51) {
        $rua_ad = $ad_rua;
        $_SESSION['END_RUA_AD'] = $ad_rua;
    } else {
        $array_erros['txt_adquirente_rua'] = 'POR FAVOR ENTRE COM RUA ADQUIRENTE VÁLIDA ';
    }

    //   ADQUIRENTE -- BAIRRO
    if ((strlen($ad_bairro) > 2) && strlen($ad_bairro) < 21) {
        $bairro_ad = $ad_bairro;
        $_SESSION['END_BAIRRO_AD'] = $ad_bairro;
    } else {
        $array_erros['txt_adquirente_bairro'] = 'POR FAVOR ENTRE COM BAIRRO ADQUIRENTE VÁLIDO ';
    }

    //   ADQUIRENTE -- CIDADE
    if ((strlen($ad_cidade) > 2) && strlen($ad_cidade) < 21) {
        $cidade_ad = $ad_cidade;
        $_SESSION['END_CIDADE_AD'] = $ad_cidade;
    } else {
        $array_erros['txt_adquirente_cidade'] = 'POR FAVOR ENTRE COM CIDADE ADQUIRENTE VÁLIDA ';
    }

    //   ADQUIRENTE -- UF
    if ((strlen($ad_uf) == 2)) {
        $uf_ad = $ad_uf;
        $_SESSION['END_UF_AD'] = $ad_uf;
    } else {
        $array_erros['txt_adquirente_uf'] = 'POR FAVOR ENTRE COM UF ADQUIRENTE VÁLIDA ';
    }

    //   ADQUIRENTE -- NUMERO
    if ((strlen($ad_numero) < 6) || is_int($ad_cep) === TRUE) {
        $numero_end_ad = $ad_numero;
        $_SESSION['END_NUM_AD'] = $ad_numero;
    } else {
        $array_erros['txt_adquirente_numero'] = 'POR FAVOR ENTRE COM NUMERO ENDEREÇO ADQUIRENTE VÁLIDO ';
    }

    //   ADQUIRENTE -- COMPLEMENTO
    if (strlen($ad_complemento) < 31) {
        $complemento_end_ad = $ad_complemento;
        $_SESSION['END_COMP_AD'] = $ad_complemento;
    } else {
        $array_erros['txt_adquirente_complemento'] = 'POR FAVOR ENTRE COM COMPLEMENTO ENDEREÇO ADQUIRENTE VÁLIDO ';
    }



//     DADOS TRANSMITENTE
//   TRANSMITENTE NOME COMPLETO
    if ((strlen($tr_nome_completo) > 0 && strlen($tr_nome_completo) < 51)) {
        $nome_completo_tr = $tr_nome_completo;
        $_SESSION['NOME_COMPLETO_TR'] = $tr_nome_completo;
    } else {
        $array_erros['txt_adquirente_itbi'] = 'POR FAVOR ENTRE COM O NOME DO ADQUIRENTE VÁLIDO ';
    }

//   TRANSMITENTE TIPO_PESSOA    
    if ((strlen($tr_tipo_pessoa) > 5 && strlen($tr_tipo_pessoa) < 9)) {
        $tipo_pessoa_tr = FUN_INSERIR_TIPO_PESSOA($tr_tipo_pessoa);
        $_SESSION['TIPO_PESSOA_TR'] = $tr_tipo_pessoa;
    } else {
        $array_erros['txt_adquirente_tipo_pessoa'] = 'POR FAVOR ENTRE COM O TIPO PESSOA ADQUIRENTE VÁLIDO ';
    }


//   TRANSMITENTE CPF_CNPJ   
    if ((strlen($tr_cpf_cnpj) > 13 && strlen($tr_cpf_cnpj) < 19)) {
        $cpf_cnpj_tr = FUN_TIRAR_MASCARA_CPF_CNPJ($tr_cpf_cnpj);
        $_SESSION['CPF_CNPJ_PESSOA_TR'] = $tr_cpf_cnpj;
    } else {
        $array_erros['txt_adquirente_cpf_cnpj'] = 'POR FAVOR ENTRE COM O CPF/CNPJ DO ADQUIRENTE VÁLIDO ';
    }


    //   TRANSMITENTE IDENTIDADE   
    if ((strlen($tr_identidade) > 2 && strlen($tr_identidade) < 21)) {
        $identidade_tr = $tr_identidade;
        $_SESSION['IDENTIDADE_TR'] = $tr_identidade;
    } else {
        $array_erros['txt_adquirente_identidade'] = 'POR FAVOR ENTRE COM IDENTIDADE ADQUIRENTE VÁLIDA ';
    }


    //   TRANSMITENTE CEP   
    if ((strlen($tr_cep) == 8) || is_int($tr_cep) === TRUE) {
        $cep_tr = $tr_cep;
        $_SESSION['END_CEP_TR'] = $tr_cep;
    } else {
        $array_erros['txt_adquirente_cep'] = 'POR FAVOR ENTRE COM CEP ADQUIRENTE VÁLIDO ';
    }

    //   TRANSMITENTE RUA
    if ((strlen($tr_rua) > 2) && strlen($tr_rua) < 51) {
        $rua_tr = $tr_rua;
        $_SESSION['END_RUA_TR'] = $tr_rua;
    } else {
        $array_erros['txt_adquirente_rua'] = 'POR FAVOR ENTRE COM RUA ADQUIRENTE VÁLIDA ';
    }

    //   TRANSMITENTE BAIRRO
    if ((strlen($tr_bairro) > 2) && strlen($tr_bairro) < 21) {
        $bairro_tr = $tr_bairro;
        $_SESSION['END_BAIRRO_TR'] = $tr_bairro;
    } else {
        $array_erros['txt_adquirente_bairro'] = 'POR FAVOR ENTRE COM BAIRRO ADQUIRENTE VÁLIDO ';
    }

    //   TRANSMITENTE CIDADE
    if ((strlen($tr_cidade) > 2) && strlen($tr_cidade) < 21) {
        $cidade_tr = $tr_cidade;
        $_SESSION['END_CIDADE_TR'] = $tr_cidade;
    } else {
        $array_erros['txt_adquirente_cidade'] = 'POR FAVOR ENTRE COM CIDADE ADQUIRENTE VÁLIDA ';
    }

    //   TRANSMITENTE UF
    if ((strlen($tr_uf) == 2)) {
        $uf_tr = $tr_uf;
        $_SESSION['END_UF_TR'] = $tr_uf;
    } else {
        $array_erros['txt_adquirente_uf'] = 'POR FAVOR ENTRE COM UF ADQUIRENTE VÁLIDA ';
    }

    //   TRANSMITENTE NUMERO
    if ((strlen($tr_numero) < 6) || is_int($tr_cep) === TRUE) {
        $numero_end_tr = $tr_numero;
        $_SESSION['END_NUM_TR'] = $tr_numero;
    } else {
        $array_erros['txt_adquirente_numero'] = 'POR FAVOR ENTRE COM NUMERO ENDEREÇO ADQUIRENTE VÁLIDO ';
    }

    //   TRANSMITENTE COMPLEMENTO
    if (strlen($tr_complemento) < 31) {
        $complemento_end_tr = $tr_complemento;
        $_SESSION['END_COMP_TR'] = $tr_complemento;
    } else {
        $array_erros['txt_adquirente_complemento'] = 'POR FAVOR ENTRE COM COMPLEMENTO ENDEREÇO ADQUIRENTE VÁLIDO ';
    }


//  DADOS IMOVEL
    //   IMOVEL -- INSCRICAO
    if (((strlen($inscricao_imovel) > 0) && (strlen($inscricao_imovel) < 7)) || is_int($inscricao_imovel) === TRUE) {
        $num_inscricao = $inscricao_imovel;
        $_SESSION['IMOV_INSC'] = $inscricao_imovel;
    } else {
        $array_erros['txt_imovel_inscricao'] = 'POR FAVOR ENTRE COM INSCRIÇÃO IMÓVEL VÁLIDA ';
    }

    //   IMOVEL -- PROPRIETARIO
    if ((strlen($prorietario_imovel) > 2) && (strlen($inscricao_imovel) < 51)) {
        $proprietario_imob = $prorietario_imovel;
        $_SESSION['IMOV_PROPRIETARIO'] = $prorietario_imovel;
    } else {
        $array_erros['txt_imovel_proprietario'] = 'POR FAVOR ENTRE COM PROPRIETARIO IMOVEL VÁLIDO ';
    }

    //   IMOVEL -- AREA_TERRENO
    if ((strlen($area_terreno_imovel) > 1) && (strlen($area_terreno_imovel) < 12) || is_int($area_terreno_imovel)) {
        $area_terreno = $area_terreno_imovel;
        $_SESSION['IMOV_AREA_TERRENO'] = $prorietario_imovel;
    } else {
        $array_erros['txt_imovel_area_terreno'] = 'POR FAVOR ENTRE COM AREA DO TERRNO IMOVEL VÁLIDA ';
    }

    //   IMOVEL -- AREA_CONSTRUIDA
    if ((strlen($area_construida_imovel) > 1) && (strlen($area_construida_imovel) < 12) || is_int($area_construida_imovel)) {
        $area_construida = $area_construida_imovel;
        $_SESSION['IMOV_AREA_CONSTRUIDA'] = $area_construida_imovel;
    } else {
        $array_erros['txt_imovel_area_construida'] = 'POR FAVOR ENTRE COM AREA CONSTRUIDA IMOVEL VÁLIDA ';
    }

    //   IMOVEL -- FRAÇÃO IDEAL
    if ((strlen($fracao_ideal_imovel) > 0) && (strlen($fracao_ideal_imovel) < 12) || is_float($fracao_ideal_imovel)) {
        $fracao_ideal = $fracao_ideal_imovel;
        $_SESSION['IMOV_FRACAO_IDEAL'] = $fracao_ideal_imovel;
    } else {
        $array_erros['txt_imovel_fracao_ideal'] = 'POR FAVOR ENTRE COM FRAÇÃO IDEAL IMOVEL VÁLIDA ';
    }


    //   IMOVEL -- DESCRICAO _ UTILIZAÇÃO
    if ((strlen($utilizacao_imovel) > 0) && (strlen($utilizacao_imovel) < 30)) {
        $descricao_utilizacao = $utilizacao_imovel;
        $_SESSION['IMOV_DESC_UTILIZACAO'] = $utilizacao_imovel;
    } else {
        $array_erros['txt_imovel_desc_utilizacao'] = 'POR FAVOR ENTRE COM UTILIZAÇÃO IMOVEL VÁLIDA ';
    }

    //   IMOVEL -- DESCRICAO _ UTILIZAÇÃO

    if ((strlen($codigo_utilizacao_imovel) > 0) && (strlen($codigo_utilizacao_imovel) < 3)) {
        $utilizacao = $codigo_utilizacao_imovel;
        $_SESSION['IMOV_COD_UTILIZACAO'] = $codigo_utilizacao_imovel;
    } else {
        $array_erros['txt_imovel_cod_utilizacao'] = 'POR FAVOR ENTRE COM CÓDIGO UTILIZAÇÃO IMOVEL VÁLIDA ';
    }

    //   IMOVEL -- VALOR_VENAL
    if (strlen($valor_venal_imovel) > 3) {
        $valor_venal = inserirDinheiro($valor_venal_imovel);
        $_SESSION['IMOV_VALOR_VENAL'] = $valor_venal_imovel;
    } else {
        $array_erros['txt_imovel_valor_venal'] = 'POR FAVOR ENTRE COM O VALOR VENAL IMOVEL VÁLIDA \n ';
    }


    //   IMOVEL -- CODIGO BAIRRO
    if ((strlen($codigo_bairro_imovel) > 0) && (strlen($codigo_bairro_imovel) < 5)) {
        $bairro_imob = $codigo_bairro_imovel;
        $_SESSION['IMOV_CODIGO_BAIRRO'] = $codigo_bairro_imovel;
    } else {
        $array_erros['txt_imovel_codigo_bairro'] = 'POR FAVOR ENTRE COM O CODIGO BAIRRO IMOVEL VÁLIDO \n ';
    }

    //   IMOVEL -- DESCRICAO BAIRRO
    if ((strlen($bairro_imovel) > 1) && (strlen($bairro_imovel) < 21)) {
        $desc_bairro_imob = $bairro_imovel;
        $_SESSION['IMOV_BAIRRO'] = $bairro_imovel;
    } else {
        $array_erros['txt_imovel_descricao_bairro'] = 'POR FAVOR ENTRE COM O BAIRRO IMOVEL VÁLIDO \n ';
    }

    //   IMOVEL -- CODIGO LOGRADOURO
    if ((strlen($codigo_logradouro_imovel) > 3) && (strlen($codigo_logradouro_imovel) < 6)) {
        $logradouro_imob = $codigo_logradouro_imovel;
        $_SESSION['IMOV_CODIGO_RUA'] = $codigo_logradouro_imovel;
    } else {
        $array_erros['txt_imovel_codigo_bairro'] = 'POR FAVOR ENTRE COM O CODIGO LOGRADOURO IMOVEL VÁLIDO \n ';
    }


    //   IMOVEL -- DESCRICAO LOGRADOURO
    if ((strlen($logradouro_imovel) > 1) && (strlen($logradouro_imovel) < 51)) {
        $desc_logradouro_imob = $logradouro_imovel;
        $_SESSION['IMOV_NOME_RUA'] = $logradouro_imovel;
    } else {
        $array_erros['txt_imovel_descricao_logradouro'] = 'POR FAVOR ENTRE COM O LOGRADOURO IMOVEL VÁLIDO \n ';
    }

    //   IMOVEL -- NUMERO LOGRADOURO
    if ((strlen($numero_endereco_imovel) < 6)) {
        $numero_end_imob = $numero_endereco_imovel;
        $_SESSION['IMOV_NUM'] = $numero_endereco_imovel;
    } else {
        $array_erros['txt_imovel_numero'] = 'POR FAVOR ENTRE COM O NUMERO ENDEREÇO IMOVEL VÁLIDO \n ';
    }


    //   IMOVEL -- COMPLEMENTO LOGRADOURO
    if ((strlen($complemento_imovel) < 20)) {
        $complemento_imob = $complemento_imovel;
        $_SESSION['IMOV_COMPL'] = $complemento_imovel;
    } else {
        $array_erros['txt_imovel_numero'] = 'POR FAVOR ENTRE COM O COMPLEMENTO IMOVEL VÁLIDO \n ';
    }


    //   IMOVEL -- QUADRA LOGRADOURO
    if ((strlen($complemento_imovel) < 20)) {
        $quadra_imob = $complemento_imovel;
        $_SESSION['IMOV_COMPL'] = $complemento_imovel;
    } else {
        $array_erros['txt_imovel_numero'] = 'POR FAVOR ENTRE COM O COMPLEMENTO IMOVEL VÁLIDO \n ';
    }

    //   IMOVEL -- LOTE LOGRADOURO
    if ((strlen($complemento_imovel) < 20)) {
        $lote_imob = $complemento_imovel;
        $_SESSION['IMOV_COMPL'] = $complemento_imovel;
    } else {
        $array_erros['txt_imovel_numero'] = 'POR FAVOR ENTRE COM O COMPLEMENTO IMOVEL VÁLIDO \n ';
    }


//    DADOS TRANSACAO
    //    TRANSAÇÃO -- NATUREZA
    if ((strlen($natureza_trans) > 0) && (strlen($natureza_trans) < 11)) {
        $natureza = $natureza_trans;
        $_SESSION['T_NATUREZA'] = $natureza_trans;
    } else {
        $array_erros['txt_transacao_natureza'] = 'POR FAVOR ENTRE COM A NATUREZA DA TRANSAÇÃO VÁLIDA \n ';
    }

    //    TRANSAÇÃO -- NUMERO PROCESSO
    if ((strlen($numero_processo_trans) > 0) && (strlen($numero_processo_trans) < 7)) {
        $numero_processo = $numero_processo_trans;
        $_SESSION['T_NUM_PROC'] = $numero_processo_trans;
    } else {
        $array_erros['txt_transacao_numero_processo'] = 'POR FAVOR ENTRE COM NUMERO PROCESSO DA TRANSAÇÃO VÁLIDA \n ';
    }

    //   TRANSAÇÃO -- ANO PROCESSO
    if ((strlen($ano_processo_trans) > 0) && (strlen($ano_processo_trans) < 5)) {
        $ano_processo = $ano_processo_trans;
        $_SESSION['T_ANO_PROC'] = $ano_processo_trans;
    } else {
        $array_erros['txt_transacao_ano_processo'] = 'POR FAVOR ENTRE COM ANO PROCESSO DA TRANSAÇÃO VÁLIDA \n ';
    }
    //   TRANSAÇÃO -- IMUNIDADE
    if (strlen($imunidade_trans) == 1) {
        $imunidade = $imunidade_trans;
        $_SESSION['T_IMUNIDADE'] = $imunidade_trans;
    } else {
        $array_erros['txt_transacao_imunidade'] = 'POR FAVOR ENTRE COM IMUNIDADE DA TRANSAÇÃO VÁLIDA \n ';
    }
    //   TRANSAÇÃO -- VALOR_DECLARADO
    if (strlen($valor_declarado_trans) > 3) {
        $valor_declarado = inserirDinheiro($valor_declarado_trans);
        $_SESSION['T_VALOR_DECLARADO'] = $valor_declarado_trans;
    } else {
        $array_erros['txt_transacao_valor_declarado'] = 'POR FAVOR ENTRE COM VALOR DECLARADO VÁLIDO \n ';
    }

    //   TRANSAÇÃO -- BASE_CALCULO
    if (strlen($base_calculo_trans) > 3) {
        $base_calculo = inserirDinheiro($base_calculo_trans);
        $_SESSION['T_BASE_CALCULO'] = $base_calculo_trans;
    } else {
        $array_erros['txt_transacao_valor_base_calculo'] = 'POR FAVOR ENTRE COM A BASE CALCULO VÁLIDA \n ';
    }
    //   TRANSAÇÃO -- VALOR_ITBI
    if (strlen($valor_itbi_trans) > 3) {
        $valor_itbi = inserirDinheiro($valor_itbi_trans);
        $_SESSION['T_VALOR_ITBI'] = $valor_itbi_trans;
    } else {
        $array_erros['txt_transacao_valor_itbi'] = 'POR FAVOR ENTRE COM VALOR ITBI DA TRANSAÇÃO VÁLIDA \n ';
    }

    //   TRANSAÇÃO -- VALOR_TOTAL
    if (strlen($valor_total_trans) > 3) {
        $valor_total = inserirDinheiro($valor_total_trans);
        $_SESSION['T_VALOR_TOTAL_ITBI'] = $valor_total_trans;
    } else {
        $array_erros['txt_transacao_valor_total'] = 'POR FAVOR ENTRE COM VALOR TOTAL VÁLIDO \n ';
    }


//  valida se o tipo da data está correta
    if (validar_estrutura_data($data_trans)) {
        $data_transacao = dataAmericano($data_trans);
        $_SESSION['T_DATA_TRAN'] = $data_trans;
    } else {
        $array_erros['txt_transacao_data'] = 'POR FAVOR ENTRE COM UMA DATA TRANSAÇÃO VÁLIDA \n\n ';
    }


//  valida se o tipo da data está correta
    if (validar_estrutura_data($vencimento_trans)) {
        $vencimento = dataAmericano($vencimento_trans);
        $_SESSION['T_DATA_VENC'] = $vencimento_trans;
    } else {
        $array_erros['txt_transacao_vencimento'] = 'POR FAVOR ENTRE COM UMA DATA VENCIMENTO VÁLIDA \n\n ';
    }


    //   TRANSAÇÃO -- MULTA
    if (strlen($multa_trans) == 1) {
        $Tem_Multa = $multa_trans;
        $_SESSION['T_VALOR_MULTA'] = $valor_multa_trans;
    } else {
        $array_erros['txt_transacao_ano_processo'] = 'POR FAVOR ENTRE COM IMUNIDADE DA TRANSAÇÃO VÁLIDA \n ';
    }
    //   TRANSAÇÃO -- DECLARANTE
    if (strlen($declarante_trans) > 2 && strlen($declarante_trans) < 51) {
        $declarante = $declarante_trans;
        $_SESSION['T_DECLARANTE'] = $declarante_trans;
    } else {
        $array_erros['txt_transacao_ano_processo'] = 'POR FAVOR ENTRE COM DECLARANTE DA TRANSAÇÃO VÁLIDA \n ';
    }
    //   TRANSAÇÃO -- OBSERVACAO
    if (strlen($obs_itbi_trans) < 240) {
        $obs_itbi = $obs_itbi_trans;
        $_SESSION['T_OBS_ITBI'] = $obs_itbi_trans;
    } else {
        $array_erros['txt_transacao_observacao'] = 'POR FAVOR ENTRE COM OBSERVAÇÃO DA TRANSAÇÃO VÁLIDA \n ';
    }

// verifico se tem erro na validação
    if (empty($array_erros)) {

//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
        $pdo->beginTransaction();

//      Comando sql a ser executado 

        $sql = "INSERT INTO Itbi "
                . "(Num_Itbi,"
                . "Ano_Itbi,"
                . "Adquirente,"
                . "Tipo_Pessoa_Adquirente,"
                . "Cgc_Cpf_Adquirente,"
                . "Identidade_Adquirente,"
                . "Rua_Adquirente,"
                . "Numero_Adquirente,"
                . "Compl_Adquirente,"
                . "Bairro_Adquirente,"
                . "Cidade_Adquirente,"
                . "Uf_Adquirente,"
                . "Cep_Adquirente,"
                . "Transmitente,"
                . "Tipo_Pessoa_Transmitente,"
                . "Cgc_Cpf_Transmitente,"
                . "Identidade_Transmitente,"
                . "Rua_Transmitente,"
                . "Numero_Transmitente,"
                . "Compl_Transmitente,"
                . "Bairro_Transmitente,"
                . "Cidade_Transmitente,"
                . "Uf_Transmitente,"
                . "Cep_Transmitente,"
                . "Inscricao_Imob,"
                . "Proprietario,"
                . "Area_Terreno,"
                . "Fracao_ideal,"
                . "Utilizacao_Imovel,"
                . "Valor_Venal,"
                . "Cod_Rua,"
                . "Numero,"
                . "Complemento,"
                . "Quadra,"
                . "Num_Lote,"
                . "Cod_Bairro,"
                . "Area_Construida,"
                . "Valor_Declarado,"
                . "Cod_Natureza,"
                . "NUM_PROCESSO,"
                . "ANO_PROCESSO,"
                . "IMUNE,"
                . "Base_Calculo,"
                . "Valor_Itbi,"
                . "Data_Transacao,"
                . "Vencimento,"
                . "Tem_Multa,"
                . "Declarante,"
                . "Observacao"
                . ")"
                . "values"
                . "("
                . "'$numero_itbi',"
                . "'$ano_itbi',"
                . "'$nome_completo_ad',"
                . "'$tipo_pessoa_ad',"
                . "'$cpf_cnpj_ad',"
                . "'$identidade_ad',"
                . "'$rua_ad',"
                . "'$numero_end_ad',"
                . "'$complemento_end_ad',"
                . "'$bairro_ad',"
                . "'$cidade_ad',"
                . "'$uf_ad',"
                . "'$cep_ad',"
                . "'$nome_completo_tr',"
                . "'$tipo_pessoa_tr',"
                . "'$cpf_cnpj_tr',"
                . "'$identidade_tr',"
                . "'$rua_tr',"
                . "'$numero_end_tr',"
                . "'$complemento_end_tr',"
                . "'$bairro_tr',"
                . "'$cidade_tr',"
                . "'$uf_tr',"
                . "'$cep_tr',"
                . "'$num_inscricao',"
                . "'$proprietario_imob',"
                . "'$area_terreno',"
                . "'$fracao_ideal',"
                . "'$utilizacao',"
                . "'$valor_venal',"
                . "'$logradouro_imob',"
                . "'$numero_end_imob',"
                . "'$complemento_imob',"
                . "'$quadra_imob',"
                . "'$lote_imob',"
                . "'$bairro_imob',"
                . "'$area_construida',"
                . "'$valor_declarado',"
                . "'$natureza',"
                . "'$numero_processo',"
                . "'$ano_processo',"
                . "'$imunidade',"
                . "'$base_calculo',"
                . "'$valor_total',"
                . "'$data_transacao',"
                . "'$vencimento',"
                . "'$Tem_Multa',"
                . "'$declarante',"
                . "'$obs_itbi'"
                . ")";

//  execução com comando sql    
        $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
//            die('<script>window.alert("ERRO AO ALTERAR ITBI  !!!");location.href = "../../../Itbi.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
            die("ERRO AO CADASTRAR ITBI"); /* É disparado em caso de erro na inserção de movimento */
        } else {
//          salvo alteração no banco de dados
// comparação para saber se o numero do itbi é menor do que o valor do proximo ibti
            if (comparaNumeroItbi($pdo) < $numero_itbi) {
//           se o numero do itbi que estou cadastrando for maior que o da
//            tabela sisparametros eu realizo update da tabela pra o proximo numero
//            comando sql update da tabela sisparametros
                $sql = "UPDATE sisparametros SET num_itbi = '$numero_itbi', Ano_Itbi = '$ano_itbi'";

//            executo comando sql
                $executa = $pdo->query($sql);

//            caso exista problema na alteração
                if (!$executa) {
                    ?> 
                    <script>
                        window.alert("<?php echo "Erro ao Cadastrar !!!"; ?> ");
                        location.href = "../../../Itbi.php";
                    </script>
                    <?php
                    die(); /* É disparado em caso de erro na inserção de movimento */
                }
            }

            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
        }
        $pdo = null;
        ?>

        <!-- Dispara mensagem de sucesso -->

        <script>
            window.open('../relatorio/relatorio_itbi.php', "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=0,width=auto,height=auto");
            location.href = "../../../Itbi.php";
        </script>   
        <?php
//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }
        echo '<script>window.alert("' . $msg_erro . '");
            location.href = "../../../Itbi.php";
        </script>';
    }


// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}

//    função para retornar o proximo numero de ibti no sistema
function comparaNumeroItbi($pdo) {
    $sql3 = "SELECT num_itbi, Ano_Itbi FROM sisparametros";
    $query1 = $pdo->prepare($sql3);
    //executo o comando sql
    $query1->execute();
    if (($dados1 = $query1->fetch()) == true) {
        return $dados1['num_itbi'];
    } else {
        return "";
    }
}
?>
