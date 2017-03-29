<?php
include_once '../estrutura/controle/validarSessao.php';
$cod = "";
$cod = $_REQUEST['cod'];

// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
// preparo para realizar o comando sql
//$sql = "select * FROM Cad_Imobiliario WHERE Inscricao_Imob = $cod";
$sql = "Select * FROM Situacao_Terreno WHERE Cod_situacao = '" . $cod . "'";
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