<?php

function fun_retorna_situacao_divida($pdo, $situacao_divida) {
    $sql1 = "SELECT * FROM situacao_divida WHERE Cod_Situacao_Divida = '$situacao_divida'";
    $query1 = $pdo->prepare($sql1);
    //executo o comando sql
    $query1->execute();
    if (($dados1 = $query1->fetch()) == true) {
        return $dados1['Desc_Situacao_Divida'];
    } else {
        return "ABERTO";
    }
}
