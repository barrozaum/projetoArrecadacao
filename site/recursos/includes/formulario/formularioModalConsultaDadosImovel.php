<?php
include_once '../estrutura/controle/validarSessao.php';
include_once '../estrutura/conexao/conexao.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
$inscricao = $_POST['codigo'];


$sql_imob = "SELECT * ";
$sql_imob = $sql_imob . " FROM Cad_Imobiliario";
$sql_imob = $sql_imob . " WHERE Inscricao_imob = '$inscricao'";

$query_imob = $pdo->prepare($sql_imob);
//executo o comando sql
$query_imob->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
if (($dados = $query_imob->fetch()) == false) {
    die("Inscricao Não Encontrada");
} else {
    //IDENTIFICAÇÃO DO IMÓVEL / PROPRIETÁRIO
    $Proprietario = $dados['Proprietario'];

    if ($dados['Tipo_Imposto'] == 1) {
        $Tipo_Imposto = "PREDIAL";
    } else {
        $Tipo_Imposto = "TERRITORIAL";
    }
    $cad_provisorio = $dados['cad_provisorio'];
    $Excluido = $dados['Excluido'];
    $carne_devolvido = $dados['carne_devolvido'];

    //IDENTIFICAÇÃO DO CONTRIBUINTE
    $nome_contribuinte = $dados['Contribuinte'];
    $Telefone_Contrib = $dados['Telefone_Contrib'];
    $Cpf_Cgc_Contrib = $dados['Cpf_Cgc_Contrib'];
    $Tipo_Pessoa_Contrib = tipo_pessoa($dados['Tipo_Pessoa_Contrib']);
    $RG_Contrib = $dados['RG_Contrib'];
    $Orgao_Contrib = $dados['Orgao_Contrib'];
    $Emissao_Contrib = dataBrasileiro($dados['Emissao_Contrib']);
    $Dt_Nascimento_Contrib = dataBrasileiro($dados['Dt_Nascimento_Contrib']);
    $Cep_Contrib = $dados['Cep_Contrib'];
    $Rua_Contrib = $dados['Rua_Contrib'];
    $Bairro_Contrib = $dados['Bairro_Contrib'];
    $Cidade_Contrib = $dados['Cidade_Contrib'];
    $UF_Contrib = $dados['UF_Contrib'];
    $Numero_Contrib = $dados['Numero_Contrib'];
    $Complemento_Contrib = $dados['Complemento_Contrib'];


    // IDENTIFICAÇÃO LOCALIZAÇÃO DO IMÓVEL
    $Cod_Bairro = $dados['Cod_Bairro'];
    $desc_cod_bairro = retornaBairo($pdo, $dados['Cod_Bairro']);
    $Cod_Rua = $dados['Cod_Rua'];
    $retornoRua = retornaRua($pdo, $dados['Cod_Rua']);
    $partes_logradouro = explode("#", $retornoRua);
    $desc_cod_rua = $partes_logradouro[0];
    $cep = $partes_logradouro[1];
    $Numero = $dados['Numero'];
    $Quadra = $dados['Quadra'];
    $Lote = $dados['Lote'];
    $Zona_Fiscal = $dados['Zona_Fiscal'];
    $Complemento = $dados['Complemento'];

    //ENDEREÇO CORRESPÔNDENCIA
    $Nome_Corr = $dados['Nome_Corr'];
    $Telefone_Corr = $dados['Telefone'];
    $Cpf_Cgc_Corr = $dados['Cpf_Cgc'];
    $Tipo_Pessoa_Corr = tipo_pessoa($dados['Tipo_Pessoa']);
    $Cep_Corr = $dados['Cep_Corr'];
    $Rua_Corr = $dados['Rua_Corr'];
    $Bairro_Corr = $dados['Bairro_Corr'];
    $Cidade_Corr = $dados['Cidade_Corr'];
    $Uf_Corr = $dados['Uf_Corr'];
    $Numero_corr = $dados['Numero_corr'];
    $Complemento_Corr = $dados['Complemento_Corr'];

    //DIMENSÃO DO IMÓVEL
    $Largura_Terreno = $dados['Largura_Terreno'];
    $Comprimento_Terreno = $dados['Comprimento_Terreno'];
    $Area_Terreno = $dados['Area_Terreno'];
    $Area_Construida = $dados['Area_Construida'];
    $Fracao_Ideal = $dados['Fracao_Ideal'];
    $Tem_Manutencao_Esgoto = $dados['Tem_Manutencao_Esgoto'];
    $DESCONTO_INDUSTRIA = $dados['DESCONTO_INDUSTRIA'];

    //ESTADO DA CONSTRUÇÃO
    $EC_Tijolo = $dados['EC_Tijolo'];
    $EC_Madeira = $dados['EC_Madeira'];
    $EC_Embocada = $dados['EC_Embocada'];
    $EC_Pintada = $dados['EC_Pintada'];
    $EC_Telha = $dados['EC_Telha'];
    $EC_laje = $dados['EC_laje'];
    $EC_Taco = $dados['EC_Taco'];
    $EC_Ceramica = $dados['EC_Ceramica'];
    $EC_Outros = $dados['EC_Outros'];
    $Cod_Utilizacao_imovel = $dados['Utilizacao_imovel'];
    $Utilizacao_imovel = retornaUtilizacao($pdo, $dados['Utilizacao_imovel']);
    $Cod_Situacao_Terreno = $dados['Situacao_Terreno'];
    $Situacao_Terreno = retornaSituacaoTerreno($pdo, $dados['Situacao_Terreno']);
    $Cod_Categoria = $dados['Categoria'];
    $Categoria = retornaCategoria($pdo, $dados['Categoria']);
    $Cod_Patrimonio_imovel = $dados['Patrimonio_imovel'];
    $Patrimonio_imovel = retornaPatrimonio($pdo, $dados['Patrimonio_imovel']);
    $Cod_Tipo_coleta = $dados['Cod_Tipo_coleta'];
    $Tipo_coleta = retornaTipoColeta($pdo, $dados['Cod_Tipo_coleta']);
    $Ano_Cadastramento = $dados['Ano_Cadastramento'];

    //ISENÇÃO
    $Cod_Tipo_isencao = $dados['Tipo_isencao'];
    $Tipo_isencao = retornaTipoIsencao($pdo, $dados['Tipo_isencao']);
    $Fundamento_Legal_Isencao = $dados['Fundamento_Legal_Isencao'];
    $Proc_Adm_Isencao = $dados['Proc_Adm_Isencao'];
    $Dt_Concessao_Isencao = dataBrasileiro($dados['Dt_Concessao_Isencao']);
    $Dt_Averbacao = dataBrasileiro($dados['Dt_Averbacao']);
    $Processo_Averbacao = $dados['Processo_Averbacao'];
    $Legalizado = $dados['Legalizado'];
    $Processo_Legalizacao = $dados['Processo_Legalizacao'];
    $observacao = buscaObsCadImob($pdo, $inscricao);
}
?>




<div class="well"><!-- div que coloca a cor no formulário -->
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">DADOS IMÓVEL</h4>
    </div>

    <div class="modal-body">

        <!-- fim doJava script para dar Focus no primeiro Campo do formulário -->
        <div class="row">


            <ul class="nav nav-tabs"> <!-- menu das abas -->
                <li class="active"><a data-toggle="tab" href="#home">Identificação</a></li>
                <li><a data-toggle="tab" href="#menu1">Localização</a></li>
                <li><a data-toggle="tab" href="#menu2">End. Correspondência</a></li>
                <li><a data-toggle="tab" href="#menu3">Inf. do Imóvel</a></li>
                <li><a data-toggle="tab" href="#menu4">Inf. Gerais</a></li>
            </ul> <!-- fim dos menu das abas -->


            <div class="tab-content"><!-- abertura das abas do formulário -->

                <div id="home" class="tab-pane fade in active"> <!-- primeira aba -->
                    <div class="panel panel-default">
                        <!-- INICIO Dados do imóvel -->
                        <div class="panel-heading text-center">IDENTIFICAÇÃO DO IMÓVEL / PROPRIETÁRIO</div>
                        <div class="panel-body">
                            <!-- inicio dados inscrição-->
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="inscricao_imovel">Inscrição:</label>
                                        <input type="text" class="form-control" name ="inscricao_imovel" id="inscricao_imovel"  value="<?php print $inscricao; ?>" readonly="true" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nome_proprietario_imovel">Nome Proprietário:</label>
                                        <input type="text" class="form-control" name ="nome_proprietario_imovel" id="nome_proprietario_imovel"  value="<?php print $Proprietario; ?>" maxlength="50" placeholder="NOME PROPRIETÁRIO" readonly="true"/>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tipo_imposto_imovel">Tipo Imposto:</label>
                                        <input type="text" class="form-control" name ="tipo_imposto_imovel" id="tipo_imposto_imovel"  value="<?php print $Tipo_Imposto; ?>" maxlength="6" placeholder="" readonly="true"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <div class="form-inline text-center ">
                                        <input type="checkbox" class="form-control" name ="cadastro_provisorio" id="cadastro_provisorio" <?php if ($cad_provisorio == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="cadastro_provisorio">Cadastro Provisório:</label> &nbsp; &nbsp; &nbsp;
                                        <input type="checkbox" class="form-control" name ="excluido" id="excluido" <?php if ($Excluido == 'S') print 'checked="cheked"'; ?> />
                                        <label for="excluido">Excluído:</label> &nbsp; &nbsp; &nbsp;
                                        <input type="checkbox" class="form-control" name ="carne_devolvido" id="carne_devolvido" <?php if ($carne_devolvido == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="carne_devolvido">Carnê Devolvido:</label>

                                    </div>
                                </div>
                            </div>
                            <!-- fim dados inscrição-->
                        </div>
                        <!-- FIM Dados do imóvel -->
                        <div class="panel-heading text-center">IDENTIFICAÇÃO DO CONTRIBUINTE</div>
                        <div class="panel-body">
                            <!-- bloco dos dados do contribuinte-->

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="nome_contribuinte">NOME CONTRIBUINTE:</label>
                                        <input type="text" class="form-control" name ="nome_contribuinte" id="nome_contribuinte"  value="<?php print $nome_contribuinte; ?>" maxlength="50" placeholder="" readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="telefone_contribuinte">TELEFONE :</label>
                                        <input type="text" class="form-control" name ="telefone_contribuinte" id="telefone_contribuinte"  value="<?php print $Telefone_Contrib; ?>" maxlength="50" placeholder=""  readonly="true">
                                    </div>
                                </div>

                            </div> 
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="cpf_cnpj_contribuinte">CPF/CNPJ:</label>
                                        <input type="text" class="form-control" name ="cpf_cnpj_contribuinte" id="cpf_cnpj_contribuinte"  value="<?php print $Cpf_Cgc_Contrib; ?>" maxlength="15" placeholder="" readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tipo_pessoa_contribuinte">TIPO PESSOA:</label>
                                        <input type="text" class="form-control" name ="tipo_pessoa_contribuinte" id="tipo_pessoa_contribuinte"  value="<?php print $Tipo_Pessoa_Contrib; ?>" readonly="true"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="rg_contribuinte">RG:</label>
                                        <input type="text" class="form-control" name ="rg_contribuinte" id="rg_contribuinte"  value="<?php print $RG_Contrib; ?>" maxlength="15" placeholder="" readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="orgao_rg_contribuinte">ÓRGÃO:</label>
                                        <input type="text" class="form-control" name ="orgao_rg_contribuinte" id="orgao_rg_contribuinte"  value="<?php print $Orgao_Contrib; ?>" maxlength="15" placeholder="" readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="emissao_rg_contribuinte">EMISSÃO:</label>
                                        <input type="text" class="form-control" name ="emissao_rg_contribuinte" id="emissao_rg_contribuinte"  value="<?php print $Emissao_Contrib; ?>" maxlength="15" placeholder="" readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="data_nascimento_contribuinte">DATA NASCIMENTO:</label>
                                        <input type="text" class="form-control" name ="data_nascimento_contribuinte" id="data_nascimento_contribuinte"  value="<?php print $Dt_Nascimento_Contrib; ?>" maxlength="15" placeholder="" readonly="true">
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="cep_contribuinte">CEP:</label>
                                        <input type="text" class="form-control" name ="cep_contribuinte" id="cep_contribuinte"  value="<?php print $Cep_Contrib; ?>" maxlength="8" placeholder="" readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="rua_contribuinte">RUA:</label>
                                        <input type="text" class="form-control" name ="rua_contribuinte" id="rua_contribuinte"  value="<?php print $Rua_Contrib; ?>" maxlength="8" placeholder="" readonly="true">
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="bairro_contribuinte">BAIRRO:</label>
                                        <input type="text" class="form-control" name ="bairro_contribuinte" id="bairro_contribuinte"  value="<?php print $Bairro_Contrib; ?>" maxlength="8" placeholder="" readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="cidade_contribuinte">CIDADE:</label>
                                        <input type="text" class="form-control" name ="cidade_contribuinte" id="cidade_contribuinte"  value="<?php print $Cidade_Contrib; ?>" maxlength="8" placeholder="" readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="uf_contribuinte">UF:</label>
                                        <input type="text" class="form-control" name ="uf_contribuinte" id="uf_contribuinte"  value="<?php print $UF_Contrib; ?>" maxlength="8" placeholder="" readonly="true">
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="numero_end_contribuinte">NÚMERO:</label>
                                        <input type="text" class="form-control" name ="numero_end_contribuinte" id="numero_end_contribuinte"  value="<?php print $Numero_Contrib; ?>" maxlength="" placeholder="" readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="complemento_end_contribuinte">COMPLEMENTO:</label>
                                        <input type="text" class="form-control" name ="complemento_end_contribuinte" id="complemento_end_contribuinte"  value="<?php print $Complemento_Contrib; ?>" maxlength="" placeholder="" readonly="true">
                                    </div>
                                </div>
                            </div> 
                            <!-- bloco dos dados do contribuinte-->
                        </div>
                    </div> 
                </div><!-- fim da primeira aba -->

                <div id="menu1" class="tab-pane"> <!-- segunda aba -->
                    <div class="panel panel-default">
                        <!-- INICIO Dados do imóvel -->
                        <div class="panel-heading text-center" >IDENTIFICAÇÃO LOCALIZAÇÃO DO IMÓVEL</div>
                        <div class="panel-body">
                            <!-- inicio dados inscrição-->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cod_bairro_imovel">Cod Bairro:</label>
                                        <input type="text" class="form-control" name ="cod_bairro_imovel" id="cod_bairro_imovel"  value="<?php print $Cod_Bairro; ?>" maxlength="50" placeholder="000" readonly="true"/>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="desc_bairro_imovel">Bairro:</label>
                                        <input type="text" class="form-control" name ="desc_bairro_imovel" id="desc_bairro_imovel"  value="<?php print $desc_cod_bairro; ?>" maxlength="50" placeholder=""  readonly="true" />
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cod_logr_imovel">Cod Log:</label>
                                        <input type="text" class="form-control" name ="cod_logr_imovel" id="cod_logr_imovel"  value="<?php print $Cod_Rua; ?>" maxlength="5" placeholder="00000" readonly="true"/>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="desc_logr_imovel">Logradouro:</label>
                                        <input type="text" class="form-control" name ="desc_logr_imovel" id="desc_logr_imovel"  value="<?php print $desc_cod_rua; ?>" maxlength="50" placeholder=""  readonly="true" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cod_cep_imovel">Cep:</label>
                                        <input type="text" class="form-control" name ="cod_cep_imovel" id="cod_cep_imovel"  value="<?php print $cep; ?>" readonly="true" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="num_end_imovel">Número:</label>
                                        <input type="text" class="form-control" name ="num_end_imovel" id="num_end_imovel"  value="<?php print $Numero; ?>" maxlength="50" placeholder="000000" readonly="true"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="quadra_imovel">Quadra:</label>
                                        <input type="text" class="form-control" name ="quadra_imovel" id="quadra_imovel"  value="<?php print $Quadra; ?>" maxlength="6" placeholder="000000" readonly="true"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="lote_imovel">Lote:</label>
                                        <input type="text" class="form-control" name ="lote_imovel" id="lote_imovel"  value="<?php print $Lote; ?>" maxlength="50" placeholder="000000" readonly="true"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="zona_imovel">Zona Fiscal:</label>
                                        <input type="text" class="form-control" name ="zona_imovel" id="zona_imovel"  value="<?php print $Zona_Fiscal; ?>" maxlength="50" placeholder="000000" readonly="true"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="compl_end_imovel">Complemento:</label>
                                        <input type="text" class="form-control" name ="compl_end_imovel" id="compl_end_imovel"  value="<?php print $Complemento; ?>" maxlength="6" placeholder="000000" readonly="true"/>
                                    </div>
                                </div>
                            </div>
                            <!-- fim dados inscrição-->
                        </div>
                        <!-- FIM Dados do imóvel -->
                    </div>
                </div><!-- Fim segunda aba -->

                <div id="menu2" class="tab-pane"> <!-- segunda aba -->
                    <div class="panel panel-default">
                        <!-- INICIO Dados do imóvel -->
                        <div class="panel-heading text-center" >ENDEREÇO CORRESPÔNDENCIA </div>
                        <div class="panel-body">
                            <!-- inicio dados inscrição-->
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="nome_responsavel_correspondencia">Nome:</label>
                                        <input type="text" class="form-control" name ="nome_responsavel_correspondencia" id="nome_responsavel_correspondencia"  value="<?php print $Nome_Corr; ?>" maxlength="50" placeholder="NOME CORRESPONDENTE" readonly="true"/>
                                    </div>
                                </div>
                                <div class="col-sm-4">

                                    <div class="form-group">
                                        <label for="telefone_responsavel_correspondencia">Telefone:</label>
                                        <input type="text" class="form-control" name ="telefone_responsavel_correspondencia" id="telefone_responsavel_correspondencia"  value="<?php print $Telefone_Corr; ?>" maxlength="6" placeholder="000000" readonly="true"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="cpf_cnpj_correspondencia">CPF/CNPJ:</label>
                                        <input type="text" class="form-control" name ="cpf_cnpj_correspondencia" id="cpf_cnpj_correspondencia"  value="<?php print $Cpf_Cgc_Corr; ?>" maxlength="15" placeholder="" readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tipo_pessoa_correspondencia">TIPO PESSOA:</label>
                                        <input type="text" class="form-control" name ="tipo_pessoa_correspondencia" id="tipo_pessoa_correspondencia"  value="<?php print $Tipo_Pessoa_Corr; ?>" readonly="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="cep_correspondencia">CEP:</label>
                                        <input type="text" class="form-control" name ="cep_correspondencia" id="cep_correspondencia"  value="<?php print $Cep_Corr; ?>" maxlength="8" placeholder="" readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="rua_correspondencia">RUA:</label>
                                        <input type="text" class="form-control" name ="rua_correspondencia" id="rua_correspondencia"  value="<?php print $Rua_Corr; ?>" maxlength="8" placeholder=""  readonly="true">
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="bairro_correspondencia">BAIRRO:</label>
                                        <input type="text" class="form-control" name ="bairro_correspondencia" id="bairro_correspondencia"  value="<?php print $Bairro_Corr; ?>" maxlength="8" placeholder=""  readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="cidade_correspondencia">CIDADE:</label>
                                        <input type="text" class="form-control" name ="cidade_correspondencia" id="cidade_correspondencia"  value="<?php print $Cidade_Corr; ?>" maxlength="8" placeholder=""  readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="uf_correspondencia">UF:</label>
                                        <input type="text" class="form-control" name ="uf_correspondencia" id="uf_correspondencia"  value="<?php print $Uf_Corr; ?>" maxlength="8" placeholder=""  readonly="true">
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="numero_end_correspondencia">NÚMERO:</label>
                                        <input type="text" class="form-control" name ="numero_end_correspondencia" id="numero_end_correspondencia"  value="<?php print $Numero_corr; ?>" maxlength="" placeholder="" readonly="true">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="complemento_end_correspondencia">COMPLEMENTO:</label>
                                        <input type="text" class="form-control" name ="complemento_end_correspondencia" id="complemento_end_correspondencia"  value="<?php print $Complemento_Corr; ?>" maxlength="" placeholder="" readonly="true">
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <!-- FIM Dados do imóvel -->
                        <!-- INICIO -->
                        <div class="panel-heading text-center" > ALUGADO PELA PREFEITURA </div>
                        <div class="panel-body">
                            <?php print historicoAlugados($pdo, $inscricao); ?>
                        </div>
                        <!-- FIM  -->

                        <!-- FIM Dados do imóvel -->
                    </div>
                </div><!-- Fim segunda aba -->

                <div id="menu3" class="tab-pane"> <!-- terceira aba -->
                    <div class="panel panel-default">
                        <!-- INICIO Dimensão do Imóvel -->
                        <div class="panel-heading text-center" >DIMENSÃO DO IMÓVEL</div>
                        <div class="panel-body">
                            <!-- inicio DADOS Dimensão do Imóvel-->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="largura_terreno_imovel">Largura Terreno:</label>
                                        <input type="text" class="form-control" name ="largura_terreno_imovel" id="largura_terreno_imovel"  value="<?php print $Largura_Terreno; ?>" maxlength="6" placeholder="000000"  readonly="true"/>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="comprimento_terreno_imovel">Comprimento Terreno:</label>
                                        <input type="text" class="form-control" name ="comprimento_terreno_imovel" id="comprimento_terreno_imovel"  value="<?php print $Comprimento_Terreno; ?>" maxlength="50" placeholder="000000" readonly="true"/>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="area_terreno_imovel">Área do Terreno (M²):</label>
                                        <input type="text" class="form-control" name ="area_terreno_imovel" id="area_terreno_imovel"  value="<?php print $Area_Terreno; ?>" maxlength="50" placeholder="000000" readonly="true"/>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="area_construida_imovel">Área Construída (M²):</label>
                                        <input type="text" class="form-control" name ="area_construida_imovel" id="area_construida_imovel"  value="<?php print $Area_Construida; ?>" maxlength="6" placeholder="000000" readonly="true"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="fracao_ideal_imovel">Fração Ideal:</label>
                                        <input type="text" class="form-control" name ="fracao_ideal_imovel" id="fracao_ideal_imovel"  value="<?php print $Fracao_Ideal; ?>" maxlength="50" placeholder="000000" readonly="true"/>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-inline text-center ">
                                        <input type="checkbox" class="form-control" name ="contem_manutencao_esgoto" id="contem_manutencao_esgoto"  value="S"  <?php if ($Tem_Manutencao_Esgoto == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="contem_manutencao_esgoto">: TEM MANUTENÇÃO DE ESGOTO</label> &nbsp; &nbsp; &nbsp;
                                        <input type="checkbox" class="form-control" name ="desconto_industria" id="desconto_industria"  value="S"  <?php if ($DESCONTO_INDUSTRIA == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="desconto_industria">: INDÚSTRIA (DESCONTO DE 80%)</label> &nbsp; &nbsp; &nbsp;
                                    </div>
                                </div>
                            </div>

                            <!-- FIM DADOS Dimensão do Imóvel-->
                        </div>
                        <!-- FIM Dimensão do Imóvel -->

                        <!-- INICIO Estado da Construção -->
                        <div class="panel-heading text-center" >ESTADO DA CONSTRUÇÃO</div>
                        <div class="panel-body">
                            <div class="col-sm-12 ">
                                <div class="row">
                                    <div class="form-inline text-left ">
                                        &nbsp; &nbsp; &nbsp;<input type="checkbox" class="form-control" name ="construcao_tijolo" id="construcao_tijolo" value="S"  <?php if ($EC_Tijolo == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="construcao_tijolo">: TIJOLO</label> &nbsp; &nbsp; &nbsp;

                                        <input type="checkbox" class="form-control" name ="construcao_madeira" id="construcao_madeira"  value="S" <?php if ($EC_Madeira == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="construcao_madeira">MADEIRA</label> &nbsp; &nbsp; &nbsp;

                                        <input type="checkbox" class="form-control" name ="construcao_embocada" id="construcao_embocada" value="S" <?php if ($EC_Embocada == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="construcao_embocada">: EMBOÇADA</label> &nbsp; &nbsp; &nbsp;

                                        <input type="checkbox" class="form-control" name ="construcao_pintada" id="construcao_pintada"  value="S" <?php if ($EC_Pintada == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="construcao_pintada">: PINTADA</label> &nbsp; &nbsp; &nbsp;

                                        <input type="checkbox" class="form-control" name ="construcao_telha" id="construcao_telha"  value="S" <?php if ($EC_Telha == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="construcao_telha">: TELHA</label> &nbsp; &nbsp; &nbsp;

                                        <input type="checkbox" class="form-control" name ="construcao_laje" id="construcao_laje"  value="S" <?php if ($EC_laje == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="construcao_laje">: LAJE</label> &nbsp; &nbsp; &nbsp;

                                        <input type="checkbox" class="form-control" name ="construcao_taco" id="construcao_taco"  value="S" <?php if ($EC_Taco == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="construcao_taco">: TACO</label> &nbsp; &nbsp; &nbsp;

                                        <input type="checkbox" class="form-control" name ="construcao_ceramico" id="construcao_ceramico"  value="S" <?php if ($EC_Ceramica == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="construcao_ceramico">: CERÂMICO</label> &nbsp; &nbsp; &nbsp;

                                        <input type="checkbox" class="form-control" name ="construcao_outros" id="construcao_outros" value="S" <?php if ($EC_Outros == 'S') print 'checked="cheked"'; ?>/>
                                        <label for="construcao_outros">: OUTROS</label> &nbsp; &nbsp; &nbsp;

                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-4"><!-- inclusao do select Utilização -->
                                        <div class="form-group">
                                            <label for="utilizacao">Utilização:</label>
                                            <input type="text" class="form-control" name ="desc_utilizacao" id="desc_utilizacao" readonly="true" value="<?php print $Utilizacao_imovel; ?>" maxlength="4" placeholder="" >
                                            <input type="hidden" class="form-control" name ="utilizacao" id="utilizacao" readonly="true" value="<?php print $Cod_Utilizacao_imovel; ?>" maxlength="4" placeholder="" >
                                        </div>
                                    </div><!-- Fim inclusao do select Utilização -->
                                    <div class="col-sm-4"><!-- inclusao do select Situação Terreno -->
                                        <div class="form-group">
                                            <label for="situacao_terreno">Situação Terreno:</label>
                                            <input type="text" class="form-control" name ="desc_situacao_terreno" id="desc_situacao_terreno" readonly="true" value="<?php print $Situacao_Terreno; ?>" maxlength="4" placeholder="" >
                                            <input type="hidden" class="form-control" name ="situacao_terreno" id="situacao_terreno" readonly="true" value="<?php print $Cod_Situacao_Terreno; ?>" maxlength="4" placeholder="" >
                                        </div>
                                    </div><!-- inclusao do select Situação Terreno -->
                                    <div class="col-sm-4"><!-- inclusao do select Categoria -->
                                        <div class="form-group">
                                            <label for="categoria">Categoria:</label>
                                            <input type="text" class="form-control" name ="desc_categoria" id="desc_categoria" readonly="true" value="<?php print $Categoria; ?>" maxlength="4" placeholder="" >
                                            <input type="hidden" class="form-control" name ="categoria" id="categoria" readonly="true" value="<?php print $Cod_Categoria; ?>" maxlength="4" placeholder="" >
                                        </div>
                                    </div><!-- inclusao do select Categoria -->
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><!-- inclusao do select Patrimonio -->
                                        <div class="form-group">
                                            <label for="patrimonio_liquido">Patrimônio Líquido:</label>
                                            <input type="text" class="form-control" name ="desc_patrimonio" id="desc_patrimonio" readonly="true" value="<?php print $Patrimonio_imovel; ?>" maxlength="4" placeholder="" >
                                            <input type="hidden" class="form-control" name ="patrimonio_liquido" id="patrimonio_liquido" readonly="true" value="<?php print $Cod_Patrimonio_imovel; ?>" maxlength="4" placeholder="" >
                                        </div>
                                    </div><!-- inclusao do select Patrimonio-->

                                    <div class="col-sm-4"><!-- inclusao do select Tipo Coleta -->
                                        <div class="form-group">
                                            <label for="tipo_coleta">Tipo Coleta:</label>
                                            <input type="text" class="form-control" name ="desc_tipo_coleta" id="desc_tipo_coleta" readonly="true" value="<?php print $Tipo_coleta; ?>" maxlength="4" placeholder="" >
                                            <input type="hidden" class="form-control" name ="tipo_coleta" id="tipo_coleta" readonly="true" value="<?php print $Cod_Tipo_coleta; ?>" maxlength="4" placeholder="" >
                                        </div>
                                    </div><!-- inclusao do select Tipo Coleta-->

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="ano_cadastramento_imovel">Ano Imóvel Cadastramento:</label>
                                            <input type="text" value="<?php print $inscricao; ?>" class="form-control" name="ano_cadastramento_imovel" id="ano_cadastramento_imovel" readonly="true"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIM Estado da Construção -->

                        <div class="panel-heading text-center" >ISENÇÃO</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-4"><!-- inclusao do select Tipo Isencao -->
                                    <div class="form-group">
                                        <label for="tipo_isencao">Isenção:</label>
                                        <input type="text" class="form-control" name ="desc_tipo_isencao" id="desc_tipo_isencao" readonly="true" value="<?php print $Tipo_isencao; ?>" maxlength="4" placeholder="" >
                                        <input type="hidden" class="form-control" name ="tipo_isencao" id="tipo_isencao" readonly="true" value="<?php print $Cod_Tipo_isencao; ?>" maxlength="4" placeholder="" >
                                    </div>
                                </div><!-- inclusao do select Tipo Isencao-->
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="fundamento_legal">Fundamento Legal:</label>
                                        <input type="text" value="<?php print $Fundamento_Legal_Isencao; ?>" class="form-control" name="fundamento_legal" id="fundamento_legal" readonly="true">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="processo_administrativo">Proc. Administrativo:</label>
                                        <input type="text" value="<?php print $Proc_Adm_Isencao; ?>" class="form-control" name="processo_administrativo" id="processo_administrativo" readonly="true">

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="data_concessao">Data Concessão:</label>
                                        <input type="text" value="<?php print $Dt_Concessao_Isencao; ?>" class="form-control" name="data_concessao" id="data_concessao"readonly="true">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div><!-- Fim TERCEIRA aba -->

                <div id="menu4" class="tab-pane"> <!-- Quarta aba -->
                    <div class="panel panel-default">
                        <div class="panel-heading text-center" >OUTROS</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6 ">
                                    <div class="panel-heading text-center well" >AVERBAÇÃO</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="data_averbacao">Data:</label>
                                            <input type="text" value="<?php print $Dt_Averbacao; ?>" class="form-control" name="data_averbacao" id="data_averbacao" readonly="true">

                                            <label for="numero_processo_averbacao">N° Processo:</label>
                                            <input type="text" value="<?php print $Processo_Averbacao; ?>" class="form-control" name="numero_processo_averbacao" id="numero_processo_averbacao" readonly="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 ">
                                    <div class="panel-heading text-center well" >LEGALIZAÇÃO</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="legalizacao_imovel">Legalizado:</label>
                                            <input type="text" value="<?php print legalizado($Legalizado); ?>" class="form-control" name="legalizacao_imovel" id="legalizacao_imovel" readonly="true">

                                            <label for="numero_processo_legalizacao">N° Processo:</label>
                                            <input type="text" value="<?php print $Processo_Legalizacao; ?>" class="form-control" name="numero_processo_legalizacao" id="numero_processo_legalizacao" readonly="true">

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <!-- INICIO INFORMAÇÕES GERAIS -->
                        <div class="panel-heading text-center" >INFORMAÇÕES GERAIS </div>
                        <div class="panel-body">
                            <!-- INICIO DADOS Dimensão do Imóvel-->
                            <div class="row">
                                <div id="mostra_campo_observação">
                                </div>
                                <!-- aparece direto -->
                                <div class="col-md-12">
                                    <textarea rows="4" class="form-control" name="observacao_imovel" id="observacao_imovel" readonly="true"><?php print $observacao; ?></textarea>
                                </div>
                            </div>
                            <!-- Fim INFORMAÇÕES GERAIS-->
                        </div>
                        <!-- INICIO INFORMAÇÕES GERAIS -->
                        <div class="panel-heading text-center" >VALOR VENAL </div>
                        <div class="panel-body">
                            <?php print historicoValorVenal($pdo, $inscricao); ?>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <div id="buttons"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Quarta aba -->
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>

<?php

function tipo_pessoa($valor) {
    if ($valor == "F")
        return "Física";
    ELSE
        return "Juridica";
}

function legalizado($valor) {
    if ($valor == "1")
        return "SIM";
    ELSE
        return "NÃO";
}

function retornaRua($pdo, $cod_rua) {

// preparo para realizar o comando sql
    $sql = "SELECT * FROM Rua WHERE Cod_Rua = '$cod_rua'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {

        return $dados['Desc_rua'] . "#" . $dados['cep'];
    }
    return "#";
}

function retornaBairo($pdo, $cod_bairro) {

// preparo para realizar o comando sql
    $sql = "SELECT * FROM Bairro WHERE Cod_Bairro = '$cod_bairro'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {

        return $dados['Desc_Bairro'];
    }
    return "";
}

function retornaUtilizacao($pdo, $cod_uti) {
// preparo para realizar o comando sql
    $sql_ut = "select * FROM Utilizacao WHERE Codigo = '$cod_uti'";
    $query_ut = $pdo->prepare($sql_ut);
    //executo o comando sql
    $query_ut->execute();

    if (($dados_ut = $query_ut->fetch()) == true) {
        return $dados_ut['Descricao'];
    } else {
        return "";
    }
}

function retornaSituacaoTerreno($pdo, $cod_sit) {

    // preparo para realizar o comando sql
    $sql_st = "select * FROM Situacao_terreno WHERE Cod_situacao = '$cod_sit'";
    $query_st = $pdo->prepare($sql_st);
    //executo o comando sql
    $query_st->execute();

    if (($dados_st = $query_st->fetch()) == true) {
        return $dados_st['Desc_situacao'];
    } else {
        return "";
    }
}

function retornaCategoria($pdo, $cod_cat) {

    // preparo para realizar o comando sql
    $sql_cat = "select * FROM Categoria WHERE Codigo = '$cod_cat'";
    $query_cat = $pdo->prepare($sql_cat);
    //executo o comando sql
    $query_cat->execute();

    if (($dados_cat = $query_cat->fetch()) == true) {
        return $dados_cat['Descricao'];
    } else {
        return "";
    }
}

function retornaPatrimonio($pdo, $cod_pat) {

    // preparo para realizar o comando sql
    $sql_pat = "select * FROM Patrimonio WHERE Codigo = '$cod_pat'";
    $query_pat = $pdo->prepare($sql_pat);
    //executo o comando sql
    $query_pat->execute();

    //loop para listar todos os dados encontrados
    if (($dados_pat = $query_pat->fetch()) == true) {
        return $dados_pat['Descricao'];
    } else {
        return "";
    }
}

function retornaTipoColeta($pdo, $tipo_coleta) {
    $sql_tc = "select * FROM Tipo_Coleta WHERE Cod_Tipo_Coleta = '$tipo_coleta'";
    $query_tc = $pdo->prepare($sql_tc);
    //executo o comando sql
    $query_tc->execute();

    if (($dados_tc = $query_tc->fetch()) == true) {
        return $dados_tc['Desc_Tipo_Coleta'];
    } else {
        return "";
    }
}

function retornaTipoIsencao($pdo, $insencao) {
    $sql_isn = "select * FROM Tipo_Isencao WHERE Codigo = '$insencao'";
    $query_isn = $pdo->prepare($sql_isn);
    //executo o comando sql
    $query_isn->execute();

    //loop para listar todos os dados encontrados
    if (($dados_isn = $query_isn->fetch()) == true) {
        return $dados_isn['Descricao'];
    } else {
        return "";
    }
}

function buscaObsCadImob($pdo, $inscricao_imob) {

    // preparo para realizar o comando sql
    $sql = "SELECT * FROM Observacao_imob WHERE Inscricao_Imob = '$inscricao_imob'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['Observacao'];
    } else {
        return "";
    }
}

function historicoValorVenal($pdo, $inscricao_imob) {

// preparo para realizar o comando sql
    $sql_valor = "SELECT * FROM Valor_Venal WHERE Inscricao_Imob = '$inscricao_imob' ORDER BY Ano DESC";
    $query = $pdo->prepare($sql_valor);

//executo o comando sql
// Faço uma comparação para saber se a busca trouxe algum resultado
    $query->execute();
// crio um array através do comando fetchAll
    // crio um array através do comando fetchAll
    $result = $query->fetchAll();
// após executar o comando fetchAll() conto a quantidade de registro atráves do rowCount()
    $numero_registro = $query->rowCount();

// se existir algum registro encontrado    
    if ($numero_registro > 0) {
        $tabela = "";
        $tabela = $tabela . "<div style='max-height: 200px; overflow: auto;'>";
        $tabela = $tabela . "<table class='table table-bordered table-hover'>";
        $tabela = $tabela . "<thead>";
        $tabela = $tabela . "<tr>";
        $tabela = $tabela . "<th>Ano</th>";
        $tabela = $tabela . "<th>Valor</th>";
        $tabela = $tabela . "<th>Alíquota</th>";
        $tabela = $tabela . "<th>Data Calculo</th>";
        $tabela = $tabela . "</tr>";
        $tabela = $tabela . "</thead>";
        $tabela = $tabela . "<tbody>";
        for ($i = 0; $i < $numero_registro; $i++) {
            $tabela = $tabela . "<tr>";
            $tabela = $tabela . "<th>" . $result[$i]['Ano'] . "</th>";
            $tabela = $tabela . "<th>" . mostrarDinheiro($result[$i]['Valor']) . "</th>";
            $tabela = $tabela . "<th>" . $result[$i]['Aliquota'] . "</th>";
            $tabela = $tabela . "<th>" . dataBrasileiro($result[$i]['Data_Calculo']) . "</th>";
            $tabela = $tabela . "</tr>";
        }


        $tabela = $tabela . "</tbody>";
        $tabela = $tabela . "</table>";
        $tabela = $tabela . "</div>";


        return $tabela;
    } else {
        return "NENHUM VALOR ENCONTRADO";
    }
}

function historicoAlugados($pdo, $inscricao_imob) {

// preparo para realizar o comando sql
    $sql = "SELECT * FROM Alugado_Pela_Prefeitura WHERE Inscricao_Imob = '$inscricao_imob' ORDER BY Processo DESC";
    $query = $pdo->prepare($sql);

//executo o comando sql
// Faço uma comparação para saber se a busca trouxe algum resultado
    $query->execute();
// crio um array através do comando fetchAll
    // crio um array através do comando fetchAll
    $result = $query->fetchAll();
// após executar o comando fetchAll() conto a quantidade de registro atráves do rowCount()
    $numero_registro = $query->rowCount();

// se existir algum registro encontrado    
    if ($numero_registro > 0) {
        $tabela = "";
        $tabela = $tabela . "<div style='max-height: 200px; overflow: auto;'>";
        $tabela = $tabela . "<table class='table table-bordered table-hover'>";
        $tabela = $tabela . "<thead>";
        $tabela = $tabela . "<tr>";
        $tabela = $tabela . "<th>Processo</th>";
        $tabela = $tabela . "<th>Data_Inicio</th>";
        $tabela = $tabela . "<th>Data_Fim</th>";
        $tabela = $tabela . "</tr>";
        $tabela = $tabela . "</thead>";
        $tabela = $tabela . "<tbody>";
        for ($i = 0; $i < $numero_registro; $i++) {
            $tabela = $tabela . "<tr>";
            $tabela = $tabela . "<th>" . $result[$i]['Processo'] . "</th>";
            $tabela = $tabela . "<th>" . dataBrasileiro($result[$i]['Data_Inicio']) . "</th>";
            $tabela = $tabela . "<th>" . dataBrasileiro($result[$i]['Data_Fim']) . "</th>";
            $tabela = $tabela . "</tr>";
        }


        $tabela = $tabela . "</tbody>";
        $tabela = $tabela . "</table>";
        $tabela = $tabela . "</div>";


        return $tabela;
    } else {
        return "NENHUM PROCESSO DE ALUGUEL ENCONTRADO";
    }
}
