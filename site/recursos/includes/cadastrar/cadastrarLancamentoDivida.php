<?php
//valido a sessão do usuário
include_once '../estrutura/controle/validarSessao.php';



//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();


// variaves serão preenchidas por valores do formulario
// // valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto
    if (strlen($_POST['txt_inscricao']) === 6 || is_int($_POST['txt_inscricao']) === TRUE) {
        $txt_inscricao = $_POST['txt_inscricao'];
    } else {
        $array_erros['txt_inscricao'] = 'POR FAVOR ENTRE COM INSCRIÇÃO VÁLIDA \n';
    }


// filtro pra validar Proprietário (não ter nenhum sql_injection)
    if (strlen($_POST['txt_descricao']) > 2) {
        $descricao = preg_replace("/[^a-zA-Z0-9ãÃáÁàÀâÂéÉèÈêÊíÍìÌîÎõÕóÓòÒôÔúÚùÙûÛçÇ@ ]/", "", $_POST['txt_descricao']);
    } else {
        $array_erros['txt_descricao'] = 'POR FAVOR ENTRE COM UM PROPRIETÁRIO VÁLIDO \n';
    }


// verifico se o tamanho do campo é cod MOEDA
    if (strlen($_POST['txt_cod_moeda']) === 2 || is_int($_POST['txt_cod_moeda']) === TRUE) {
        $txt_cod_moeda = $_POST['txt_cod_moeda'];
    } else {
        $array_erros['txt_cod_moeda'] = 'POR FAVOR ENTRE COM INSCRIÇÃO VÁLIDA \n';
    }

//  filtro pra validar Nome da Moeda (não ter nenhum sql_injection)
    if (strlen($_POST['txt_descricao_moeda']) > 2) {
        $txt_descricao_moeda = preg_replace("/[^a-zA-Z0-9ãÃáÁàÀâÂéÉèÈêÊíÍìÌîÎõÕóÓòÒôÔúÚùÙûÛçÇ@ ]/", "", $_POST['txt_descricao_moeda']);
    } else {
        $array_erros['txt_descricao_moeda'] = 'POR FAVOR ENTRE COM UM DESCRIÇÃO MOEDA VÁLIDA \n';
    }

//  verifico se o tamanho do campo é cod DIVIDA
    if (strlen($_POST['txt_cod_divida']) === 2 || is_int($_POST['txt_cod_divida']) === TRUE) {
        $txt_cod_divida = $_POST['txt_cod_divida'];
    } else {
        $array_erros['txt_cod_divida'] = 'POR FAVOR ENTRE COM CODIGO DA DIVIDA VALIDA \n';
    }

//  filtro pra validar Nome da DIVIDA (não ter nenhum sql_injection)
    if (strlen($_POST['txt_descricao_div']) > 2) {
        $txt_descricao_div = preg_replace("/[^a-zA-Z0-9ãÃáÁàÀâÂéÉèÈêÊíÍìÌîÎõÕóÓòÒôÔúÚùÙûÛçÇ@ ]/", "", $_POST['txt_descricao_div']);
    } else {
        $array_erros['txt_descricao_div'] = 'POR FAVOR ENTRE COM UM DESCRIÇÃO MOEDA VÁLIDA \n';
    }

//  verifico se o tamanho do campo é cod DIVIDA
    if (strlen($_POST['txt_cod_sit_divida']) === 2 || is_int($_POST['txt_cod_sit_divida']) === TRUE) {
        $txt_cod_sit_divida = $_POST['txt_cod_sit_divida'];
    } else {
        $array_erros['txt_cod_sit_divida'] = 'POR FAVOR ENTRE COM CODIGO DA DIVIDA VALIDA \n';
    }

//  filtro pra validar Nome da DIVIDA (não ter nenhum sql_injection)
    if (strlen($_POST['txt_descricao_sit_div']) > 2) {
        $txt_descricao_sit_div = preg_replace("/[^a-zA-Z0-9ãÃáÁàÀâÂéÉèÈêÊíÍìÌîÎõÕóÓòÒôÔúÚùÙûÛçÇ@ ]/", "", $_POST['txt_descricao_sit_div']);
    } else {
        $array_erros['txt_descricao_sit_div'] = 'POR FAVOR ENTRE COM UM DESCRIÇÃO MOEDA VÁLIDA \n';
    }

    //  verifico se o tamanho do campo é cod DIVIDA
    if (strlen($_POST['txt_sub_divida']) === 2 || is_int($_POST['txt_sub_divida']) === TRUE) {
        $txt_sub_divida = $_POST['txt_sub_divida'];
    } else {
        $array_erros['txt_sub_divida'] = 'POR FAVOR ENTRE COM CODIGO DA SUB DIVIDA VALIDA \n';
    }

    //  verifico se o tamanho do campo é cod DIVIDA
    if (strlen($_POST['txt_ano']) === 4 || is_int($_POST['txt_ano']) === TRUE) {
        $txt_ano = $_POST['txt_ano'];
    } else {
        $array_erros['txt_ano'] = 'POR FAVOR ENTRE COM CODIGO DA SUB DIVIDA VALIDA \n';
    }


    //  verifico se o tamanho do campo é cod DIVIDA
    if (strlen($_POST['txt_parc_ini']) === 2 || is_int($_POST['txt_parc_ini']) === TRUE) {
        $txt_parc_ini = $_POST['txt_parc_ini'];
    } else {
        $array_erros['txt_parc_ini'] = 'POR FAVOR ENTRE COM CODIGO DA SUB DIVIDA VALIDA \n';
    }

    //  verifico se o tamanho do campo é cod DIVIDA
    if (strlen($_POST['txt_qtd_parc']) === 2 || is_int($_POST['txt_qtd_parc']) === TRUE) {
        $txt_qtd_parc = $_POST['txt_qtd_parc'];
    } else {
        $array_erros['txt_qtd_parc'] = 'POR FAVOR ENTRE COM CODIGO DA SUB DIVIDA VALIDA \n';
    }


    //  verifico se o tamanho do campo é cod DIVIDA
    if (strlen($_POST['txt_parc_atual']) === 2 || is_int($_POST['txt_parc_atual']) === TRUE) {
        $txt_parc_atual = $_POST['txt_parc_atual'];
    } else {
        $array_erros['txt_parc_atual'] = 'POR FAVOR ENTRE COM CODIGO DA SUB DIVIDA VALIDA \n';
    }


// verifico se tem erro na validação
    if (empty($array_erros)) {

//  biblioteca para converter data   
        include_once '../funcaoPHP/funcaoData.php';

//    biblioteca pra converte dinheiro
        include_once '../funcaoPHP/funcaoDinheiro.php';

//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
        $pdo->beginTransaction();

        for ($i = 0; $i < $txt_qtd_parc; $i++) {
            $parcela = $_POST['parcela'][$i];
            $parcela_vencimento = dataAmericano($_POST['parcela_vencimento'][$i]);
            $parcela_valor = inserirDinheiro($_POST['parcela_valor'][$i]);
            $parcela_observacao = $_POST['parcela_observacao'][$i];


            $sql = "INSERT INTO financeiro_imob (inscricao_imob, ano_divida, cod_divida, sub_divida, cod_tipo_moeda, parcela, vencimento, valor, cod_situacao_divida , tem_composicao)";
            $sql = $sql . "VALUES ";
            $sql = $sql . "('$txt_inscricao', '$txt_ano', '$txt_cod_divida', '$txt_sub_divida', '$txt_cod_moeda', '$parcela', '$parcela_vencimento', '$parcela_valor', '$txt_cod_sit_divida', 'N')";

//      execução com comando sql    
            $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
            if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
                die('<script>window.alert("Erro ao Cadastrar  !!!");location.href = "../../../TabelaBairro.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
            } else {

//      Cadastro a observação referente a dívida

                $sql_obs = "INSERT INTO Observacao_Financ (cod_cadastro, Inscricao, ano_divida, cod_divida, Sub_divida, Parcela, Observacao)";
                $sql_obs = $sql_obs . " VALUES ";
                $sql_obs = $sql_obs . "('1','$txt_inscricao','$txt_ano', '$txt_cod_divida', '$txt_sub_divida', '$parcela', '$parcela_observacao'  )";


                //      execução com comando sql    
                $executa1 = $pdo->query($sql_obs);


//      Verifico se comando foi realizado  
                if (!$executa1) {
                    die('<script>window.alert("Erro ao Cadastrar  !!!"); location.href = "../../../LancamentoDivida.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
                }



                $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
                $pdo = null;
            }
        }
        //  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../TabelaBairro.php";
        </script>';
    }
    ?>


    <script>
        window.alert("<?php echo "Lançamento Realizado com Sucesso !!!"; ?> ");
        location.href = "../../../LancamentoDivida.php";
    </script>

    <?php
} else {

    print "ACESSO NEGADO";
}
?>