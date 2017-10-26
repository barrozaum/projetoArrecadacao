<?php
//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//    inclusao da biblioteca para dinheiro
    include_once '../funcaoPHP/funcaoDinheiro.php';

//ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();

// biblioteca para validar string informada    
    include ('../funcaoPHP/function_letraMaiscula.php');
//    aplica filtro na string enviada (LetraMaiuscula)
    $codigo_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_codigo']);
    $descricao_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_descricao']);
    $valor_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_valor']);


// variaves serão preenchidas por valores do formulario
// valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($codigo_Letra_Maiscula) > 0 && strlen($codigo_Letra_Maiscula) < 11) || is_int($codigo_Letra_Maiscula) === TRUE) {
        $codigo = $codigo_Letra_Maiscula;
    } else {
        $array_erros['txt_alterar_descricao'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO \n';
    }

// filtro pra validar Nome do Bairro (não ter nenhum sql_injection)
    if (strlen($descricao_Letra_Maiscula) > 2) {
        $descricao = $descricao_Letra_Maiscula;
    } else {
        $array_erros['txt_alterar_descricao'] = 'POR FAVOR ENTRE COM A DESCRIÇÃO VÁLIDA \n';
    }


//    filtro pra saber se o valor está correto
    if (is_numeric(inserirDinheiro($valor_Letra_Maiscula)) && strlen($valor_Letra_Maiscula) >= 3) {
        $valor = inserirDinheiro($valor_Letra_Maiscula);
    } else {
        $array_erros['txt_valor'] = 'POR FAVOR ENTRE COM UM VALOR (UFIR) VÁLIDO \n';
    }

// verifico se tem erro na validação
    // verifico se tem erro na validação
    if (empty($array_erros)) {
        try {
            include_once '../estrutura/conexao/conexao.php';
            $pdo->beginTransaction();

            //  preparo comando sql para receber valores
            $stmt = $pdo->prepare("UPDATE Tipo_Coleta SET Desc_Tipo_Coleta =:descricao, Valor =:valor WHERE Cod_Tipo_Coleta =:codigo");

            //  passando valores para o sql
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':valor', $valor);

            //  executa comando sql
            $stmt->execute();

            //  persiste comando sql
            $pdo->commit();
            $_SESSION['MENSAGEM_RETORNO_OPERACAO'] = "<div class='alert alert-info'>ALTERADO COM SUCESSO !!!</div>";
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
    header("Location: ../../../TabelaColeta.php");
// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>
    