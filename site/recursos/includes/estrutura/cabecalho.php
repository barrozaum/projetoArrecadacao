<?php
include_once './controle/validarSessao.php';
//lembre-se não pode alterar a ordem do menu
// cada código representa uma parte do menu
?>
<div class="row">
<div class="page-header">
    <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
        <div class="row">
            <div class="col-lg-2 col-lg-offset-0 text-center">
                <a href="inicial.php">
                    <img src="<?php echo $_SESSION['C_CAMINHO_LOGO']; ?>" height="76" width="150" alt="logo cliente" title="logo da prefeitura">
                    <!--<img src="recursos/imagens/estrutura/logo.jpg" height="76px" alt="logo cliente" title="logo da prefeitura">-->
                </a>
            </div>
            <div class="col-lg-9 col-lg-offset-0 ">
                <nav class="navbar navbar-default nav-justified" role="navigation">
                    <!-- Brand and toggle get grouped for better mobile display -->

                    <div class="navbar-header ">
                        <a class="navbar-brand" href="inicial.php"><?php echo $_SESSION['C_PREFEITURA']; ?></a>
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse navbar-ex1-collapse ">
                        <ul class="nav navbar-nav ">
                            <li class="root">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cadastro <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">imobiliário</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="CadastroImovel.php">Imoveis</a></li>
                                            <li><a href="cadastroEnderecoCorrespondencia.php">Endereço de Correspondencia</a></li>
                                            <li><a href="#">Bloquear Inscrição</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Divídas</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="TabelaDividaImob.php">Dividas</a></li>
                                            <li><a href="TabelaSituacaoDivida.php">Situação Divida</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="TabelaBanco.php">Banco</a></li>
                                    <li><a href="TabelaMoeda.php">Moeda</a></li>
                                    <li><a href="TabelaValorMoeda.php">Valor Moeda</a></li>
                                    <li class="dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Valor m²</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="TabelaValorM2Terreno.php">Terreno</a></li>
                                            <li><a href="TabelaValorM2Construcao.php">Construção</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="ExportarFunesBom.php">Exportar FunesBom</a></li>
                                </ul>
                            </li>
                            <li class="root">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cálculo <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="LancamentoDivida.php">Lançamento de Dívida</a></li>
                                    <li><a href="CalcularIptu.php">Cálculo IPTU</a></li>


                                </ul>
                            </li>

                            <li class="root">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Baixa <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Pagamentos</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Online</a></li>
                                            <li class="dropdown-submenu"> <a href="#">Leitura Arquivo </a>
                                                <ul class="dropdown-menu">
                                                    <li><a href="#">Ceneaban - Vs 3</a></li>
                                                    <li><a href="#">Ficha Compensação -Bco Brasil - CBR643</a></li>
                                                    <li><a href="#">Ficha Compensação -Itaú</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="#">Digitação Lote</a></li>
                                            <li><a href="#">Correção Documentos</a></li>
                                            <li><a href="#">Exclusão Arquivo</a></li>
                                            <li><a href="#">Correção Banco Lote </a></li>
                                            <li><a href="#">Fechamento </a></li>
                                            <li><a href="#">Consistência </a></li>
                                            <li><a href="#">Atualização </a></li>
                                            <li><a href="#">Resumo Arrecadação </a></li>
                                            <li><a href="#">Pagamento ISS </a></li>
                                            <li><a href="#">Consulta Pagamentos</a></li>
                                            <li><a href="#">Consulta Situação Arquivo</a></li>  
                                        </ul>

                                    </li>
                                    <li><a href="#">Estorno Pagamento</a></li>
                                    <li><a href="#">Cancelamento Dívida</a></li>
                                    <li><a href="#">Cancelamento Dívida(Sequencial)</a></li>
                                    <li><a href="#">Cancelamento Dívida(Processo Tj)</a></li>
                                    <li><a href="#">Estorno Cancelamento Dívida</a></li>
                                </ul>
                            </li>

                            <li class="root">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Divída Ativa <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Agrupar Dívida</a></li>
                                    <li class="dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Inscrição em Div. Ativa</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Inscrever Dívida</a></li>
                                            <li><a href="#">Cadastrar Parâmetros</a></li>
                                        </ul>
                                    <li><a href="#">Emissão de Documentos</a></li>
                                    <li><a href="#">Ajuizar Dívida</a></li>
                                    <li><a href="#">Emissão do Livro </a></li>
                                    <li><a href="#">Emissão Rel. Processos Exc. Fiscal </a></li>
                                    <li><a href="#">Carta Citação </a></li>
                                    <li class="dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Parcelamento</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Dívida Ativa</a></li>
                                            <li><a href="#">Dívida Ativa - Anistia</a></li>
                                            <li><a href="#">Dívida Ajuizada</a></li>
                                            <li><a href="#">Dívida Ajuizada - Anistia</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Estorno Parcelamento </a></li>
                                    <li><a href="#">Emissão do Termo de Parcelamento </a></li>
                                    <li><a href="#">Cadastrar CPF/CNPJ Termo Parcelamento </a></li>
                                    <li class="dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Geração de Arquivos</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Arquivo TJ</a></li>
                                            <li><a href="#">Arquivo TJ - Periodo</a></li>
                                            <li><a href="#">Arquivo TJ - Web Service</a></li>
                                            <li><a href="#">Arquivo CBR653</a></li>
                                            <li><a href="#">Rel Guias Ajuizadas Emitidas (Cart.17)</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="root">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">ITBI <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="Itbi.php">Cadastrar</a></li>
                                    <li><a href="ConsultaItbi.php">Consultar</a></li>
                                    <li><a href="BaixaOnlineItbi.php">Baixa Online</a></li>
                                    <li><a href="EstornoPagamentoItbi.php">Estorno de Pagamento</a></li>
                                    <li><a href="CancelamentoItbi.php">Cancelamento</a></li>
                                    <li><a href="EstornoCancelamentoItbi.php">Estorno Cancelamento</a></li>
                                </ul>
                            </li>

                            <li class="root">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Consulta <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="ConsultaInscImob.php">Inscrição</a></li>
                                    <li><a href="ConsultaDadosImovel.php">Endereço</a></li>
                                    <li><a href="ConsultaFinanceiraImovel.php">Financeira</a></li>
                                </ul>
                            </li>

                            <li class="root">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Relatório <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li class="dropdown-submenu"> <a tabindex="-1" href="#">Emissões</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="Emitir_segunda_via_boleto.php">Guia de Pagamento</a></li>
                                            <li><a href="#">Guia por Arquivo</a></li>
                                            <li><a href="#">Comprovante Isenção</a></li>
                                            <li><a href="#">Comprovante Pagamento</a></li>
                                            <li><a href="#">Arquivos p/ Emissão de Guias</a></li>
                                            <li><a href="#">Etiquetas p/ Mala Direta</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu"> <a tabindex="-1" href="#">Certidões</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="RelCertidaoNegativa.php">Certidões Negativa</a></li>
                                            <li><a href="#">Certidões Positiva</a></li>
                                            <li><a href="#">Certidões Regularidade Fiscal</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu"> <a tabindex="-1" href="#">Levantamentos</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="LevantamentoMaioresDevedores.php">Maiores Devedores</a></li>
                                            <li><a href="#">Devedores</a></li>
                                            <li><a href="#">Dívida Ativa Paga</a></li>
                                            <li><a href="#">Dívida a vencer/vencidas</a></li>
                                            <li><a href="#">Listagem de Parcelamentos</a></li>
                                            <li><a href="#">Dívidas por Contribuinte</a></li>
                                            <li><a href="#">Acumulado - Dívida Ativa</a></li>
                                            <li><a href="#">Dívidas Ajuizadas</a></li>
                                            <li><a href="#">Processos de Ajuizamento Pagos</a></li>
                                            <li><a href="#">Processos de Ajuizamento Parcelados</a></li>
                                            <li><a href="#">Resumo da Arrecadação - Mensal</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu"> <a tabindex="-1" href="#">Cobrança</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Amigavél</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu"> <a tabindex="-1" href="#">Auditoria</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Imobiliário</a></li>
                                            <li><a href="#">Guias</a></li>
                                            <li><a href="filtroRelCancelamentosDividas.php">Cancelamentos</a></li>
                                            <li><a href="#">Baixas on-Line</a></li>
                                            <li><a href="#">Permissões de Acesso</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Tabelas</a></li>
                                    <li class="dropdown-submenu"> <a tabindex="-1" href="#">Geração de Arquivos</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Carnê</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu"> <a tabindex="-1" href="#">TCE-RJ</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Livro da Dívida Ativa</a></li>
                                            <li><a href="#">Relação de Todos Pagamentos </a></li>
                                            <li><a href="#">Arrecadação Mensal</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="root">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Docarj <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="CadastroDocarj.php">Cadastrar</a></li>
                                    <li><a href="ConsultaDocarj.php">Consultar</a></li>
                                    <li class="dropdown-submenu"> <a tabindex="-1" href="#">Emissão</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Emissão de Guia</a></li>
                                            <li><a href="EmissaoComprovanteDocarj.php">Emissão de Comprovante</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu"> <a tabindex="-1" href="#">Pagamento</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="BaixaOnlineDocarj.php">Baixa On Line</a></li>
                                            <li><a href="EstornoPagamentoDocarj.php">Estorno</a></li>

                                        </ul>
                                    </li>
                                    <li class="dropdown-submenu"> <a tabindex="-1" href="#">Cancelamento</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="CancelamentoDocarj.php">Cancelamento DOCARJ</a></li>
                                            <li><a href="EstornoCancelamentoDocarj.php">Estorno Cancelamento</a></li>

                                        </ul>
                                    </li>
                                     <li><a href="RelatorioDocarj.php">Relatório</a></li>
                                   
                                    <li class="dropdown-submenu"> <a tabindex="-1" href="#">Dívida Ativa</a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Insc. Dívida Ativa</a></li>
                                            <li><a href="#">Emissão de Certidão</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="root">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Tabelas <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="TabelaUtilizacao.php">Utilização</a></li>
                                    <li><a href="TabelaCategoria.php">Categoria</a></li>
                                    <li><a href="TabelaSituacaoTerreno.php">Situação Terreno</a></li>
                                    <li><a href="TabelaPatrimonio.php">Patrimônio</a></li>
                                    <li><a href="TabelaColeta.php">Tipo Coleta</a></li>
                                    <li><a href="TabelaIsencao.php">Tipo Isenção</a></li>
                                    <li><a href="TabelaBairro.php">Bairro</a></li>
                                    <li><a href="TabelaRua.php">Rua</a></li>
                                    <li><a href="motivoCancelamento.php">Motivo Cancelamento</a></li>
                                    <li><a href="TabelaNaturezaTransmissao.php">Natureza Transmição</a></li>
                                </ul>
                            </li>
                            <li class="root">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manutenção <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="Man_Usuario.php">Usuário</a></li>
                                    <li><a href="#" id="id_btn_alterar_senha">Senha</a></li>
                                    <li><a href="Man_Perimissao.php">Permissão</a></li>
                                    <li><a href="Man_Configuracao.php">Configuração</a></li>
                                </ul>
                            </li>

                            <li class="dropdown"><a href="logout.php" >Sair</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </nav>
            </div>
        </div>
    </div>
</div>
<hr />
</div>