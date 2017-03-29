<?php
session_start();
include_once '../estrutura/conexao/conexao.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
include_once '../funcaoPHP/funcaoData.php';
include_once './barcode.php';
include_once './util.php';
include_once './complemento_guia.php';
//variaveis globais
$valor_ufir_do_dia = moeda($pdo);
$cod_divida_imob = array();
$valor_divida_imob = array();
$vr_iptu_ufir = 0;
$valor_multa = 0;
$valor_juros = 0;
$vr_tx_expediente = '8,80';


//Dados do formulario
$inscricao = $_POST['inscricao'];
$ano_iptu = $_POST['ano_final'];



//dados_imóvel
//IMÓVEL -> PROPRIETARIO
$proprietario = "";

// IMÓVEL -> LOCALIZAÇÃO
$bairro_imovel = "";
$rua_imovel = "";
$num_imovel = "";
$lote_imovel = "";
$quadra_imovel = "";

// IMÓVEL -> DIMENSÃO

$Area_Terreno = "";
$Area_Construida = "";
$vr_venal = mostrarDinheiro(valor_venal($inscricao, $pdo, $ano_iptu));
$ano = $_POST['ano_final'];
$area_terreno = 0;
$area_construida = 0;
dados_imovel($pdo, $inscricao);


//data_emissao da guia 
$data_emissao_guia = date('d/m/Y');
$quantidade_de_parcelas = 6;
$data_vencimento= $_POST['data'];


//Dados da Dívida
composicao_divida ($pdo, $inscricao, $ano);
$vr_iptu_real = calcular_iptu_real($vr_iptu_ufir);
busca_juros_multas($pdo, $inscricao, $ano);

//Mensagem dos boletos
$mensagem_desconto = "<BR />MENSAGEM ";
$mensagem_lancamento_divida = "Sr.Contribuinte: Seu IPTU 2016 foi lançado em 04/01/2016.";
$mensagem_lancamento_divida = $mensagem_lancamento_divida . "<br>Pague Seus Impostos em dia, evite a D&iacute;vida Ativa.";
$mensagem_lancamento_divida = $mensagem_lancamento_divida . "<br>Japeri agradece";

// INICIO da opção de percelamento - cota_unicao

if(isset($_POST)){
    $parcela = '00'; 
    $percent_desconto = 0;
    $mes_emissao = date('m');
    $ano_emissao = date('Y');
    $ultimo_dia = diasNoMes($mes_emissao, $ano_emissao);
    
    $op_pagto = 'COTA ÚNICA';
}else{
    echo 'PARCELADO EM ' ;  
}
// Fim da opção de percelamento - cota_unicao





// numero da guia
$num_guia = proxima_guia($pdo);

//barra ficha compensacao
$barra_banco = '341';
$barra_moeda = '9';
$barra_digito = '0';
$barra_vencimento = fator_vencimento($data_vencimento);
$barra_valor = zeros(mostrarDinheiroSoNumero(calcula_iptu($vr_tx_expediente))) . mostrarDinheiroSoNumero(calcula_iptu($vr_tx_expediente));
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

<?php 
if(isset($_POST)){
    $op_pagto = 'Cota Única';
}else{
    $op_pagto =  'Parcelado ';  
}

//tipo da divida 
if ($_POST['divida'] == '01') {
    $divida =  'IMPOSTO PREDIAL '.$ano;
} else {
    $divida =  'IMPOSTO TERRITORIAL '.$ano;
} 
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
      <?php for($i = 0; $i < 1; $i++) {?>
        <table style="height: 995px" border="0" >
            <tr>			
                <td style="vertical-align: top;" > <br />
                    <table style="width:18cm;" cellpadding="0" cellspacing="0" border="0" align="center" >
                        <tr>
                            <td style="text-align: right;height: 50px;" ><a href="javascript:window.print();" style="text-decoration: none"  >Clique aqui para imprimir <img src="../../imagens/guias/impressora.gif" alt="Imprimir" border="0" /></a></td>
                        </tr>
                    </table>
                    <table style="width:18cm;" cellpadding="0" cellspacing="0" border="0" align="center" >
                        <tr>
                            <td height="79" valign="top">
                                <table width="100%" border="1" height="76" cellspacing="0" bordercolor="#000000">
                                    <tr>
                                        <td height="70" valign="top">
                                            <table width="100%" border="0" align="left" height="62" cellspacing="0">
                                                <tr>
                                                    <td rowspan="2" width="11%" valign="top"><img src="../../imagens/estrutura/logo.jpg" width="67" height="65"></td>
                                                    <td width="49%" valign="left"><font size="3"><b>Prefeitura Municipal de Japeri</b></font>
                                                    <br /><font size="1">DOCUMENTO DE ARRECADA&Ccedil;&Atilde;O DE RECEITAS MUNICIPAIS</font></td>
                                                    <td valign="top" height="auto">
                                                        <table align="center" width="100%" border="1" cellspacing="0" height="11" bordercolor="#000000">
                                                            <tr valign="top">
                                                                <td width="15%" height="15  " bgcolor="#CCCCCC">
                                                                    <font size="1">&nbsp;INSCRIÇÃO &nbsp;</font>
                                                                </td>
                                                                <td width="22%" height="15" bgcolor="#CCCCCC">
                                                                    <div align="center"><font size="1">&nbsp; EXERCÍCIO &nbsp;</font></div>
                                                                </td>
                                                             </tr>
                                                            <tr>
                                                                <td width="15%" height="11" valign="top">
                                                                    <div align="center"><?php print $inscricao; ?></div>
                                                                </td>
                                                                <td width="22%" height="11" valign="top">
                                                                    <div align="center"><?php print $ano; ?></div>
                                                                </td>

                                                            </tr>
                                                             <tr valign="top">
                                                                <td width="22%" height="15" bgcolor="#CCCCCC">
                                                                    <div align="center"><font size="1"> &nbsp;PARCELA &nbsp</font></div>
                                                                </td>
                                                                 <td width="15%" height="15  " bgcolor="#CCCCCC"><font size="1">&nbsp;VENCIMENTO &nbsp;</font></td>

                                                             </tr>
                                                            <tr>
                                                                <td width="22%" height="11" valign="top">
                                                                    <div align="center"><?php print $op_pagto; ?></div>
                                                                </td>
                                                                 <td width="22%" height="11" valign="top">
                                                                    <div align="center"><?php print $data_vencimento; ?></div>
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
                            <td valign="top" height="62">
                                <table align="center" width="100%" border="1" height="52" cellspacing="0" bordercolor="#000000">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="3" height="17">
                                            <div align="center">
                                                <b><font size="2"><?php print $divida;?> </font></b>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="38" valign="top" width="236">
                                            <table width="100%" border="0" cellspacing="0">
                                                <tr>
                                                    <td valign="top"><font size="1">Contribuinte</font></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"><font size="1"><?php echo $proprietario ?></font></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td height="38" valign="top" width="407">
                                            <table width="100%" border="0" cellspacing="0">
                                                <tr>
                                                    <td valign="top"><font size="1">Endere&ccedil;o Im&oacute;vel</font></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"><font size="1"><?php echo $rua_imovel . "-" . $num_imovel ."- QD". $quadra_imovel ."- LT".  $lote_imovel  ."-". $bairro_imovel; ?></font></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" height="auto">
                                <table align="center" width="100%" border="1" cellspacing="0" height="auto" bordercolor="#000000">
                                    <tr valign="top">
                                        <td width="22%" height="19" bgcolor="#CCCCCC"><font size="1">&nbsp;Especificação da Receita:</font></td>
                                        <td width="12%" height="19" bgcolor="#CCCCCC">
                                            <div align="center"><font size="1"> Valor</font></div>
                                        </td>
                                        <td width="63%" height="19" bgcolor="#CCCCCC">
                                            <div align="center"><font size="1"> &nbsp;Informa&ccedil;&otilde;es</font></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="30%" height="auto" valign="top">
                                            <div align="left">
                                               <font size="1">
                                                <?php 
                                                 foreach ($cod_divida_imob as $cod) {
                                                    print $cod;
                                                    print "<br />";
                                                } 
                                                
                                                ?>
                                               </font>
                                            </div>
                                        </td>
                                        <td width="15%" height="auto" valign="top">
                                            <div align="center">
                                                <font size="1">
                                                <?php
                                                foreach ($valor_divida_imob as $value) {
                                                    print mostrarDinheiro4Casas($value);
                                                    print "<br />";
                                                } 
                                                ?> 
                                                     </font>
                                            </div>
                                        </td>
                                        
                                        <td height="auto">
                                            <table width="100%" border="0" min-height="auto">
                                                <tr>
                                                    <td valign="top"><font size="1">&Aacute;rea Terreno (M2): <?php print $Area_Terreno; ?></font></td>
                                                    <td valign="top"><font size="1">&Aacute;rea Construida (M2): <?php print $Area_Construida; ?></font></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"><font size="1">Vr Venal (R$): <?php print $vr_venal; ?></font></td>
                                                    <td valign="top"><font size="1">Vr Iptu (R$): <?php print mostrarDinheiro4Casas($vr_iptu_real); ?> </font></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" colspan="2">
                                                        <?php 
                                                        print $mensagem_desconto; 
                                                        ?>
                                                    </td>
                                                </tr>
                                               
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" height="116"> 
                                <table width="100%" border="0" height="83" cellspacing="0">
                                    <tr>
                                        <td valign="top" height="101"> 
                                            <table align="center" width="100%" border="0" cellspacing="0" height="77">
                                                <tr>
                                                    <td colspan="2" height="41" valign="top">
                                                        <table align="center" width="100%" border="1" height="35" cellspacing="0" bordercolor="#000000">
                                                            <tr>
                                                                <td height="33" valign="top">
                                                                    <table width="100%" border="0">
                                                                        <tr>
                                                                            <td align="center" height="13">
                                                                                <font size="2">
                                                                                    <b>
                                                                                        <?php print $mensagem_lancamento_divida; ?>
                                                                                    </b>
                                                                                </font>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="78%" height="16" valign="top">
                                                        <font face="Arial, Helvetica, sans-serif" size="1">
                                                            Autentica&ccedil;&atilde;o Mec&acirc;nica
                                                        </font>
                                                    </td>
                                                    <td width="22%" height="16" valign="top">
                                                        <div align="right"><font size="1">Emiss&atilde;o: <?php print $data_emissao_guia . date('H:i:s'); ?></font><font size="2"><b><i></i></b></font></div>
                                                    </td>
                                                </tr>
                                                <tr valign="top" align="center">
                                                    <td colspan="2" height="34"> 
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
                        <tr>
                            <td valign="top" height="10">
                                <div align="center">
                                    <p>-------------------------------------------------------------------------------------------------------------------------------------------------------------------------</p>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table style="width:18cm;" cellpadding="0" cellspacing="0" border="0" align="center" >
                        <tr>
                            <td>&nbsp;
                            </td>
                        </tr>
                    </table>
                    <table style="width:18cm;" cellpadding="0" cellspacing="0" border="0" align="center" >
                        <tr>
                            <td>
                                <table class="bordelessTop" cellpadding="0" cellspacing="0" border="1" >
                                    <tr style="text-align: center;" >
                                        <td class="negrito" style="width: 160px" >BANCO ITA&Uacute; S.A.</td>
                                        <td class="huge" style="vertical-align: bottom;width: 50px" ><b>&nbsp;341-7&nbsp;</b></td>
                                        <td class="huge" style="vertical-align: bottom;" >
                                            <?php echo $barra_linha_digitavel; ?>
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
                                        <td class="negrito" style="text-align: right;" ><?php print $data_vencimento; ?> &nbsp;&nbsp;&nbsp; </td>
                                    </tr>
                                    <tr> 
                                        <td class="topbottombordeLess" >Cedente</td>
                                        <td class="topbottombordeLess" >Agência/Código Cedente</td>
                                    </tr>
                                    <tr> 
                                        <td class="prefeitura" >Prefeitura Municipal de Japeri</td>
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
                                                    <td class="negrito" ><?php print $data_emissao_guia; ?></td>
                                                    <td class="negrito" style="text-align: center;" ><?php print $inscricao; ?></td>
                                                    <td class="negrito" >Outros</td>
                                                    <td class="negrito" width="80px" >N</td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="topbottombordeLess" >Nosso Número</td>
                                    </tr>
                                    <tr> 
                                        <td class="negrito" style="text-align: right;" > 
                                          <?php echo '175/' . $barra_nosso_numero . '-' . $barra_digito_nosso_num ?> &nbsp;&nbsp;&nbsp; 
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
                                                    <td style="font-size: 7pt;" colspan="2" >Taxa de Expediente R$ <?php echo $vr_tx_expediente; ?></td>
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
                                        <td class="negrito" style="text-align: right;" ><?php print $vr_tx_expediente; ?>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    </tr>
                                    <tr> 
                                        <td class="topbottombordeLess"  >(=)Valor Cobrado</td>
                                    </tr>
                                    <tr> 
                                        <td class="negrito" style="text-align: right;" ><?php print mostrarDinheiro(calcula_iptu($vr_tx_expediente)); ?> &nbsp;&nbsp;&nbsp; </td>
                                    </tr>
                                    <tr> 
                                        <td colspan="2" > 
                                            <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                                <tr> 
                                                    <td colspan="4" >Sacado</td>
                                                </tr>
                                                <tr style="font-weight: bold;" > 
                                                    <td class="arialPadding"  ><?php print $proprietario; ?></td>
                                                    <td class="arialPadding" ></td>
                                                    <td>&nbsp;</td>
                                                    <td  >&nbsp;</td>
                                                </tr>
                                                <tr style="font-weight: bold;padding-bottom: 5px" > 
                                                    <td class="arialPadding" >&nbsp;</td>
                                                    <td></td>
                                                    <td class="negrito" style="text-align: right;" >Inscri&ccedil;&atilde;o  Municipal:</td>
                                                    <td class="negrito" style="text-align: left;" > 
                                                        <?php print $inscricao; ?>
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

								<td class="dashedBorder" style="text-align: center;" ><?php echo fbarcode($barra_numero); ?></td>

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
      <?php }?>
    </body>
</html>