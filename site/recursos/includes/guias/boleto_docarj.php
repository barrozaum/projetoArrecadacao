<?php
include_once '../estrutura/controle/validarSessao.php';
if(isset($_SESSION['IMPRIMIR_GUIA_DOCARJ'])){
    
    include_once '../estrutura/conexao/conexao.php';
    include_once '../funcaoPHP/funcaoDinheiro.php';
    include_once '../funcaoPHP/funcaoCpfCnpj.php';
    include_once '../funcaoPHP/funcaoPessoaFisica_Juridica.php';
    include_once '../funcaoPHP/funcaoData.php';
    include_once '../funcaoPHP/funcao_receitas_docarj.php';
    include_once './complemento_guia.php';
    include_once './barcode.php';
    include_once './util.php';

    function carrega_descricao_receita_boleto($pdo){
        $_SESSION['DESCRICAO_RECEITA1'] = funcao_descricao_receitas($pdo, $_SESSION['CADASTRO_RECEITAS'], $_SESSION['RECEITA1']);
        $_SESSION['DESCRICAO_RECEITA2'] = funcao_descricao_receitas($pdo, $_SESSION['CADASTRO_RECEITAS'], $_SESSION['RECEITA2']);
        $_SESSION['DESCRICAO_RECEITA3'] = funcao_descricao_receitas($pdo, $_SESSION['CADASTRO_RECEITAS'], $_SESSION['RECEITA3']);
        $_SESSION['DESCRICAO_RECEITA4'] = funcao_descricao_receitas($pdo, $_SESSION['CADASTRO_RECEITAS'], $_SESSION['RECEITA4']);
      
    }
    



    ?>  
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
            <meta charset="utf-8">
            <title>Arrecadação</title>
            <link href="../../css/guias_pagamento.css" rel="stylesheet" />
        </head>
        <body >
            <?php
            
                function gerar_boleto_docarj ($pdo, $vencimento, $parcela){

                $_SESSION['EMISSAO'] = date('d/m/Y');
                $vr_tx_expediente = '8,80';
                // linha digitavel
                $valor_docarj_com_taxa = $_SESSION['VALOR_DOCARJ']+ 8.80;

                $num_guia = proxima_guia($pdo);

                //barra ficha compensacao
                $barra_banco = '341';
                $barra_moeda = '9';
                $barra_digito = '0';
                $barra_vencimento = fator_vencimento($vencimento);
                $barra_valor = zeros(mostrarDinheiroSoNumero($valor_docarj_com_taxa)) . mostrarDinheiroSoNumero($valor_docarj_com_taxa);
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
            <table style="height: 1000px; margin-top: 0px;" border="0" >
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
                                                            <br /><font size="1"><?php print $_SESSION['C_SECRETARIA'] ?></font>

                                                        </td>
                                                        <td valign="top" height="auto">
                                                            <table align="center" width="100%" border="1" cellspacing="0" height="11" bordercolor="#000000">
                                                                <tr valign="top">
                                                                    <td width="20%" height="30  " bgcolor="#CCCCCC">
                                                                        <div align="center">
                                                                            <font size="2">&nbsp; DOCARJ &nbsp;</font><BR />
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
                                            <td height="auto">INSCRIÇÃO</td>
                                            <td height="auto">NUMERO DOCARJ</td>
                                            <td height="auto">EMISSÃO</td>
                                            <td height="auto">PARCELA</td>
                                            <td height="auto">VENCIMENTO</td>
                                        </tr>

                                        <tr>
                                            <td valign="top"><font size="2">&nbsp <?php print $_SESSION['NUMERO_DOCARJ']; ?></font></td>
                                            <td valign="top"><font size="2">&nbsp <?php print $_SESSION['NUMERO_DOCARJ'] . "&nbsp /&nbsp " .$_SESSION['ANO_DOCARJ']; ?></font></td>
                                            <td valign="top"><font size="2">&nbsp <?php print $_SESSION['EMISSAO'];  ?></font></td>
                                            <td valign="top"><font size="2">&nbsp <?php print $parcela . "&nbsp /&nbsp " .$_SESSION['QTD_PARCELA'];  ?></font></td>
                                            <td valign="top"><font size="2">&nbsp <?php print $vencimento;  ?></font></td>
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
                                                    <b><font size="2"> CONTRIBUINTE</font></b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="38" valign="top" width="100%">
                                                <table width="100%" border="0" cellspacing="0" >
                                                    <tr>
                                                        <td valign="top"><font size="1">NOME : &nbsp <?php print $_SESSION['NOME_CONTRIBUINTE']; ?></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top"><font size="1">TIPO PESSOA : &nbsp <?php print FUN_MOSTRAR_DESCRICAO_TIPO_PESSOA($_SESSION['TIPO_PESSOA']); ?></font></td>
                                                        <td valign="top"><font size="1">CPF/CNPJ : &nbsp <?php print FUN_COLOCAR_MASCARA_CPF_CNPJ($_SESSION['CPF_CNPJ']); ?></font></td>
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
                                                                    <td valign="top"><font size="1">RUA : &nbsp <?php print $_SESSION['LOGRADOURO']; ?></font></td>
                                                                    <td valign="top"><font size="1">NÚMERO : &nbsp <?php print $_SESSION['NUMERO_ENDERECO']; ?></font></td>
                                                                    <td valign="top" colspan="2"><font size="1">COMPLEMENTO : &nbsp <?php print $_SESSION['COMPLEMENTO']; ?></font></td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top"><font size="1">BAIRRO : &nbsp <?php print $_SESSION['BAIRRO']; ?></font></td>
                                                                    <td valign="top"><font size="1">CEP : &nbsp <?php print $_SESSION['CEP']; ?></font></td>
                                                                    <td valign="top"><font size="1">CIDADE : &nbsp <?php print $_SESSION['CIDADE']; ?></font></td>
                                                                    <td valign="top"><font size="1">UF : &nbsp <?php print $_SESSION['UF']; ?></font></td>
                                                                </tr>
                                                            </table>
                                                            <table align="center" width="100%" border="1" height="32" cellspacing="0" bordercolor="#000000">
                                                                <tr bgcolor="#CCCCCC">
                                                                    <td colspan="4" height="auto">
                                                                        <div align="LEFT">
                                                                            <b><font size="2"> ATIVIDADE</font></b>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td valign="top"><font size="1">RUA : &nbsp <?php print $_SESSION['LOGRADOURO']; ?></font></td>
                                                                    <td valign="top"><font size="1">NÚMERO : &nbsp <?php print $_SESSION['NUMERO_ENDERECO']; ?></font></td>
                                                                    <td valign="top" colspan="2"><font size="1">COMPLEMENTO : &nbsp <?php print $_SESSION['COMPLEMENTO']; ?></font></td>
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
                                            <td colspan="12" height="17">
                                                <div align="center">
                                                    <b><font size="2"> ESPECIFICAÇÃO DA RECEITA</font></b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" height="17" width="307">
                                                <div align="center">
                                                    <b><font size="1"> ESPECIFICAÇÃO</font></b>
                                                </div>
                                            </td>
                                            <td colspan="4" height="17" width="307">
                                                <div align="center">
                                                    <b><font size="1"> VALOR</font></b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" height="17" width="307">
                                                    <b><font size="1"><?php  print $_SESSION['DESCRICAO_RECEITA1']; ?> </font></b>
                                            </td>
                                            <td colspan="4" height="17" width="307">
                                                <div align="center">
                                                    <b><font size="1"><?php  print mostrarDinheiro($_SESSION['VALOR1']); ?> </font></b>
                                                </div> 
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="8" height="17" width="307">
                                                    <b><font size="1"><?php  print $_SESSION['DESCRICAO_RECEITA2']; ?> </font></b>
                                            </td>
                                            <td colspan="4" height="17" width="307">
                                                <div align="center">
                                                    <b><font size="1"><?php  print mostrarDinheiro($_SESSION['VALOR2']); ?> </font></b>
                                                </div> 
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="8" height="17" width="307">
                                                    <b><font size="1"><?php  print $_SESSION['DESCRICAO_RECEITA3']; ?> </font></b>
                                            </td>
                                            <td colspan="4" height="17" width="307">
                                                <div align="center">
                                                    <b><font size="1"><?php  print mostrarDinheiro($_SESSION['VALOR3']); ?> </font></b>
                                                </div> 
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="8" height="17" width="307">
                                                    <b><font size="1"><?php  print $_SESSION['DESCRICAO_RECEITA4']; ?> </font></b>
                                            </td>
                                            <td colspan="4" height="17" width="307">
                                                <div align="center">
                                                    <b><font size="1"><?php  print mostrarDinheiro($_SESSION['VALOR4']); ?> </font></b>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                       
                                        <tr>
                                            <td colspan="8" height="17" width="307">
                                                <div align="left">
                                                    <b><font size="1"> VALOR  R$ </font></b>
                                                </div>
                                            </td>
                                            <td colspan="4" height="17" width="307">
                                                <div align="center">
                                                    <b><font size="1"><?php print mostrarDinheiro($_SESSION['VALOR_DOCARJ']); ?></font></b>
                                                </div>
                                            </td>
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
                                                                                <?php print $_SESSION['OBS1'] ." <BR /> ". $_SESSION['OBS2']." <BR /> ". $_SESSION['OBS3']." <BR /> ". $_SESSION['OBS4']; ?> 
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
                                                            <div align="right"><font size="1">Emiss&atilde;o:  <?php  print $_SESSION['EMISSAO'] . " " . date('H:i:s'); ?></font><font size="2"><b><i></i></b></font></div>
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
                                        <br /><br />-------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br /><br />
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
                                                        <td class="negrito" > <?php print $_SESSION['EMISSAO']; ?> </td>
                                                        <td class="negrito" style="text-align: center;" >  </td>
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
                                            <td class="negrito" style="text-align: right;" > <?php print mostrarDinheiro($valor_docarj_com_taxa);?>  &nbsp;&nbsp;&nbsp; </td>
                                        </tr>
                                        <tr> 
                                            <td colspan="2" > 
                                                <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                                    <tr> 
                                                        <td colspan="4" >Sacado</td>
                                                    </tr>
                                                    <tr style="font-weight: bold;" > 
                                                        <td class="arialPadding"  > <?php print $_SESSION['NOME_CONTRIBUINTE']; ?> </td>
                                                        <td class="arialPadding" ></td>
                                                        <td>&nbsp;</td>
                                                        <td  >&nbsp;</td>
                                                    </tr>
                                                    <tr style="font-weight: bold;padding-bottom: 5px" > 
                                                        <td class="arialPadding" >&nbsp;</td>
                                                        <td></td>
                                                        <td class="negrito" style="text-align: right;" >NÚMERO DOCARJ</td>
                                                        <td class="negrito" style="text-align: left;" > 
                                                            <?php print $_SESSION['NUMERO_DOCARJ'] ."&nbsp/&nbsp" . $_SESSION['ANO_DOCARJ']; ?>
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
                <tr>
                <br /><br /> &nbsp 
                </tr>                
            </table>
                <?php 
    }
//      COMANDO PARA IMPRIMIR O BOLETO DE ACORDO COM AS QUANTIDADES DE PARCELAS
    $auxiliar_data = $_SESSION['VENCIMENTO'];
    $inserir_parcela = $_SESSION['PARCELA_INICIAL'];
    $auxiliar_parcela = $_SESSION['PARCELA_INICIAL'];
    carrega_descricao_receita_boleto($pdo);
    for($i = 0; $i < $_SESSION['QTD_PARCELA']; $i++){
        gerar_boleto_docarj($pdo,$auxiliar_data, $inserir_parcela);
        $auxiliar_data = dataBrasileiro(acrescentar_periodo_a_data($auxiliar_data));
        $auxiliar_parcela++;
        if ($auxiliar_parcela < 10) {
            $inserir_parcela = "0" . $auxiliar_parcela;
        } else {
            $inserir_parcela = $auxiliar_parcela;
        }
    }
    ?>
        </body>
    </html>
    
    <script type="text/javascript">
        window.print();
    </script>

    <?php 
    // acabar com dados em sessão
//    unset($_SESSION['IMPRIMIR_GUIA_DOCARJ']);
//    unset($_SESSION['NUMERO_DOCARJ']);
//    unset($_SESSION['ANO_DOCARJ']);
//    unset($_SESSION['QTD_PARCELA']);
//    unset($_SESSION['PARCELA_INICIAL']);
//    unset($_SESSION['VENCIMENTO']);
//    unset($_SESSION['NOME_CONTRIBUINTE']);
//    unset($_SESSION['TIPO_PESSOA']);
//    unset($_SESSION['CPF_CNPJ']);
//    unset($_SESSION['LOGRADOURO']);
//    unset($_SESSION['NUMERO_ENDERECO']);
//    unset($_SESSION['COMPLEMENTO']);
//    unset($_SESSION['BAIRRO']);
//    unset($_SESSION['CEP']);
//    unset($_SESSION['CIDADE']);
//    unset($_SESSION['UF']);
//    unset($_SESSION['CADASTRO_RECEITAS']);
//    unset($_SESSION['RECEITA1']);
//    unset($_SESSION['VALOR1']);
//    unset($_SESSION['OBS1']);
//    unset($_SESSION['RECEITA2']);
//    unset($_SESSION['VALOR2']);
//    unset($_SESSION['OBS2']);
//    unset($_SESSION['RECEITA3']);
//    unset($_SESSION['VALOR3']);
//    unset($_SESSION['OBS3']);
//    unset($_SESSION['RECEITA4']);
//    unset($_SESSION['VALOR4']);
//    unset($_SESSION['OBS4']);
//    unset($_SESSION['VALOR_DOCARJ']);
//    unset($_SESSION['DESCRICAO_RECEITA1']);
//    unset($_SESSION['DESCRICAO_RECEITA2']);
//    unset($_SESSION['DESCRICAO_RECEITA3']);
//    unset($_SESSION['DESCRICAO_RECEITA3']);
//    unset($_SESSION['EMISSAO']);
          
          
    
}else{
      die(header("Location: ../../../index.php"));
}
?>