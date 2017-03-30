<?php

function fun_retorna_descricao_cod_banco($pdo, $cod_banco) {
    $sql1 = "SELECT * FROM Banco WHERE Cod_banco = '$cod_banco'";
    $query1 = $pdo->prepare($sql1);
    //executo o comando sql
    $query1->execute();
    if (($dados1 = $query1->fetch()) == true) {
        return $dados1['Desc_Banco'];
    } else {
        return "NÃO ENCONTRADO";
    }
}
