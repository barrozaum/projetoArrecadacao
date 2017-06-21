<?php
include_once '../estrutura/controle/validarSessao.php';
//validacao
include_once '../funcaoPHP/function_letraMaiscula.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>
<?php
if (empty($_POST['id'])) {
    formularioCadastro();
} else if ($_POST['id'] == 1) {
    formularioAlterar();
} else if ($_POST['id'] == 2) {
    formularioExcluir();
}
?>

<?php

function formularioCadastro() {
    ?>

    <form  method="post" action="recursos/includes/cadastrar/cadastrarLancamentoDivida.php">    
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div class="well"><!-- div que coloca a cor no formulário -->
                <div class="panel panel-default">
                    <!-- INICIO Dados do imóvel -->
                    <div class="panel-heading text-center">LANÇAMENTO DE DÍVIDA</div>
                    <div class="panel-body">
                        <!-- inicio dados inscrição-->
                        <div class="row">
                            <div id='msg_erro'></div>
                            <div class="col-sm-2">
                                <?php
                                //   INPUT - INSCRICAO                             
                                criar_input_text('Inscrição', 'inscricao', 'inscricao');
                                ?>
                            </div>
                            <div class="col-sm-10">
                                <?php
                                //   INPUT - INSCRICAO (DESCRICAO)
                                criar_input_text('Proprietário', 'descricao', 'descricao', array('readonly' => 'true'));
                                ?>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-2">
                                <?php
                                //   INPUT - CODIGO (DIVIDA)
                                criar_input_text('Codigo (MOEDA)', 'cod_moeda', 'cod_moeda', array('readonly' => 'true'), '02');
                                ?>
                            </div>
                            <div class="col-sm-10">
                                <?php
                                //    INPUT - CODIGO (DIVIDA) - DESCRICAO                            
                                criar_input_text('Descricão (MOEDA)', 'descricao_moeda', 'descricao_moeda', array('readonly' => 'true'), 'UFIR      ');
                                ?>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-2">
                                <?php
                                //   INPUT - CODIGO (DIVIDA)
                                criar_input_text('Codigo (DIV)', 'cod_divida', 'cod_divida');
                                ?>
                            </div>
                            <div class="col-sm-10">
                                <?php
                                //    INPUT - CODIGO (DIVIDA) - DESCRICAO                            
                                criar_input_text('Descricão (DIV)', 'descricao_div', 'descricao_div', array('readonly' => 'true'));
                                ?>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-2">
                                <?php
                                // SITUAÇÃO DE CADASTRO DA DIVIDA 
                                criar_input_text('Situação (DIV)', 'cod_sit_divida', 'cod_sit_divida');
                                ?>
                            </div>
                            <div class="col-sm-10">
                                <?php
                                // DESCRIÇÃO DA SITUAÇÃO DA DIVIDA ESCOLHIDA
                                criar_input_text('Descricão Sit (DIV)', 'descricao_sit_div', 'descricao_sit_div', array('readonly' => 'true'));
                                ?>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <?php
                                            //    INPUT - SUB DIVIDA
                                            criar_input_text('Sub (DIV)', 'sub_divida', 'sub_divida');
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            //    INPUT - ANO DA DÍVIDA
                                            criar_input_text('Ano (DIV)', 'ano', 'ano');
                                            ?>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?php
                                            // PARCELA INICIAL DA DIVIDA
                                            criar_input_text('Parc (INI)', 'parc_ini', 'parc_ini');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?php
                                            // QUANTIDADE DE PARCELAS DA DIVIDA
                                            criar_input_text('Qtd (PAR)', 'qtd_parc', 'qtd_parc');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?php
                                            // QUANTIDADE DE PARCELAS DA DIVIDA
                                            criar_input_text('Parcela', 'parc_atual', 'parc_atual', array('readonly' => 'true'));
                                            ?>
                                        </div>

                                    </div> 
                                    <div class="row">


                                        <div class="col-sm-6 ">  
                                            <?php
                                            // OBSERVAÇÃO DA INSERÇÃO DA DIVIDA
                                            criar_input_data('Vencimento', 'data', 'data');
                                            ?> 
                                        </div>
                                        <div class="col-sm-6">  
                                            <?php
                                            // OBSERVAÇÃO DA INSERÇÃO DA DIVIDA
                                            criar_input_text('Valor', 'valor_parcela', 'valor_parcela', array("onKeyPress" => "return formatarValor(this, '.', ',', event);"));
                                            ?> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?php
                                            // OBSERVAÇÃO DA INSERÇÃO DA DIVIDA
                                            criar_textarea('Observação', 'observacao', 'observacao');
                                            ?> 
                                        </div> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div style='max-height: 230px; overflow: auto;'>
                                            <table id="tabela-contrato" class="table-responsive" border="1" width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>PARCELA:</td>
                                                        <td>VENCIMENTO:</td>
                                                        <td>VALOR:</td>
                                                        <td>OBSERVAÇÃO</td>
                                                    </tr>
                                                </thead>
                                                <tbody id="tabela-contrato-corpo"> 
                                                    <!-- será preenchido quando o botão adicionar foir clicado -->
                                                </tbody>
                                            </table>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div id="div_botao_enviar"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-2" id="div_botao">
                                <button type="button" id="id_salvar" class="btn btn-info" >SIMULAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
}
?>
