<?php
//die(print_r($_POST));
//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();

// biblioteca para validar string informada    
    include_once '../funcaoPHP/funcaoDiaBisesto.php';
    include_once '../funcaoPHP/funcaoDinheiro.php';
    include_once '../funcaoPHP/funcaoData.php';
    include ('../funcaoPHP/function_letraMaiscula.php');

// aplica filtro na string enviada (LetraMaiuscula)
    $codigo_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_codigo']);
    $data_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_data']);
    $valor_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_valor']);

// variaves serão preenchidas por valores do formulario
// valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($codigo_Letra_Maiscula) > 0 && strlen($codigo_Letra_Maiscula) < 11) || is_int($codigo_Letra_Maiscula) === TRUE) {
        $cod_moeda = $codigo_Letra_Maiscula;
    } else {
        $array_erros['txt_codigo'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO !!! <br />';
    }

//  valida se o tipo da data está correta
    if (validar_estrutura_data($data_Letra_Maiscula)) {
        $dia = dataAmericano($data_Letra_Maiscula);
    } else {
        $array_erros['txt_alterar_data'] = 'POR FAVOR ENTRE COM UMA DATA VÁLIDA !!! <br />';
    }

//    filtro pra saber se o valor está correto
    if (is_numeric(inserirDinheiro($valor_Letra_Maiscula)) && strlen($valor_Letra_Maiscula) >= 3) {
        $valor_moeda =  inserirDinheiro($valor_Letra_Maiscula);
    } else {
        $array_erros['txt_valor'] = 'POR FAVOR ENTRE COM UM VALOR (UFIR) VÁLIDO !!!';
    }

// verifico se tem erro na validação
    if (empty($array_erros)) {
        try {
            include_once '../estrutura/conexao/conexao.php';
            $pdo->beginTransaction();

            //  preparo comando sql para receber valores

            $stmt = $pdo->prepare("UPDATE moeda SET valor_moeda = :valor WHERE cod_tipo_moeda =:codigo AND data_moeda =:dia_mes");
         
//            //  passando valores para o sql
            $stmt->bindValue(':codigo', $cod_moeda);
            $stmt->bindValue(':dia_mes', $dia);
            $stmt->bindValue(':valor', $valor_moeda);
                
            //  executa comando sql
             $stmt->execute();
           
             
            //  persiste comando sql
            $pdo->commit();
            $_SESSION['MENSAGEM_RETORNO_OPERACAO'] = "<div class='alert alert-success'>ALTERADO COM SUCESSO !!!</div>";
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