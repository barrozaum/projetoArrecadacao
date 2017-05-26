<?php

include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
include_once '../estrutura/conexao/conexao.php';
include_once '../funcaoPHP/funcao_retorna_descricao_cod_banco.php';

if ($_REQUEST['txt_op'] == '1') {
    retornaDadosDam($pdo);
    die();
}
if ($_REQUEST['txt_op'] == '2') {
    retornaDescricaoBanco($pdo);
    die();
}
?>
<?php

function retornaDadosDam($pdo) {
    $numero = $_POST['txt_numero_Docarj'];
    $ano = $_POST['txt_ano_Docarj'];
    $parcela = $_POST['txt_parcela_Docarj'];

// chamo a conexao com o banco de dados
// preparo para realizar o comando sql
    $sql = "SELECT * ";
    $sql = $sql . "FROM DAM d,  Financeiro_Dam fd ";
    $sql = $sql . "WHERE d.Num_Dam = '$numero' and d.Ano_Dam = '$ano' ";
    $sql = $sql . "AND fd.Num_Dam = d.Num_Dam ";
    $sql = $sql . "AND fd.Ano_Dam = d.Ano_Dam ";
    $sql = $sql . "AND fd.Parcela = '$parcela' ";

    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {

        $achou = "1";
        $contrinbuinte = $dados['Nome_Contribuinte'];
        $Data_Vencimento = dataBrasileiro($dados['Vencimento']);
        $Valor_Docarj = mostrarDinheiro($dados['Valor']);
        $Situacao_divida = $dados['Cod_Situacao_divida'];
    } else {

        $achou = "0";
        $contrinbuinte = "";
        $Data_Vencimento = "";
        $Valor_Docarj = "";
        $Situacao_divida = "";
    }
    $pdo = null;
// array com referente a 3 pessoas

    $var = Array(
        "achou" => "$achou",
        "campo1" => "$contrinbuinte",
        "campo3" => "$Data_Vencimento",
        "campo4" => "$Valor_Docarj",
        "campo5" => "$Situacao_divida"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}

function retornaDescricaoBanco($pdo) {
    $cod_banco = $_POST['txt_cod_banco'];

    $retorno = fun_retorna_descricao_cod_banco($pdo, $cod_banco);
    if ($retorno == "") {
        $achou = 0;
        $descricao = "";
    } else {
        $achou = 1;
        $descricao = $retorno;
    }

    $var = Array(
        "achou" => "$achou",
        "descricao" => "$descricao"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}

?>