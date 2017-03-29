    <?php
    include_once '../estrutura/controle/validarSessao.php';
    ?>
    <?php
    if (empty($_POST['id'])) {
        formularioCadastro();
    }
    ?>
    <script>
        $(document).ready(function () {
            $("#mostra_utilizacao").load('recursos/includes/funcaoPHP/campo_select_Utilizacao.php?selecionado="0"');
            $("#mostra_Situacao_Terreno").load('recursos/includes/funcaoPHP/campo_select_Situacao_Terreno.php?selecionado="0"');
            $("#mostra_categoria").load('recursos/includes/funcaoPHP/campo_select_Categoria.php?selecionado="0"');
            $("#mostra_patrimonio_liquido").load('recursos/includes/funcaoPHP/campo_select_Patrimonio.php?selecionado="0"');
            $("#mostra_Tipo_Coleta").load('recursos/includes/funcaoPHP/campo_select_Tipo_Coleta.php?selecionado="0"');
            $("#mostra_Tipo_Isencao").load('recursos/includes/funcaoPHP/campo_select_Tipo_Isencao.php?selecionado="0"');
        });</script>



    <?php

    function formularioCadastro() {
        ?>


        <!-- fim doJava script para dar Focus no primeiro Campo do formulário -->
        <div class="row">
            <div class="col-sm-12">
                <div  id="msg"></div>
            </div>
        </div>
        <div class="row">
            <form  method="post" action="" name="formulario_imovel" id="formulario_imovel">   <!-- inicio do formulário --> 
                <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
                    <div class="well"><!-- div que coloca a cor no formulário -->
                        <P ALIGN="CENTER">CONSULTA INSCRIÇÃO IMÓVEL</P>
                        <HR />

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
                                                    <input type="text" class="form-control" name ="inscricao_imovel" id="inscricao_imovel"  value="" maxlength="6" placeholder="000000" onkeypress='return SomenteNumero(event)' onblur="validaInscricao(this);"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="nome_proprietario_imovel">Nome Proprietário:</label>
                                                    <input type="text" class="form-control" name ="nome_proprietario_imovel" id="nome_proprietario_imovel"  value="" maxlength="50" placeholder="NOME PROPRIETÁRIO" readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="tipo_imposto_imovel">Tipo Imposto:</label>
                                                    <input type="text" class="form-control" name ="tipo_imposto_imovel" id="tipo_imposto_imovel"  value="" maxlength="6" placeholder="" readonly="true"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                <div class="form-inline text-center ">
                                                    <input type="checkbox" class="form-control" name ="cadastro_provisorio" id="cadastro_provisorio"/>
                                                    <label for="cadastro_provisorio">Cadastro Provisório:</label> &nbsp; &nbsp; &nbsp;
                                                    <input type="checkbox" class="form-control" name ="excluido" id="excluido" />
                                                    <label for="excluido">Excluído:</label> &nbsp; &nbsp; &nbsp;
                                                    <input type="checkbox" class="form-control" name ="carne_devolvido" id="carne_devolvido" />
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
                                                    <input type="text" class="form-control" name ="nome_contribuinte" id="nome_contribuinte"  value="" maxlength="50" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="telefone_contribuinte">TELEFONE :</label>
                                                    <input type="text" class="form-control" name ="telefone_contribuinte" id="telefone_contribuinte"  value="" maxlength="50" placeholder=""  readonly="true">
                                                </div>
                                            </div>

                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="cpf_cnpj_contribuinte">CPF/CNPJ:</label>
                                                    <input type="text" class="form-control" name ="cpf_cnpj_contribuinte" id="cpf_cnpj_contribuinte"  value="" maxlength="15" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="tipo_pessoa_contribuinte">TIPO PESSOA:</label>
                                                    <input type="text" class="form-control" name ="tipo_pessoa_contribuinte" id="tipo_pessoa_contribuinte"  value="" readonly="true"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="rg_contribuinte">RG:</label>
                                                    <input type="text" class="form-control" name ="rg_contribuinte" id="rg_contribuinte"  value="" maxlength="15" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="orgao_rg_contribuinte">ÓRGÃO:</label>
                                                    <input type="text" class="form-control" name ="orgao_rg_contribuinte" id="orgao_rg_contribuinte"  value="" maxlength="15" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="emissao_rg_contribuinte">EMISSÃO:</label>
                                                    <input type="text" class="form-control" name ="emissao_rg_contribuinte" id="emissao_rg_contribuinte"  value="" maxlength="15" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="data_nascimento_contribuinte">DATA NASCIMENTO:</label>
                                                    <input type="text" class="form-control" name ="data_nascimento_contribuinte" id="data_nascimento_contribuinte"  value="" maxlength="15" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="cep_contribuinte">CEP:</label>
                                                    <input type="text" class="form-control" name ="cep_contribuinte" id="cep_contribuinte"  value="" maxlength="8" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="rua_contribuinte">RUA:</label>
                                                    <input type="text" class="form-control" name ="rua_contribuinte" id="rua_contribuinte"  value="" maxlength="8" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="bairro_contribuinte">BAIRRO:</label>
                                                    <input type="text" class="form-control" name ="bairro_contribuinte" id="bairro_contribuinte"  value="" maxlength="8" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="cidade_contribuinte">CIDADE:</label>
                                                    <input type="text" class="form-control" name ="cidade_contribuinte" id="cidade_contribuinte"  value="" maxlength="8" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="uf_contribuinte">UF:</label>
                                                    <input type="text" class="form-control" name ="uf_contribuinte" id="uf_contribuinte"  value="" maxlength="8" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="numero_end_contribuinte">NÚMERO:</label>
                                                    <input type="text" class="form-control" name ="numero_end_contribuinte" id="numero_end_contribuinte"  value="" maxlength="" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="complemento_end_contribuinte">COMPLEMENTO:</label>
                                                    <input type="text" class="form-control" name ="complemento_end_contribuinte" id="complemento_end_contribuinte"  value="" maxlength="" placeholder="" readonly="true">
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
                                                    <input type="text" class="form-control" name ="cod_bairro_imovel" id="cod_bairro_imovel"  value="" maxlength="50" placeholder="000" readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="desc_bairro_imovel">Bairro:</label>
                                                    <input type="text" class="form-control" name ="desc_bairro_imovel" id="desc_bairro_imovel"  value="" maxlength="50" placeholder=""  readonly="true" />
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="cod_logr_imovel">Cod Log:</label>
                                                    <input type="text" class="form-control" name ="cod_logr_imovel" id="cod_logr_imovel"  value="" maxlength="5" placeholder="00000" readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="desc_logr_imovel">Logradouro:</label>
                                                    <input type="text" class="form-control" name ="desc_logr_imovel" id="desc_logr_imovel"  value="" maxlength="50" placeholder=""  readonly="true" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="cod_cep_imovel">Cep:</label>
                                                    <input type="text" class="form-control" name ="cod_cep_imovel" id="cod_cep_imovel"  value="" readonly="true" />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="num_end_imovel">Número:</label>
                                                    <input type="text" class="form-control" name ="num_end_imovel" id="num_end_imovel"  value="" maxlength="50" placeholder="000000" readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="quadra_imovel">Quadra:</label>
                                                    <input type="text" class="form-control" name ="quadra_imovel" id="quadra_imovel"  value="" maxlength="6" placeholder="000000" readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="lote_imovel">Lote:</label>
                                                    <input type="text" class="form-control" name ="lote_imovel" id="lote_imovel"  value="" maxlength="50" placeholder="000000" readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="zona_imovel">Zona Fiscal:</label>
                                                    <input type="text" class="form-control" name ="zona_imovel" id="zona_imovel"  value="" maxlength="50" placeholder="000000" readonly="true"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="compl_end_imovel">Complemento:</label>
                                                    <input type="text" class="form-control" name ="compl_end_imovel" id="compl_end_imovel"  value="" maxlength="6" placeholder="000000" readonly="true"/>
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
                                                    <input type="text" class="form-control" name ="nome_responsavel_correspondencia" id="nome_responsavel_correspondencia"  value="" maxlength="50" placeholder="NOME CORRESPONDENTE" readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">

                                                <div class="form-group">
                                                    <label for="telefone_responsavel_correspondencia">Telefone:</label>
                                                    <input type="text" class="form-control" name ="telefone_responsavel_correspondencia" id="telefone_responsavel_correspondencia"  value="" maxlength="6" placeholder="000000" readonly="true"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="cpf_cnpj_correspondencia">CPF/CNPJ:</label>
                                                    <input type="text" class="form-control" name ="cpf_cnpj_correspondencia" id="cpf_cnpj_correspondencia"  value="" maxlength="15" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="tipo_pessoa_correspondencia">TIPO PESSOA:</label>
                                                    <input type="text" class="form-control" name ="tipo_pessoa_correspondencia" id="tipo_pessoa_correspondencia"  value="" readonly="true" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="cep_correspondencia">CEP:</label>
                                                    <input type="text" class="form-control" name ="cep_correspondencia" id="cep_correspondencia"  value="" maxlength="8" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="rua_correspondencia">RUA:</label>
                                                    <input type="text" class="form-control" name ="rua_correspondencia" id="rua_correspondencia"  value="" maxlength="8" placeholder=""  readonly="true">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="bairro_correspondencia">BAIRRO:</label>
                                                    <input type="text" class="form-control" name ="bairro_correspondencia" id="bairro_correspondencia"  value="" maxlength="8" placeholder=""  readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="cidade_correspondencia">CIDADE:</label>
                                                    <input type="text" class="form-control" name ="cidade_correspondencia" id="cidade_correspondencia"  value="" maxlength="8" placeholder=""  readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="uf_correspondencia">UF:</label>
                                                    <input type="text" class="form-control" name ="uf_correspondencia" id="uf_correspondencia"  value="" maxlength="8" placeholder=""  readonly="true">
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label for="numero_end_correspondencia">NÚMERO:</label>
                                                    <input type="text" class="form-control" name ="numero_end_correspondencia" id="numero_end_correspondencia"  value="" maxlength="" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="complemento_end_correspondencia">COMPLEMENTO:</label>
                                                    <input type="text" class="form-control" name ="complemento_end_correspondencia" id="complemento_end_correspondencia"  value="" maxlength="" placeholder="" readonly="true">
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <!-- FIM Dados do imóvel -->
                                    <!-- INICIO -->
                                    <div id="Titulo_Alugado_Pela_Prefeitura"></div>
                                    <div id="tabela_Alugado_Pela_Prefeitura"></div>
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
                                                    <input type="text" class="form-control" name ="largura_terreno_imovel" id="largura_terreno_imovel"  value="" maxlength="6" placeholder="000000"  readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="comprimento_terreno_imovel">Comprimento Terreno:</label>
                                                    <input type="text" class="form-control" name ="comprimento_terreno_imovel" id="comprimento_terreno_imovel"  value="" maxlength="50" placeholder="000000" readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="area_terreno_imovel">Área do Terreno (M²):</label>
                                                    <input type="text" class="form-control" name ="area_terreno_imovel" id="area_terreno_imovel"  value="" maxlength="50" placeholder="000000" readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="area_construida_imovel">Área Construída (M²):</label>
                                                    <input type="text" class="form-control" name ="area_construida_imovel" id="area_construida_imovel"  value="" maxlength="6" placeholder="000000" readonly="true"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="fracao_ideal_imovel">Fração Ideal:</label>
                                                    <input type="text" class="form-control" name ="fracao_ideal_imovel" id="fracao_ideal_imovel"  value="" maxlength="50" placeholder="000000" readonly="true"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="form-inline text-center ">
                                                    <input type="checkbox" class="form-control" name ="contem_manutencao_esgoto" id="contem_manutencao_esgoto"  value=""/>
                                                    <label for="contem_manutencao_esgoto">: TEM MANUTENÇÃO DE ESGOTO</label> &nbsp; &nbsp; &nbsp;
                                                    <input type="checkbox" class="form-control" name ="desconto_industria" id="desconto_industria"  value="" />
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
                                                    &nbsp; &nbsp; &nbsp;<input type="checkbox" class="form-control" name ="construcao_tijolo" id="construcao_tijolo" value="" />
                                                    <label for="construcao_tijolo">: TIJOLO</label> &nbsp; &nbsp; &nbsp;

                                                    <input type="checkbox" class="form-control" name ="construcao_madeira" id="construcao_madeira"  value="" />
                                                    <label for="construcao_madeira">MADEIRA</label> &nbsp; &nbsp; &nbsp;

                                                    <input type="checkbox" class="form-control" name ="construcao_embocada" id="construcao_embocada" value="" />
                                                    <label for="construcao_embocada">: EMBOÇADA</label> &nbsp; &nbsp; &nbsp;

                                                    <input type="checkbox" class="form-control" name ="construcao_pintada" id="construcao_pintada"  value="" />
                                                    <label for="construcao_pintada">: PINTADA</label> &nbsp; &nbsp; &nbsp;

                                                    <input type="checkbox" class="form-control" name ="construcao_telha" id="construcao_telha"  value="" />
                                                    <label for="construcao_telha">: TELHA</label> &nbsp; &nbsp; &nbsp;

                                                    <input type="checkbox" class="form-control" name ="construcao_laje" id="construcao_laje"  value="" />
                                                    <label for="construcao_laje">: LAJE</label> &nbsp; &nbsp; &nbsp;

                                                    <input type="checkbox" class="form-control" name ="construcao_taco" id="construcao_taco"  value="" />
                                                    <label for="construcao_taco">: TACO</label> &nbsp; &nbsp; &nbsp;

                                                    <input type="checkbox" class="form-control" name ="construcao_ceramico" id="construcao_ceramico"  value="" />
                                                    <label for="construcao_ceramico">: CERÂMICO</label> &nbsp; &nbsp; &nbsp;

                                                    <input type="checkbox" class="form-control" name ="construcao_outros" id="construcao_outros" value=""/>
                                                    <label for="construcao_outros">: OUTROS</label> &nbsp; &nbsp; &nbsp;

                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-sm-4"><!-- inclusao do select Utilização -->
                                                    <div id="mostra_utilizacao">
                                                    </div> 
                                                </div><!-- Fim inclusao do select Utilização -->
                                                <div class="col-sm-4"><!-- inclusao do select Situação Terreno -->
                                                    <div id="mostra_Situacao_Terreno">
                                                    </div>
                                                </div><!-- inclusao do select Situação Terreno -->
                                                <div class="col-sm-4"><!-- inclusao do select Categoria -->
                                                    <div id="mostra_categoria">
                                                    </div> 
                                                </div><!-- inclusao do select Categoria -->
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4"><!-- inclusao do select Patrimonio -->

                                                    <div id="mostra_patrimonio_liquido"></div>

                                                </div><!-- inclusao do select Patrimonio-->

                                                <div class="col-sm-4"><!-- inclusao do select Tipo Coleta -->
                                                    <div id="mostra_Tipo_Coleta"></div>
                                                </div><!-- inclusao do select Tipo Coleta-->

                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <label for="ano_cadastramento_imovel">Ano Imóvel Cadastramento:</label>
                                                        <input type="text" value="" class="form-control" name="ano_cadastramento_imovel" id="ano_cadastramento_imovel" readonly="true"> 
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
                                                   <div id="mostra_Tipo_Isencao"></div>
                                            </div><!-- inclusao do select Tipo Isencao-->
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <label for="fundamento_legal">Fundamento Legal:</label>
                                                    <input type="text" value="" class="form-control" name="fundamento_legal" id="fundamento_legal" readonly="true">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="processo_administrativo">Proc. Administrativo:</label>
                                                    <input type="text" value="" class="form-control" name="processo_administrativo" id="processo_administrativo" readonly="true">

                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="data_concessao">Data Concessão:</label>
                                                    <input type="text" value="" class="form-control" name="data_concessao" id="data_concessao"readonly="true">
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
                                            <div class="col-sm-4 ">
                                                <div class="panel-heading text-center well" >AVERBAÇÃO</div>
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label for="data_averbacao">Data:</label>
                                                        <input type="text" value="" class="form-control" name="data_averbacao" id="data_averbacao" readonly="true">

                                                        <label for="numero_processo_averbacao">N° Processo:</label>
                                                        <input type="text" value="" class="form-control" name="numero_processo_averbacao" id="numero_processo_averbacao" readonly="true">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 ">
                                                <div class="panel-heading text-center well" >LEGALIZAÇÃO</div>
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label for="legalizacao_imovel">Legalizado:</label>
                                                        <select name="legalizacao_imovel" id="legalizacao_imovel" class="form-control" readonly="TRUE">
                                                            <option value=""></option>
                                                            <option value="S">1 - SIM</option>
                                                            <option value="N">2 - NÃO</option>
                                                        </select>
                                                        <label for="numero_processo_legalizacao">N° Processo:</label>
                                                        <input type="text" value="" class="form-control" name="numero_processo_legalizacao" id="numero_processo_legalizacao" readonly="true">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 ">
                                                <div class="panel-heading text-center well" >ALTERAÇÕES</div>
                                                <div class="panel-body">
                                                    <div class="form-group">
                                                        <label for="data_ultima_alteracao">Ultima Data:</label>
                                                        <input type="text" class="form-control" name ="data_ultima_alteracao" id="data_ultima_alteracao"  value="" maxlength="50" placeholder="000000" readonly="true" />
                                                        <div class="col-md-6">
                                                            <label for="numero_processo_alteracao">Número:</label>
                                                            <input type="text" class="form-control" name ="numero_processo_alteracao" id="numero_processo_alteracao"  value="" maxlength="50" placeholder="000000" readonly="true" />
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="ano_processo_alteracao">Ano:</label>
                                                            <input type="text" class="form-control" name ="ano_processo_alteracao" id="ano_processo_alteracao"  value="" maxlength="50" placeholder="000000" readonly="true" />
                                                        </div>
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
                                                <textarea rows="4" class="form-control" name="observacao_imovel" id="observacao_imovel" readonly="true"></textarea>
                                            </div>
                                        </div>
                                        <!-- Fim INFORMAÇÕES GERAIS-->
                                    </div>


                                    <!-- INICIO VALOR VENAL-->
                                    <div id="Titulo_Tabela_Valor_Venal"></div>
                                    <div id="tabela_valor_venal"></div>
                                    <!-- FIM  VALOR VENAL-->
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 text-right">
                                        <div id="buttons"></div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Quarta aba -->
                    </div>

                </div><!-- div que posiciona o formulário na tela -->
            </form> <!-- fim do Formulário -->
        </div>
        <?php
    }
    ?>