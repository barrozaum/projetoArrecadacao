<?php

include_once '../estrutura/controle/validarSessao.php';

$cod = $_REQUEST['cod'];

// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
// preparo para realizar o comando sql
$sql = "select * FROM Divida_Imob WHERE Cod_Divida_Imob = $cod";
$query = $pdo->prepare($sql);
//executo o comando sql
$query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
if (($dados = $query->fetch()) == true) {
    $proprietario = $dados['Desc_Divida'];
} else
    $proprietario = "0";

$pdo = null;
// array com referente a 3 pessoas

$var = Array(
    array(
        "proprietario" => "$proprietario"
    )
);
// convertemos em json e colocamos na tela
echo json_encode($var);
?>