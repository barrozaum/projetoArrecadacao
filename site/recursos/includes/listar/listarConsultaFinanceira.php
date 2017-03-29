<?php
include_once '../estrutura/controle/validarSessao.php';
include_once '../estrutura/conexao/conexao.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
include_once '../funcaoPHP/funcao_calcular_juros_multa.php';
?>
<?php
if ($_POST['id'] == 1) {
    consultaFinanceiraImovel($pdo);
    die();
}
if ($_POST['id'] == 2) {
    consultaTaxasImovel($pdo);
    die();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Arrecadação</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>

        <?php

        function consultaFinanceiraImovel($pdo) {
            $valor_Vencido = 0.00;
            $valor_a_Vencer = 0.00;
            $valor_Total = 0.00;
            $ano_corrente = date('Y');
            $moeda_do_dia = moeda($pdo);

            $inscricao = $_POST['inscricao'];
            $proprietario = $_POST['proprietario'];
            $cod_divida = $_POST['cod_divida'];
            $desc_cod_divida = $_POST['desc_cod_divida'];
            $sub_divida = $_POST['sub_divida'];
            $ano_inicial = $_POST['ano_inicial'];
            $ano_final = $_POST['ano_final'];


            $sql = "SELECT  f.*, p.data_pagamento,  p.valor_pagamento,  p.cod_banco, ";
            $sql = $sql . " p.lote, c.cod_motivo_cancelamento, c.data_cancelamento, d.desc_divida, ";
            $sql = $sql . " s.desc_situacao_divida, DA.*, Obs.Observacao ";
            $sql = $sql . " FROM  financeiro_imob f, pagamentos_imob p, cancelamentos_imob c, ";
            $sql = $sql . " divida_imob d, situacao_divida s, divida_ativa_imob DA,";
            $sql = $sql . " Observacao_Financ Obs ";
            $sql = $sql . " WHERE ";
            $sql = $sql . " f.inscricao_imob *= c.inscricao_imob and  ";
            $sql = $sql . " f.ano_divida *= c.ano_divida and  ";
            $sql = $sql . " f.cod_divida *= c.cod_divida and  ";
            $sql = $sql . " f.sub_divida *= c.sub_divida and  ";
            $sql = $sql . " f.parcela    *= c.parcela and  ";
            $sql = $sql . " f.inscricao_imob *= p.inscricao_imob and  ";
            $sql = $sql . " f.ano_divida *= p.ano_divida and  ";
            $sql = $sql . " f.cod_divida *= p.cod_divida and  ";
            $sql = $sql . " f.sub_divida *= p.sub_divida and ";
            $sql = $sql . " f.parcela *= p.parcela and ";
            $sql = $sql . " f.cod_divida = d.cod_divida_imob and  ";
            $sql = $sql . " f.cod_situacao_divida = s.cod_situacao_divida and  ";
            $sql = $sql . " f.inscricao_imob *= DA.inscricao_imob_ativa and  ";
            $sql = $sql . " f.ano_divida *= DA.ano_divida_ativa and  ";
            $sql = $sql . " f.cod_divida *= DA.cod_divida_ativa and  ";
            $sql = $sql . " f.sub_divida *= DA.sub_divida_ativa and  ";
            $sql = $sql . " f.parcela *= DA.parcela_ativa and  ";
            $sql = $sql . " Obs.Cod_Cadastro = '1' and ";
            $sql = $sql . " f.inscricao_imob *= Obs.inscricao and  ";
            $sql = $sql . " f.ano_divida     *= Obs.ano_divida and ";
            $sql = $sql . " f.cod_divida     *= Obs.cod_divida and ";
            $sql = $sql . " f.sub_divida     *= Obs.sub_divida and ";
            $sql = $sql . " f.parcela        *= Obs.parcela  and ";
            if ($cod_divida > '00') {
                $sql = $sql . " f.cod_divida = '" . $cod_divida . "' and";
            }
            if ($_POST['dividas_ajuizada'] == "true") {
                $sql = $sql . "(f.cod_situacao_divida='03' or f.cod_situacao_divida='06' or f.cod_situacao_divida='09' or f.cod_divida='18') AND";
            }
            if ($_POST['dividas_nao_ajuizada'] == "true") {
                $sql = $sql . "(f.cod_situacao_divida<>'03' and f.cod_situacao_divida<>'06' and f.cod_situacao_divida<>'09' and f.cod_divida<>'18') AND";
            }
            if ($_POST['dividas_aberta'] == "true") {
                $sql = $sql . "(f.cod_situacao_divida='01' or f.cod_situacao_divida='02' or f.cod_situacao_divida='03') AND";
            }

            if ($ano_inicial != "") {
                $sql = $sql . " f.ano_divida >= '$ano_inicial' and";
            }
            if ($ano_final != "") {
                $sql = $sql . " f.ano_divida <= '$ano_final' and";
            }



            $sql = $sql . " f.inscricao_imob= '" . $inscricao . "'  ";

            $query = $pdo->prepare($sql);
            //executo o comando sql
            $query->execute();

            for ($i = 0; $dados = $query->fetch(); $i++) {
                $retorna_ano_divida[$i] = $dados['ano_divida'];
                $retorna_cod_divida[$i] = $dados['cod_divida'];
                $retorna_desc_divida[$i] = $dados['desc_divida'];
                $retorna_sub_divida[$i] = $dados['sub_divida'];
                $retorna_cod_tipo_moeda[$i] = $dados['cod_tipo_moeda'];
                $retorna_parcela[$i] = $dados['parcela'];
                $retorna_q_p_a[$i] = $dados['qtde_parc_agrupada'];
                $retorna_vencimento[$i] = dataBrasileiro($dados['vencimento']);
                $retorna_valor[$i] = mostrarDinheiro4Casas($dados['valor']);
                $retorna_cod_sit_divida[$i] = $dados['cod_situacao_divida'];
                $retorna_desc_sit_divida[$i] = $dados['desc_situacao_divida'];
                $retorna_valor_pagamento[$i] = mostrarDinheiro4Casas($dados['valor_pagamento']);
                $retorna_cod_banco[$i] = $dados['cod_banco'];
                $retorna_lote[$i] = $dados['lote'];
                $retorna_data_pagamento[$i] = dataBrasileiro($dados['data_pagamento']);
                $retorna_num_termo_origem[$i] = $dados['num_termo_origem'];
                $retorna_ano_termo_origem[$i] = $dados['ano_termo_origem'];
                $retorna_num_termo_destino[$i] = $dados['num_termo_destino'];
                $retorna_ano_termo_destino[$i] = $dados['ano_termo_destino'];
                $retorna_data_cancelamento[$i] = dataBrasileiro($dados['data_cancelamento']);
                $retorna_motivo_cancelamento[$i] = retornaMotivoCancelamento($pdo, $dados['cod_motivo_cancelamento']);
                $retorna_Data_Inscricao_Ativa[$i] = dataBrasileiro($dados['Data_Inscricao_Ativa']);
                $retorna_Inscricao_Livro[$i] = $dados['Inscricao_Livro'];
                $retorna_Livro_Ativa[$i] = $dados['Livro_Ativa'];
                $retorna_Folha_Ativa[$i] = $dados['Folha_Ativa'];
                $retorna_Linha_Ativa[$i] = $dados['Linha_Ativa'];
                $retorna_Num_Certidao[$i] = $dados['Num_Certidao'];
                $retorna_Ano_Certidao[$i] = $dados['Ano_Certidao'];
                $retornaDadosAjuizados_Imob = explode("|", retornaAjuizados_imob($pdo, $dados['Num_Certidao'], $dados['Ano_Certidao']));
                $retorna_data_ajuizamento_Imob[$i] = $retornaDadosAjuizados_Imob[0];
                $retorna_num_processo_ajuizamento[$i] = $retornaDadosAjuizados_Imob[1];
                $retorna_valor_base[$i] = calcula_valor_base($dados['valor'], $moeda_do_dia, $dados['cod_situacao_divida']);
                $retorna_multa[$i] = calcula_multa($dados['cod_situacao_divida'], $dados['ano_divida'], $retorna_vencimento[$i], $retorna_valor_base[$i]);
                $retorna_juros[$i] = calcula_juros($dados['cod_situacao_divida'], $retorna_vencimento[$i], $retorna_valor_base[$i]);
                $retorna_valor_real[$i] = calcula_valor_total($retorna_valor_base[$i], $retorna_multa[$i], $retorna_juros[$i]);
                $retorna_observacao[$i] = $dados['Observacao'];

//                comparo a ano da divida com o ano atual
//                se ano da divida menor que ano atula
                if ($retorna_ano_divida[$i] < $ano_corrente) {
                    $valor_Vencido = $valor_Vencido + $retorna_valor_real[$i];
                } else {
//                    dia atual (data)
                $data_corrente = date('d/m/Y');
                       
//                     compara qual data é maior
//                      caso data do vencimento menor ou igual data corrente retorna 1
//                      caso data do vencimento maior que a data corrente retorna 0
                
           
                    if (compara_data_maior($retorna_vencimento[$i], $data_corrente) == 0) {
                        $valor_a_Vencer = $valor_a_Vencer + $retorna_valor_real[$i];
                    } else {
                        $valor_Vencido = $valor_Vencido + $retorna_valor_real[$i];
                    }
                }
            }
            $valor_Total = $valor_Vencido + $valor_a_Vencer;
            ?>

            <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
                <div class="well"><!-- div que coloca a cor no formulário -->
                    <ul class="nav nav-tabs"> <!-- menu das abas -->
                        <li class="active"><a data-toggle="tab" href="#home">DÍVIDAS</a></li>
                        <li><a data-toggle="tab" href="#menu1">PAGAMENTOS</a></li>
                        <li><a data-toggle="tab" href="#menu2">PARCELAMENTOS</a></li>
                        <li><a data-toggle="tab" href="#menu3">CANCELAMENTOS</a></li>
                        <li><a data-toggle="tab" href="#menu4">DÍVIDA ATIVA</a></li>
                        <li><a data-toggle="tab" href="#menu5">VALOR REAL</a></li>
                        <li><a data-toggle="tab" href="#menu6">OBSERVAÇÃO</a></li>
                    </ul> <!-- fim dos menu das abas -->


                    <div class="tab-content"><!-- abertura das abas do formulário -->
                        <div id="home" class="tab-pane fade in active"> <!-- primeira aba -->
                            <div class="panel panel-default">
                                <!-- INICIO Dados do imóvel -->
                                <div class="panel-heading text-center">DÍVIDAS</div>
                                <div class="panel-body">
                                    <div style="overflow: auto; max-height: 250px; width: 100%">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td>ANO</td>
                                                    <td>Cod_divida</td>
                                                    <td>Desc_Divida</td>
                                                    <td>Sub_Divida</td>
                                                    <td>Moeda</td>
                                                    <td>PARCELA</td>
                                                    <td>QPA</td>
                                                    <td>Vencimento</td>
                                                    <td>Valor</td>
                                                    <td>Cod_Sit_Divida</td>
                                                    <td>Desc_Sit_Divida</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $linha = "";
                                                for ($cont = 0; $cont < $i; $cont++) {
                                                    $linha = $linha . "<tr id='edit-editar' data-id='" . $retorna_observacao[$cont] . "|" . $inscricao . "|" . $retorna_ano_divida[$cont] . "|" . $retorna_cod_divida[$cont] . "|" . $retorna_sub_divida[$cont] . "|" . $retorna_parcela[$cont] . "'>";
                                                    $linha = $linha . "<th>" . $retorna_ano_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_cod_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_desc_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_sub_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_cod_tipo_moeda[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_parcela[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_q_p_a[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_vencimento[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_valor[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_cod_sit_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_desc_sit_divida[$cont] . "</th>";
                                                    $linha = $linha . "</tr>";
                                                }
                                                print $linha;
                                                ?>

                                            </tbody>


                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="menu1" class="tab-pane"> 
                            <div class="panel panel-default">
                                <!-- INICIO Dados do imóvel -->
                                <div class="panel-heading text-center">PAGAMENTOS</div>
                                <div class="panel-body">
                                    <div style="overflow: auto; max-height: 250px; width: 100%">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td>ANO</td>
                                                    <td>Cod_divida</td>
                                                    <td>Sub_Divida</td>
                                                    <td>Moeda</td>
                                                    <td>PARCELA</td>
                                                    <td>Vencimento</td>
                                                    <td>Valor</td>
                                                    <td>Desc_Sit_Divida</td>
                                                    <td>Valor_Pag</td>
                                                    <td>Cod_Banco</td>
                                                    <td>Lote</td>
                                                    <td>Dt_Pag</td>
                                                    <td>Diferença</td>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $linha = "";
                                                for ($cont = 0; $cont < $i; $cont++) {
                                                    $linha = $linha . "<tr id='edit-editar' data-id='" . $retorna_observacao[$cont] . "|" . $inscricao . "|" . $retorna_ano_divida[$cont] . "|" . $retorna_cod_divida[$cont] . "|" . $retorna_sub_divida[$cont] . "|" . $retorna_parcela[$cont] . "'>";
                                                    $linha = $linha . "<th>" . $retorna_ano_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_cod_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_sub_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_cod_tipo_moeda[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_parcela[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_vencimento[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_valor[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_desc_sit_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_valor_pagamento[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_cod_banco[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_lote[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_data_pagamento[$cont] . "</th>";
                                                    $linha = $linha . "<th> </th>";
                                                    $linha = $linha . "</tr>";
                                                }
                                                print $linha;
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div id="menu2" class="tab-pane"> 
                            <div class="panel panel-default">
                                <!-- INICIO Dados do imóvel -->
                                <div class="panel-heading text-center">PARCELAMENTOS</div>
                                <div class="panel-body">
                                    <div style="overflow: auto; max-height: 250px; width: 100%">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td>ANO</td>
                                                    <td>Cod_divida</td>
                                                    <td>Sub_Divida</td>
                                                    <td>PARCELA</td>
                                                    <td>Vencimento</td>
                                                    <td>Valor</td>
                                                    <td>Desc_Sit_Divida</td>
                                                    <td>Num_Termo_Origem</td>
                                                    <td>Ano_Termo_Origem</td>
                                                    <td>Num_Termo_Destino</td>
                                                    <td>Ano_Termo_Destino</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $linha = "";
                                                for ($cont = 0; $cont < $i; $cont++) {
                                                    $linha = $linha . "<tr id='edit-editar' data-id='" . $retorna_observacao[$cont] . "|" . $inscricao . "|" . $retorna_ano_divida[$cont] . "|" . $retorna_cod_divida[$cont] . "|" . $retorna_sub_divida[$cont] . "|" . $retorna_parcela[$cont] . "'>";
                                                    $linha = $linha . "<th>" . $retorna_ano_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_cod_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_sub_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_parcela[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_vencimento[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_valor[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_desc_sit_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_num_termo_origem[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_ano_termo_origem[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_num_termo_destino[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_ano_termo_destino[$cont] . "</th>";
                                                    $linha = $linha . "</tr>";
                                                }
                                                print $linha;
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div id="menu3" class="tab-pane"> 
                            <div class="panel panel-default">
                                <!-- INICIO Dados do imóvel -->
                                <div class="panel-heading text-center">CANCELAMENTOS</div>
                                <div class="panel-body">
                                    <div style="overflow: auto; max-height: 250px; width: 100%">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td>ANO</td>
                                                    <td>Cod_divida</td>
                                                    <td>Sub_Divida</td>
                                                    <td>PARCELA</td>
                                                    <td>Vencimento</td>
                                                    <td>Valor</td>
                                                    <td>Desc_Sit_Dívida</td>
                                                    <td>Data_Canelamento</td>
                                                    <td>Motivo_Cancelamento</td>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $linha = "";
                                                for ($cont = 0; $cont < $i; $cont++) {
                                                    $linha = $linha . "<tr id='edit-editar' data-id='" . $retorna_observacao[$cont] . "|" . $inscricao . "|" . $retorna_ano_divida[$cont] . "|" . $retorna_cod_divida[$cont] . "|" . $retorna_sub_divida[$cont] . "|" . $retorna_parcela[$cont] . "'>";
                                                    $linha = $linha . "<th>" . $retorna_ano_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_cod_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_sub_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_parcela[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_vencimento[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_valor[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_desc_sit_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_data_cancelamento[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_motivo_cancelamento[$cont] . "</th>";
                                                    $linha = $linha . "</tr>";
                                                }
                                                print $linha;
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div id="menu4" class="tab-pane"> 
                            <div class="panel panel-default">
                                <!-- INICIO Dados do imóvel -->
                                <div class="panel-heading text-center">DÍVIDA ATIVA</div>
                                <div class="panel-body">
                                    <div style="overflow: auto; max-height: 250px; width: 100%">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td>ANO</td>
                                                    <td>Cod_divida</td>
                                                    <td>Sub_Divida</td>
                                                    <td>PARCELA</td>
                                                    <td>Desc_Sit_Divida</td>
                                                    <td>Data_Insc</td>
                                                    <td>Insc_Ativa</td>
                                                    <td>Livro</td>
                                                    <td>Folha</td>
                                                    <td>Linha</td>
                                                    <td>Num_Certidão</td>
                                                    <td>Ano_Certidão</td>
                                                    <td>Data_Ajuiz</td>
                                                    <td>N°_Processo_Ajuiz.</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $linha = "";
                                                for ($cont = 0; $cont < $i; $cont++) {
                                                    $linha = $linha . "<tr id='edit-editar' data-id='" . $retorna_observacao[$cont] . "|" . $inscricao . "|" . $retorna_ano_divida[$cont] . "|" . $retorna_cod_divida[$cont] . "|" . $retorna_sub_divida[$cont] . "|" . $retorna_parcela[$cont] . "'>";
                                                    $linha = $linha . "<th>" . $retorna_ano_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_cod_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_sub_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_parcela[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_desc_sit_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_Data_Inscricao_Ativa[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_Inscricao_Livro[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_Livro_Ativa[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_Folha_Ativa[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_Linha_Ativa[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_Num_Certidao[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_Ano_Certidao[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_data_ajuizamento_Imob[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_num_processo_ajuizamento[$cont] . "</th>";
                                                    $linha = $linha . "</tr>";
                                                }
                                                print $linha;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="menu5" class="tab-pane"> 
                            <div class="panel panel-default">
                                <!-- INICIO Dados do imóvel -->
                                <div class="panel-heading text-center">VALOR REAL</div>
                                <div class="panel-body">
                                    <div style="overflow: auto; max-height: 250px; width: 100%">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td>ANO</td>
                                                    <td>Desc_Sit_Dívida</td>
                                                    <td>Sub_Divida</td>
                                                    <td>PARCELA</td>
                                                    <td>Cod_Sit</td>
                                                    <td>Q.P.A</td>
                                                    <td>Vencimento</td>
                                                    <td>Valor</td>
                                                    <td>VALOR BASE(R$)</td>
                                                    <td>MULTA</td>
                                                    <td>JUROS</td>
                                                    <td>VALOR(R$)</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $linha = "";
                                                for ($cont = 0; $cont < $i; $cont++) {
                                                    $linha = $linha . "<tr id='edit-editar' data-id='" . $retorna_observacao[$cont] . "|" . $inscricao . "|" . $retorna_ano_divida[$cont] . "|" . $retorna_cod_divida[$cont] . "|" . $retorna_sub_divida[$cont] . "|" . $retorna_parcela[$cont] . "'>";
                                                    $linha = $linha . "<th>" . $retorna_ano_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_desc_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_sub_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_parcela[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_cod_sit_divida[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_q_p_a[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_vencimento[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . $retorna_valor[$cont] . "</th>";
                                                    $linha = $linha . "<th>" . mostrarDinheiro($retorna_valor_base[$cont]) . " </th>";
                                                    $linha = $linha . "<th>" . mostrarDinheiro($retorna_multa[$cont]) . " </th>";
                                                    $linha = $linha . "<th>" . mostrarDinheiro($retorna_juros[$cont]) . " </th>";
                                                    $linha = $linha . "<th>" . mostrarDinheiro($retorna_valor_real[$cont]) . " </th>";
                                                    $linha = $linha . "</tr>";
                                                }
                                                print $linha;
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="menu6" class="tab-pane"> 
                            <div class="panel panel-default">
                                <!-- INICIO Dados do imóvel -->
                                <div class="panel-heading text-center">OBSERVAÇÃO</div>
                                <div class="panel-body">
                                    <div class="col-md-6" style="overflow: auto; max-height: 250px;">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <td>ANO</td>
                                                    <td>Cod_divida</td>
                                                    <td>Desc_Divida</td>
                                                    <td>Sub_Divida</td>
                                                    <td>PARCELA</td>
                                                    <td>QPA</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $linha = "";
                                                for ($cont = 0; $cont < $i; $cont++) {
                                                    $linha = $linha . "<tr id='edit-editar' data-id='" . $retorna_observacao[$cont] . "|" . $inscricao . "|" . $retorna_ano_divida[$cont] . "|" . $retorna_cod_divida[$cont] . "|" . $retorna_sub_divida[$cont] . "|" . $retorna_parcela[$cont] . "'>";
                                                    $linha = $linha . "<td>" . $retorna_ano_divida[$cont] . "</td>";
                                                    $linha = $linha . "<td>" . $retorna_cod_divida[$cont] . "</td>";
                                                    $linha = $linha . "<td>" . $retorna_desc_divida[$cont] . "</td>";
                                                    $linha = $linha . "<td>" . $retorna_sub_divida[$cont] . "</td>";
                                                    $linha = $linha . "<td>" . $retorna_parcela[$cont] . "</td>";
                                                    $linha = $linha . "<td>" . $retorna_q_p_a[$cont] . "</td>";

                                                    $linha = $linha . "</tr>";
                                                }
                                                print $linha;
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <textarea name="obs_const_finc" id="obs_const_finc" class="form-control" rows="5" readonly="true"></textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" text-center">TOTAL DE REGISTROS ENCONTRADOS <?php print $i; ?></div>
                    <script>
                        passagem_valores_consulta('<?php print mostrarDinheiro($valor_Total); ?>', '<?php print mostrarDinheiro($valor_Vencido); ?>', '<?php print mostrarDinheiro($valor_a_Vencer); ?>');
                    </script>
                </div>
            </div>

            <?php
        }
        ?>

        <?php

        function consultaTaxasImovel($pdo) {
            ?>
            <div style="overflow: auto; max-height: 250px; width: 100%" >
                <div class="alert-dismissable text-center"><p>TAXAS</p></div>

                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <td>ANO</td>
                            <td>Cod_divida</td>
                            <td>Desc_Divida</td>
                            <td>Sub_Divida</td>
                            <td>PARCELA</td>
                            <td>Trib</td>
                            <td>Desc_Trib</td>
                            <td>VALOR</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $inscricao = $_POST['inscricao'];
                        $cod_divida = $_POST['cod_divida'];
                        $sub_divida = $_POST['sub_divida'];
                        $ano_divida = $_POST['ano_divida'];
                        $parcela = $_POST['parcela'];



                        $sql_taxa = "SELECT * ";
                        $sql_taxa = $sql_taxa . " FROM composicao_divida_imob cdi, divida_imob di";
                        $sql_taxa = $sql_taxa . " WHERE cdi.inscricao_imob = '$inscricao'";
                        $sql_taxa = $sql_taxa . " AND cdi.ano_divida = '$ano_divida'";
                        $sql_taxa = $sql_taxa . " AND cdi.cod_divida = '$cod_divida'";
                        $sql_taxa = $sql_taxa . " AND cdi.sub_divida = '$sub_divida'";
                        $sql_taxa = $sql_taxa . " AND cdi.parcela = '$parcela'";
                        $sql_taxa = $sql_taxa . " AND cdi.cod_divida_imob = di.Cod_Divida_Imob";

                        $query_taxa = $pdo->prepare($sql_taxa);
                        //executo o comando sql
                        $query_taxa->execute();
                        $linha = "";
                        for ($i = 0; $dados_taxa = $query_taxa->fetch(); $i++) {
                            $linha = $linha . "<tr>";
                            $linha = $linha . "<td>" . $dados_taxa['ano_divida'] . "</td>";
                            $linha = $linha . "<td>" . $dados_taxa['cod_divida'] . "</td>";
                            if ($dados_taxa['cod_divida'] == "01")
                                $descricao = "IMPOSTO PREDIAL";
                            if ($dados_taxa['cod_divida'] == "02")
                                $descricao = "IPTU TERRITORIAL";

                            $linha = $linha . "<td>" . $descricao . "</td>";
                            $linha = $linha . "<td>" . $dados_taxa['sub_divida'] . "</td>";
                            $linha = $linha . "<td>" . $dados_taxa['parcela'] . "</td>";
                            $linha = $linha . "<td>" . $dados_taxa['cod_divida_imob'] . "</td>";
                            $linha = $linha . "<td>" . $dados_taxa['Desc_Divida'] . "</td>";
                            $linha = $linha . "<td>" . mostrarDinheiro($dados_taxa['valor']) . "</td>";
                            $linha = $linha . "</tr>";
                        }
                        print $linha;
                        ?>

                    </tbody>
                </table>
            </div>


            <?php
        }
        ?>

    </body>
</html>


<?php

function retornaMotivoCancelamento($pdo, $cod_motivo) {

    $sql1 = "Select * from MOTIVO_CANCELAMENTO  WHERE cod_motivo_cancelamento  = '$cod_motivo'";
    $query1 = $pdo->prepare($sql1);
    //executo o comando sql
    $query1->execute();
    if (($dados1 = $query1->fetch()) == true) {
        return $dados1['Desc_Motivo_Cancelamento'];
    } else {
        return "";
    }
}

function retornaAjuizados_imob($pdo, $num_certidao, $ano_certidao) {

    $sql1 = "Select * from Ajuizados_imob  WHERE Num_Certidao  = '$num_certidao' AND  Ano_Certidao  = '$ano_certidao'";
    $query1 = $pdo->prepare($sql1);
    //executo o comando sql
    $query1->execute();
    if (($dados1 = $query1->fetch()) == true) {
        return dataBrasileiro($dados1['Data_Ajuizamento']) . "|" . $dados1['Num_Processo'];
    } else {
        return "|";
    }
}

function calcula_valor_base($valor, $moeda_do_dia, $situacao) {

    if ($situacao == 1 || $situacao == 2 || $situacao == 3) {
        return  $valor * $moeda_do_dia;
    }
}

function calcula_valor_total($valor_base, $retorna_multa, $retorna_juros) {
    return $valor_base + $retorna_multa + $retorna_juros;
}

function moeda($pdo) {

   
        return  $_SESSION['C_VALOR_MOEDA_DIA_UFIR'];
   
}
?>