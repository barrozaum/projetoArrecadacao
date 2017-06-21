<?php
include_once '../estrutura/controle/validarSessao.php';
if(isset($_SESSION['IMPRIMIR_GUIA_ITBI'])){
    
    include_once '../estrutura/conexao/conexao.php';
    include_once '../funcaoPHP/funcaoDinheiro.php';
    include_once '../funcaoPHP/funcaoData.php';
    include_once './complemento_guia.php';
    include_once './controle/controle_guia_itbi.php';
    include_once './barcode.php';
    include_once './util.php';


    function calcula_valor_itbi($valor_total, $vr_tx_expediente){
        $valor_itbi = inserirDinheiro($valor_total);
        $valor_taxa = inserirDinheiro($vr_tx_expediente);

        return $valor_itbi + $valor_taxa;
    }



    $vr_tx_expediente = '8,80';
    // linha digitavel

    $num_guia = proxima_guia($pdo);

    //barra ficha compensacao
    $barra_banco = '341';
    $barra_moeda = '9';
    $barra_digito = '0';
    $barra_vencimento = fator_vencimento($vencimento);
    $barra_valor = zeros(mostrarDinheiroSoNumero(calcula_valor_itbi($valor_total, $vr_tx_expediente))) . mostrarDinheiroSoNumero(calcula_valor_itbi($valor_total, $vr_tx_expediente));
    $barra_Carteira = '175';
    $barra_nosso_numero = 80000000 + $num_guia;
    $barra_Agencia = '6891';
    $barra_Conta = '03707';


    $barra_digito_nosso_num = digito_Modulo10($barra_Agencia . $barra_Conta . $barra_Carteira . $barra_nosso_numero);
    $barra_digito_agencia_conta = digito_Modulo10($barra_Agencia . $barra_Conta);

    $barra_numero = $barra_banco . $barra_moeda . $barra_digito . $barra_vencimento 
            . $barra_valor .  $barra_Carteira . $barra_nosso_numero . $barra_digito_nosso_num
            . $barra_Agencia . $barra_Conta . $barra_digito_agencia_conta. '000';

    $barra_digito = digito_Modulo11($barra_numero);

    $barra_numero = $barra_banco . $barra_moeda . $barra_digito . $barra_vencimento
            . $barra_valor . $barra_Carteira . $barra_nosso_numero . $barra_digito_nosso_num
            . $barra_Agencia . $barra_Conta . $barra_digito_agencia_conta . '000';


    // -- Linha Digitavel

    $barra_1 = $barra_banco . $barra_moeda . $barra_Carteira . substr($barra_nosso_numero, 0, 2);
    $barra_1 = $barra_1 . digito_Modulo10($barra_1);

    $barra_2 = substr($barra_nosso_numero, 2, 6) . $barra_digito_nosso_num . substr($barra_Agencia, 0, 3);
    $barra_2 = $barra_2 . digito_Modulo10($barra_2);

    $barra_3 = substr($barra_Agencia, 3, 1) . $barra_Conta . $barra_digito_agencia_conta . '000';
    $barra_3 = $barra_3 . digito_Modulo10($barra_3);

    $barra_linha_digitavel = substr($barra_1, 0, 5) . '.' . substr($barra_1, 5, 5) . ' ' .
            substr($barra_2, 0, 5) . '.' . substr($barra_2, 5, 6) . ' ' .
            substr($barra_3, 0, 5) . '.' . substr($barra_3, 5, 6) . ' ' .
            $barra_digito . ' ' . $barra_vencimento . $barra_valor;

    //$barra_linha_digitavel = '34191.75801 04010.996892 10370.760000 1 67800000000000';


    ?>  
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
            <meta charset="utf-8">
            <title>Arrecadação</title>
            <link href="../../css/guias_pagamento.css" rel="stylesheet" />
            <!--<script src="../../js/guias_pagamento.js"></script>-->
        </head>
        <body >
            <table style="height: 995px; margin-top: 0px;" border="0" >
                <tr>			
                    <td style="vertical-align: top;" > <br />
                        <table style="width:18cm;" cellpadding="0" cellspacing="0" border="0" align="center" >
                            <tr>
                                <td height="39" valign="top">
                                    <table width="100%" border="1" height="auto" cellspacing="0" bordercolor="#000000">
                                        <tr>
                                            <td height="60" valign="top">
                                                <table width="100%" border="0" align="left" height="40" cellspacing="0">
                                                    <tr>
                                                        <td rowspan="2" width="11%" valign="top"><img src="../../../<?php print $_SESSION['C_CAMINHO_LOGO']; ?>" width="90" height="50"></td>
                                                        <td width="49%" valign="left"><font size="3"><b><?php print $_SESSION['C_PREFEITURA'] ?></b></font>
                                                            <br /><font size="1">IMPOSTO DE TRANSMISSÃO DE BENS IMÓVEIS</font>
                                                            <br /><font size="1"><?php print $_SESSION['C_SECRETARIA'] ?></font>

                                                        </td>
                                                        <td valign="top" height="auto">
                                                            <table align="center" width="100%" border="1" cellspacing="0" height="11" bordercolor="#000000">
                                                                <tr valign="top">
                                                                    <td width="20%" height="30  " bgcolor="#CCCCCC">
                                                                        <div align="center">
                                                                            <font size="2">&nbsp; I.T.B.I &nbsp;</font><BR />
                                                                            <font size="2">&nbsp; <?php print $num_ano_itbi; ?> &nbsp;</font><BR />
                                                                        </div>
                                                                    </td>
                                                                 </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" height="62" >
                                    <table align="center" width="100%" border="1" height="52" cellspacing="0" bordercolor="#000000">
                                        <tr bgcolor="#CCCCCC">
                                            <td colspan="3" height="17">
                                                <div align="center">
                                                    <b><font size="2"> ADQUIRINTE</font></b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="38" valign="top" width="100%">
                                                <table width="100%" border="0" cellspacing="0" >
                                                    <tr>
                                                        <td valign="top"><font size="1">Nome : &nbsp <?php print $nome_ad; ?></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top"><font size="1">TIPO PESSOA : &nbsp <?php print $tipo_pessoa_ad; ?></font></td>
                                                        <td valign="top"><font size="1">CPF/CNPJ : &nbsp <?php print $cpf_cnpj_ad; ?></font></td>
                                                        <td valign="top"><font size="1">IDENTIDADE : &nbsp <?php print $identidade_ad; ?></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" height="38" valign="top" width="100%">
                                                            <table align="center" width="100%" border="1" height="52" cellspacing="0" bordercolor="#000000">
                                                                <tr bgcolor="#CCCCCC">
                                                                    <td colspan="4" height="auto">
                                                                        <div align="LEFT">
                                                                            <b><font size="2"> ENDEREÇO</font></b>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td valign="top"><font size="1">RUA : &nbsp <?php print $rua_ad; ?></font></td>
                                                                    <td valign="top"><font size="1">NÚMERO : &nbsp <?php print $numero_end_ad; ?></font></td>
                                                                    <td valign="top" colspan="2"><font size="1">COMPLEMENTO : &nbsp <?php print $complemento_end_ad; ?></font></td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top"><font size="1">BAIRRO : &nbsp <?php print $bairro_end_ad; ?></font></td>
                                                                    <td valign="top"><font size="1">CEP : &nbsp <?php print $cep_end_ad; ?></font></td>
                                                                    <td valign="top"><font size="1">CIDADE : &nbsp <?php print $cidade_end_ad; ?></font></td>
                                                                    <td valign="top"><font size="1">UF : &nbsp <?php print $uf_end_ad; ?></font></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                        </tr>
                                    </table>

                                </td>
                            </tr>
                            <tr>
                                <td valign="top" height="auto">
                                    <table align="center" width="100%" border="1" height="52" cellspacing="0" bordercolor="#000000">
                                        <tr bgcolor="#CCCCCC">
                                            <td colspan="3" height="17">
                                                <div align="center">
                                                    <b><font size="2"> TRANSMITENTE</font></b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="38" valign="top" width="100%">
                                                <table width="100%" border="0" cellspacing="0" >
                                                    <tr>
                                                        <td valign="top"><font size="1">Nome : &nbsp <?php print $nome_tr; ?></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top"><font size="1">TIPO PESSOA : &nbsp <?php print $tipo_pessoa_tr; ?></font></td>
                                                        <td valign="top"><font size="1">CPF/CNPJ : &nbsp <?php print $cpf_cnpj_tr; ?></font></td>
                                                        <td valign="top"><font size="1">IDENTIDADE : &nbsp <?php print $identidade_tr; ?></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" height="38" valign="top" width="100%">
                                                            <table align="center" width="100%" border="1" height="52" cellspacing="0" bordercolor="#000000">
                                                                <tr bgcolor="#CCCCCC">
                                                                    <td colspan="4" height="auto">
                                                                        <div align="LEFT">
                                                                            <b><font size="2"> ENDEREÇO</font></b>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td valign="top"><font size="1">RUA : &nbsp <?php print $rua_tr; ?></font></td>
                                                                    <td valign="top"><font size="1">NÚMERO : &nbsp <?php print $numero_end_tr; ?></font></td>
                                                                    <td valign="top" colspan="2"><font size="1">COMPLEMENTO : &nbsp <?php print $complemento_end_tr; ?></font></td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top"><font size="1">BAIRRO : &nbsp <?php print $bairro_end_tr; ?></font></td>
                                                                    <td valign="top"><font size="1">CEP : &nbsp <?php print $cep_end_tr; ?></font></td>
                                                                    <td valign="top"><font size="1">CIDADE : &nbsp <?php print $cidade_end_tr; ?></font></td>
                                                                    <td valign="top"><font size="1">UF : &nbsp <?php print $uf_end_tr; ?></font></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" height="auto" >
                                    <table align="center" width="100%" border="1" height="52" cellspacing="0" bordercolor="#000000">
                                        <tr bgcolor="#CCCCCC">
                                            <td colspan="3" height="17">
                                                <div align="center">
                                                    <b><font size="2"> ESPECIFICAÇÃO DO IMÓVEL</font></b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="38" valign="top" width="100%">
                                                 <table width="100%" border="0" cellspacing="0" >
                                                    <tr>
                                                        <td valign="top"><font size="1">INSCRIÇÃO : &nbsp <?php print $inscricao; ?></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top"><font size="1">ÁREA DO TERRENO : &nbsp <?php print $area_terreno; ?></font></td>
                                                        <td valign="top"><font size="1">ÁREA DA CONTRUÇÃO : &nbsp <?php print $area_construida; ?></font></td>
                                                        <td valign="top"><font size="1">UTILIZAÇÃO : &nbsp <?php print $utilizacao; ?></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top"><font size="1">FRAÇÃO IDEAL : &nbsp <?php print $fracao_ideal; ?></font></td>
                                                        <td valign="top"><font size="1">VALOR VENAL : &nbsp <?php print $valor_venal; ?></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" height="38" valign="top" width="100%">
                                                            <table align="center" width="100%" border="1" height="52" cellspacing="0" bordercolor="#000000">
                                                                <tr bgcolor="#CCCCCC">
                                                                    <td colspan="4" height="auto">
                                                                        <div align="LEFT">
                                                                            <b><font size="2"> ENDEREÇO</font></b>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td valign="top"><font size="1">RUA : &nbsp <?php print $imov_lograd; ?></font></td>
                                                                    <td valign="top"><font size="1">NÚMERO : &nbsp <?php print $imov_num; ?></font></td>
                                                                    <td valign="top" colspan="2"><font size="1">COMPLEMENTO : &nbsp <?php print $imov_compl; ?></font></td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top"><font size="1">BAIRRO : &nbsp <?php print $imov_bairro; ?></font></td>
                                                                    <td valign="top"><font size="1">CIDADE : &nbsp <?php print 'JAPERI'; ?></font></td>
                                                                    <td valign="top"><font size="1">UF : &nbsp <?php print 'RJ'; ?></font></td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>

                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" height="auto" >
                                    <table align="center" width="100%" border="1" height="22" cellspacing="0" bordercolor="#000000">
                                        <tr bgcolor="#CCCCCC" >
                                            <td colspan="3" height="17" width="307">
                                                <div align="center">
                                                    <b><font size="1"> ESPECIFICAÇÃO DA TRANSAÇÃO</font></b>
                                                </div>
                                            </td>
                                            <td colspan="3" height="17" width="307">
                                                <div align="center">
                                                    <b><font size="1"> LANÇAMENTO DO IMPOSTO (<font size="1"> Alíquita 2%</font>)</font></b>
                                                </div>
                                            </td>
                                            <td colspan="3" height="17" width="207">
                                                <div align="center">
                                                    <b><font size="2"> Processo : 000025/2016</font></b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" valign="top"><font size="1,5">NATUREZA : &nbsp <br /> &nbsp&nbsp&nbsp <b> <?php print $natureza; ?></b></font></td>
                                            <td colspan="3" valign="top"><font size="1,5">BASE CALCULO (R$) : &nbsp <br /> &nbsp&nbsp&nbsp  <b><?php print $base_calculo; ?></b></font></td>
                                            <td colspan="3" valign="top"><font size="1,5">LANÇAMENTO : &nbsp <br /> &nbsp&nbsp&nbsp  <b> <?php print $data_Transacao; ?></b></font></td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" valign="top"><font size="1,5">VALOR DECLARADO (R$) : &nbsp <br /> &nbsp&nbsp&nbsp <b><?php print $valor_declarado; ?></b></font></td>
                                            <td colspan="3" valign="top"><font size="1,5">VALOR IMPOSTO (R$) &nbsp <br /> &nbsp&nbsp&nbsp <b><?php print $valor_imposto; ?></b></font></td>
                                            <td colspan="3" valign="top"><font size="1,5">VENCIMENTO : &nbsp <br /> &nbsp&nbsp&nbsp  <b><?php print $vencimento; ?></b></font></td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" valign="top"><font size="1,5">DATA : &nbsp <br /> &nbsp&nbsp&nbsp  <b> <?php print $data_Transacao; ?></b> </font></td>
                                            <td colspan="3" valign="top"><font size="1,5">VALOR MULTA(R$): &nbsp <br /> &nbsp&nbsp&nbsp   <b> <?php print $valor_multa; ?></b></font></td>
                                            <td colspan="3" valign="top"><font size="1,5">VALOR TOTAL(R$) : &nbsp <br /> &nbsp&nbsp&nbsp   <b> <?php print $valor_total; ?></b></font></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" height="auto" > 
                                    <table width="100%" border="0" height="63" cellspacing="0" >
                                        <tr>
                                            <td valign="top" height="auto"> 
                                                <table align="center" width="100%" border="0" cellspacing="0" height="auto">
                                                    <tr>
                                                        <td colspan="2" height="31" valign="top">
                                                            <table align="center" width="100%" border="1" height="35" cellspacing="0" bordercolor="#000000">
                                                                <tr>
                                                                    <td height="33" valign="top">

                                                                        <font size="1">
                                                                           Observação: 
                                                                        </font>
                                                                         <font size="2" >
                                                                            <b>
                                                                                <?php print $obs_Itbi; ?> 
                                                                            </b>
                                                                        </font>

                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="78%" height="10" valign="top">
                                                            <font face="Arial, Helvetica, sans-serif" size="1">
                                                                Autentica&ccedil;&atilde;o Mec&acirc;nica
                                                            </font>
                                                        </td>
                                                        <td width="22%" height="10" valign="top">
                                                            <div align="right"><font size="1">Emiss&atilde;o:  <?php  print $data_emissao_guia . date('H:i:s'); ?></font><font size="2"><b><i></i></b></font></div>
                                                        </td>
                                                    </tr>
                                                    <tr valign="top" align="center">
                                                        <td colspan="2" height="4"> 
                                                            <div align="right">
                                                                <font size="2"><b><i><font face="Arial, Helvetica, sans-serif" size="1">Via do Contribuinte</font></i></b></font>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <table style="width:18cm;" cellpadding="0" cellspacing="0" border="0" align="center" >
                           <tr>
                                <td>
                                    <div align="center">
                                        -------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="bordelessTop" cellpadding="0" cellspacing="0" border="1" >
                                        <tr style="text-align: center;" >
                                            <td class="negrito" style="width: 160px" >BANCO ITA&Uacute; S.A.</td>
                                            <td class="huge" style="vertical-align: bottom;width: 50px" ><b>&nbsp;341-7&nbsp;</b></td>
                                            <td class="huge" style="vertical-align: bottom;" >
                                                 <?php print $barra_linha_digitavel; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table class="partialBorderLess" style="width:100%;" cellpadding="0" cellspacing="0" border="1">
                                        <tr> 
                                            <td class="topbottombordeLess" >Local de Pagamento</td>
                                            <td style="width: 155px;" class="topbottombordeLess" >Vencimento</td>
                                        </tr>
                                        <tr> 
                                            <td class="tiny" ><b>AT&Eacute; O VENCIMENTO EM TODA REDE BANC&Aacute;RIA.  <br>          </td>
                                            <td class="negrito" style="text-align: right;" > <?php print $vencimento; ?> &nbsp;&nbsp;&nbsp; </td>
                                        </tr>
                                        <tr> 
                                            <td class="topbottombordeLess" >Cedente</td>
                                            <td class="topbottombordeLess" >Agência/Código Cedente</td>
                                        </tr>
                                        <tr> 
                                            <td class="prefeitura" ><?php print $_SESSION['C_PREFEITURA']; ?></td>
                                            <td class="negrito" style="text-align: right;" >6891/03707-6&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr> 
                                            <td rowspan="2" > 
                                                <table class="bordeLess " style="width:100%;" cellpadding="0" cellspacing="0" border="1">
                                                    <tr> 
                                                        <td class="topbottombordeLess" width="120px"  >Data do Documento</td>
                                                        <td class="topbottombordeLess" >N° do Documento/Inscrições</td>
                                                        <td class="topbottombordeLess" >Espécie Documento</td>
                                                        <td class="topbottombordeLess" >Aceite</td>
                                                    </tr>
                                                    <tr> 
                                                        <td class="negrito" > <?php print $data_emissao_guia; ?> </td>
                                                        <td class="negrito" style="text-align: center;" > print $inscricao; </td>
                                                        <td class="negrito" >Outros</td>
                                                        <td class="negrito" width="80px" >N</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="topbottombordeLess" >Nosso Número</td>
                                        </tr>
                                        <tr> 
                                            <td class="negrito" style="text-align: right;" > 
                                               <?php print '175/' . $barra_nosso_numero . '-' . $barra_digito_nosso_num ?> &nbsp;&nbsp;&nbsp; 
                                            </td>
                                        </tr>
                                        <tr> 
                                            <td rowspan="2" > 
                                                <table class="bordeLess" style="border-top-color: transparent;" cellpadding="0" cellspacing="0" border="1">
                                                    <tr> 
                                                        <td class="topbottombordeLess" width="140px" >Uso do Banco</td>
                                                        <td class="topbottombordeLess" width="90px" >Carteira</td>
                                                        <td class="topbottombordeLess" >Espécie</td>
                                                        <td class="topbottombordeLess" width="80px" >Quantidade</td>
                                                        <td class="topbottombordeLess" width="80px" >Valor</td>
                                                    </tr>
                                                    <tr style="text-align: center;" > 
                                                        <td class="negrito" ></td>
                                                        <td class="negrito" style=";text-align: center;" >175&nbsp;&nbsp;</td>
                                                        <td class="negrito" >R$</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="topbottombordeLess" > (=)Valor do Documento </td>
                                        </tr>
                                        <tr> 
                                            <td class="negrito" style="text-align: right;" > 
                                                &nbsp;&nbsp;&nbsp; 
                                            </td>
                                        </tr>
                                        <tr style="vertical-align: top;" > 
                                            <td rowspan="8" > 
                                                <table style="width:100%;border-color: #FFFFFF" cellpadding="0" cellspacing="0" border="0">
                                                    <tr> 
                                                        <td>Instruções/Mensagens</td>
                                                        <td class="parcela"  style="text-align: left;" rowspan="2" > 
                                                        </td>
                                                    </tr>
                                                    <tr> 
                                                        <td style="height: 20px;" >Sr.Caixa</td>
                                                    </tr>
                                                    <tr> 
                                                        <td style="font-size: 7pt;" colspan="2" ><b>NÃO RECEBER APÓS  O VENCIMENTO<b></td>
                                                    </tr>
                                                    <tr> 
                                                        <td style="font-size: 7pt;" colspan="2" >Taxa de Expediente R$  <?php print  $vr_tx_expediente; ?></td>
                                                    </tr>
                                                    <tr> 
                                                        <td style="font-size: 7pt;" colspan="2" >&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="topbottombordeLess" > (-)Desconto/Abatimento </td>
                                        </tr>
                                        <tr style="vertical-align: top;" > 
                                            <td class="negrito" style="text-align: right;" >&nbsp;&nbsp;&nbsp;&nbsp;</td>              </tr>
                                        <tr> 
                                            <td style="height: 20px;" >(-)Outras Deduções</td>
                                        </tr>
                                        <tr> 
                                            <td style="height: 20px;" >(+)Multa/Juros</td>
                                        </tr>
                                        <tr> 
                                            <td class="topbottombordeLess" >(+)Outros Acrésimos</td>
                                        </tr>
                                        <tr>
                                            <td class="negrito" style="text-align: right;" ><?php  print $vr_tx_expediente; ?> &nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        </tr>
                                        <tr> 
                                            <td class="topbottombordeLess"  >(=)Valor Cobrado</td>
                                        </tr>
                                        <tr> 
                                            <td class="negrito" style="text-align: right;" > <?php print mostrarDinheiro(calcula_valor_itbi($valor_total, $vr_tx_expediente));?>  &nbsp;&nbsp;&nbsp; </td>
                                        </tr>
                                        <tr> 
                                            <td colspan="2" > 
                                                <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                                    <tr> 
                                                        <td colspan="4" >Sacado</td>
                                                    </tr>
                                                    <tr style="font-weight: bold;" > 
                                                        <td class="arialPadding"  > <?php print $nome_ad; ?> </td>
                                                        <td class="arialPadding" ></td>
                                                        <td>&nbsp;</td>
                                                        <td  >&nbsp;</td>
                                                    </tr>
                                                    <tr style="font-weight: bold;padding-bottom: 5px" > 
                                                        <td class="arialPadding" >&nbsp;</td>
                                                        <td></td>
                                                        <td class="negrito" style="text-align: right;" >Inscri&ccedil;&atilde;o  Municipal:</td>
                                                        <td class="negrito" style="text-align: left;" > 
                                                            <?php print $num_ano_itbi; ?>
                                                        </td>
                                                    </tr>
                                                    <tr> 
                                                        <td colspan="2" >Sacador / Avalista </td>
                                                        <td style="text-align: right;" colspan="2" >&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                   <table style="padding-bottom: 10px;" class="dashedBorder" cellpadding="0" cellspacing="0" border="1">
                                        <tr style="text-align: right;vertical-align: top;" >
                                            <td class="dashedBorder" style="text-align: center;" > <?php print fbarcode($barra_numero); ?></td>
                                            <td class="dashedBorder" >autentificação mecânica</td>
                                            <td  class="autentificacao" style="font-weight: bold;" >FICHA DE COMPENSAÇÃO</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
    </html>
    <script type="text/javascript">
        window.print();
    </script>

    <?php 
    // acabar com dados em sessão
    unset($_SESSION['IMPRIMIR_GUIA_ITBI']);
    unset($_SESSION['ITBI_NUMERO']);
    unset($_SESSION['ITBI_ANO']);
    unset($_SESSION['NOME_COMPLETO_AD']);
    unset($_SESSION['TIPO_PESSOA_AD']);
    unset($_SESSION['CPF_CNPJ_PESSOA_AD']);
    unset($_SESSION['IDENTIDADE_AD']);
    unset($_SESSION['END_CEP_AD']);
    unset($_SESSION['END_RUA_AD']);
    unset($_SESSION['END_BAIRRO_AD']);
    unset($_SESSION['END_CIDADE_AD']);
    unset($_SESSION['END_UF_AD']);
    unset($_SESSION['END_NUM_AD']);
    unset($_SESSION['END_COMP_AD']);
    unset($_SESSION['NOME_COMPLETO_TR']);
    unset($_SESSION['TIPO_PESSOA_TR']);
    unset($_SESSION['CPF_CNPJ_PESSOA_TR']);
    unset($_SESSION['IDENTIDADE_TR']);
    unset($_SESSION['END_CEP_TR']);
    unset($_SESSION['END_RUA_TR']);
    unset($_SESSION['END_BAIRRO_TR']);
    unset($_SESSION['END_CIDADE_TR']);
    unset($_SESSION['END_UF_TR']);
    unset($_SESSION['END_NUM_TR']);
    unset($_SESSION['END_COMP_TR']);
    unset($_SESSION['IMOV_INSC']);
    unset($_SESSION['IMOV_PROPRIETARIO']);
    unset($_SESSION['IMOV_AREA_TERRENO']);
    unset($_SESSION['IMOV_AREA_CONSTRUIDA']);
    unset($_SESSION['IMOV_FRACAO_IDEAL']);
    unset($_SESSION['IMOV_DESC_UTILIZACAO']);
    unset($_SESSION['IMOV_COD_UTILIZACAO']);
    unset($_SESSION['IMOV_VALOR_VENAL']);
    unset($_SESSION['IMOV_CODIGO_BAIRRO']);
    unset($_SESSION['IMOV_BAIRRO']);
    unset($_SESSION['IMOV_CODIGO_RUA']);
    unset($_SESSION['IMOV_NOME_RUA']);
    unset($_SESSION['IMOV_NUM']);
    unset($_SESSION['IMOV_COMPL']);
    unset($_SESSION['T_NATUREZA']);
    unset($_SESSION['T_NUM_PROC']);
    unset($_SESSION['T_ANO_PROC']);
    unset($_SESSION['T_IMUNIDADE']);
    unset($_SESSION['T_VALOR_DECLARADO']);
    unset($_SESSION['T_BASE_CALCULO']);
    unset($_SESSION['T_VALOR_ITBI']);
    unset($_SESSION['T_VALOR_TOTAL_ITBI']);
    unset($_SESSION['T_DATA_TRAN']);
    unset($_SESSION['T_DATA_VENC']);
    unset($_SESSION['T_VALOR_MULTA']);
    unset($_SESSION['T_DECLARANTE']);
    unset($_SESSION['T_OBS_ITBI']);
}else{
      die(header("Location: ../../../index.php"));
}
?>