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





// verifico se tem erro na validação
    if (empty($array_erros)) {

//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
        $pdo->beginTransaction();

//      Comando sql a ser executado  


        $sql = "UPDATE itbi SET cod_situacao_divida ='01',";
        $sql = $sql . " data_pagamento  = null ,";
        $sql = $sql . " valor_pagamento  = null ,";
        $sql = $sql . " Cod_Banco  = null ,";
        $sql = $sql . " Lote  = null ,";
        $sql = $sql . " Num_Processo_Baixa  = null ,";
        $sql = $sql . " Ano_Processo_Baixa  = null, ";
        $sql = $sql . " tipo_pagto = '',";
        $sql = $sql . " usuario_pagto = '',";
        $sql = $sql . " estacao_pagto = '',";
        $sql = $sql . " dia_hora_pagto = null";
        $sql = $sql . " WHERE Num_Itbi = '$num_itbi' AND Ano_Itbi = '$ano_itbi' ";


//      execução com comando sql    
        $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
            die('<script>window.alert("ERROR AO REALIZAR ESTORNO PAGAMENTO  !!!");location.href = "../../../EstornoPagamentoItbi.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
        } else {
//            inclusão da biblioteca para cadastrar observação itbi
            require_once '../funcaoPHP/funcao_retorna_observacao_itbi.php';

            $obs_Itbi_Letra_Maiscula = "ESTORNO DO PAGAMENTO REALIZADO POR : ";

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
            window.alert("<?php echo "ESTORNO PAGAMENTO EFETUADO COM SUCESSO !!!"; ?> ");
            location.href = "../../../EstornoPagamentoItbi.php";
        </script>

        <?php
//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../EstornoPagamentoItbi.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>