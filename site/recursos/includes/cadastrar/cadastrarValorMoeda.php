<?php

//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include_once '../funcaoPHP/funcaoDiaBisesto.php';
    include_once '../funcaoPHP/funcaoDinheiro.php';
    include_once '../funcaoPHP/funcaoData.php';

// biblioteca para validar string informada    
    include ('../funcaoPHP/function_letraMaiscula.php');

//ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();

//    campos enviados pelos formulario
//    aplica filtro na string enviada (LetraMaiuscula)

    $codigo_Letra_Maiscula = letraMaiuscula($_POST['txt_codigo']);
    $mes_Letra_Maiscula = letraMaiuscula($_POST['txt_mes']);
    $ano_Letra_Maiscula = letraMaiuscula($_POST['txt_ano']);
    $valor_Letra_Maiscula = letraMaiuscula($_POST['txt_valor']);


// variaves serão preenchidas por valores do formulario
// valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($codigo_Letra_Maiscula) > 0 && strlen($codigo_Letra_Maiscula) < 11) || is_int($codigo_Letra_Maiscula) === TRUE) {
        $cod_moeda = $codigo_Letra_Maiscula;
    } else {
        $array_erros['txt_codigo'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO !!! <br />';
    }
//    mes
    if ((strlen($mes_Letra_Maiscula) > 0 && strlen($mes_Letra_Maiscula) < 3) || is_int($mes_Letra_Maiscula) === TRUE) {
        $mes = $mes_Letra_Maiscula;
    } else {
        $array_erros['txt_mes'] = 'POR FAVOR ENTRE COM UM MÊS VÁLIDO !!! <br />';
    }

//    ano
    if ((strlen($ano_Letra_Maiscula) > 0 && strlen($ano_Letra_Maiscula) < 5) || is_int($ano_Letra_Maiscula) === TRUE) {
        $ano = $ano_Letra_Maiscula;
    } else {
        $array_erros['txt_ano'] = 'POR FAVOR ENTRE COM UM ANO VÁLIDO !!! <br />';
    }


//    filtro pra saber se o valor está correto
    if (is_numeric(inserirDinheiro($valor_Letra_Maiscula)) && strlen($valor_Letra_Maiscula) >= 3) {
        $valor_moeda = inserirDinheiro($valor_Letra_Maiscula);
    } else {
        $array_erros['txt_valor'] = 'POR FAVOR ENTRE COM UM VALOR (UFIR) VÁLIDO !!!';
    }

//    VERIFICO SE NÃO CONTEM ERRO DE VALIDAÇÃO
    if (empty($array_erros)) {
        try {
//            bibliotecas com as funçoes
            include_once '../funcaoPHP/funcaoDiaBisesto.php';
            include_once '../funcaoPHP/funcaoDinheiro.php';
            include_once '../funcaoPHP/funcaoData.php';
            include_once '../estrutura/conexao/conexao.php';
            $pdo->beginTransaction();

            //  preparo comando sql para receber valores
            $stmt = $pdo->prepare("INSERT INTO moeda (cod_tipo_moeda, data_moeda, valor_moeda) VALUES (:codigo, :dia_mes, :valor)");


            for ($i = 1; $i <= diaBisesto($ano, $mes); $i++) {

                // inserindo 0 caso o dia seja menor que 10 para ficar com duas casas 
                if ($i > 9) {
                    $dia = dataAmericano($i . "/" . $mes . "/" . $ano);
                } else {
                    $dia = dataAmericano("0" . $i . "/" . $mes . "/" . $ano);
                }

                //  passando valores para o sql
                $stmt->bindParam(':codigo', $cod_moeda);
                $stmt->bindParam(':dia_mes', $dia);
                $stmt->bindParam(':valor', $valor_moeda);

                //  executa comando sql
                $stmt->execute();
            }

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
    header("Location: ../../../TabelaValorMoeda.php");


// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>