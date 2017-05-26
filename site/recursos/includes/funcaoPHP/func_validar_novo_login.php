<?php

if (!isset($_SESSION)) {
    session_start();
}

if ($_POST['cmd'] == '1') {
    include_once '../estrutura/conexao/conexao.php';
    include_once '../funcaoPHP/function_letraMaiscula.php';
    fun_validar_existencia_login($pdo, $_POST['login']);
    exit();
}

//função para saber se o assunto encontra-se em alum processo
// se for encotrado,  vai retornar verdadeiro
//senão for encontrado vai retornar falso
function fun_validar_existencia_login($pdo, $login_novo_usuario) {
    try {
        $sql_novo_login = "SELECT * FROM usuario WHERE usuario = '{$login_novo_usuario}'";

        $query_novo_login = $pdo->prepare($sql_novo_login);
        $query_novo_login->execute();
        if($query_novo_login->fetchColumn()){
            print 1;
        }else{
            print 0;
        }
    } catch (Exception $e) {
        print $e->getMessage();
    }
   
}
