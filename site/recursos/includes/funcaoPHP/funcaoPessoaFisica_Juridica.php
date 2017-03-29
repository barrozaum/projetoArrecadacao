<?php
// mostra a descricao completa do tipo pessoa
function FUN_MOSTRAR_DESCRICAO_TIPO_PESSOA($tipo) {
    if ($tipo === 'F') {
        return "FISICA";
    } else {
        return "JURIDICA";
    }
}

// insere no banco de dados o tipo da pessoa
function FUN_INSERIR_TIPO_PESSOA($descricao) {
//    die($descricao);
    if($descricao === "FISICA"){
        return "F";
    }else{
        return "J";
    }
}
?>