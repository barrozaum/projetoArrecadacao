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

// biblioteca para validar estrutura data informada  
    include ('../funcaoPHP/funcaoData.php');

// biblioteca para mascarar valores 
    include ('../funcaoPHP/funcaoDinheiro.php');


//    aplica filtro na string enviada (LetraMaiuscula)
    $numero_itbi_Letra_Maiscula = letraMaiuscula($_POST['txt_numero_itbi']);
    $ano_itbi_Letra_Maiscula = letraMaiuscula($_POST['txt_ano_itbi']);
    $adquirinte_Letra_Maiscula = letraMaiuscula($_POST['txt_adquirinte']);
    $transmitente_Letra_Maiscula = letraMaiuscula($_POST['txt_transmitente']);
    $data_Letra_Maiscula = letraMaiuscula($_POST['txt_data']);
    $valor_itbi_Letra_Maiscula = letraMaiuscula($_POST['txt_valor_itbi']);
    $obs_Itbi_Letra_Maiscula = letraMaiuscula($_POST['txt_obs_itbi']);

//    NUMERO ITBI
    if ((strlen($numero_itbi_Letra_Maiscula) == 6) || is_int($numero_itbi_Letra_Maiscula) === TRUE) {
        $num_itbi = $numero_itbi_Letra_Maiscula;
    } else {
        $array_erros['numero_itbi_Letra_Maiscula'] = 'POR FAVOR ENTRE COM UM NÚMERO ITBI VÁLIDO \n';
    }

//    ANO ITBI
    if ((strlen($ano_itbi_Letra_Maiscula) == 4) || is_int($ano_itbi_Letra_Maiscula) === TRUE) {
        $ano_itbi = $ano_itbi_Letra_Maiscula;
    } else {
        $array_erros['txt_ano_itbi'] = 'POR FAVOR ENTRE COM UM ANO ITBI VÁLIDO \n';
    }

//    ADQUIRINTE
    if ((strlen($adquirinte_Letra_Maiscula) > 3) && (strlen($adquirinte_Letra_Maiscula) < 51)) {
        $adquirinte = $adquirinte_Letra_Maiscula;
    } else {
        $array_erros['txt_adquirinte'] = 'POR FAVOR ENTRE COM O ADQUIRENTE VÁLIDO \n';
    }

//    ADQUIRINTE
    if ((strlen($transmitente_Letra_Maiscula) > 3) && (strlen($transmitente_Letra_Maiscula) < 51)) {
        $transmitente = $transmitente_Letra_Maiscula;
    } else {
        $array_erros['txt_transmitente'] = 'POR FAVOR ENTRE COM O TRANSMITENTE VÁLIDO \n';
    }

//    DATA 
//  valida se o tipo da data está correta
    if (validar_estrutura_data($data_Letra_Maiscula)) {
        $data_Transacao = dataAmericano($data_Letra_Maiscula);
    } else {
        $array_erros['txt_data'] = 'POR FAVOR ENTRE COM UMA DATA TRANSAÇÃO VÁLIDA \n';
    }


//    VALOR ITBI
//       filtro pra saber se o valor está correto
    if (is_numeric(inserirDinheiro($valor_itbi_Letra_Maiscula)) && strlen($valor_itbi_Letra_Maiscula) >= 3) {
        $valor_Itbi = inserirDinheiro($valor_itbi_Letra_Maiscula);
    } else {
        $array_erros['txt_valor_itbi'] = 'POR FAVOR ENTRE COM UM VALOR ITBI VÁLIDO \n';
    }



// verifico se tem erro na validação
    if (empty($array_erros)) {

//        DATA DO CANCELAMENTO
        $data_cancelamento = dataAmericano(date('d/m/Y'));



//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
        $pdo->beginTransaction();

//      Comando sql a ser executado  
//
        $sql = "UPDATE itbi SET ";
        $sql = $sql . "cod_situacao_divida =null,";
        $sql = $sql . "Data_Cancelamento = null, ";
        $sql = $sql . "Cod_Motivo_Cancelamento = null";
        $sql = $sql . " WHERE Num_ITBI ='$num_itbi' ";
        $sql = $sql . " AND Ano_ITBI ='$ano_itbi' ";


//      execução com comando sql    
        $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
            die('<script>window.alert("ERROR AO REALIZAR ESTORNO DO CANCELAMENTO  !!!");location.href = "../../../EstornoCancelamentoItbi.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
        } else {
//            inclusão da biblioteca para cadastrar observação itbi
            require_once '../funcaoPHP/funcao_retorna_observacao_itbi.php';

            $obs_Itbi_Letra_Maiscula = "ESTORNO DO CANCELAMENTO REALIZADO POR : ";

//        O PROCESSO DE CADASTRO DA OBSERVAÇÃO É REALIZADO PELA FUNÇÃO ABAIXO    
            FUN_CONTROLE_OBSERVACAO($pdo, 4, $num_itbi, $ano_itbi, $obs_Itbi_Letra_Maiscula);

//          salvo alteração no banco de dados
            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
        }
//        fecho conexao
        $pdo = null;
        ?>
        <!-- Dispara mensagem de sucesso -->
        <script>
            window.alert("<?php echo "ESTORNO CANCELAMENTO EFETUADO COM SUCESSO !!!"; ?> ");
            location.href = "../../../EstornoCancelamentoItbi.php";
        </script>

        <?php
//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../EstornoCancelamentoItbi.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>