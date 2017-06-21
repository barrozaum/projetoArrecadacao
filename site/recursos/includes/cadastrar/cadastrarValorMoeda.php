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
        $array_erros['txt_codigo'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO \n';
    }
//    mes
    if ((strlen($mes_Letra_Maiscula) > 0 && strlen($mes_Letra_Maiscula) < 3) || is_int($mes_Letra_Maiscula) === TRUE) {
        $mes = $mes_Letra_Maiscula;
    } else {
        $array_erros['txt_mes'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO \n';
    }

//    ano
    if ((strlen($ano_Letra_Maiscula) > 0 && strlen($ano_Letra_Maiscula) < 5) || is_int($ano_Letra_Maiscula) === TRUE) {
        $ano = $ano_Letra_Maiscula;
    } else {
        $array_erros['txt_ano'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO \n';
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
//      loop para executar durante todos os dias do mes
        for ($i = 1; $i <= diaBisesto($ano, $mes); $i++) {

//            insetiro 0 caso o dia seja menor que 10 para ficar com duas casas 
            if ($i > 9) {
                $dia = dataAmericano($i . "/" . $mes . "/" . $ano);
            } else {
                $dia = dataAmericano("0" . $i . "/" . $mes . "/" . $ano);
            }
            $sql = "INSERT INTO moeda "
                    . "(cod_tipo_moeda, data_moeda, valor_moeda) "
                    . "VALUES "
                    . "('$cod_moeda', '$dia', '$valor_moeda')";
            $executa = $pdo->query($sql);
            if (!$executa) {
                //lancçamento de erro
                die('<script>window.alert("Erro ao Cadastrar  !!!");location.href = "../../../TabelaValorMoeda.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
            }
        } // fim do for
        $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */

//        atualizando na sessao do sistema
        $_SESSION['C_VALOR_MOEDA_DIA_UFIR'] = mostrarDinheiro5Casas($valor_moeda);
        $pdo = null;
        ?>

        <script>
            window.alert("<?php echo "Cadastrado com Sucesso !!!"; ?> ");
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
               location.href = "../../../TabelaColeta.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>