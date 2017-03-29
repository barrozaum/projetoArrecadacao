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

    $codigo_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_codigo']);
    $data_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_data']);
    $valor_Letra_Maiscula = letraMaiuscula($_POST['txt_alterar_valor']);


// variaves serão preenchidas por valores do formulario
// valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($codigo_Letra_Maiscula) > 0 && strlen($codigo_Letra_Maiscula) < 11) || is_int($codigo_Letra_Maiscula) === TRUE) {
        $alterar_cod = $codigo_Letra_Maiscula;
    } else {
        $array_erros['txt_codigo'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO \n';
    }

//  valida se o tipo da data está correta
    if (validar_estrutura_data($data_Letra_Maiscula)) {
        $alterar_data = dataAmericano($data_Letra_Maiscula);
    } else {
        $array_erros['txt_alterar_data'] = 'POR FAVOR ENTRE COM UMA DATA VÁLIDA \n';
    }

//    filtro pra saber se o valor está correto
    if (is_numeric(inserirDinheiro($valor_Letra_Maiscula)) && strlen($valor_Letra_Maiscula) >= 3) {
        $valor_moeda = inserirDinheiro($valor_Letra_Maiscula);
    } else {
        $array_erros['txt_valor'] = 'POR FAVOR ENTRE COM UM VALOR (UFIR) VÁLIDO \n';
    }



// verifico se tem erro na validação
    if (empty($array_erros)) {

//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
        $pdo->beginTransaction();

//      Comando sql a ser executado  

        $sql = "UPDATE moeda "
                . "SET valor_moeda = '$valor_moeda'"
                . "WHERE cod_tipo_moeda = '$alterar_cod' "
                . "AND data_moeda = '$alterar_data'";

//      execução com comando sql    
        $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
            die('<script>window.alert("Erro ao Alterar  !!!");location.href = "../../../TabelaValorMoeda.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
        } else {
//          salvo alteração no banco de dados
            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
        }
//        fecho conexao
        $pdo = null;
        ?>
        <script>
            window.alert("<?php echo "Alterado com Sucesso !!!"; ?> ");
            location.href = "../../../TabelaValorMoeda.php";
        </script>
        <?php
//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../TabelaValorMoeda.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>