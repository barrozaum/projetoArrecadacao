<?php
session_start();
require_once '../estrutura/conexao/conexao.php';
require_once '../funcaoPHP/funcaoData.php';
require_once './controle_rel_itbi.php';
// INDICA QUE PARA A GUIA QUE ESSE ARQUIVO FOI CHAMADO CORRETAMENTE
$_SESSION['IMPRIMIR_GUIA_ITBI'] = 'ON';

// TITULO DO FORMULARIO, CARREGADO NO ARQUIVO CARREGAR PARAMETROS
$titulo_personalizacao = $_SESSION['C_PREFEITURA'];
?>




<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
        <meta charset="utf-8" />
        <title>Arrecadação</title>
        <link href="../../css/guias_pagamento.css" rel="stylesheet" />
    </head>

    <body>
        <table style="height: 995px" border="0" >
            <tr>			
                <td style="vertical-align: top;" > <br />
                    <table style="width:18cm;" cellpadding="0" cellspacing="0" border="0" align="center" >
                        <tr>
                            <td height="79" valign="top">
                                <table width="100%" border="1" height="76" cellspacing="0" bordercolor="#000000">
                                    <tr>
                                        <td height="70" valign="top">
                                            <table width="100%" border="0" align="left" height="62" cellspacing="0">
                                                <tr>
                                                    <td rowspan="2" width="11%" valign="top"><img src="../../../<?php print $_SESSION['C_CAMINHO_LOGO']; ?>" width="90" height="50"></td>
                                                    <td width="49%" valign="left"><font size="3"><b><?php print $titulo_personalizacao; ?></b></font>
                                                        <br /><font size="1">SECRETÁRIA DE FAZENDA</font>
                                                        <br /><font size="1">GUIA DE INFORMAÇÃO E LANÇAMENTO D I.T.B.I.</font>
                                                        <br /><font size="1">IMPOSTO DE TRANSMISSÃO E BENS IMÓVEIS</font>


                                                    </td>
                                                    <td valign="top" height="auto">
                                                        <table align="center" width="100%" border="1" cellspacing="0" height="11" bordercolor="#000000">
                                                            <tr valign="top">
                                                                <td width="15%" height="15  " bgcolor="#CCCCCC" align="center">
                                                                    <font size="1">&nbsp;DATA EMISSÃO &nbsp; <?php print date('d/m/Y H:i:s') ?></font>
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
                            <td valign="top" height="auto">
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
                            <td valign="top" height="auto">
                                <table align="center" width="100%" border="1" height="52" cellspacing="0" bordercolor="#000000">
                                    <tr bgcolor="#CCCCCC">
                                        <td colspan="3" height="17">
                                            <div align="center">
                                                <b><font size="2"> ESPECIFICAÇÃO DA TRANSAÇÃO</font></b>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="38" valign="top" width="100%">
                                            <table width="100%" border="0" cellspacing="0" >
                                                <tr>
                                                    <td valign="top"><font size="1">NATUREZA : &nbsp <?php print $natureza; ?></font></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"><font size="1">VALOR DECLARADO : &nbsp <?php print $valor_declarado; ?></font></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"><font size="1">DOC LEGAL : &nbsp <?php print $doc_legal; ?></font></td>
                                                    <td valign="top"><font size="1">LIVRO : &nbsp <?php print $livro; ?></font></td>
                                                    <td valign="top"><font size="1">FOLHA : &nbsp <?php print $folha; ?></font></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"><font size="1">DATA : &nbsp <?php print $data_esp; ?></font></td>
                                                    <td valign="top"><font size="1">PROCESSO : &nbsp <?php print $numero_proc_esp; ?></font></td>
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
                                                <b><font size="2"> LANÇAMENTO DO IMPOSTO</font></b>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="38" valign="top" width="100%">
                                            <table width="100%" border="0" cellspacing="0" >
                                                <tr>
                                                    <td valign="top"><font size="1">BASE DE CÁLCULO: &nbsp <?php print $base_calculo; ?></font></td>
                                                    <td valign="top"><font size="1">ALÍQUOTA : &nbsp <?php print $aliquota; ?></font></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"><font size="1">VALOR IMPOSTO: &nbsp <?php print $valor_imposto; ?></font></td>
                                                    <td valign="top"><font size="1">LANÇAMENTO : &nbsp <?php print $data_lancamento; ?></font></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"><font size="1">VALOR MULTA: &nbsp <?php print $valor_multa; ?></font></td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"><font size="1">VALOR TOTAL: &nbsp <?php print $valor_total; ?></font></td>
                                                    <td valign="top"><font size="1">VENCIMENTO : &nbsp <?php print $vencimento; ?></font></td>
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
                                                <b><font size="2"> OBSERVAÇÃO</font></b>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="38" valign="top" width="100%">
                                            <table width="100%" border="0" cellspacing="0" >
                                                <tr>
                                                    <td valign="top"><font size="2"><?php print $obs_Itbi; ?></font></td>
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
                                    <tr>
                                        <td height="38" valign="top" width="100%">
                                            <table width="100%" border="0" cellspacing="0" >
                                                <tr>
                                                    <td valign="top">
                                                        <font size="1.9">
                                                            FUNDAMENTAÇÃO LEGAL:<BR />
                                                            LEI N° 495/88 E L.C.N°004/93:<BR /><BR />
                                                            <i><strong>QUASQUER RECLAMAÇÕES SOMENTES SERÃO ACEITAS <BR />
                                                                    MEDIANTE A APRESENTAÇÃO DESTA GUIA.</strong></i>
                                                        </font>
                                                   </td>
                                                    <td valign="top">
                                                        <font size="1.9">
                                                            DECLARO SEREM VERÍDICAS AS INFORMAÇÕES <BR />
                                                            CONSTANTES DESTA GUIA, E TOMO CIÊNCIA, NESTA <BR />
                                                            DATA, DO LANÇAMENTO DO IMPOSTO DEVIDO.
                                                        </font>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td valign="top"><font size="1">ITBI N° <?php print $num_ano_itbi; ?></font></td>
                                                    <td valign="top">
                                                       
                                                    -----------------------------------------------------------------------------<BR />
                                                        <font size="1" align="center">ASSINATURA DO DECLARANTE</font>
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
                </td>
            </tr>
        </table>

    </body>
</html>