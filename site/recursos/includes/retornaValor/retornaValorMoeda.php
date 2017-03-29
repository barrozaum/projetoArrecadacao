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
    $codigo_Letra_Maiscula = letraMaiuscula($_POST['cod']);

// variaves serão preenchidas por valores do formulario
// // valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($codigo_Letra_Maiscula) > 0 && strlen($codigo_Letra_Maiscula) < 3) || is_int($codigo_Letra_Maiscula) === TRUE) {
        $codigo = $codigo_Letra_Maiscula;
    } else {
        $array_erros['txt_excluir_codigo'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO \n';
    }

// verifico se tem erro na validação
    if (empty($array_erros)) {


// chamo a conexao com o banco de dados
        include_once '../estrutura/conexao/conexao.php';

// preparo para realizar o comando sql
        $sql = "SELECT * FROM tipo_moeda WHERE cod_tipo_moeda = '$codigo'";
        $query = $pdo->prepare($sql);
//executo o comando sql
        $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
        if (($dados = $query->fetch()) == true) {
            $achou = 1;
            $descricao = $dados['Desc_tipo_moeda'];
        } else {
            $achou = 0;
            $descricao = "Código inválido";
        }

        $pdo = null;
// array com referente a 3 pessoas

        $var = Array(
            "achou" => "$achou",
            "descricao" => "$descricao"
        );
// convertemos em json e colocamos na tela
        echo json_encode($var);
    } else {
        $array_erros['achou'] = 0;
        $array_erros['descricao'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO ';
        echo json_encode($array_erros);
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>