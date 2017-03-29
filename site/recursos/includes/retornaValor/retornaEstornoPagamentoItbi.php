<?php

include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';

if ($_REQUEST['op'] == '1') {
    retornaDadosItbi();
    die();
}
?>
<?php

function retornaDadosItbi() {
    $numero = $_REQUEST['numero'];
    $ano = $_REQUEST['ano'];


// chamo a conexao com o banco de dados
    include_once '../estrutura/conexao/conexao.php';
// preparo para realizar o comando sql
    $sql = "SELECT * FROM itbi WHERE Num_Itbi = '$numero' and Ano_Itbi = '$ano'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {

        $achou = "1";
        $Adquirente = $dados['Adquirente'];
        $vencimento = dataBrasileiro($dados['Vencimento']);
        $Valor_Itbi = mostrarDinheiro(calcularValorItbi($dados['Tem_Multa'], $dados['Valor_Itbi']));
        $data_pagamento = dataBrasileiro($dados['data_pagamento']);
        $valor_pagamento = mostrarDinheiro($dados['valor_pagamento']);
        $num_processo = $dados['NUM_PROCESSO_BAIXA'];
        $ano_processo = $dados['ANO_PROCESSO_BAIXA'];
        $lote_banco = $dados['Lote'];
        $cod_banco = $dados['cod_banco'];
        $desc_banco = buscaNomeBanco($pdo, $cod_banco);
        $obs_itbi_pago = buscarObservacao($pdo, $numero, $ano);
        $cod_situacao_itbi= $dados['cod_situacao_divida'];;
    } else {

        $achou = "0";
        $Adquirente = "";
        $vencimento = "";
        $Valor_Itbi = "";
        $data_pagamento = "";
        $valor_pagamento = "";
        $num_processo = "";
        $ano_processo = "";
        $lote_banco = "";
        $cod_banco = "";
        $desc_banco = "";
        $obs_itbi_pago = "";
        $cod_situacao_itbi = "";
        
    }
    $pdo = null;
// array com referente a 3 pessoas

    $var = Array(
        "achou" => "$achou",
        "campo1" => "$Adquirente",
        "campo2" => "$vencimento",
        "campo3" => "$Valor_Itbi",
        "campo4" => "$data_pagamento",
        "campo5" => "$valor_pagamento",
        "campo6" => "$num_processo",
        "campo7" => "$ano_processo",
        "campo8" => "$lote_banco",
        "campo9" => "$cod_banco",
        "campo10" => "$desc_banco",
        "campo11" => "$obs_itbi_pago",
        "campo12" => "$cod_situacao_itbi"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}

//busca as observações
function buscaObsItbi($pdo, $cod_banco) {


// preparo para realizar o comando sql
    $sql = "SELECT * FROM Banco WHERE Cod_banco = '$cod_banco'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {

        return $dados['Desc_Banco'];
    } else {

        return "BANCO NÃO ENCONTRADO ";
    }
}

function buscarObservacao($pdo, $num_itbi, $ano_itbi) {
    $sql = "SELECT  * "
            . "FROM observacao_financ "
            . "WHERE cod_cadastro = 4 "
            . "AND Inscricao = '$num_itbi' "
            . "AND ano_divida = '$ano_itbi'";

    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['Observacao'];
    } else {
        return "";
    }
}

// busca o nome do Banco que houve pagamento
function buscaNomeBanco($pdo, $cod_banco) {


// preparo para realizar o comando sql
    $sql = "SELECT * FROM Banco WHERE Cod_banco = '$cod_banco'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {

        return $dados['Desc_Banco'];
    } else {

        return "BANCO NÃO ENCONTRADO ";
    }
}

function calcularValorItbi($Tem_Multa, $valor_itbi) {
    if ($Tem_Multa == "N")
        $porcentagem = 0;
    else if ($Tem_Multa == '1')
        $porcentagem = 0.5;
    else if ($Tem_Multa == '2')
        $porcentagem = 1;


    return $valor_itbi + ($valor_itbi * $porcentagem);
}

?>