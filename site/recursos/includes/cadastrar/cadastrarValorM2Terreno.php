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
    include_once '../funcaoPHP/function_letraMaiscula.php';
    include_once '../funcaoPHP/funcaoDinheiro.php';

// aplica filtro na string enviada (LetraMaiuscula)
    $zona_Letra_Maiscula = letraMaiuscula($_POST['txt_zona']);
    $valor_Letra_Maiscula = letraMaiuscula($_POST['txt_valor']);
    $codigo_utilizacao_Letra_Maiscula = letraMaiuscula($_POST['txt_cod_utilizacao']);
    

// variaves serão preenchidas por valores do formulario
// valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($zona_Letra_Maiscula) > 0 && strlen($zona_Letra_Maiscula) < 11) || is_int($zona_Letra_Maiscula) === TRUE) {
        $zona = $zona_Letra_Maiscula;
    } else {
        $array_erros['txt_zona'] = 'POR FAVOR ENTRE COM UMA ZONA VÁLIDA !!! <br />';
    }

//    filtro pra saber se o valor está correto
    if (is_numeric(inserirDinheiro($valor_Letra_Maiscula)) && strlen($valor_Letra_Maiscula) >= 3) {
        $valor = inserirDinheiro($valor_Letra_Maiscula);
    } else {
        $array_erros['txt_valor'] = 'POR FAVOR ENTRE COM UM VALOR (UFIR) VÁLIDO !!! <br />';
    }
    
//    CODIGO UTILIZACAO
     if ((strlen($codigo_utilizacao_Letra_Maiscula) > 0 && strlen($codigo_utilizacao_Letra_Maiscula) < 11) || is_int($codigo_utilizacao_Letra_Maiscula) === TRUE) {
        $utilizacao = $codigo_utilizacao_Letra_Maiscula;
    } else {
        $array_erros['txt_cod_utilizacao'] = 'POR FAVOR ENTRE COM UMA UTILIZAÇÃO VÁLIDA !!! ';
    }

// verifico se tem erro na validação
   if (empty($array_erros)) {
        try {
            include_once '../estrutura/conexao/conexao.php';
            $pdo->beginTransaction();

            //  preparo comando sql para receber valores
            
            $stmt = $pdo->prepare("INSERT INTO Valor_M2_Terreno (Zona_Fiscal, Cod_Utilizacao, vlr_m2_Terreno) VALUES (:zona, :utilizacao,:valor)");

            //  passando valores para o sql
            $stmt->bindParam(':zona', $zona);
            $stmt->bindParam(':utilizacao', $utilizacao);
            $stmt->bindParam(':valor', $valor);

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
    header("Location: ../../../TabelaValorM2Terreno.php");



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>