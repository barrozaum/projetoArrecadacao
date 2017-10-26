<?php
//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/function_letraMaiscula.php';
include_once '../funcaoPHP/funcaoData.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//    VARIAVEIS 
//ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();


    if (!fun_aplica_validacao_campo($_POST['txt_num_inscricao'], 6, 6)) {
        $array_erros['txt_inscricao'] = 'POR FAVOR ENTRE COM INSCRICÃO VÁLIDA \n';
    }

    if (!fun_aplica_validacao_campo($_POST['txt_proprietario_imovel'], 3, 50)) {
        $array_erros['txt_proprietario_imovel'] = 'POR FAVOR ENTRE COM PROPRIETARIO VÁLIDO  \n';
    }

    if (!fun_aplica_validacao_campo($_POST['txt_logradouro_imovel'], 1, 50)) {
        $array_erros['txt_logradouro_imovel'] = 'POR FAVOR ENTRE COM LOGRADOURO VÁLIDO  \n';
    }

    if (!fun_aplica_validacao_campo($_POST['txt_nome_completo_requerente'], 3, 50)) {
        $array_erros['txt_nome_completo_requerente'] = 'POR FAVOR ENTRE COM REQUERENTE VÁLIDO  \n';
    }

    if (!fun_aplica_validacao_campo($_POST['txt_tipo_pessoa_requerente'], 5, 9)) {
        $array_erros['txt_tipo_pessoa_requerente'] = 'POR FAVOR ENTRE COM TIPO PESSOA VÁLIDO  \n';
    }

    if (!fun_aplica_validacao_campo($_POST['txt_cep_requerente'], 5, 9)) {
        $array_erros['txt_cep_requerente'] = 'POR FAVOR ENTRE COM CEP VÁLIDO  \n';
    }

    if (!fun_aplica_validacao_campo($_POST['txt_identidade_requerente'], 3, 20)) {
        $array_erros['txt_identidade_requerente'] = 'POR FAVOR ENTRE COM IDENTIDADE VÁLIDA  \n';
    }



// verifico se tem erro na validação
    if (empty($array_erros)) {
        try {
            include_once '../estrutura/conexao/conexao.php';
            $pdo->beginTransaction();
            func_executa_sql($pdo);
            $pdo->commit();   
           
            header("Location: relatorio_certidao_negativa.php");
            
         
            
//    $pdo->commit();
        } catch (Exception $ex) {
             echo '<script>window.alert("' . $ex->getMessage() . '");
               location.href = "../../../RelCertidaoNegativa.php";
        </script>';
        }
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../RelCertidaoNegativa.php";
        </script>';
    }

// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}

function func_buscar_proximo_numero_certidao($pdo) {
    $sql = "SELECT * FROM SisParametros";
    $query = $pdo->prepare($sql);
    $query->execute();
    if ($dados = $query->fetch()) {
        return $dados['Num_Certidao'];
    } else {
        return "0";
    }
}

function func_executa_sql($pdo) {

    //nome da estação que esta acessando o sistema
    $hostname = $_SERVER['REMOTE_ADDR'];
    // Nome do usuário logado
    $usuario_logado = $_SESSION["usuario"];
    //pegando o numero da certidao
    $numero_certidao = str_pad(func_buscar_proximo_numero_certidao($pdo), 6, "0", STR_PAD_LEFT);
    $ano_certidao = date('Y');
    $inscricao = letraMaiuscula($_POST['txt_num_inscricao']);
    $cadastro = 1;
    $cod_divida = '01';
    $requerente = $_POST['txt_nome_completo_requerente'];
    $obs = $_POST['txt_obs'];
    $data_emissao = dataAmericano(date('d/m/Y'));
    $tipo_certidao = '01';
    

    $sql_insert = "INSERT INTO Certidao (Num_Certidao, Ano_Certidao, Inscricao, Cadastro, Cod_Divida, Requerente, Obs, Data_Emissao, Tipo_Certidao, USUARIO, ESTACAO)";
    $sql_insert = $sql_insert . " VALUES ";
    $sql_insert = $sql_insert . " (:numero_certidao, :ano_certidao, :inscricao, :cadastro, :cod_divida, :requerente,:obs, :data_emissao, :tipo_certidao, :usuario, :estacao)";

    $executa_insert = $pdo->prepare($sql_insert);
    $executa_insert->bindParam(':numero_certidao', $numero_certidao);
    $executa_insert->bindParam(':ano_certidao', $ano_certidao);
    $executa_insert->bindParam(':inscricao', $inscricao);
    $executa_insert->bindParam(':cadastro', $cadastro);
    $executa_insert->bindParam(':cod_divida', $cod_divida);
    $executa_insert->bindParam(':requerente', $requerente);
    $executa_insert->bindParam(':obs', $obs);
    $executa_insert->bindParam(':data_emissao', $data_emissao);
    $executa_insert->bindParam(':tipo_certidao', $tipo_certidao);
    $executa_insert->bindParam(':usuario', $usuario_logado);
    $executa_insert->bindParam(':estacao', $hostname);

    $executa_insert->execute();
    
    func_carreagar_variaveis($numero_certidao);

    fun_alterar_numero_certidao($pdo, $numero_certidao + 1);
    
}


function fun_alterar_numero_certidao($pdo, $proximo){
    $sql_update = "UPDATE SisParametros SET Num_Certidao = ?";
    $executa_update = $pdo->prepare($sql_update);
    $executa_update->bindParam(1, $proximo);
    $executa_update->execute();
}


function func_carreagar_variaveis($numero_certidao){
    
//VARIAVEIS DE SESSAO
  $_SESSION['PASSOU_CONTROLE'] = "OK";  
    
$_SESSION['REL_NUMERO_CERTIDAO'] = $numero_certidao;
$_SESSION['REL_ANO_CERTIDAO'] = date('Y');
$_SESSION['REL_INSCRICAO'] = letraMaiuscula($_POST['txt_num_inscricao']);
$_SESSION['REL_CONTRIBUINTE'] = letraMaiuscula($_POST['txt_proprietario_imovel']);
$_SESSION['REL_ENDERECO'] = letraMaiuscula($_POST['txt_logradouro_imovel']) . letraMaiuscula($_POST['txt_quadra_endereco_imovel']). letraMaiuscula($_POST['txt_lote_endereco_imovel']) ;
$_SESSION['REL_CIDADE'] = 'JAPERI';
$_SESSION['REL_BAIRRO'] = letraMaiuscula($_POST['txt_bairro_imovel']);
$_SESSION['REL_ESTADO'] = 'RJ';
$_SESSION['REL_AREA_CONSTRUIDA'] = letraMaiuscula($_POST['txt_area_construida']);
$_SESSION['REL_AREA_TERRENO'] = letraMaiuscula($_POST['txt_area_terreno']);
$_SESSION['REL_AVERBADO_EM'] = '21/01/2017';
$_SESSION['REL_VALOR_VENAL'] = letraMaiuscula($_POST['txt_valor_venal']);
$_SESSION['REL_UTILIZACAO'] = letraMaiuscula($_POST['txt_utilizacao']);
$_SESSION['REL_REQUERENTE'] = letraMaiuscula($_POST['txt_nome_completo_requerente']);
$_SESSION['REL_REQUERENTE_CPF'] = letraMaiuscula($_POST['txt_cpf_cnpj_requerente']);
$_SESSION['REL_REQUERENTE_IDENTIDADE'] = letraMaiuscula($_POST['txt_identidade_requerente']);
$_SESSION['REL_REQUERENTE_ENDERECO'] =letraMaiuscula($_POST['txt_cep_requerente']) . " - " .letraMaiuscula($_POST['txt_rua_requerente']) . " - " . letraMaiuscula($_POST['txt_bairro_requerente']) . " - ". letraMaiuscula($_POST['txt_cidade_requerente'])   ;
$_SESSION['REL_REQUERENTE_ENDERECO'] = $_SESSION['REL_REQUERENTE_ENDERECO'] . letraMaiuscula($_POST['txt_uf_requerente']). " - " .  letraMaiuscula($_POST['txt_numero_endereco_requerente']). " - " .  letraMaiuscula($_POST['txt_complemento_endereco_requerente']) ;
$_SESSION['NUMERO_PROCESSO'] = letraMaiuscula($_POST['txt_numero_processo']);
$_SESSION['ANO_PROCESSO']= letraMaiuscula($_POST['txt_ano_processo']);
$_SESSION['REL_AVERBADO_EM']= letraMaiuscula($_POST['txt_data_averbacao']);
         
$_SESSION['REL_CARTA'] = '        CERTIFICO, conforme despacho exarado no processo administrativo número '. $_SESSION['NUMERO_PROCESSO'] .'/' . $_SESSION['ANO_PROCESSO']  .', em que o requerente Sr(a) : ';
$_SESSION['REL_CARTA'] = $_SESSION['REL_CARTA'] . $_SESSION['REL_REQUERENTE'];
$_SESSION['REL_CARTA'] = $_SESSION['REL_CARTA'] . ", CPF = ". $_SESSION['REL_REQUERENTE_CPF'];
$_SESSION['REL_CARTA'] = $_SESSION['REL_CARTA'] . ", IDENTIDADE ". $_SESSION['REL_REQUERENTE_IDENTIDADE'];
$_SESSION['REL_CARTA'] = $_SESSION['REL_CARTA'] . ", situado ". $_SESSION['REL_REQUERENTE_ENDERECO'];
$_SESSION['REL_CARTA'] = $_SESSION['REL_CARTA'] . ", de acordo com as informações constantes em nossa base de dados, que o imóvel acima ";
$_SESSION['REL_CARTA'] = $_SESSION['REL_CARTA'] . " descrito encontra-se QUITE com o Imposto respectivos";
$_SESSION['REL_OBSERVACAO'] = letraMaiuscula($_POST['txt_obs']);
}
?>