<?php

//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcao_retorna_rua.php';
include_once '../funcaoPHP/funcao_retorna_bairro.php';
include_once '../funcaoPHP/funcaoCpfCnpj.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoPessoaFisica_Juridica.php';
include_once '../funcaoPHP/funcaoDinheiro.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


//ARRAY PARA ARMAZENAR ERROS
    $erros = "";

// biblioteca para validar string informada    
    include ('../funcaoPHP/function_letraMaiscula.php');
//    aplica filtro na string enviada (LetraMaiuscula)
    $op_Letra_Maiscula = letraMaiuscula($_POST['op']);

// variaves serão preenchidas por valores do formulario
// // valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($op_Letra_Maiscula) > 0 && strlen($op_Letra_Maiscula) < 3) || is_int($op_Letra_Maiscula) === TRUE) {
        $op = $op_Letra_Maiscula;
    } else {
        $erros = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO !!! <br />';
    }

    if (isset($_POST['insricao_imobiliaria'])) {
        if (fun_aplica_validacao_campo($_POST['insricao_imobiliaria'], 6, 6)) {
            $inscricao_imob = letraMaiuscula($_POST['insricao_imobiliaria']);
        } else {
            $erros .= 'POR FAVOR ENTRE COM INSCRICAO IMOB VÁLIDA !!! <br />';
        }
    }
    if (isset($_POST['numero_docarj'])) {
        if (fun_aplica_validacao_campo($_POST['numero_docarj'], 6, 6)) {
            $num_Docarj = letraMaiuscula($_POST['numero_docarj']);
        } else {
            $erros .= 'POR FAVOR ENTRE COM NUMERO DOCARJ VÁLIDO  !!! <br />';
        }
    }
    if (isset($_POST['ano_docarj'])) {
        if (fun_aplica_validacao_campo($_POST['ano_docarj'], 4, 4)) {
            $ano_Docarj = letraMaiuscula($_POST['ano_docarj']);
        } else {
            $erros .= 'POR FAVOR ENTRE COM ANO DOCARJ VÁLIDO !!! <br />';
        }
    }
    if (isset($_POST['cod_rua'])) {
        if (fun_aplica_validacao_campo($_POST['cod_rua'], 5, 5)) {
            $cod_rua = letraMaiuscula($_POST['cod_rua']);
        } else {
            $erros .= 'POR FAVOR ENTRE COM CÓDIGO DE RUA VÁLIDO  !!! <br />';
        }
    }
    if (isset($_POST['cod_bairro'])) {
        if (fun_aplica_validacao_campo($_POST['cod_bairro'], 3, 3)) {
            $cod_bairro = letraMaiuscula($_POST['cod_bairro']);
        } else {
            $erros .= 'POR FAVOR ENTRE COM CÓDIGO DE BAIRRO VÁLIDO  !!! <br />';
        }
    }
// verifico se tem erro na validação
    if ($erros == "") {

        //  INCLUSAO DA BIBLIOTECA CONEXAO
        include_once '../estrutura/conexao/conexao.php';

        // SELECIONO A OPÇÃO DO PROGRAMA QUE IREI EXECUTAR
        if ($op_Letra_Maiscula == 1) {
            retornaProximoValor($pdo);
            die();
        }
        if ($op_Letra_Maiscula == 2) {
            retornaDadosImobiliario($pdo, $inscricao_imob);
            die();
        }
        if ($op_Letra_Maiscula == 3) {
            retornaDadosDocarj($pdo, $num_Docarj, $ano_Docarj);
            die();
        }
        if ($op_Letra_Maiscula == 4) {
            FUNC_RETORNA_JSON_DESCRICAO_RUA_E_CEP($pdo, $cod_rua);
            die();
        }
        if ($op_Letra_Maiscula == 5) {
            FUNC_RETORNA_JSON_DESCRICAO_BAIRRO($pdo, $cod_bairro);
            die();
        }
    } else { // if (empty($array_erros)) {
        $array_erros['achou'] = 0;
        $array_erros['erro_validacao'] = $erros;
        echo json_encode($array_erros);
    }





// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}

//PROCURO O PRÓXIMO NUMERO A SER INSERIDO NO SISTEMA
function retornaProximoValor($pdo) {


// preparo para realizar o comando sql
    $sql = "SELECT * FROM sisparametros";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    $dados = $query->fetch();

// array com resultado de saida

    $var = Array(
        "numero_itbi" => str_pad(++$dados['Num_Dam'], 6, "0", STR_PAD_LEFT),
        "ano_itbi" => $dados['Ano_Dam']
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);

//    fecha conexao
    $pdo = null;
}

function retornaDadosImobiliario($pdo, $incricao) {

    $sql = "SELECT * FROM Cad_Imobiliario WHERE Inscricao_Imob = $incricao";
    $query = $pdo->prepare($sql);
    $query->execute();
    if ($dados = $query->fetch()) {
        $proprietario = $dados['Proprietario'];
        $tipo_pessoa = FUN_MOSTRAR_DESCRICAO_TIPO_PESSOA($dados['Tipo_Pessoa']);
        $cpf_cnpj = FUN_COLOCAR_MASCARA_CPF_CNPJ($dados['Cpf_Cgc']);
        $telefone = $dados['Telefone'];
        $numero = $dados['Numero_corr'];
        $rua = $dados['Cod_Rua'];
        $bairro = $dados['Cod_Bairro'];
        $complemento = $dados['Complemento'];
    }

    $var = Array(
        "proprietario" => "$proprietario",
        "tipo_pessoa" => "$tipo_pessoa",
        "cpf_cnpj" => "$cpf_cnpj",
        "telefone" => "$telefone",
        "numero" => "$numero",
        "rua" => "$rua",
        "bairro" => "$bairro",
        "complemento" => "$complemento"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);

//    fecha conexao
    $pdo = null;
}

function retornaDadosDocarj($pdo, $num_Docar, $ano_Docarj) {
    $sql = "SELECT * FROM DAM ";
    $sql = $sql . " WHERE Num_Dam = '$num_Docar' ";
    $sql = $sql . " AND Ano_Dam = '$ano_Docarj' ";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

    if ($dados = $query->fetch()) {
        $cod_atividade = $dados['Cod_Atividade'];
        $desc_atividade = $dados['Desc_Atividade'];
        $codigo_cadastro = $dados['Cod_Cadastro'];
        $inscricao = $dados['Inscricao'];
        $nome_contribuinte = $dados['Nome_Contribuinte'];
        $tipo_pessoa = FUN_MOSTRAR_DESCRICAO_TIPO_PESSOA($dados['Tipo_Pessoa']);
        $cpf_cnpj = FUN_COLOCAR_MASCARA_CPF_CNPJ($dados['CPF_CGC']);
        $telefone = str_replace(" ", "", $dados['Telefone']);
        $cep = $dados['CEP'];
        $rua = $dados['Logradouro'];
        $bairro = $dados['Bairro'];
        $cidade = $dados['Cidade'];
        $uf = $dados['UF'];
        $complemento_endereco = $dados['Complemento'];
        $numero_endereco = $dados['Numero'];
        $receita_1 = $dados['Receita_1'];
        $valor_1 = mostrarDinheiro($dados['Valor_1']);
        $obs_1 = $dados['Obs_1'];
        $receita_2 = $dados['Receita_2'];
        $valor_2 = mostrarDinheiro($dados['Valor_2']);
        $obs_2 = $dados['Obs_2'];
        $receita_3 = $dados['Receita_3'];
        $valor_3 = mostrarDinheiro($dados['Valor_3']);
        $obs_3 = $dados['Obs_3'];
        $receita_4 = $dados['Receita_4'];
        $valor_4 = mostrarDinheiro($dados['Valor_4']);
        $obs_4 = $dados['Obs_4'];
        $tx_expediente = mostrarDinheiro($dados['Taxa_Expediente']);
        $multa = mostrarDinheiro($dados['Multa']);
        $juros = mostrarDinheiro($dados['Juros']);
        $auto_infracao = $dados['Auto_Infracao'];
        $num_processo = $dados['Num_Processo'];
        $ano_processo = $dados['Ano_Processo'];
        $total_docarj = mostrarDinheiro($dados['Total']);
        $financeiro_docarj = retorna_dados_financeiro_docarj($pdo, $num_Docar, $ano_Docarj);


        $var = Array(
            "achou" => "1",
            "codigo_atividade" => $cod_atividade,
            "descricao_atividade" => $desc_atividade,
            "codigo_cadastro" => $codigo_cadastro,
            "inscricao" => $inscricao,
            "nome_contribuinte" => $nome_contribuinte,
            "cpf_cnpj" => $cpf_cnpj,
            "tipo_pessoa" => $tipo_pessoa,
            "telefone" => $telefone,
            "cep" => $cep,
            "rua" => $rua,
            "bairro" => $bairro,
            "cidade" => $cidade,
            "uf" => $uf,
            "complemento_endereco" => $complemento_endereco,
            "numero_endereco" => $numero_endereco,
            "receita_1" => $receita_1,
            "valor_1" => $valor_1,
            "obs_1" => $obs_1,
            "receita_2" => $receita_2,
            "valor_2" => $valor_2,
            "obs_2" => $obs_2,
            "receita_3" => $receita_3,
            "valor_3" => $valor_3,
            "obs_3" => $obs_3,
            "receita_4" => $receita_4,
            "valor_4" => $valor_4,
            "obs_4" => $obs_4,
            "tx_expediente" => $tx_expediente,
            "multas" => $multa,
            "juros" => $juros,
            "auto_infracao" => $auto_infracao,
            "numero_processo" => $num_processo,
            "ano_processo" => $ano_processo,
            "total_docarj" => $total_docarj,
            "financeiro_docarj" => $financeiro_docarj,
        );
    } else {
        $var = Array(
            "achou" => "0"
        );
    }



    // convertemos em json e colocamos na tela
    echo json_encode($var);

//    fecha conexao
    $pdo = null;
}

function retorna_dados_financeiro_docarj($pdo, $numero_docarj, $ano_docarj) {
//   variaveis 
    $data_vencimento = "00/00/0000";
    $cod_situacao_dam = "00";
    $parcela_inicial = "00";
//     array de codigos
    $cod_situacao = array("04", "05", "06", "07", "08", "09");

    $sql = "select * from Financeiro_Dam where Ano_Dam = '$ano_docarj' and Num_Dam = '$numero_docarj' ORDER BY Vencimento DESC ";
    $query = $pdo->prepare($sql);
    $query->execute();

    for ($i = 0; $dados = $query->fetch(); $i++) {
        $data_vencimento = dataBrasileiro($dados['Vencimento']);
        $parcela_inicial = $dados['Parcela'];
        if (in_array($dados['Cod_Situacao_divida'], $cod_situacao)) {
            $cod_situacao_dam = "04";
        }
    }
    if ($i < 10) {
        $i = "0" . $i;
    }

    $var = Array(
        "quantidade_parcelas" => $i,
        "parcela_inicial" => $parcela_inicial,
        "data_vencimento" => $data_vencimento,
        "cod_situacao_dam" => $cod_situacao_dam
    );


    // convertemos em json e colocamos na tela
    return $var;
}
