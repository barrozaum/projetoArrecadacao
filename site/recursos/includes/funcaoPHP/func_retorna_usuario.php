<?php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['id'])) {
    if ($_POST['id'] == 1) {
        $codigo_usuario = $_POST['txt_cod_usu'];
        func_retorna_dados_permissao($codigo_usuario);
    }
}


function func_retorna_dados_permissao($codigo_usuario) {
//    incluindo conexao
    include_once '../estrutura/conexao/conexao.php';

//    consultando permissões do usuario
    $sql_p = "SELECT * FROM permissao WHERE usuario = '{$codigo_usuario}'";
    $query_p = $pdo->prepare($sql_p);
    $query_p->execute();

//    array de permissoes
    for ($i = 0; $dados_p = $query_p->fetch(); $i++) {
        $array[$i] = $dados_p['Nome_prog'];
    }

    if (isset($array)) {


        $array = array(
            "achou" => "s",
            "permissao" => $array
        );
    } else {
        $array = array(
            "achou" => 'n',
            "permissao" => array()
        );
    }
    print json_encode($array);
    $pdo = null;
}
