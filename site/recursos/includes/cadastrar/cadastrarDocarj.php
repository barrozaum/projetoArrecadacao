<?php
//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//incluindo bibliotecas
    include_once '../funcaoPHP/function_letraMaiscula.php';
    include_once '../funcaoPHP/funcaoData.php';
    include_once '../funcaoPHP/funcaoDinheiro.php';
    include_once '../funcaoPHP/funcaoPessoaFisica_Juridica.php';
    include_once '../funcaoPHP/funcaoCpfCnpj.php';
    include_once '../funcaoPHP/funcao_docarj.php';


//ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();

//  validando campos
    if (!fun_aplica_validacao_campo($_POST['txt_numero_docarj'], 6, 6)) {
        $array_erros['txt_numero_docarj'] = "NUMERO DOCARJ INVÁLIDO !!! ";
    } else {
        $numero_docarj = letraMaiuscula($_POST['txt_numero_docarj']);
    }

    if (!fun_aplica_validacao_campo($_POST['txt_ano_docarj'], 4, 4)) {
        $array_erros['txt_ano_docarj'] = "ANO DOCARJ INVÁLIDO !!! ";
    } else {
        $ano_docarj = letraMaiuscula($_POST['txt_ano_docarj']);
    }

    $valor_total_docarj = inserirDinheiro(letraMaiuscula($_POST['txt_valor_docarj']));
    $codigo_atividade_docarj = letraMaiuscula($_POST['txt_atividade_Docarj']);


    if (!fun_aplica_validacao_campo($_POST['txt_descricao_atividade_Docarj'], 3, 100)) {
        $array_erros['txt_descricao_atividade_Docarj'] = "DESCRIÇÃO ATIVIDADE CONTRIBUINTE DOCARJ INVÁLIDO !!! ";
    } else {
        $descricao_atividade_docarj = letraMaiuscula($_POST['txt_descricao_atividade_Docarj']);
    }

    if (!fun_aplica_validacao_campo($_POST['txt_cadastro_contribuinte'], 1, 1)) {
        $array_erros['txt_cadastro_contribuinte'] = "CADASTRO DOCARJ INVÁLIDO !!!  ";
    } else {
        $cadastro_docarj = letraMaiuscula($_POST['txt_cadastro_contribuinte']);
    }

    $inscricao_contribuinte = letraMaiuscula($_POST['txt_inscricao_contribuinte']);


    if (!fun_aplica_validacao_campo($_POST['txt_nome_contribuinte'], 3, 50)) {
        $array_erros['txt_nome_contribuinte'] = "NOME CONTRIBUINTE DOCARJ INVÁLIDO !!!  ";
    } else {
        $nome_contribuinte_docarj = letraMaiuscula($_POST['txt_nome_contribuinte']);
    }


    if (!fun_aplica_validacao_campo($_POST['txt_cpf_cnpj'], 13, 19)) {
        $array_erros['txt_cpf_cnpj'] = "CPF_CNPJ CONTRIBUINTE DOCARJ INVÁLIDO !!! ";
    } else {
        $cpf_cnpj_contribuinte_docarj = FUN_TIRAR_MASCARA_CPF_CNPJ(letraMaiuscula($_POST['txt_cpf_cnpj']));
    }

    if (!fun_aplica_validacao_campo($_POST['txt_tipo_pessoa'], 5, 9)) {
        $array_erros['txt_tipo_pessoa'] = "TIPO PESSOA CONTRIBUINTE DOCARJ INVÁLIDO  !!! ";
    } else {
        $tipo_pessoa_contribuinte_docarj = FUN_INSERIR_TIPO_PESSOA(letraMaiuscula($_POST['txt_tipo_pessoa']));
    }

    if (!fun_aplica_validacao_campo($_POST['txt_telefone'], 10, 11)) {
        $array_erros['txt_telefone'] = "TELEFONE CONTRIBUINTE DOCARJ INVÁLIDO  !!! ";
    } else {
        $telefone = letraMaiuscula($_POST['txt_telefone']);
    }

    if (!fun_aplica_validacao_campo($_POST['txt_cep'], 8, 8)) {
        $array_erros['txt_cep'] = "CEP CONTRIBUINTE DOCARJ INVÁLIDO  !!! ";
    } else {
        $cep = letraMaiuscula($_POST['txt_cep']);
    }

    $rua = letraMaiuscula($_POST['txt_rua']);
    $bairro = letraMaiuscula($_POST['txt_bairro']);
    $cidade = letraMaiuscula($_POST['txt_cidade']);
    $uf = letraMaiuscula($_POST['txt_uf']);
    $numero_endereco = letraMaiuscula($_POST['txt_numero_endereco']);
    $complemento_endereco = letraMaiuscula($_POST['txt_complemento_endereco']);

//VERIFICA SE EXISTE RECEITA NO DOCARJ
    $receita_1 = letraMaiuscula($_POST['txt_receita_1']);
    $valor_1 = inserirDinheiro(letraMaiuscula($_POST['txt_valor_1']));
    $obs_1 = letraMaiuscula($_POST['txt_obs_1']);

    $receita_2 = letraMaiuscula($_POST['txt_receita_2']);
    $valor_2 = inserirDinheiro(letraMaiuscula($_POST['txt_valor_2']));
    $obs_2 = letraMaiuscula($_POST['txt_obs_2']);

    $receita_3 = letraMaiuscula($_POST['txt_receita_3']);
    $valor_3 = inserirDinheiro(letraMaiuscula($_POST['txt_valor_3']));
    $obs_3 = letraMaiuscula($_POST['txt_obs_3']);

    $receita_4 = letraMaiuscula($_POST['txt_receita_4']);
    $valor_4 = inserirDinheiro(letraMaiuscula($_POST['txt_valor_4']));
    $obs_4 = letraMaiuscula($_POST['txt_obs_4']);

    if ($receita_1 == "" && $receita_2 == "" && $receita_3 == "" && $receita_4 == "") {
        $array_erros['txt_receitas'] = "RECEITA DOCARJ INVÁLIDO !!! ";
    }



// VERIFICAR SE A RECEITA EXISTE E SE TEM O VALOR
    if ($receita_1 !== "" && strlen($valor_1) < 3) {
        $array_erros['txt_valo1_1'] = "VALOR RECEITA 1 DOCARJ INVÁLIDO !!! ";
    }
    if ($receita_2 !== "" && strlen($valor_2) < 3) {
        $array_erros['txt_valo1_2'] = "VALOR RECEITA 2 DOCARJ INVÁLIDO !!! ";
    }
    if ($receita_3 !== "" && strlen($valor_3) < 3) {
        $array_erros['txt_valo1_3'] = "VALOR RECEITA 3 DOCARJ INVÁLIDO !!! ";
    }
    if ($receita_4 !== "" && strlen($valor_4) < 3) {
        $array_erros['txt_valo1_4'] = "VALOR RECEITA 4 DOCARJ INVÁLIDO !!! ";
    }

    if (!fun_aplica_validacao_campo($_POST['txt_taxa_expediente'], 3, 11)) {
        $array_erros['txt_taxa_expediente'] = "TAXA EXPEDIENTE INVÁLIDO  !!! ";
    } else {
        $taxa_expediente = inserirDinheiro(letraMaiuscula($_POST['txt_taxa_expediente']));
    }

    if (!fun_aplica_validacao_campo($_POST['txt_multas'], 3, 11)) {
        $array_erros['txt_multas'] = "MULTA INVÁLIDA  !!! ";
    } else {
        $multas = inserirDinheiro(letraMaiuscula($_POST['txt_multas']));
    }

    if (!fun_aplica_validacao_campo($_POST['txt_juros'], 3, 11)) {
        $array_erros['txt_juros'] = "JUROS INVÁLIDO !!! ";
    } else {
        $juros = inserirDinheiro(letraMaiuscula($_POST['txt_juros']));
    }


    if (fun_aplica_validacao_campo($_POST['txt_quantidade_parcelas'], 2, 2)) {
        $qtd_parcelas = letraMaiuscula($_POST['txt_quantidade_parcelas']);
    } else {
        $array_erros['txt_quantidade_parcelas'] = "QUANTIDADE PARCELA INVÁLIDA!!! ";
    }

    if (fun_aplica_validacao_campo($_POST['txt_parcela_inicial'], 2, 2)) {
        $parcela_inicial = letraMaiuscula($_POST['txt_parcela_inicial']);
    } else {
        $array_erros['txt_parcela_inicial'] = "PARCELA INICIAL INVÁLIDA !!! ";
    }

    if (validar_estrutura_data($_POST['txt_vencimento'])) {
        $vencimento = letraMaiuscula($_POST['txt_vencimento']);
    } else {
        $array_erros['txt_vencimento'] = "VENCIMENTO INVÁLIDO !!! ";
    }

    if (fun_aplica_validacao_campo($_POST['txt_auto_infracao'], 3, 50)) {
        $auto_infracao = letraMaiuscula($_POST['txt_auto_infracao']);
    } else {
        $array_erros['txt_auto_infracao'] = "AUTO INFRAÇÃO INVÁLIDO !!! ";
    }

    $numero_processo = letraMaiuscula($_POST['txt_numero_processo']);
    $ano_processo = letraMaiuscula($_POST['txt_ano_processo']);




//verificando se existe erro de validacao
    if (empty($array_erros)) {

        try {
//      Conexao com o banco de dados  
            include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
            $pdo->beginTransaction();


//      Comando sql a ser executado  
            $sql = "INSERT INTO Dam";
            $sql = $sql . "(";
            $sql = $sql . " Num_Dam, Ano_Dam, ";
            $sql = $sql . " Nome_Contribuinte, Tipo_Pessoa, CPF_CGC, Telefone, ";
            $sql = $sql . " CEP, Logradouro, Numero, Complemento, Bairro, Cidade, uf, ";
            $sql = $sql . " Cod_Cadastro, Inscricao, Cod_Atividade, Desc_Atividade, ";
            $sql = $sql . " Auto_Infracao, Num_processo, Ano_processo,";
            $sql = $sql . " Receita_1, Valor_1, Obs_1, ";
            $sql = $sql . " Receita_2, Valor_2, Obs_2, ";
            $sql = $sql . " Receita_3, Valor_3, Obs_3,";
            $sql = $sql . " Receita_4, Valor_4, Obs_4, ";
            $sql = $sql . " Taxa_Expediente, Multa, Juros, Total";
            $sql = $sql . " )";
            $sql = $sql . " values ";
            $sql = $sql . "('$numero_docarj', '$ano_docarj',";
            $sql = $sql . " '$nome_contribuinte_docarj', '$tipo_pessoa_contribuinte_docarj', '$cpf_cnpj_contribuinte_docarj', '$telefone',";
            $sql = $sql . " '$cep', '$rua', '$numero_endereco', '$complemento_endereco', '$bairro', '$cidade', '$uf', ";
            $sql = $sql . " '$cadastro_docarj', '$inscricao_contribuinte', '$codigo_atividade_docarj', '$descricao_atividade_docarj', ";
            $sql = $sql . " '$auto_infracao', '$numero_processo', '$ano_processo', ";
            $sql = $sql . " '$receita_1', '$valor_1', '$obs_1', ";
            $sql = $sql . " '$receita_2', '$valor_2', '$obs_2', ";
            $sql = $sql . " '$receita_3', '$valor_3', '$obs_3', ";
            $sql = $sql . " '$receita_4', '$valor_4', '$obs_4', ";
            $sql = $sql . " '$taxa_expediente', '$multas', '$juros', '$valor_total_docarj' ";
            $sql = $sql . " )";


//      execução com comando sql    
            $executa1 = $pdo->query($sql);

//      Verifico se comando foi realizado      
            if (!$executa1) {
//          Caso tenha errro 
//          lanço erro na tela
                die('<script>window.alert("Erro ao Cadastrar  !!!");location.href = "../../../CadastroDocarj.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
            } else {

//            função no arquivo funcao_docarj
                if (FUNC_INSERIR_FINANCEIRO_DOCARJ($pdo, $numero_docarj, $ano_docarj, $qtd_parcelas, $parcela_inicial, $vencimento, $valor_total_docarj)) {

//              comparação para saber se o numero do docarj é menor do que o valor do proximo docarj
                    if (comparaNumeroDocarj($pdo) < $numero_docarj) {

//              se o numero do docarj que estou cadastrando for maior que o da
//              tabela sisparametros eu realizo update da tabela pra o proximo numero
//              comando sql update da tabela sisparametros
                        $sql_update = "UPDATE sisparametros SET Num_Dam = '$numero_docarj', Ano_Dam = '$ano_docarj'";

//                  executo comando sql
                        $executa_update = $pdo->query($sql_update);
                        if (!$sql_update) {
//                     caso algum erro ocorra volta estado anterior
                            $pdo->rollback();
                            die('<script>window.alert("Erro ao Cadastrar  !!!");location.href = "../../../CadastroDocarj.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
                        }
                    }

//                if (FUNC_INSERIR_FINANCEIRO_DOCARJ)
                } else {
                    die('<script>window.alert("Erro ao Cadastrar  !!!");location.href = "../../../CadastroDocarj.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
                }
//            salvo no banco de dados
                $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
            }
//        fecho conexao
            $pdo = null;
            
//            variaveis de sessao para o boleto
             $_SESSION['IMPRIMIR_GUIA_DOCARJ'] = "sim";
            $_SESSION['NUMERO_DOCARJ'] = $numero_docarj;
            $_SESSION['ANO_DOCARJ'] = $ano_docarj;
            $_SESSION['QTD_PARCELA'] = $qtd_parcelas;
            $_SESSION['PARCELA_INICIAL'] = $parcela_inicial;
            $_SESSION['VENCIMENTO'] = $vencimento;
            $_SESSION['NOME_CONTRIBUINTE'] = $nome_contribuinte_docarj;
            $_SESSION['TIPO_PESSOA'] = $tipo_pessoa_contribuinte_docarj;
            $_SESSION['CPF_CNPJ'] = $cpf_cnpj_contribuinte_docarj;
            $_SESSION['LOGRADOURO'] = $rua;
            $_SESSION['NUMERO_ENDERECO'] = $numero_endereco;
            $_SESSION['COMPLEMENTO'] = $complemento_endereco;
            $_SESSION['BAIRRO'] = $bairro;
            $_SESSION['CEP'] = $cep;
            $_SESSION['CIDADE'] = $cidade;
            $_SESSION['UF'] = $uf;
            $_SESSION['CADASTRO_RECEITAS'] = $cadastro_docarj;
            $_SESSION['RECEITA1'] = $receita_1;
            $_SESSION['VALOR1'] = $valor_1;
            $_SESSION['OBS1'] = $obs_1;
            $_SESSION['RECEITA2'] = $receita_2;
            $_SESSION['VALOR2'] = $valor_2;
            $_SESSION['OBS2'] = $obs_2;
            $_SESSION['RECEITA3'] = $receita_3;
            $_SESSION['VALOR3'] = $valor_3;
            $_SESSION['OBS3'] = $obs_3;
            $_SESSION['RECEITA4'] = $receita_4;
            $_SESSION['VALOR4'] = $valor_4;
            $_SESSION['OBS4'] = $obs_4;
            $_SESSION['VALOR_DOCARJ'] = $valor_total_docarj;
           
            ?>
            <!-- Dispara mensagem de sucesso -->
            <script>
            window.alert("<?php echo "Docarj Cadastrado com Sucesso !!!"; ?> ");
            window.open('../guias/boleto_docarj.php', "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=0,width=auto,height=auto");
            location.href = "../../../CadastroDocarj.php";
            </script>

            <?php
        } catch (Exception $e) {
            echo '<script>window.alert("' . $e->getMessage() . '");
//               location.href = "../../../CadastroDocarj.php";
        </script>';
        }
        //  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../CadastroDocarj.php";
        </script>';
    }

// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}

//    função para retornar o proximo numero de docarj no sistema
function comparaNumeroDocarj($pdo) {
    $sql3 = "SELECT Num_Dam, Ano_Dam FROM sisparametros";
    $query1 = $pdo->prepare($sql3);
    //executo o comando sql
    $query1->execute();
    if (($dados1 = $query1->fetch()) == true) {
        return $dados1['Num_Dam'];
    } else {
        return "";
    }
}
?>