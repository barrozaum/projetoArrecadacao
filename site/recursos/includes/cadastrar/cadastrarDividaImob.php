<?php
//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';

error_reporting(0);
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
    $codigo_Letra_Maiscula = letraMaiuscula($_POST['txt_codigo']);
    $descricao_Letra_Maiscula = letraMaiuscula($_POST['txt_descricao']);
    $descricao_completa_Letra_Maiscula = letraMaiuscula($_POST['txt_descricao_completa']);
    $data_Letra_Maiscula = letraMaiuscula($_POST['txt_data']);
    $codigo_ano_Letra_Maiscula = letraMaiuscula($_POST['txt_codigo_ano']);
    $codigo_divida_ativa_Letra_Maiscula = letraMaiuscula($_POST['txt_divida_ativa']);
    $codigo_desconto_Letra_Maiscula = letraMaiuscula($_POST['txt_desconto']);
    $codigo_multas_juros_Letra_Maiscula = letraMaiuscula($_POST['txt_multas_juros']);

// variaves serão preenchidas por valores do formulario
// // valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto
    if ((strlen($codigo_Letra_Maiscula) > 0 && strlen($codigo_Letra_Maiscula) < 11) || is_int($codigo_Letra_Maiscula) === TRUE) {
        $codigo = $codigo_Letra_Maiscula;
    } else {
        $array_erros['txt_codigo'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO \n';
    }

// filtro pra validar Nome do Bairro (não ter nenhum sql_injection)
    if (strlen($descricao_Letra_Maiscula) > 2) {
        $descricao = $descricao_Letra_Maiscula;
    } else {
        $array_erros['txt_descricao'] = 'POR FAVOR ENTRE COM O NOME DA DÍVIDA VÁLIDA \n';
    }


// filtro pra validar Nome do Bairro (não ter nenhum sql_injection)
    if (strlen($descricao_completa_Letra_Maiscula) > 2) {
        $descricaoCompleta = $descricao_completa_Letra_Maiscula;
    } else {
        $array_erros['txt_descricao_completa'] = 'POR FAVOR ENTRE COM O NOME COMPLETO DA DÍVIDA VÁLIDA \n';
    }


//  valida se o tipo da data está correta
    if (validar_estrutura_data($data_Letra_Maiscula)) {
        $vencimento = dataAmericano($data_Letra_Maiscula);
    } else {
        $array_erros['txt_data'] = 'POR FAVOR ENTRE COM UMA DATA VÁLIDA \n';
    }


//    Valida o ano informado
    if ((strlen($codigo_ano_Letra_Maiscula) > 0 && strlen($codigo_ano_Letra_Maiscula) < 11) || is_int($codigo_ano_Letra_Maiscula) === TRUE) {
        $ano_divida = $codigo_ano_Letra_Maiscula;
    } else {
        $array_erros['txt_codigo_ano'] = 'POR FAVOR ENTRE COM ANO VÁLIDO \n';
    }


//    Valida o cod div ativ
    if ((strlen($codigo_divida_ativa_Letra_Maiscula) > 0 && strlen($codigo_divida_ativa_Letra_Maiscula) < 11) || is_int($codigo_divida_ativa_Letra_Maiscula) === TRUE) {
        $codigo_div_ativ = $codigo_divida_ativa_Letra_Maiscula;
    } else {
        $array_erros['txt_divida_ativa'] = 'POR FAVOR ENTRE COM DÍV ATIVA VÁLIDA \n';
    }


//    Valida o desconto
    if ((strlen($codigo_desconto_Letra_Maiscula) > 0 && strlen($codigo_desconto_Letra_Maiscula) < 11) || is_int($codigo_desconto_Letra_Maiscula) === TRUE) {
        $desconto = $codigo_desconto_Letra_Maiscula;
    } else {
        $array_erros['txt_desconto'] = 'POR FAVOR ENTRE COM PORCENTAGEM DESCONTO VÁLIDO \n';
    }

//    Valida multas
    if ((strlen($codigo_multas_juros_Letra_Maiscula) > 0 && strlen($codigo_multas_juros_Letra_Maiscula) < 11) || is_int($codigo_multas_juros_Letra_Maiscula) === TRUE) {
        $multas = $codigo_multas_juros_Letra_Maiscula;
    } else {
        $array_erros['txt_multas_juros'] = 'POR FAVOR ENTRE COM PORCENTAGEM MULTA VÁLIDA \n';
    }



// verifico se tem erro na validação
    if (empty($array_erros)) {

//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
        $pdo->beginTransaction();

//      Comando sql a ser executado  
        $sql = "INSERT INTO Divida_Imob "
                . "(Cod_Divida_Imob, Desc_Divida, Venc_Cota_Unica, Desconto, Cod_Contabil, Cod_Contabil_DA, Cod_Contabil_Multa_Juros, Desc_Completa) "
                . "VALUES "
                . "('$codigo', '$descricao', '$vencimento','$desconto' ,'$ano_divida', '$codigo_div_ativ', '$multas', '$descricaoCompleta' )";

//      execução com comando sql    
        $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
            die('<script>window.alert("Erro ao Cadastrar  !!!");location.href = "../../../TabelaDividaImob.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
        } else {
//          salvo alteração no banco de dados
            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
        }
//        fecho conexao
        $pdo = null;
        ?>
        <!-- Dispara mensagem de sucesso -->
        <script>
            window.alert("<?php echo "Dívida Imob cadastrada com Sucesso !!!"; ?> ");
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