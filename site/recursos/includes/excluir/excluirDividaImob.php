<?php
//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';

//die(print_r($_POST));
//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//BIBLIOTECA COM FUNÇÕES DATA
    include_once '../funcaoPHP/funcaoData.php';

//ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();

// biblioteca para validar string informada    
    include ('../funcaoPHP/function_letraMaiscula.php');
//    aplica filtro na string enviada (LetraMaiuscula)
    $codigo_Letra_Maiscula = letraMaiuscula($_POST['txt_excluir_codigo']);

// variaves serão preenchidas por valores do formulario
// // valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($codigo_Letra_Maiscula) > 0 && strlen($codigo_Letra_Maiscula) < 11) || is_int($codigo_Letra_Maiscula) === TRUE) {
        $codigo = $codigo_Letra_Maiscula;
    } else {
        $array_erros['txt_excluir_codigo'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO \n';
    }


// filtro pra validar Nome do Bairro (não ter nenhum sql_injection)
    if (strlen($_POST['txt_excluir_descricao_completa']) > 2) {
        $descricaoCompleta = preg_replace("/[^a-zA-Z0-9ãÃáÁàÀâÂéÉèÈêÊíÍìÌîÎõÕóÓòÒôÔúÚùÙûÛçÇ@ ]/", "", $_POST['txt_excluir_descricao_completa']);
    } else {
        $array_erros['txt_excluir_descricao_completa'] = 'POR FAVOR ENTRE COM O NOME COMPLETO DA DÍVIDA VÁLIDA \n';
    }


//  valida se o tipo da data está correta
    if (validar_estrutura_data($_POST['txt_excluir_data'])) {
        $vencimento = dataAmericano($_POST['txt_excluir_data']);
    } else {
        $array_erros['txt_excluir_data'] = 'POR FAVOR ENTRE COM UMA DATA VÁLIDA \n';
    }


//    Valida o desconto
    if (strlen($_POST['txt_excluir_desconto']) === 2 || is_int($_POST['txt_excluir_desconto']) === TRUE) {
        $desconto = $_POST['txt_excluir_desconto'];
    } else {
        $array_erros['txt_excluir_desconto'] = 'POR FAVOR ENTRE COM PORCENTAGEM DESCONTO VÁLIDO \n';
    }


//    Valida o ano informado
    if (strlen($_POST['txt_excluir_codigo_ano']) === 3 || is_int($_POST['txt_excluir_codigo_ano']) === TRUE) {
        $ano_divida = $_POST['txt_excluir_codigo_ano'];
    } else {
        $array_erros['txt_excluir_codigo_ano'] = 'POR FAVOR ENTRE COM ANO VÁLIDO \n';
    }


//    Valida o cod div ativ
    if (strlen($_POST['txt_excluir_divida_ativa']) === 3 || is_int($_POST['txt_excluir_divida_ativa']) === TRUE) {
        $codigo_div_ativ = $_POST['txt_excluir_divida_ativa'];
    } else {
        $array_erros['txt_excluir_divida_ativa'] = 'POR FAVOR ENTRE COM DÍV ATIVA VÁLIDA \n';
    }



//    Valida multas
    if (strlen($_POST['txt_excluir_multas_juros']) < 4 || is_int($_POST['txt_excluir_multas_juros']) === TRUE) {
        $multas = $_POST['txt_excluir_multas_juros'];
    } else {
        $array_erros['txt_excluir_multas_juros'] = 'POR FAVOR ENTRE COM PORCENTAGEM MULTA VÁLIDA \n';
    }



// verifico se tem erro na validação
    if (empty($array_erros)) {

//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
        $pdo->beginTransaction();

//      Comando sql a ser executado  
        $sql = "DELETE  FROM Divida_Imob  WHERE Cod_Divida_Imob = '".$codigo."'";

//      execução com comando sql    
        $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
            die('<script>window.alert("Erro ao Excluir  !!!");location.href = "../../../TabelaDividaImob.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
        } else {
//          salvo alteração no banco de dados
            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
        }
//        fecho conexao
        $pdo = null;
        ?>
        <!-- Dispara mensagem de sucesso -->
        <script>
            window.alert("<?php echo "Dívida Imob excluida com Sucesso !!!"; ?> ");
            location.href = "../../../TabelaDividaImob.php";
        </script>

        <?php
//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../TabelaDividaImob.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>