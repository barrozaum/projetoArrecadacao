<?php

//validando a seção
include_once '../estrutura/controle/validarSessao.php';

//incluindo validacão de campos
include_once '../funcaoPHP/function_letraMaiscula.php';


//    mensagem de erro


$msg = "";


if (!fun_aplica_validacao_campo($_POST['senha_atual'], 3, 50)) {
    $msg .= "SENHA ATUAL NÃO ATENDE EXIGENCIAS !!! <BR /> ";
} else {
    $senha_antiga_colaborador = letraMaiuscula($_POST['senha_atual']);
}

if (!fun_aplica_validacao_campo($_POST['nova_senha'], 3, 50)) {
    $msg .= "NOVA SENHA NÃO ATENDE EXIGENCIAS !!! <BR /> ";
} else {
    $nova_senha_colaborador_logado = letraMaiuscula($_POST['nova_senha']);
}

if (!fun_aplica_validacao_campo($_POST['conf_nova_senha'], 3, 50)) {
    $msg .= "CONFIRMAÇÃO NOVA SENHA NÃO ATENDE EXIGENCIAS !!! <BR /> ";
} else {
    $conf_nova_senha_colaborador_logado = letraMaiuscula($_POST['conf_nova_senha']);
}

if ($nova_senha_colaborador_logado !== $conf_nova_senha_colaborador_logado) {
    $msg .= "SENHAS NÃO CONFEREM !!! <BR /> ";
}


if ($senha_antiga_colaborador !== $_SESSION["senha"]) {
    $msg .= "SENHA ATUAL INVÁLIDA !!! <BR />";
}


if ($msg !== "") {
    $msg = "<div class='alert alert-danger'>" . $msg . "</div>";
} else {
    try {
//        alterando a senha do usuario

        include_once '../estrutura/conexao/conexao.php';

        $pdo->beginTransaction();

//        $sql = "exec sp_password @old = '{$senha_antiga_colaborador}', @new = '{$nova_senha_colaborador_logado}', @loginame = '{$_SESSION['usuario']}' ";
        $sql = "ALTER LOGIN {$_SESSION['usuario']} WITH PASSWORD = '{$nova_senha_colaborador_logado}'";
        $query = $pdo->prepare($sql);
        $query->execute();

        $pdo->commit();

//altera a senha do usuario em secao
        $_SESSION['senha'] = $nova_senha_colaborador_logado;
        
        $msg = "<div class='alert alert-success'> ALTERADO COM SUCESSO </div>";
    } catch (Exception $exc) {
        $msg = "<div class='alert alert-danger>" . $exc->getMessage() . "</div>";
    }
}

//mensagem de saida
print $msg;


