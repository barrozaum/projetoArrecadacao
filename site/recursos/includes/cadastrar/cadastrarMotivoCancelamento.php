<?php
//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();

// biblioteca para validar string informada    
    include ('../funcaoPHP/function_letraMaiscula.php');
//    aplica filtro na string enviada (LetraMaiuscula)
    $codigo_Letra_Maiscula = letraMaiuscula($_POST['txt_codigo']);
    $descricao_Letra_Maiscula = letraMaiuscula($_POST['txt_descricao']);


// variaves serão preenchidas por valores do formulario
// valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($codigo_Letra_Maiscula) > 0 && strlen($codigo_Letra_Maiscula) < 3) || is_int($codigo_Letra_Maiscula) === TRUE) {
        $codigo = $codigo_Letra_Maiscula;
    } else {
        $array_erros['txt_codigo'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO !!! <BR />';
    }

    if ((strlen($descricao_Letra_Maiscula) > 2) && (strlen($descricao_Letra_Maiscula) < 21)) {
        $descricao = $descricao_Letra_Maiscula;
    } else {
        $array_erros['txt_descricao'] = 'POR FAVOR ENTRE COM A DESCRIÇÃO VÁLIDA !!!';
    }


// verifico se tem erro na validação
    if (empty($array_erros)) {
        try {
            include_once '../estrutura/conexao/conexao.php';
            $pdo->beginTransaction();

            //  preparo comando sql para receber valores
            $stmt = $pdo->prepare("INSERT INTO Motivo_Cancelamento (Cod_Motivo_Cancelamento, Desc_Motivo_Cancelamento)
            VALUES (:codigo, :descricao)");

            //  passando valores para o sql
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':descricao', $descricao);

            //  executa comando sql
            $stmt->execute();

            //  persiste comando sql
            $pdo->commit();
            $_SESSION['MENSAGEM_RETORNO_OPERACAO'] = "<div class='alert alert-success'>CADASTRADO COM SUCESSO !!!</div>";
        } catch (Exception $exc) {
            $_SESSION['MENSAGEM_RETORNO_OPERACAO'] = "<div class='alert alert-danger'>" . $exc->getMessage() . "</div>";
        }
    } else {//  if (empty($array_erros)) {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }
        $_SESSION['MENSAGEM_RETORNO_OPERACAO'] = "<div class='alert alert-danger'>" . $msg_erro . "</div>";
    }
    header("Location: ../../../TabelaMotivoCancelamento.php");
} else {// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    die(header("Location: ../../../logout.php"));
}
?>