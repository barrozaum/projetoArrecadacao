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
    include_once ('../funcaoPHP/function_letraMaiscula.php');
    include_once ('../funcaoPHP/funcaoData.php');

// aplica filtro na string enviada (LetraMaiuscula)
   $codigo_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_codigo']);
    $descricao_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_descricao']);
    $descricao_completa_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_descricao_completa']);
    $data_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_data']);
    $codigo_contabil_ano_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_codigo_ano']);
    $codigo_divida_ativa_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_divida_ativa']);
    $codigo_desconto_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_desconto']);
    $codigo_multas_juros_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_multas_juros']);


// variaves serão preenchidas por valores do formulario
// valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($codigo_Letra_Maiscula) > 0 && strlen($codigo_Letra_Maiscula) < 3)) {
        $codigo = $codigo_Letra_Maiscula;
    } else {
        $array_erros['txt_error_descricao'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO !!! <BR />';
    }

    if ((strlen($descricao_Letra_Maiscula) > 2) && (strlen($descricao_Letra_Maiscula) < 31)) {
        $descricao = $descricao_Letra_Maiscula;
    } else {
        $array_erros['txt_error_descricao'] = 'POR FAVOR ENTRE COM A DESCRIÇÃO VÁLIDA !!!';
    }

    if (validar_estrutura_data($data_Letra_Maiscula)) {
        $vencimento = dataAmericano($data_Letra_Maiscula);
    } else {
        $array_erros['txt_data'] = 'POR FAVOR ENTRE COM UMA DATA VÁLIDA !!! <br />';
    }

    if ((strlen($codigo_desconto_Letra_Maiscula) > 0 && strlen($codigo_desconto_Letra_Maiscula) < 11) || is_int($codigo_desconto_Letra_Maiscula) === TRUE) {
        $desconto = $codigo_desconto_Letra_Maiscula;
    } else {
        $array_erros['txt_desconto'] = 'POR FAVOR ENTRE COM PORCENTAGEM DESCONTO VÁLIDO !!! <br />';
    }

    if ((strlen($codigo_contabil_ano_Letra_Maiscula) > 0 && strlen($codigo_contabil_ano_Letra_Maiscula) < 4) || is_int($codigo_divida_ativa_Letra_Maiscula) === TRUE) {
        $codigo_contabil_ano = $codigo_contabil_ano_Letra_Maiscula;
    } else {
        $array_erros['txt_divida_ativa'] = 'POR FAVOR ENTRE COM COD CONTÁBIL ANO VÁLIDO !!! <br />';
    }

    if ((strlen($codigo_divida_ativa_Letra_Maiscula) > 0 && strlen($codigo_divida_ativa_Letra_Maiscula) < 4) || is_int($codigo_divida_ativa_Letra_Maiscula) === TRUE) {
        $codigo_div_ativ = $codigo_divida_ativa_Letra_Maiscula;
    } else {
        $array_erros['txt_divida_ativa'] = 'POR FAVOR ENTRE COM DÍV ATIVA VÁLIDA !!! <br />';
    }

    if ((strlen($codigo_multas_juros_Letra_Maiscula) > 0 && strlen($codigo_multas_juros_Letra_Maiscula) < 4) || is_int($codigo_divida_ativa_Letra_Maiscula) === TRUE) {
        $contabil_multas_juros = $codigo_multas_juros_Letra_Maiscula;
    } else {
        $array_erros['txt_divida_ativa'] = 'POR FAVOR ENTRE COM PORCENTAGEM MULTA VÁLIDA  !!! <br />';
    }

    if ((strlen($descricao_completa_Letra_Maiscula) > 2) && (strlen($descricao_completa_Letra_Maiscula) < 60)) {
        $descricaoCompleta = $descricao_completa_Letra_Maiscula;
    } else {
        $array_erros['txt_descricao_completa'] = 'POR FAVOR ENTRE COM O NOME COMPLETO DA DÍVIDA VÁLIDA !!! <br />';
    }

// verifico se tem erro na validação
    if (empty($array_erros)) {
        try {
            include_once '../estrutura/conexao/conexao.php';
            $pdo->beginTransaction();

            //  preparo comando sql para receber valores

            $sql = "UPDATE Divida_Imob ";
            $sql = $sql . " SET Desc_Divida =:descricaoDivida, ";
            $sql = $sql . " Venc_Cota_Unica =:vencimentoCotaUnica, ";
            $sql = $sql . " Desconto =:desconto, ";
            $sql = $sql . " Cod_Contabil =:codigoContabil, ";
            $sql = $sql . " Cod_Contabil_DA =:codigoContabilDA, ";
            $sql = $sql . " Cod_Contabil_Multa_Juros =:codContabilMultaJuros, ";
            $sql = $sql . " Desc_Completa =:descricaoDividaCompleta";
            $sql = $sql . " WHERE Cod_Divida_Imob = :codigoDividaImob";
            $stmt = $pdo->prepare($sql);
            //  passando valores para o sql
            $stmt->bindParam(':codigoDividaImob', $codigo);
            $stmt->bindParam(':descricaoDivida', $descricao);
            $stmt->bindParam(':vencimentoCotaUnica', $vencimento);
            $stmt->bindParam(':desconto', $desconto);
            $stmt->bindParam(':codigoContabil', $codigo_contabil_ano);
            $stmt->bindParam(':codigoContabilDA', $codigo_div_ativ);
            $stmt->bindParam(':codContabilMultaJuros', $contabil_multas_juros);
            $stmt->bindParam(':descricaoDividaCompleta', $descricaoCompleta);

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
    header("Location: ../../../TabelaDividaImob.php");



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>