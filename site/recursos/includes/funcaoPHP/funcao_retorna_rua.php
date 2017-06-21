<?php

function FUNC_RETORNA_JSON_DESCRICAO_RUA_E_CEP($pdo, $cod_rua) {
    
// convertemos em json e colocamos na tela
    echo json_encode(FUNC_RETORNA_DESCRICAO_RUA_E_CEP($pdo, $cod_rua));
}

function FUNC_RETORNA_DESCRICAO_RUA_E_CEP($pdo, $cod_rua) {
    

// preparo para realizar o comando sql
    $sql = "SELECT * FROM Rua WHERE Cod_Rua = '$cod_rua'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $achou = 1;
        $descricao = $dados['Desc_rua'];
        $cep = $dados['cep'];
    } else {
        $achou = "";
        $descricao = "";
        $cep = "" . $sql;
    }


    $var = Array(
        "achou" => "$achou",
        "descricao" => "$descricao",
        "cep" => "$cep"
    );
    
    return $var;
}