<?php
//die(print_r($_POST));
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
    $numero_dam_Letra_Maiscula = letraMaiuscula($_POST['txt_numero_dam']);
    $ano_dam_Letra_Maiscula = letraMaiuscula($_POST['txt_ano_dam']);
    $parcela_dam_Letra_Maiscula = letraMaiuscula($_POST['txt_parcela']);
    $contribuinte_Letra_Maiscula = letraMaiuscula($_POST['txt_contribuinte']);
    $data_vencimento_Letra_Maiscula = letraMaiuscula($_POST['txt_data_vencimento']);
    $valor_dam_Letra_Maiscula = letraMaiuscula($_POST['txt_valor_dam']);
    $data_pagamento_Letra_Maiscula = letraMaiuscula($_POST['txt_data_pagto']);
    $valor_pagamento_Letra_Maiscula = letraMaiuscula($_POST['txt_valor_pagamento']);
    $numero_processo_Letra_Maiscula = letraMaiuscula($_POST['txt_numero_processo']);
    $ano_processo_Letra_Maiscula = letraMaiuscula($_POST['txt_ano_processo']);
    $lote_Letra_Maiscula = letraMaiuscula($_POST['txt_lote']);
    $banco_Letra_Maiscula = letraMaiuscula($_POST['txt_banco']);
    $descricao_banco_Letra_Maiscula = letraMaiuscula($_POST['txt_descricao_banco']);
    $obs_dam_Letra_Maiscula = letraMaiuscula($_POST['txt_obs_dam']);

//    NUMERO DAM
    if ((strlen($numero_dam_Letra_Maiscula) == 6) || is_int($numero_dam_Letra_Maiscula) === TRUE) {
        $num_dam = $numero_dam_Letra_Maiscula;
    } else {
        $array_erros['numero_dam_Letra_Maiscula'] = 'POR FAVOR ENTRE COM UM NÚMERO DAM VÁLIDO \n';
    }

//    ANO DAM
    if ((strlen($ano_dam_Letra_Maiscula) == 4) || is_int($ano_dam_Letra_Maiscula) === TRUE) {
        $ano_dam = $ano_dam_Letra_Maiscula;
    } else {
        $array_erros['txt_ano_dam'] = 'POR FAVOR ENTRE COM UM ANO DAM VÁLIDO \n';
    }
//    PARCELA DAM
    if ((strlen($parcela_dam_Letra_Maiscula) == 2) || is_int($parcela_dam_Letra_Maiscula) === TRUE) {
        $parcela = $parcela_dam_Letra_Maiscula;
    } else {
        $array_erros['txt_parcela_dam'] = 'POR FAVOR ENTRE COM PARCELA DAM VÁLIDA \n';
    }

//    CONTRIBUINTE
    if ((strlen($contribuinte_Letra_Maiscula) > 3) && (strlen($contribuinte_Letra_Maiscula) < 51)) {
        $contribuinte = $contribuinte_Letra_Maiscula;
    } else {
        $array_erros['txt_contribuinte'] = 'POR FAVOR ENTRE COM O CONTRIBUINTE VÁLIDO \n';
    }



//    DATA vencimento
//  valida se o tipo da data está correta
    if (validar_estrutura_data($data_vencimento_Letra_Maiscula)) {
        $data_vencimento = dataAmericano($data_vencimento_Letra_Maiscula);
    } else {
        $array_erros['txt_data_vencimento'] = 'POR FAVOR ENTRE COM UMA DATA VENCIMENTO VÁLIDA \n';
    }


//    VALOR DAM
//       filtro pra saber se o valor está correto
    if (is_numeric(inserirDinheiro($valor_dam_Letra_Maiscula)) && strlen($valor_dam_Letra_Maiscula) >= 3) {
        $valor_Itbi = inserirDinheiro($valor_dam_Letra_Maiscula);
    } else {
        $array_erros['txt_valor_dam'] = 'POR FAVOR ENTRE COM UM VALOR DAM VÁLIDO \n';
    }


//    DATA PAGAMENTO
//  valida se o tipo da data está correta
    if (validar_estrutura_data($data_pagamento_Letra_Maiscula)) {
        $data_Pagamento = dataAmericano($data_pagamento_Letra_Maiscula);
    } else {
        $array_erros['txt_data_pagto'] = 'POR FAVOR ENTRE COM UMA DATA PAGAMENTO VÁLIDA \n';
    }


//    VALOR PAGAMENTO
//       filtro pra saber se o valor está correto
    if (is_numeric(inserirDinheiro($valor_pagamento_Letra_Maiscula)) && strlen($valor_pagamento_Letra_Maiscula) >= 3) {
        $valor_Pagamento = inserirDinheiro($valor_pagamento_Letra_Maiscula);
    } else {
        $array_erros['txt_valor_pagamento'] = 'POR FAVOR ENTRE COM UM VALOR PAGAMENTO VÁLIDO \n';
    }



//    NUMERO PROCESSO
    if ((strlen($numero_processo_Letra_Maiscula) == 6) || is_int($numero_processo_Letra_Maiscula) === TRUE) {
        $numero_Processo = $numero_processo_Letra_Maiscula;
    } else {
        $array_erros['numero_processo_Letra_Maiscula'] = 'POR FAVOR ENTRE COM UM NÚMERO PROCESSO VÁLIDO \n';
    }

//    ANO PROCESSO
    if ((strlen($ano_processo_Letra_Maiscula) == 4) || is_int($ano_processo_Letra_Maiscula) === TRUE) {
        $ano_Processo = $ano_processo_Letra_Maiscula;
    } else {
        $array_erros['txt_ano_dam'] = 'POR FAVOR ENTRE COM UM ANO PROCESSO VÁLIDO \n';
    }


    //    LOTE
    if ((strlen($lote_Letra_Maiscula) == 4) || is_int($lote_Letra_Maiscula) === TRUE) {
        $lote = $lote_Letra_Maiscula;
    } else {
        $array_erros['txt_lote'] = 'POR FAVOR ENTRE COM UM LOTE VÁLIDO \n';
    }

    //    BANCO
    if ((strlen($banco_Letra_Maiscula) == 3) || is_int($banco_Letra_Maiscula) === TRUE) {
        $banco = $banco_Letra_Maiscula;
    } else {
        $array_erros['txt_banco'] = 'POR FAVOR ENTRE COM UM ANO PROCESSO VÁLIDO \n';
    }
    //    BANCO - DESCRICAO BANCO
    if (strlen($descricao_banco_Letra_Maiscula) > 3) {
        $desc_Banco = $descricao_banco_Letra_Maiscula;
    } else {
        $array_erros['txt_descricao_banco'] = 'POR FAVOR ENTRE COM UM ANO PROCESSO VÁLIDO \n';
    }




// verifico se tem erro na validação
    if (empty($array_erros)) {


        //nome da estação que esta acessando o sistema
        $hostname = $_SERVER['REMOTE_ADDR'];
        // Nome do usuário logado
        $usuario_logado = $_SESSION["usuario"];
        //dia hora pagamento
        $dia_hora_pagamento = dataAmericano(date('d/m/Y'));
        $dia_hora_pagamento = $dia_hora_pagamento . " " . date('H:i:s');

//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
        $pdo->beginTransaction();

//      Comando sql a ser executado  




        $sql = "UPDATE Financeiro_Dam SET ";
        $sql = $sql . " Cod_Situacao_divida ='04',";
        $sql = $sql . " Data_Pagamento ='$data_Pagamento',";
        $sql = $sql . " Valor_Pagamento ='$valor_Pagamento',";
        $sql = $sql . " Cod_Banco ='$banco',";
        $sql = $sql . " Lote ='$lote'"; 
//        $sql = $sql . " NUM_PROCESSO_BAIXA ='$numero_Processo',";
//        $sql = $sql . " ANO_PROCESSO_BAIXA ='$ano_Processo',";
//        $sql = $sql . " tipo_pagto ='M',";
//        $sql = $sql . " usuario_pagto = '$usuario_logado',";
//        $sql = $sql . " estacao_pagto = '$hostname',";
//        $sql = $sql . " dia_hora_pagto ='$dia_hora_pagamento'";
        $sql = $sql . " WHERE Num_Dam ='$num_dam' ";
        $sql = $sql . " AND Ano_DAM ='$ano_dam' ";
        $sql = $sql . " AND Parcela = '$parcela'  ";


//      execução com comando sql    
        $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
            die('<script>window.alert("ERROR AO REALIZAR BAIXA  !!!");location.href = "../../../BaixaOnlineDam.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
        } else {
//            inclusão da biblioteca para cadastrar observação itbi
            require_once '../funcaoPHP/funcao_retorna_observacao_itbi.php';

            
//        O PROCESSO DE CADASTRO DA OBSERVAÇÃO É REALIZADO PELA FUNÇÃO ABAIXO    
            FUN_CONTROLE_OBSERVACAO($pdo, 3, $num_dam, $ano_dam , $obs_dam_Letra_Maiscula, '00', $parcela);

//          salvo alteração no banco de dados
            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
        }
//        fecho conexao
        $pdo = null;
        ?>
        <!-- Dispara mensagem de sucesso -->
        <script>
            window.alert("<?php echo "BAIXA EFETUADA COM SUCESSO !!!"; ?> ");
                    location.href = "../../../BaixaOnlineDam.php";
        </script>

        <?php
//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
//               location.href = "../../../BaixaOnlineDam.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>