<?php

include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
include_once '../funcaoPHP/funcao_retorna_observacao_itbi.php';
include_once '../funcaoPHP/funcao_retorna_descricao_cod_mot_cancelamento.php';


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
        $Transmitente = $dados['Transmitente'];
        $Data_Transacao = dataBrasileiro($dados['Data_Transacao']);
        $Valor_Itbi = mostrarDinheiro($dados['Valor_Itbi']);
        $Situacao_divida = $dados['cod_situacao_divida'];
        $observacao = buscarObservacao($pdo, 4, $numero, $ano, '00', '00');
        $motivo_cancelamento = retorna_descricao_cod_mot_cancelamento($pdo, $dados['Cod_Motivo_Cancelamento']);
    } else {

        $achou = "0";
        $Adquirente = "";
        $Transmitente = "";
        $Data_Transacao = "";
        $Valor_Itbi = "";
        $Situacao_divida = "";
        $observacao = "";
        $motivo_cancelamento = "";
    }
    $pdo = null;
// array com referente a 3 pessoas

    $var = Array(
        "achou" => "$achou",
        "campo1" => "$Adquirente",
        "campo2" => "$Transmitente",
        "campo3" => "$Data_Transacao",
        "campo4" => "$Valor_Itbi",
        "campo5" => "$Situacao_divida",
        "campo6" => "$observacao",
        "campo7" => "$motivo_cancelamento"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}

?>