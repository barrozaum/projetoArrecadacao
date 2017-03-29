<?php
//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    include_once ('../funcaoPHP/funcaoDinheiro.php');

//ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();

// biblioteca para validar string informada    
    include_once ('../funcaoPHP/function_letraMaiscula.php');
//    aplica filtro na string enviada (LetraMaiuscula)
    $zona_Letra_Maiscula = letraMaiuscula($_POST['txt_excluir_zona']);
    $valor_Letra_Maiscula = letraMaiuscula($_POST['txt_excluir_valor']);
    $codigo_utilizacao_Letra_Maiscula = letraMaiuscula($_POST['txt_excluir_cod_utilizacao']);
    $codigo_categoria_Letra_Maiscula = letraMaiuscula($_POST['txt_excluir_cod_cat']);


// variaves serão preenchidas por valores do formulario
// valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($zona_Letra_Maiscula) > 0 && strlen($zona_Letra_Maiscula) < 11) || is_int($zona_Letra_Maiscula) === TRUE) {
        $codigo = $zona_Letra_Maiscula;
    } else {
        $array_erros['txt_excluir_zona'] = 'POR FAVOR ENTRE COM UMA ZONA VÁLIDA \n';
    }

//    filtro pra saber se o valor está correto
    if (is_numeric(inserirDinheiro($valor_Letra_Maiscula)) && strlen($valor_Letra_Maiscula) >= 3) {
        $valor = inserirDinheiro($valor_Letra_Maiscula);
    } else {
        $array_erros['txt_excluir_valor'] = 'POR FAVOR ENTRE COM UM VALOR (UFIR) VÁLIDO \n';
    }

//    CODIGO UTILIZACAO
    if ((strlen($codigo_utilizacao_Letra_Maiscula) > 0 && strlen($codigo_utilizacao_Letra_Maiscula) < 11) || is_int($codigo_utilizacao_Letra_Maiscula) === TRUE) {
        $cod_uti = $codigo_utilizacao_Letra_Maiscula;
    } else {
        $array_erros['txt_excluir_cod_utilizacao'] = 'POR FAVOR ENTRE COM UMA UTILIZAÇÃO VÁLIDA \n';
    }


//    CODIGO CATEGORIA
    if ((strlen($codigo_categoria_Letra_Maiscula) > 0 && strlen($codigo_categoria_Letra_Maiscula) < 11) || is_int($codigo_categoria_Letra_Maiscula) === TRUE) {
        $cod_cat = $codigo_categoria_Letra_Maiscula;
    } else {
        $array_erros['txt_excluir_cod_cat'] = 'POR FAVOR ENTRE COM UMA CATEGORIA VÁLIDA \n';
    }



// verifico se tem erro na validação
    if (empty($array_erros)) {

//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
        $pdo->beginTransaction();

//      Comando sql a ser executado  
       $sql = "DELETE  FROM Valor_M2_Construcao  "
                . "WHERE Zona_Fiscal = '$codigo' "
                . "AND Cod_Utilizacao = '$cod_uti' "
                . "AND Cod_Categoria = '$cod_cat'";
         
//      execução com comando sql    
        $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
            die('<script>window.alert("Erro ao Exlcuir  !!!");location.href = "../../../TabelaValorM2Construcao.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
        } else {
//          salvo alteração no banco de dados
            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
        }
//        fecho conexao
        $pdo = null;
        ?>
        <!-- Dispara mensagem de sucesso -->
        <script>
            window.alert("<?php echo "Valor Construção Excluido com Sucesso !!!"; ?> ");
            location.href = "../../../TabelaValorM2Construcao.php";
        </script>

        <?php
//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../TabelaValorM2Construcao.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>