<?php

include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcaoDiaBisesto.php';
include_once '../funcaoPHP/funcaoData.php';

$cod_moeda = $_REQUEST['cod'];
$mes = $_REQUEST['mes'];
$ano = $_REQUEST['ano'];

$data_inicial = dataAmericano("01/".$mes."/".$ano);


$data_final = dataAmericano(diaBisesto($ano,$mes)."/".$mes."/".$ano);


// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
// preparo para realizar o comando sql

$sql = "SELECT * FROM moeda 
        WHERE cod_tipo_moeda = '$cod_moeda'
        AND data_moeda >= '$data_inicial'
        AND data_moeda <= '$data_final'";
$res = $pdo->query($sql);
/* Check the number of rows that match the SELECT statement */
if ($res->fetchColumn() > 0) {
    $achou = 1;
} else {
    $achou = 0;
}


$res = null;
$pdo = null;
// array com referente a 3 pessoas

echo $achou;
?> 