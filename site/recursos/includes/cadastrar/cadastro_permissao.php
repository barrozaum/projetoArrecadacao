<?php

//validando secao
include_once '../estrutura/controle/validarSessao.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//validacao
    include_once '../funcaoPHP/function_letraMaiscula.php';

//mensagem de erro
    $array_erros = array();

//    aplicando validação nos dados
    if (fun_aplica_validacao_campo($_POST['txt_colaborador'], 3, 50)) {
        $nome_colaborador_permissao = letraMaiuscula($_POST['txt_colaborador']);
    } else {
        $array_erros['txt_colaborador'] = "USUÁRIO DA PERMISSAO INVÁLIDO !!! \n";
    }

//    verifico se existe alguma permissao marcada
    if (isset($_POST['permissao'])) {
        $permissoes = $_POST['permissao'];
//        conto o todal de permissoes concedidas
        $total_permissao = count($permissoes);
        foreach ($permissoes as $key => $value) {
            if (!fun_aplica_validacao_campo($value, 1, 50)) {
                $array_erros['txt_permissors'] = "PERMISSAO INVÁLIDO !!! \n";
            }
        }
    }


    if (empty($array_erros)) {
        try {
//            incluo conexao
            include_once '../estrutura/conexao/conexao.php';

            $pdo->beginTransaction();

//            LIMPO AS PERMISSOES DO USUÁRIO
            $sql_del = "DELETE FROM permissao  WHERE usuario = '{$nome_colaborador_permissao}'";
            $query_del = $pdo->prepare($sql_del);
            $query_del->execute();

//            se existir permissoes eu insiro 
            if (isset($total_permissao)) {
//            CADASTRO NOVAS PERMISSOES
                foreach ($permissoes as $key => $value) {
                    $valor = letraMaiuscula($value);
                    $sql_insert = "INSERT INTO permissao (usuario, Nome_prog) VALUES ('{$nome_colaborador_permissao}', '{$valor}')";
                    $query_insert = $pdo->prepare($sql_insert);
                    $query_insert->execute();
                }
            }


            $pdo->commit();

//            mensagem de sucesso
            $msg = "CADASTRADO COM SUCESSO ";
        } catch (Exception $exc) {
            $msg = $exc->getMessage();
        }

//      fecho conexao
        $pdo = null;

//        Emito mensagem
        echo '<script>window.alert("' . $msg . '");
               location.href = "../../../Man_Perimissao.php";
        </script>';



//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../Man_Perimissao.php";
        </script>';
    }

// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>