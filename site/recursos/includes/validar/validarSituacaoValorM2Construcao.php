<?php

include_once '../estrutura/controle/validarSessao.php';

$zona = $_REQUEST['Zona'];
$cod_uti = $_REQUEST['Cod_Uti'];
$cod_cat = $_REQUEST['Cod_Cat'];


// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
// preparo para realizar o comando sql
$sql = "SELECT * 
FROM Valor_M2_Construcao 
WHERE Zona_Fiscal= '$zona'
AND Cod_Utilizacao = '$cod_uti'
AND Cod_Categoria = '$cod_cat'
";
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