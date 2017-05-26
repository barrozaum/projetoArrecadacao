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


    if (fun_aplica_validacao_campo($_POST['txt_numero_Docarj'], 6, 6)) {
        $numero_Docarj = letraMaiuscula($_POST['txt_numero_Docarj']);
    } else {
        $array_erros['txt_numero_Docarj'] = "NÚMERO DOCARJ INVÁLIDO !!! \n";
    }

    if (fun_aplica_validacao_campo($_POST['txt_ano_Docarj'], 4, 4)) {
        $ano_Docarj = letraMaiuscula($_POST['txt_ano_Docarj']);
    } else {
        $array_erros['txt_ano_Docarj'] = "ANO DOCARJ INVÁLIDO !!! \n";
    }

    if (fun_aplica_validacao_campo($_POST['txt_parcela'], 2, 2)) {
        $parcela_Docarj = letraMaiuscula($_POST['txt_parcela']);
    } else {
        $array_erros['txt_parcela_Docarj'] = "PARCELA DOCARJ INVÁLIDO !!! \n";
    }

    if (fun_aplica_validacao_campo($_POST['txt_contribuinte'], 3, 50)) {
        $contribuinte_Docarj = letraMaiuscula($_POST['txt_contribuinte']);
    } else {
        $array_erros['txt_contribuinte_Docarj'] = "CONTRIBUINTE DOCARJ INVÁLIDO !!! \n";
    }

    if (validar_estrutura_data($_POST['txt_data_vencimento'])) {
        if (fun_aplica_validacao_campo($_POST['txt_data_vencimento'], 10, 10)) {
            $vencimento = dataAmericano(letraMaiuscula($_POST['txt_data_vencimento']));
        } else {
            $array_erros['txt_data_vencimento'] = "VENCIMENTO DOCARJ INVÁLIDO !!! \n";
        }
    } else {
        $array_erros['txt_data_vencimento'] = "VENCIMENTO DOCARJ INVÁLIDO !!! \n";
    }

    if (fun_aplica_validacao_campo($_POST['txt_valor_Docarj'], 3, 11)) {
        $valor_Docarj = inserirDinheiro(letraMaiuscula($_POST['txt_valor_Docarj']));
    } else {
        $array_erros['txt_valor_Docarj'] = "VALOR DOCARJ INVÁLIDO !!! \n";
    }

    

    $obs_Dam_Letra_Maiscula = letraMaiuscula($_POST['txt_obs_Docarj']);

// verifico se tem erro na validação
    if (empty($array_erros)) {

//        DATA DO CANCELAMENTO
        $data_cancelamento = dataAmericano(date('d/m/Y'));


        try {
//      Conexao com o banco de dados  
            include_once '../estrutura/conexao/conexao.php';
//      inlusao da biblioteca para inserir observacao
            include_once '../funcaoPHP/funcao_retorna_observacao_itbi.php';


//      Inicio a transação com o banco        
            $pdo->beginTransaction();

//      Comando sql a ser executado  

            $sql = "UPDATE Financeiro_Dam SET ";
            $sql = $sql . " Cod_Situacao_divida = null ,";
            $sql = $sql . " Data_Pagamento = null,";
            $sql = $sql . " Valor_Pagamento = null,";
            $sql = $sql . " Cod_Banco = null,";
            $sql = $sql . " Lote = null";
            $sql = $sql . " WHERE Num_Dam ='$numero_Docarj' ";
            $sql = $sql . " AND Ano_Dam ='$ano_Docarj' ";
            $sql = $sql . " AND Parcela = '$parcela_Docarj'  ";

//      execução com comando sql    
            $executa = $pdo->query($sql);

         
//            inclusão da biblioteca para cadastrar observação itbi
//        O PROCESSO DE CADASTRO DA OBSERVAÇÃO É REALIZADO PELA FUNÇÃO ABAIXO    
            FUN_CONTROLE_OBSERVACAO($pdo, 3, $numero_Docarj, $ano_Docarj, $obs_Dam_Letra_Maiscula, '00', $parcela_Docarj);

//          salvo alteração no banco de dados
            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */

//            mensagem de sucesso
            $msg = "ESTORNO REALIZADO COM SUCESSO ";
        } catch (Exception $e) {
            $msg = $e->getMessage();
        }
        echo '<script>window.alert("' . $msg . '");
               location.href = "../../../EstornoCancelamentoDocarj.php";
        </script>';

//        fecho conexao
        $pdo = null;

//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../EstornoCancelamentoDocarj.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>