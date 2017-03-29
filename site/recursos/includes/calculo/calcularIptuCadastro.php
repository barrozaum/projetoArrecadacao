<?php
include_once '../estrutura/controle/validarSessao.php';
include_once '../estrutura/conexao/conexao.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
include_once '../funcaoPHP/funcao_dados_imovel.php';
include_once '../funcaoPHP/funcao_valor_para_iptu.php';
include_once './funcao_calculo.php';
set_time_limit(0);
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Arrecadação</title>

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="../../css/bootstrap.css" rel="stylesheet">
        <link href="../../css/menu.css" rel="stylesheet">

        <!--[if lt IE 9]>
          <script src="html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="../../js/jquery.min.js"></script>
        <script src="../../js/bootstrap.min.js"></script>

    </head>
    <body>
        <div class="container text center">

            <div class="mainbox col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
                <div class="well"><!-- div que coloca a cor no formulário -->
                    <div class="panel panel-default">
                        <!-- INICIO Dados do imóvel -->
                        <div class="panel-heading text-center">IDENTIFICAÇÃO DO LANÇAMENTO DO IPTU</div>
                        <div class="panel-body">
                            <?php
//inscricao
                             $inscricao_inicial = $_POST['insc_inicial'];
                             $inscricao_final = $_POST['insc_inicial'];
//anos da divida
                             $ano_inicial = $_POST['ano_inicial'];
                             $ano_final = $_POST['ano_final'];

                            $quantidade_de_parcelas = 6;


                            $pdo->beginTransaction();

                            $msg = "<table class='table table-striped table-hover'>";
                            $msg = $msg . "<tr>";
                            $msg = $msg . "<td>Inscrição </td>";
                            $msg = $msg . "<td>Ano</td>";
                            $msg = $msg . "<td>Mensagem</td>";
                            $msg = $msg . "</tr>";

                            for ($inscricao_atual = $inscricao_inicial; $inscricao_atual <= $inscricao_final; $inscricao_atual++) {
                                $inscricao_atual = str_pad($inscricao_atual, 6, 0, STR_PAD_LEFT);
                                fun_retorna_dados_imovel_para_formulario_calculo_iptu($pdo, $inscricao_atual);
//                                print "PROPRIETÁRIO    = " . $_SESSION['SESSION_PROPIETARIO'] . '<br />';

                                $valor_desconto_industria = desconto_industria($pdo, $inscricao_atual, $_SESSION['SESSION_TEM_DESCONTO_INDUSTRIA']);
//                                print "DESCONTO INDUSTRIA    = " . $valor_desconto_industria;
//                                echo "<hr />";

                                $valor_metro_quadrado_terreno = mostrarDinheiro4Casas(valor_metro_terreno($pdo, $_SESSION['SESSION_ZONA_IMOVEL'], $_SESSION['SESSION_SITUACAO']));
//                                print "VALOR M² TERR. = " . $valor_metro_quadrado_terreno . '<br />';
                                $valor_metro_quadrado_construcao = mostrarDinheiro4Casas(valor_metro_construcao($pdo, $_SESSION['SESSION_ZONA_IMOVEL'], $_SESSION['SESSION_UTILIZACAO'], $_SESSION['SESSION_CATEGORIA']));
//                                print "VALOR M² CONST. = " . $valor_metro_quadrado_construcao . '<br />';
//                                echo "<hr />";

                                $valor_venal_territorial = valor_venal_terreno($valor_metro_quadrado_terreno, $_SESSION['SESSION_AREA_TERRENO']);
//                                print "VENAL TERRITORIAL = " . $valor_venal_territorial . '<br />';

                                $valor_venal_predial = valor_venal_construcao($valor_metro_quadrado_construcao, $_SESSION['SESSION_AREA_CONSTRUIDA']);
//                                print "VENAL PREDIAL = " . $valor_venal_predial . '<br />';
//                                echo "<hr />";

                                $taxa_coleta_de_lixo_sem_desconto = valor_taxa_coleta_lixo($pdo, $_SESSION['SESSION_COD_TIPO_COLETA']);
//                                print "VALOR TCL : = " . $taxa_coleta_de_lixo_sem_desconto . '<br />';
                                $taxa_coleta_de_lixo_com_desconto = aplicar_desconto($taxa_coleta_de_lixo_sem_desconto, $valor_desconto_industria, $_SESSION['SESSION_TEM_DESCONTO_INDUSTRIA']);
//                                print "VALOR TCL DESCONTO: = " . $taxa_coleta_de_lixo_com_desconto . '<br />';
//                                echo "<hr />";

                                $valor_te = 0;
                                $valor_tip = 0;
//                                echo "<hr />";

                                $valor_tem_manutencao_esgoto_sem_desconto = tem_manutencao_esgoto($_SESSION['SESSION_TEM_MANUTENCAO_ESGOTO']);
//                                print "VALOR TEM : = " . $valor_tem_manutencao_esgoto_sem_desconto . '<br />';

                                $valor_tem_manutencao_esgoto_com_desconto = aplicar_desconto($valor_tem_manutencao_esgoto_sem_desconto, $valor_desconto_industria, $_SESSION['SESSION_TEM_DESCONTO_INDUSTRIA']);
//                                print "VALOR TEM DESCONTO : = " . $valor_tem_manutencao_esgoto_com_desconto . '<br />';
//                                echo "<hr />";

                                $valor_taxas_sem_desconto = valor_taxas_total($taxa_coleta_de_lixo_sem_desconto, $valor_tem_manutencao_esgoto_sem_desconto, $valor_te, $valor_tip);
//                                print "VALOR TAXAS : = " . $valor_taxas_sem_desconto . '<br >';

                                $valor_taxas_com_desconto = valor_taxas_total($taxa_coleta_de_lixo_com_desconto, $valor_tem_manutencao_esgoto_com_desconto, $valor_te, $valor_tip);
//                                print "VALOR TAXAS DESCONTO: = " . $valor_taxas_com_desconto . '<br >';
//                                echo "<hr />";

                                $valor_iptu_em_ufir_sem_desconto = valor_iptu_ufir($valor_venal_territorial, $valor_venal_predial, $_SESSION['SESSION_TIPO_ISENCAO']);
//                                print "VALOR IPTU UFIR : = " . $valor_iptu_em_ufir_sem_desconto . '<br />';

                                $valor_iptu_em_ufir_com_desconto = aplicar_desconto($valor_iptu_em_ufir_sem_desconto, $valor_desconto_industria, $_SESSION['SESSION_TEM_DESCONTO_INDUSTRIA']);
//                                print "VALOR IPTU UFIR DESCONTO: = " . $valor_iptu_em_ufir_com_desconto . '<br />';
//                                echo "<hr />";


                                $valor_iptu_total_ufir_sem_desconto = valor_iptu_total_ufir($valor_iptu_em_ufir_sem_desconto, $valor_taxas_sem_desconto);
//                                print "VALOR IPTU UFIR : = " . $valor_iptu_total_ufir_sem_desconto . '<br />';

                                $valor_iptu_total_ufir_com_desconto = valor_iptu_total_ufir($valor_iptu_em_ufir_com_desconto, $valor_taxas_com_desconto);
//                                print "VALOR IPTU UFIR DESCONTO: = " . $valor_iptu_total_ufir_com_desconto . '<br />';
//                                echo "<hr /><hr />";


                                for ($ano_atual = $ano_inicial; $ano_atual <= $ano_final; $ano_atual++) {
                                    if (busca_divida_ano($pdo, $inscricao_atual, $ano_atual) == 1) {
                                        $msg = $msg . "<tr>";
                                        $msg = $msg . "<td> " . $inscricao_atual . "</td>";
                                        $msg = $msg . "<td> " . $ano_atual . "</td>";
                                        $msg = $msg . "<td> MOTIVO PARCELA PAGA OU CANCELADA !!! </td>";
                                        $msg = $msg . "</tr>";
                                        continue;
                                    } else {
                                        limpar_divida_do_ano($pdo, $inscricao_atual, $ano_atual);
                                        cadastrar_divida_ano($pdo, $inscricao_atual, $ano_atual, $valor_iptu_total_ufir_sem_desconto, $valor_desconto_industria);

                                        $msg = $msg . "<tr>";
                                        $msg = $msg . "<td> " . $inscricao_atual . "</td>";
                                        $msg = $msg . "<td> " . $ano_atual . "</td>";
                                        $msg = $msg . "<td> IPTU LANÇADO COM SUCESSO !!! </td>";
                                        $msg = $msg . "</tr>";
                                    }
                                }
                            }
                            $msg = $msg . "</table>";
                            $pdo->commit();

                            print $msg;


//                            limpando as variaveis utilizadas em sessão
                            unset($_SESSION['SESSION_INSCRICAO_VALIDA']);
                            unset($_SESSION['SESSION_ZONA_IMOVEL']);
                            unset($_SESSION['SESSION_SITUACAO']);
                            unset($_SESSION['SESSION_UTILIZACAO']);
                            unset($_SESSION['SESSION_CATEGORIA']);
                            unset($_SESSION['SESSION_AREA_TERRENO']);
                            unset($_SESSION['SESSION_AREA_CONSTRUIDA']);
                            unset($_SESSION['SESSION_COD_TIPO_COLETA']);
                            unset($_SESSION['SESSION_TEM_MANUTENCAO_ESGOTO']);
                            unset($_SESSION['SESSION_TIPO_ISENCAO']);
                            unset($_SESSION['SESSION_DESCONTO_INDUSTRIA']);
                            unset($_SESSION['SESSION_TIPO_IMPOSTO']);
                            unset($_SESSION['SESSION_PROPIETARIO']);
                            ?>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="button" class="btn btn-danger" onclick="location.href = '../../../CadastroImovel.php'">Sair</button>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>