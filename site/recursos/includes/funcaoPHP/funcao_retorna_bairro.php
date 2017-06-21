<?php

function FUNC_RETORNA_JSON_DESCRICAO_BAIRRO($pdo, $cod_bairro) {
    
// convertemos em json e colocamos na tela
    echo json_encode(FUNC_RETORNA_DESCRICAO_BAIRRO($pdo, $cod_bairro));
}


function FUNC_RETORNA_DESCRICAO_BAIRRO($pdo, $cod_bairro){
// preparo para realizar o comando sql
    $sql = "SELECT * FROM Bairro WHERE Cod_Bairro = '$cod_bairro'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $achou = 1;
        $descricao = $dados['Desc_Bairro'];
    } else {
        $achou = "";
        $descricao = "" . $sql;
    }


    $var = Array(
        "achou" => "$achou",
        "descricao" => "$descricao"
    );
 
    return $var;
}