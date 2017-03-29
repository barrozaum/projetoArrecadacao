<?php

include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';

if ($_REQUEST['op'] == '1') {
    retornaCadImob($pdo);
    die();
}else if ($_REQUEST['op'] == '2') {
    retornaDivida($pdo);
    die();
}
?>

<?php
// buscaCadastroImovel
function retornaCadImob($pdo) {
    $insc_imovel = $_REQUEST['cod'];

// preparo para realizar o comando sql
    $sql = "SELECT * FROM cad_imobiliario WHERE Inscricao_imob= '$insc_imovel'";
    $query = $pdo->prepare($sql);

//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $Proprietario = $dados['Proprietario'];
    }else{
        $Proprietario = "";
    }
    
    $var = Array(
        "Proprietario" => "$Proprietario"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}
?>

<?php
// buscaCadastroImovel
function retornaDivida($pdo) {
    $cod_divida = $_REQUEST['cod'];

// preparo para realizar o comando sql
    $sql = "SELECT * FROM Divida_Imob WHERE Cod_Divida_Imob= '$cod_divida'";
    $query = $pdo->prepare($sql);

//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $desc_divida = $dados['Desc_Divida'];
    }else{
        $desc_divida = "";
    }
    
    $var = Array(
        "Descricao_divida" => "$desc_divida"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}
?>





