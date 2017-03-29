<?php

include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';

if ($_REQUEST['op'] == '1') {
    retornaDadosItbi();
    die();
}
if ($_REQUEST['op'] == '2') {
    retornaDescricaoBanco();
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
        $Transmitente = $dados['Transmitente'];
        $Data_Transacao = dataBrasileiro($dados['Vencimento']);
        $Valor_Itbi = mostrarDinheiro($dados['Valor_Itbi']);
        $Situacao_divida = $dados['cod_situacao_divida'];
    } else {

        $achou = "0";
        $Adquirente = "";
        $Transmitente = "";
        $Data_Transacao = "";
        $Valor_Itbi = "";
        $Situacao_divida = "";
    }
    $pdo = null;
// array com referente a 3 pessoas

    $var = Array(
        "achou" => "$achou",
        "campo1" => "$Adquirente",
        "campo2" => "$Transmitente",
        "campo3" => "$Data_Transacao",
        "campo4" => "$Valor_Itbi",
        "campo5" => "$Situacao_divida"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
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

function retornaDescricaoBanco() {
    $cod_banco = $_REQUEST['cod'];



// chamo a conexao com o banco de dados
    include_once '../estrutura/conexao/conexao.php';
// preparo para realizar o comando sql
    $sql = "SELECT * FROM Banco WHERE Cod_banco = '$cod_banco'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $achou = 1;
        $descricao = $dados['Desc_Banco'];
    } else {
        $achou = "";
        $descricao = "";
    }


    $var = Array(
        "achou" => "$achou",
        "descricao" => "$descricao"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}

?>