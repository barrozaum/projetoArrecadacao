<?php

include_once '../estrutura/controle/validarSessao.php';
include_once '../estrutura/conexao/conexao.php';


if ($_REQUEST['op'] == '1') {
    retornaProprietariImovel($pdo);
    die();
}


if ($_REQUEST['op'] == '2') {
    retornaCodigoMoeda($pdo);
    die();
}

if ($_REQUEST['op'] == '3') {
    retornaCodigoDivida($pdo);
    die();
}

//função para retorna o proprietario do imóvel de acordo com a inscrição informada
function retornaProprietariImovel($pdo) {
//    numero da inscricao informada
    $inscricao = $_POST['num_insc'];


    $sql_busca = "SELECT Proprietario FROM Cad_Imobiliario WHERE Inscricao_Imob = '$inscricao'";
    $query = $pdo->prepare($sql_busca);
//    executo o comando sql
    $query->execute();

//    comparo pra saber se retornou valor
    if (($dados = $query->fetch()) == true) {
        $achou = 1;
        $pro = $dados['Proprietario'];
    } else {
        $achou = 0;
        $pro = "";
    }

//  crio arrai pra armazenar dados
    $var = Array(
        "achou" => "$achou",
        "campo1" => "$pro"
    );

// transformo array em arquivo json
// dou a saida do arquivo    
    print json_encode($var);
}

function retornaCodigoMoeda($pdo) {
//    codigo da divida informada
    $cod_moeda = $_POST['cod_moeda'];


    $sql_busca = "SELECT Desc_tipo_moeda FROM tipo_moeda WHERE cod_tipo_moeda = '$cod_moeda'";
    $query = $pdo->prepare($sql_busca);
//    executo o comando sql
    $query->execute();

//    comparo pra saber se retornou valor
    if (($dados = $query->fetch()) == true) {
        $achou = 1;
        $desc_moeda = $dados['Desc_tipo_moeda'];
    } else {
        $achou = 0;
        $desc_moeda = "";
    }


//  crio arrai pra armazenar dados
    $var = Array(
        "achou" => "$achou",
        "campo1" => "$desc_moeda"
    );

// transformo array em arquivo json
// dou a saida do arquivo    
    print json_encode($var);
}

function retornaCodigoDivida($pdo) {
//    codigo da divida informada
    $cod_divida = $_POST['cod_divida'];


    $sql_busca = "SELECT Desc_Divida FROM Divida_Imob WHERE Cod_Divida_Imob = '$cod_divida'";
    $query = $pdo->prepare($sql_busca);
//    executo o comando sql
    $query->execute();

//    comparo pra saber se retornou valor
    if (($dados = $query->fetch()) == true) {
        $achou = 1;
        $desc_div = $dados['Desc_Divida'];
    } else {
        $achou = 0;
        $desc_div = "";
    }


//  crio arrai pra armazenar dados
    $var = Array(
        "achou" => "$achou",
        "campo1" => "$desc_div"
    );

// transformo array em arquivo json
// dou a saida do arquivo    
    print json_encode($var);
}
