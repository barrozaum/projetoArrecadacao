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
    $numero_Docarj_Letra_Maiscula = letraMaiuscula($_POST['txt_numero_Docarj']);
    $ano_Docarj_Letra_Maiscula = letraMaiuscula($_POST['txt_ano_Docarj']);
    $parcela_Docarj_Letra_Maiscula = letraMaiuscula($_POST['txt_parcela']);

//    NUMERO ITBI
    if ((strlen($numero_Docarj_Letra_Maiscula) == 6) || is_int($numero_Docarj_Letra_Maiscula) === TRUE) {
        $num_Docarj = $numero_Docarj_Letra_Maiscula;
    } else {
        $array_erros['txt_numero_Docarj'] = 'POR FAVOR ENTRE COM UM NÚMERO DAM VÁLIDO \n';
    }

//    ANO ITBI
    if ((strlen($ano_Docarj_Letra_Maiscula) == 4) || is_int($ano_Docarj_Letra_Maiscula) === TRUE) {
        $ano_Docarj = $ano_Docarj_Letra_Maiscula;
    } else {
        $array_erros['txt_ano_Docarj'] = 'POR FAVOR ENTRE COM UM ANO DAM VÁLIDO \n';
    }
//    ANO ITBI
    if ((strlen($parcela_Docarj_Letra_Maiscula) == 2) || is_int($parcela_Docarj_Letra_Maiscula) === TRUE) {
        $parcela = $parcela_Docarj_Letra_Maiscula;
    } else {
        $array_erros['txt_parcela'] = 'POR FAVOR ENTRE COM A PARCELA DAM VÁLIDO \n';
    }





// verifico se tem erro na validação
    if (empty($array_erros)) {

//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
        $pdo->beginTransaction();

//      Comando sql a ser executado  


        $sql = "UPDATE Financeiro_Dam";
        $sql = $sql . " SET Cod_Situacao_divida = '01' ,";
        $sql = $sql . " Valor_Pagamento = null ,";
        $sql = $sql . " Cod_Banco  = null ,";
        $sql = $sql . " Lote  = null ,";
        $sql = $sql . " Data_Pagamento = null";
        $sql = $sql . " WHERE Num_Dam = '$num_Docarj'";
        $sql = $sql . " AND Ano_Dam = '$ano_Docarj' ";
        $sql = $sql . " AND Parcela= '$parcela' ";


//      execução com comando sql    
        $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
            die('<script>window.alert("ERROR AO REALIZAR ESTORNO PAGAMENTO  !!!");location.href = "../../../EstornoPagamentoDocarj.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
        } else {
//            inclusão da biblioteca para cadastrar observação itbi
            require_once '../funcaoPHP/funcao_retorna_observacao_itbi.php';

            $obs_Letra_Maiscula = "MOTIVO ESTORNO :"  .  letraMaiuscula($_POST['txt_obs_Docarj']). " ESTORNO DO PAGAMENTO REALIZADO POR : ";

//        O PROCESSO DE CADASTRO DA OBSERVAÇÃO É REALIZADO PELA FUNÇÃO ABAIXO    
            FUN_CONTROLE_OBSERVACAO($pdo, 3, $num_Docarj, $ano_Docarj, $obs_Letra_Maiscula, '00' , $parcela);
          
//          salvo alteração no banco de dados
            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
        }
//        fecho conexao
        $pdo = null;
        ?>
        <!-- Dispara mensagem de sucesso -->
        <script>
            window.alert("<?php echo "ESTORNO PAGAMENTO EFETUADO COM SUCESSO !!!"; ?> ");
            location.href = "../../../EstornoPagamentoDocarj.php";
        </script>

        <?php
//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../EstornoPagamentoDocarj.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>