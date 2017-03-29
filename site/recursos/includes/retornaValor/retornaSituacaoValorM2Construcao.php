<?php

include_once '../estrutura/controle/validarSessao.php';


if ($_REQUEST['escolha'] == 1) {
    retornaUtilizaco();
} else {
    retornaCategoria();
}

function retornaUtilizaco() {

    $cod = $_REQUEST['cod'];

// chamo a conexao com o banco de dados
    include_once '../estrutura/conexao/conexao.php';
// preparo para realizar o comando sql
    $sql = "select * from Utilizacao where Codigo = '" . $cod . "'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $descricao = $dados['Descricao'];
    } else {
        $descricao = "Código inválido";
    }

    $pdo = null;
// array com referente a 3 pessoas

    $var = Array(
        array(
            "descricao" => "$descricao"
        )
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}

function retornaCategoria() {

    $cod = $_REQUEST['cod'];

// chamo a conexao com o banco de dados
    include_once '../estrutura/conexao/conexao.php';
// preparo para realizar o comando sql
    $sql = "select * from Categoria where Codigo = '" . $cod . "'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $descricao = $dados['Descricao'];
    } else {
        $descricao = "Código inválido";
    }

    $pdo = null;
// array com referente a 3 pessoas

    $var = Array(
        array(
            "descricao" => "$descricao"
        )
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}

?>