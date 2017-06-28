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

function retornaDadosImovel($pdo) {

//    INCLUSAO DAS BIBLIOTECAS
    include_once '../funcaoPHP/funcaoData.php';
    include_once '../funcaoPHP/funcaoDinheiro.php';

    //    aplica filtro na string enviada (LetraMaiuscula)
    $inscricao = letraMaiuscula($_POST['num_imovel']);



// preparo para realizar o comando sql
    $sql = "SELECT Proprietario, Area_Terreno, Area_Construida,Utilizacao_imovel,Numero,Complemento,Quadra,Lote,Cod_Rua,Cod_Bairro, Dt_Averbacao "
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
        $possui_dividas = fun_verifica_divida($pdo, $inscricao);
        $data_averbacao = dataBrasileiro($dados['Dt_Averbacao']);
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
            "COD_BAIRRO" => "$Cod_Bairro",
            "POSSUI_DIVIDAS" => "$possui_dividas",
            "DATA_AVERBACAO" => "$data_averbacao"
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

function fun_verifica_divida($pdo, $inscricao){
//    data atual
    $ano_atual = date('Y');
//    função verifica se a inscricao tem débitos
    $sql = "SELECT * FROM financeiro_imob";
    $sql = $sql ." WHERE inscricao_imob = '{$inscricao}' ";
    $sql = $sql ." AND cod_situacao_divida IN ('01','02','03') ";
    $sql = $sql ." AND ano_divida < '{$ano_atual}'";
    $query = $pdo->prepare($sql);
    //executo o comando sql
    $query->execute();
    if (($dados = $query->fetch()) == true) {
        return "1"; // se tiver débitos retorna 1
    } else {
        return "0"; // senão tiver débitos retorna 0
    }
    
}

?>