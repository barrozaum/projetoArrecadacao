<?php
session_start();

include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
include_once '../funcaoPHP/function_letraMaiscula.php';
include_once '../funcaoPHP/funcaoPessoaFisica_Juridica.php';
include_once '../funcaoPHP/funcaoCpfCnpj.php';
include_once '../funcaoPHP/funcao_retorna_descricao_cod_banco.php';
include_once './controle_rel_comprovante_Docarj.php';
?>




<?php
// INDICA QUE PARA A GUIA QUE ESSE ARQUIVO FOI CHAMADO CORRETAMENTE
$_SESSION['IMPRIMIR_GUIA_ITBI'] = 'ON';

// TITULO DO FORMULARIO, CARREGADO NO ARQUIVO CARREGAR PARAMETROS
$titulo_personalizacao = $_SESSION['C_PREFEITURA'];

// TITULO DA SECRETÁRIA DO FORMULARIO, CARREGADO NO ARQUIVO CARREGAR PARAMETROS
$titulo_secretaria = $_SESSION['C_SECRETARIA'];
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/> 
        <meta charset="utf-8" />
        <title>Arrecadação</title>
        <link href="../../css/guias_pagamento.css" rel="stylesheet" />
    </head>

    <body>
        <?php

        function exibir_comprovante($parcela, $num_dam, $ano_dam) {

            try {
                include_once '../estrutura/conexao/conexao.php';

                $sql = "SELECT * FROM financeiro_dam fd, dam d ";
                $sql = $sql . " WHERE fd.Num_Dam = '{$num_dam}'";
                $sql = $sql . " AND fd.Ano_Dam = '{$ano_dam}'";
                $sql = $sql . " AND fd.Parcela = '{$parcela}'";
                $sql = $sql . " AND fd.Num_Dam =  d.Num_dam";
                $sql = $sql . " AND fd.Ano_Dam = d.Ano_Dam";

                $query = $pdo->prepare($sql);
                $query->execute();
                if (($dados = $query->fetch()) == true) {
                    $nome_contribuinte = $dados['Nome_Contribuinte'];
                    $tipo_pessoa = FUN_MOSTRAR_DESCRICAO_TIPO_PESSOA($dados['Tipo_Pessoa']);
                    $cpf_cnpj = FUN_COLOCAR_MASCARA_CPF_CNPJ($dados['CPF_CGC']);
                    $inscricao = $dados['Inscricao'];
                    $logradouro = $dados['Logradouro'];
                    $numero_endereco = $dados['Numero'];
                    $complemento_endereco = $dados['Complemento'];
                    $bairro_endereco = $dados['Bairro'];
                    $distrito_endereco = $dados['Distrito'];
                    $cidade_endereco = $dados['Cidade'];
                    $uf_endereco = $dados['UF'];
                    $cep_endereco = $dados['CEP'];
                    $cod_atividade = $dados['Cod_Atividade'];
                    $desc_atividade = $dados['Desc_Atividade'];
                    $vencimento = dataBrasileiro($dados['Vencimento']);
                    $valor_dam = mostrarDinheiro($dados['Valor']);
                    $data_pagamento = dataBrasileiro($dados['Data_Pagamento']);
                    $valor_pago_dam = mostrarDinheiro($dados['Valor_Pagamento']);
                    $descricao_banco = fun_retorna_descricao_cod_banco($pdo, $dados['Cod_Banco']);
                    $receita_1 = $dados['Receita_1'];
                    $desc_receita_1 = $dados['Desc_Receita_1'];
                    $valor_1 = mostrarDinheiro($dados['Valor_1']);
                    $obs_1 = $dados['Obs_1'];
                    $receita_2 = $dados['Receita_2'];
                    $desc_receita_2 = $dados['Desc_Receita_2'];
                    $valor_2 = mostrarDinheiro($dados['Valor_2']);
                    $obs_2 = $dados['Obs_2'];
                    $receita_3 = $dados['Receita_3'];
                    $desc_receita_3 = $dados['Desc_Receita_3'];
                    $valor_3 = mostrarDinheiro($dados['Valor_3']);
                    $obs_3 = $dados['Obs_3'];
                    $receita_4 = $dados['Receita_4'];
                    $desc_receita_4 = $dados['Desc_Receita_4'];
                    $valor_4 = mostrarDinheiro($dados['Valor_4']);
                    $obs_4 = $dados['Obs_4'];

                    $soma_valores = mostrarDinheiro($dados['Valor_1'] + $dados['Valor_2'] + $dados['Valor_3'] + $dados['Valor_4']);
                }

//            fecho conexao
                $pdo = null;
            } catch (Exception $e) {
                $erro[] = $e->getMessage();
                mostrar_erro_validacao($erro);
            }
            ?>
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
                                                        <td width="49%" valign="left"><font size="3"><b>  <?php print $_SESSION['C_PREFEITURA']; ?></b></font>
                                                            <br /><font size="1"><?php print $_SESSION['C_SECRETARIA']; ?></font>
                                                            <br /><font size="1">COMPROVANTE PAGAMENTO DAM</font>

                                                        </td>
                                                        <td valign="top" height="auto">
                                                            <table align="center" width="100%" border="1" cellspacing="0" height="11" bordercolor="#000000">
                                                                <tr valign="top">
                                                                    <td width="15%" height="15  " bgcolor="#CCCCCC" >
                                                                        <font size="1">&nbsp;DATA EMISSÃO &nbsp; <?php print date('d/m/Y H:i:s') ?></font>
                                                                    </td>

                                                                </tr>
                                                                <tr valign="top">
                                                                    <td width="15%" height="15  " bgcolor="#CCCCCC" align="center" >
                                                                        <font size="4" align="center">DOCARJ </font>
                                                                    </td>

                                                                </tr>
                                                                <tr valign="top">
                                                                    <td width="15%" height="15  " bgcolor="#CCCCCC" >
                                                                        <font size="2">PARCELA <?php print $parcela; ?></font>
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
                                                    <b><font size="2"> CONTRIBUINTE</font></b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="38" valign="top" width="100%">
                                                <table width="100%" border="0" cellspacing="0" >
                                                    <tr>
                                                        <td valign="top"><font size="1">Nome : &nbsp  <?php echo $nome_contribuinte; ?></font></td>
                                                    </tr>
                                                    <tr>

                                                        <td valign="top"><font size="1">COD. ATIV. : &nbsp  <?php echo $cod_atividade; ?></font></td>
                                                        <td valign="top"><font size="1">DESC. ATIV. : &nbsp  <?php echo $desc_atividade; ?></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top"><font size="1">TIPO PESSOA : &nbsp  <?php print $tipo_pessoa; ?></font></td>
                                                        <td valign="top"><font size="1">CPF/CNPJ : &nbsp  <?php print $cpf_cnpj; ?></font></td>
                                                        <td valign="top"><font size="1">INSCRIÇÃO : &nbsp  <?php print $inscricao; ?></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" height="38" valign="top" width="100%">
                                                            <table align="center" width="100%" border="1" height="52" cellspacing="0" bordercolor="#000000">
                                                                <tr bgcolor="#CCCCCC">
                                                                    <td colspan="5" height="auto">
                                                                        <div align="LEFT">
                                                                            <b><font size="2"> ENDEREÇO</font></b>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <td valign="top"><font size="1">RUA : &nbsp  <?php print $logradouro; ?></font></td>
                                                                    <td valign="top"><font size="1">NÚMERO : &nbsp <?php print $numero_endereco; ?></font></td>
                                                                    <td valign="top" colspan="2"><font size="1">COMPLEMENTO : &nbsp  <?php print $complemento_endereco; ?></font></td>
                                                                    <td valign="top" colspan="2"><font size="1">COMPLEMENTO : &nbsp  <?php print $complemento_endereco; ?></font></td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top"><font size="1">BAIRRO : &nbsp  <?php print $bairro_endereco; ?></font></td>
                                                                    <td valign="top"><font size="1">CEP : &nbsp <?php print $cep_endereco; ?></font></td>
                                                                    <td valign="top"><font size="1">CIDADE : &nbsp  <?php print $cidade_endereco; ?></font></td>
                                                                    <td valign="top"><font size="1">UF : &nbsp  <?php print $uf_endereco; ?></font></td>
                                                                    <td valign="top"><font size="1">DISTRITO : &nbsp  <?php print $distrito_endereco; ?></font></td>
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
                                                    <b><font size="2"> DESCRIÇÃO DAM</font></b>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="38" valign="top" width="100%">
                                                <table width="100%" border="0" cellspacing="0" >
                                                    <tr>
                                                        <td valign="top"><font size="1">NÚMERO / ANO DAM : &nbsp  <?php echo $num_dam . " / " . $ano_dam; ?></font></td>
                                                        <td valign="top"><font size="1">VENCIMENTO : &nbsp  <?php echo $vencimento; ?></font></td>
                                                        <td valign="top"><font size="1">PAGAMENTO : &nbsp  <?php echo $data_pagamento; ?></font></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top"><font size="1">VALOR_DAM : &nbsp  <?php echo $valor_dam; ?></font></td>
                                                        <td valign="top"><font size="1">VALOR_PAGO_DAM : &nbsp  <?php echo $valor_pago_dam; ?></font></td>
                                                        <td valign="top"><font size="1">BANCO_PAGTO : &nbsp  <?php echo $descricao_banco; ?></font></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" height="38" valign="top" width="100%">
                                                            <table align="center" width="100%" border="1" height="52" cellspacing="0" bordercolor="#000000">
                                                                <tr bgcolor="#CCCCCC">
                                                                    <td colspan="5" height="auto">
                                                                        <div align="LEFT">
                                                                            <b><font size="2"> ESPECIFICAÇÃO RECEITA</font></b>
                                                                        </div>
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <td valign="top"><font size="1">CÓDIGO : <br /></font></td>
                                                                    <td valign="top"><font size="1">DESCRICAO : <br /></font></td>
                                                                    <td valign="top"><font size="1">OBSERVACAO :<br /></font></td>
                                                                    <td valign="top"><font size="1">VALOR R$ :<br /> </font></td>
                                                                </tr>

                                                                <tr>
                                                                    <td valign="top"><font size="1">&nbsp  <?php print $receita_1; ?></font></td>
                                                                    <td valign="top"><font size="1">&nbsp  <?php print $desc_receita_1; ?></font></td>
                                                                    <td valign="top"><font size="1">&nbsp <?php print $obs_1; ?></font></td>
                                                                    <td valign="top"><font size="1">&nbsp <?php print $valor_1; ?></font></td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top"><font size="1">&nbsp  <?php print $receita_2; ?></font></td>
                                                                    <td valign="top"><font size="1">&nbsp  <?php print $desc_receita_2; ?></font></td>
                                                                    <td valign="top"><font size="1">&nbsp <?php print $obs_2; ?></font></td>
                                                                    <td valign="top"><font size="1">&nbsp <?php print $valor_2; ?></font></td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top"><font size="1">&nbsp  <?php print $receita_3; ?></font></td>
                                                                    <td valign="top"><font size="1">&nbsp  <?php print $desc_receita_3; ?></font></td>
                                                                    <td valign="top"><font size="1">&nbsp <?php print $obs_3; ?></font></td>
                                                                    <td valign="top"><font size="1">&nbsp <?php print $valor_3; ?></font></td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top"><font size="1">&nbsp  <?php print $receita_4; ?></font></td>
                                                                    <td valign="top"><font size="1">&nbsp  <?php print $desc_receita_4; ?></font></td>
                                                                    <td valign="top"><font size="1">&nbsp <?php print $obs_4; ?></font></td>
                                                                    <td valign="top"><font size="1">&nbsp <?php print $valor_4; ?></font></td>
                                                                </tr>

                                                                <tr>
                                                                    <td valign="top" colspan="3"><font size="1">&nbsp  Valor Total R$ :</font></td>
                                                                    <td valign="top" ><font size="1">&nbsp <?php print $soma_valores; ?></font></td>
                                                                </tr>

                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table align="center" width="100%" border="1" height="52" cellspacing="0" bordercolor="#000000">
                                        <tr bgcolor="#CCCCCC">
                                            <td colspan="3" height="17">
                                                <div align="center">
                                                    <b><font size="2"> PAGAMENTO DO DAM EFETUADO</font></b>
                                                </div>
                                            </td>
                                        </tr>

                                    </table>
                                    ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

                                </td>
                            </tr>
                        </table>    
                    </td>
                </tr>
            </table>

            <?php
        }
        ?>



    </body>
</html>
