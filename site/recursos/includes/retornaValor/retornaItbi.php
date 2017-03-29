<?php

//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


//ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();

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
        $array_erros['descricao'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO \n';
    }

// verifico se tem erro na validação
    if (empty($array_erros)) {

        //  INCLUSAO DA BIBLIOTECA CONEXAO
        include_once '../estrutura/conexao/conexao.php';

        // SELECIONO A OPÇÃO DO PROGRAMA QUE IREI EXECUTAR
        if ($op_Letra_Maiscula == 1) {
            retornaProximoValor($pdo);
            die();
        } else if ($op_Letra_Maiscula == 2) {
            retornaITBI($pdo);
            die();
        } else if ($op_Letra_Maiscula == 3) {
            retornaDadosImovel($pdo);
            die();
        } else if ($op_Letra_Maiscula == 4) {
            valorDeclarado();
            die();
        }
    } else { // if (empty($array_erros)) {
        $array_erros['achou'] = 0;
        echo json_encode($array_erros);
    }





// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}

//} else if ($_REQUEST['op'] == 4) {
//    valorDeclarado();
//    die();
//} else if ($_REQUEST['op'] == 5) {
//    valorMulta();
//    die();
//}
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
        "numero_itbi" => str_pad(++$dados['Num_ITBI'], 6, "0", STR_PAD_LEFT),
        "ano_itbi" => $dados['Ano_ITBI']
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);

//    fecha conexao
    $pdo = null;
}

//Procuro o valor do ITBI e retorno ele caso exista no banco de Dados
function retornaITBI($pdo) {

//    INCLUSAO DAS BIBLIOTECAS
    include_once '../funcaoPHP/funcaoData.php';
    include_once '../funcaoPHP/funcaoDinheiro.php';
    include_once '../funcaoPHP/funcaoPessoaFisica_Juridica.php';
    include_once '../funcaoPHP/funcaoCpfCnpj.php';

//    aplica filtro na string enviada (LetraMaiuscula)
    $itbi = letraMaiuscula($_POST['itbi']);
    $ano_itbi = letraMaiuscula($_POST['ano']);


// preparo para realizar o comando sql
    $sql = "SELECT * FROM itbi WHERE Num_Itbi = '$itbi' AND Ano_Itbi = '$ano_itbi'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $achou = '1';

        // Adquirente --
        $Adquirente = $dados['Adquirente'];
        $Cgc_Cpf_Adquirente = FUN_COLOCAR_MASCARA_CPF_CNPJ($dados['Cgc_Cpf_Adquirente']);
        $Tipo_Pessoa_Adquirente = FUN_MOSTRAR_DESCRICAO_TIPO_PESSOA($dados['Tipo_Pessoa_Adquirente']);
        $Identidade_Adquirente = $dados['Identidade_Adquirente'];
        $Cep_Adquirente = $dados['Cep_Adquirente'];
        $Rua_Adquirente = $dados['Rua_Adquirente'];
        $Bairro_Adquirente = $dados['Bairro_Adquirente'];
        $Cidade_Adquirente = $dados['Cidade_Adquirente'];
        $Uf_Adquirente = $dados['Uf_Adquirente'];
        $Numero_Adquirente = $dados['Numero_Adquirente'];
        $Compl_Adquirente = $dados['Compl_Adquirente'];

        // Transmitente Cedente --
        $Transmitente = $dados['Transmitente'];
        $Tipo_Pessoa_Transmitente = FUN_MOSTRAR_DESCRICAO_TIPO_PESSOA($dados['Tipo_Pessoa_Transmitente']);
        $Cgc_Cpf_Transmitente = FUN_COLOCAR_MASCARA_CPF_CNPJ($dados['Cgc_Cpf_Transmitente']);
        $Identidade_Transmitente = $dados['Identidade_Transmitente'];
        $Cep_Transmitente = $dados['Cep_Transmitente'];
        $Rua_Transmitente = $dados['Rua_Transmitente'];
        $Bairro_Transmitente = $dados['Bairro_Transmitente'];
        $Cidade_Transmitente = $dados['Cidade_Transmitente'];
        $Uf_Transmitente = $dados['Uf_Transmitente'];
        $Numero_Transmitente = $dados['Numero_Transmitente'];
        $Compl_Transmitente = $dados['Compl_Transmitente'];

        // Imovel
        $Inscricao_Imob = $dados['Inscricao_Imob'];
        $Proprietario = $dados['Proprietario'];
        $Area_Terreno = $dados['Area_Terreno'];
        $Area_Construida = $dados['Area_Construida'];
        $Utilizacao_imovel = UtilizacaoImovel($dados['Utilizacao_Imovel'], $pdo);
        $Cod_Utilizacao = $dados['Utilizacao_Imovel'];
        $Logradouro = logradouro($dados['Cod_Rua'], $pdo);
        $Cod_Rua = $dados['Cod_Rua'];
        $Numero = $dados['Numero'];
        $Complemento = $dados['Complemento'];
        $Quadra = $dados['Quadra'];
        $Lote = $dados['Num_Lote'];
        $Bairro = bairro($dados['Cod_Bairro'], $pdo);
        $Cod_Bairro = $dados['Cod_Bairro'];
        $Valor_Venal = mostrarDinheiro(valor_venal($Inscricao_Imob, $pdo) * moeda());
        $Fracao_Ideal = $dados['Fracao_Ideal'];

        // transação
        $Natureza = $dados['Cod_Natureza'];
        $Num_Processo = $dados['NUM_PROCESSO'];
        $Ano_Processo = $dados['ANO_PROCESSO'];
        $Imune = $dados['IMUNE'];
        $Valor_Declarado = mostrarDinheiro($dados['Valor_Declarado']);
        $Base_Calculo = mostrarDinheiro($dados['Base_Calculo']);
        $valor_Total_Itbi = mostrarDinheiro($dados['Valor_Itbi']);
        $Data_Transacao = dataBrasileiro($dados['Data_Transacao']);
        $Vencimento = dataBrasileiro($dados['Vencimento']);
        $Declarante = $dados['Declarante'];
        $Observacao_Itbi = $dados['Observacao'];
        $Tem_Multa = $dados['Tem_Multa'];
        $Valor_Itbi = calcularValorBaseItbi($Base_Calculo);
        $valor_Multa = calculaMulta($Tem_Multa, $Valor_Itbi);
//        die($valor_Multa);
        $Situacao_divida = $dados['cod_situacao_divida'];

//        CRIAÇÃO ARRAY DE RETORNO
        $var = Array(
            "ACHOU" => "$achou",
            "ADQUIRENTE" => "$Adquirente",
            "CGC_CPF_ADQUIRENTE" => "$Cgc_Cpf_Adquirente",
            "TIPO_PESSOA_ADQUIRENTE" => "$Tipo_Pessoa_Adquirente",
            "IDENTIDADE_ADQUIRENTE" => "$Identidade_Adquirente",
            "CEP_ADQUIRENTE" => "$Cep_Adquirente",
            "RUA_ADQUIRENTE" => "$Rua_Adquirente",
            "BAIRRO_ADQUIRENTE" => "$Bairro_Adquirente",
            "CIDADE_ADQUIRENTE" => "$Cidade_Adquirente",
            "UF_ADQUIRENTE" => "$Uf_Adquirente",
            "NUMERO_ADQUIRENTE" => "$Numero_Adquirente",
            "COMPLEMENTO_ADQUIRENTE" => "$Compl_Adquirente",
            "TRANSMITENTE" => "$Transmitente",
            "TIPO_PESSOA_TRANSMITENTE" => "$Tipo_Pessoa_Transmitente",
            "CGC_CPF_TRANSMITENTE" => "$Cgc_Cpf_Transmitente",
            "IDENTIDADE_TRANSMITENTE" => "$Identidade_Transmitente",
            "CEP_TRANSMITENTE" => "$Cep_Transmitente",
            "RUA_TRANSMITENTE" => "$Rua_Transmitente",
            "BAIRRO_TRANSMITENTE" => "$Bairro_Transmitente",
            "CIDADE_TRANSMITENTE" => "$Cidade_Transmitente",
            "UF_TRANSMITENTE" => "$Uf_Transmitente",
            "NUMERO_TRANSMITENTE" => "$Numero_Transmitente",
            "COMPLEMENTO_TRANSMITENTE" => "$Compl_Transmitente",
            "INSCRICAO_IMOVEL" => "$Inscricao_Imob",
            "PROPRIETARIO" => "$Proprietario",
            "AREA_TERRENO" => "$Area_Terreno",
            "AREA_CONSTRUIDA" => "$Area_Construida",
            "UTILIZACAO_IMOVEL" => "$Utilizacao_imovel",
            "LOGRADOURO_IMOVEL" => "$Logradouro",
            "NUMERO_IMOVEL" => "$Numero",
            "COMPLEMENTO_IMOVEL" => "$Complemento",
            "QUADRA_IMOVEL" => "$Quadra",
            "LOTE_IMOVEL" => "$Lote",
            "BAIRRO_IMOVEL" => "$Bairro",
            "VALOR_VENAL_IMOVEL" => "$Valor_Venal",
            "FRACAO_IDEAL_IMOVEL" => "$Fracao_Ideal",
            "NATUREZA_TRANSACAO" => "$Natureza",
            "NUM_PROCESSO_TRANSACAO" => "$Num_Processo",
            "ANO_PROCESSO_TRANSACAO" => "$Ano_Processo",
            "IMUNE_TRANSACAO" => "$Imune",
            "VALOR_DECLARADO_TRANSACAO" => "$Valor_Declarado",
            "BASE_CALCULO_TRANSACAO" => "$Base_Calculo",
            "VALOR_ITBI_TRANSACAO" => "$Valor_Itbi",
            "DATA_TRANSACAO" => "$Data_Transacao",
            "VENCIMENTO" => "$Vencimento",
            "DECLARANTE" => "$Declarante",
            "OBSERVACAO" => "$Observacao_Itbi",
            "CODIGO_BAIRRO_IMOVEL" => "$Cod_Bairro",
            "CODIGO_RUA_IMOVEL" => "$Cod_Rua",
            "CODIGO_UTILIZACAO_IMOVEL" => "$Cod_Utilizacao",
            "TEM_MULTA" => "$Tem_Multa",
            "VALOR_MULTA" => "$valor_Multa",
            "VALOR_TOTAL_ITBI" => "$valor_Total_Itbi",
            "SITUACAO_DIVIDA" => "$Situacao_divida"
        );

// convertemos em json e colocamos na tela
        echo json_encode($var);
    } else { // if (($dados = $query->fetch()) == true) {
//        verifico se o ano do itbi é diferente do ano atual,
//        caso seja ele diferente só poderar cadastrar o proximo valor de itbi.
//        Caso contrário poderar cadastrar o valor desde que esteja 
//        vago
        $ano_atual = date('Y');

        if ($ano_itbi !== $ano_atual) {
            $achou = 0;
        } else {
            $achou = 2;
        }

        $var = Array(
            "ACHOU" => $achou
        );
        echo json_encode($var);
    }
//FECHA CONEXAO
    $pdo = null;
}

function retornaDadosImovel($pdo) {

//    INCLUSAO DAS BIBLIOTECAS
    include_once '../funcaoPHP/funcaoData.php';
    include_once '../funcaoPHP/funcaoDinheiro.php';

    //    aplica filtro na string enviada (LetraMaiuscula)
    $inscricao = letraMaiuscula($_POST['num_imovel']);



// preparo para realizar o comando sql
    $sql = "SELECT Proprietario, Area_Terreno, Area_Construida,Utilizacao_imovel,Numero,Complemento,Quadra,Lote,Cod_Rua,Cod_Bairro "
            . "FROM Cad_Imobiliario "
            . "WHERE Inscricao_Imob = '$inscricao'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
//        CAMPOS DO VETOR

        $achou = '1';
        $Proprietario = $dados['Proprietario'];
        $Area_Terreno = $dados['Area_Terreno'];
        $Area_Construida = $dados['Area_Construida'];
        $Utilizacao_imovel = UtilizacaoImovel($dados['Utilizacao_imovel'], $pdo);
        $Cod_Utilizacao = $dados['Utilizacao_imovel'];
        $Logradouro = logradouro($dados['Cod_Rua'], $pdo);
        $Cod_Rua = $dados['Cod_Rua'];
        $Numero = $dados['Numero'];
        $Complemento = $dados['Complemento'];
        $Quadra = $dados['Quadra'];
        $Lote = $dados['Lote'];
        $Bairro = bairro($dados['Cod_Bairro'], $pdo);
        $Cod_Bairro = $dados['Cod_Bairro'];
        $Valor_Venal = mostrarDinheiro(valor_venal($inscricao, $pdo) * moeda());
//        
//   VETOR COM SAIDA DE DADOS      
//        
        $var = Array(
            "ACHOU" => "$achou",
            "PROPRIETARIO" => "$Proprietario",
            "AREA_TERRENO" => "$Area_Terreno",
            "AREA_CONSTRUIDA" => "$Area_Construida",
            "UTILIZACAO" => "$Utilizacao_imovel",
            "LOGRADOURO" => "$Logradouro",
            "NUMERO" => "$Numero",
            "COMPLEMENTO" => "$Complemento",
            "QUADRA" => "$Quadra",
            "LOTE" => "$Lote",
            "BAIRRO" => "$Bairro",
            "VALOR_VENAL" => "$Valor_Venal",
            "COD_UTILIZACAO" => "$Cod_Utilizacao",
            "COD_RUA" => "$Cod_Rua",
            "COD_BAIRRO" => "$Cod_Bairro"
        );
    } else {
        $var = Array(
            "ACHOU" => "0",
            "MENSAGEM" => '<div class="alert alert-danger">INSCRIÇÃO NÃO ENCONTRADA</div>'
        );
    }
    $pdo = null;
// array com referente a 3 pessoas
// convertemos em json e colocamos na tela
    echo json_encode($var);
}

function UtilizacaoImovel($utilizacao, $pdo) {
    $sql1 = "Select * from Utilizacao WHERE Codigo = '$utilizacao'";
    $query1 = $pdo->prepare($sql1);
    //executo o comando sql
    $query1->execute();
    if (($dados1 = $query1->fetch()) == true) {
        return $dados1['Descricao'];
    } else {
        return "";
    }
}

function logradouro($rua, $pdo) {

    $sql1 = "Select * from Rua WHERE Cod_Rua = '$rua'";
    $query1 = $pdo->prepare($sql1);
    //executo o comando sql
    $query1->execute();
    if (($dados1 = $query1->fetch()) == true) {
        return $dados1['Tipo'] . $dados1['Desc_rua'];
    } else {
        return "";
    }
}

function bairro($bairro, $pdo) {

    $sql1 = "Select * from Bairro WHERE Cod_Bairro = '$bairro'";
    $query1 = $pdo->prepare($sql1);
    //executo o comando sql
    $query1->execute();
    if (($dados1 = $query1->fetch()) == true) {
        return $dados1['Desc_Bairro'];
    } else {
        return "";
    }
}

function valor_venal($inscricao, $pdo) {
    $ano = date('Y');

    $sql1 = "SELECT Valor FROM valor_venal WHERE ano = '$ano' AND inscricao_imob = '$inscricao'";
    $query1 = $pdo->prepare($sql1);
    //executo o comando sql
    $query1->execute();
    if (($dados1 = $query1->fetch()) == true) {
        return $dados1['Valor'];
    } else {
        return "";
    }
}

function moeda() {
//  MOEDA ESTÁ NA SESSÃO DO USUÁRIO
//  É CARREGADA ASSIM QUE O USUARIO REALIZA LOGIN
    return $_SESSION['C_VALOR_MOEDA_DIA_UFIR'];
}

function valorDeclarado() {

//    INCLUSAO DAS BIBLIOTECAS

    include_once '../funcaoPHP/funcaoDinheiro.php';

    //    aplica filtro na string enviada (LetraMaiuscula)
    $valor_Venal = inserirDinheiro(letraMaiuscula($_POST['valor_venal']));
    $valor_Declarado = inserirDinheiro(letraMaiuscula($_POST['valor_declarado']));
    $fracao_ideal = letraMaiuscula($_POST['fracao_ideal']);
    $tem_multa = letraMaiuscula($_POST['porcentagem']);
    $valor_itbi = 0;


//    COMPARAÇÃO PARA SABER SE O VALOR VENAL DO TERRENO É MAIOR QUE O VALOR 
//    DECLARADO NO ITBI
    if ($valor_Venal > $valor_Declarado) {
        $valor_Base = $valor_Venal;
    } else {
        $valor_Base = $valor_Declarado;
    }
//    VALOR ITBI É O MAIOR VALOR DA COMPARAÇÃO
//    MULTIPLICADO PELA FRACA IDEAL
//    MULTIPLICADO POR 20 PORCENTO

    $valor_itbi = $valor_Base * $fracao_ideal * 0.02;


// VERIFICO SE O ITBI VAI CONTER MULTA
    if ($tem_multa == "N") {
        $porcentagem = 0;
    } else if ($tem_multa == '1') {
        $porcentagem = 0.5;
    } else if ($tem_multa == '2') {
        $porcentagem = 1;
    }

//APLICAÇÃO DE MASCARA DO VALOR EM REAIS
    $valor_itbi = mostrarDinheiro($valor_itbi);
    $valor_Base = mostrarDinheiro($valor_Base);
    $valor_Multa = mostrarDinheiro(inserirDinheiro($valor_itbi) * $porcentagem);
    $valor_total = mostrarDinheiro(inserirDinheiro($valor_itbi) + inserirDinheiro($valor_Multa));

//    DECLARAÇÃO ARRAY COM DADOS DE RETORNO
    $var = Array(
        "VALOR_BASE" => "$valor_Base",
        "VALOR_ITBI" => "$valor_itbi",
        "VALOR_MULTA" => "$valor_Multa",
        "VALOR_TOTAL" => "$valor_total"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}

function calculaMulta($Tem_Multa, $valor_itbi) {
    if ($Tem_Multa == "N" || $Tem_Multa == null) {
        $porcentagem = 0;
    } else if ($Tem_Multa == '1') {
        $porcentagem = 0.5;
    } else if ($Tem_Multa == '2') {
        $porcentagem = 1;
    }

    $valor_multa = mostrarDinheiro(inserirDinheiro($valor_itbi) * $porcentagem);
    return $valor_multa;
}

function calcularValorBaseItbi($valor_base) {

    return mostrarDinheiro(inserirDinheiro($valor_base) * 1 * 0.02);
}

?>