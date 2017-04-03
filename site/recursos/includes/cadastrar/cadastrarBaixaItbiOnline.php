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
    $data_vencimento_Letra_Maiscula = letraMaiuscula($_POST['txt_data_vencimento']);
    $valor_itbi_Letra_Maiscula = letraMaiuscula($_POST['txt_valor_itbi']);
    $data_pagamento_Letra_Maiscula = letraMaiuscula($_POST['txt_data_pagto']);
    $valor_pagamento_Letra_Maiscula = letraMaiuscula($_POST['txt_valor_pagamento']);
    $numero_processo_Letra_Maiscula = letraMaiuscula($_POST['txt_numero_processo']);
    $ano_processo_Letra_Maiscula = letraMaiuscula($_POST['txt_ano_processo']);
    $lote_Letra_Maiscula = letraMaiuscula($_POST['txt_lote']);
    $banco_Letra_Maiscula = letraMaiuscula($_POST['txt_banco']);
    $descricao_banco_Letra_Maiscula = letraMaiuscula($_POST['txt_descricao_banco']);
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

//    DATA vencimento
//  valida se o tipo da data está correta
    if (validar_estrutura_data($data_vencimento_Letra_Maiscula)) {
        $data_vencimento = dataAmericano($data_vencimento_Letra_Maiscula);
    } else {
        $array_erros['txt_data_vencimento'] = 'POR FAVOR ENTRE COM UMA DATA VENCIMENTO VÁLIDA \n';
    }


//    VALOR ITBI
//       filtro pra saber se o valor está correto
    if (is_numeric(inserirDinheiro($valor_itbi_Letra_Maiscula)) && strlen($valor_itbi_Letra_Maiscula) >= 3) {
        $valor_Itbi = inserirDinheiro($valor_itbi_Letra_Maiscula);
    } else {
        $array_erros['txt_valor_itbi'] = 'POR FAVOR ENTRE COM UM VALOR ITBI VÁLIDO \n';
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
        $array_erros['txt_ano_itbi'] = 'POR FAVOR ENTRE COM UM ANO PROCESSO VÁLIDO \n';
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

        $sql = "UPDATE itbi SET ";
        $sql = $sql . "cod_situacao_divida ='04',";
        $sql = $sql . "data_pagamento ='$data_Pagamento',";
        $sql = $sql . "valor_pagamento ='$valor_Pagamento',";
        $sql = $sql . "Cod_Banco ='$banco',";
        $sql = $sql . "Lote ='$lote',";
        $sql = $sql . "NUM_PROCESSO_BAIXA ='$numero_Processo',";
        $sql = $sql . "ANO_PROCESSO_BAIXA ='$ano_Processo',";
        $sql = $sql . "tipo_pagto ='M',";
        $sql = $sql . "usuario_pagto = '$usuario_logado',";
        $sql = $sql . "estacao_pagto = '$hostname',";
        $sql = $sql . "dia_hora_pagto ='$dia_hora_pagamento'";
        $sql = $sql . " WHERE Num_ITBI ='$num_itbi' ";
        $sql = $sql . " AND Ano_ITBI ='$ano_itbi' ";


//      execução com comando sql    
        $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
            die('<script>window.alert("ERROR AO REALIZAR BAIXA  !!!");location.href = "../../../BaixaOnlineItbi.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
        } else {
//            inclusão da biblioteca para cadastrar observação itbi
            require_once '../funcaoPHP/funcao_retorna_observacao_itbi.php';

//        O PROCESSO DE CADASTRO DA OBSERVAÇÃO É REALIZADO PELA FUNÇÃO ABAIXO    
            FUN_CONTROLE_OBSERVACAO_ITBI($pdo, $num_itbi, $ano_itbi, '00', $obs_Itbi_Letra_Maiscula);

//          salvo alteração no banco de dados
            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
        }
//        fecho conexao
        $pdo = null;
        ?>
        <!-- Dispara mensagem de sucesso -->
        <script>
            window.alert("<?php echo "BAIXA EFETUADA COM SUCESSO !!!"; ?> ");
            location.href = "../../../BaixaOnlineItbi.php";
        </script>

        <?php
//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../BaixaOnlineItbi.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>