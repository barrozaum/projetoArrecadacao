<?php
include_once '../estrutura/controle/validarSessao.php';

$zona = $_REQUEST['Zona'];
$cod_sit = $_REQUEST['Cod_Sit'];


// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
// preparo para realizar o comando sql
$sql = "SELECT * FROM Valor_M2_Terreno
WHERE Zona_Fiscal = '$zona'
AND Cod_Utilizacao = '$cod_sit'";
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