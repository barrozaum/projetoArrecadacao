<?php
include_once '../estrutura/controle/validarSessao.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>


<form role="form" method="post" name="formularioRelCancelamento" action="recursos/includes/relatorio/relCancelamentosDividas.php" target="_Blank">   
    <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
       <div id="msg"></div>
       <div class="well"><!-- div que coloca a cor no formulário -->
            <div class="panel panel-default">
                <!-- INICIO Dados do imóvel -->
                <div class="panel-heading text-center">RELAÇÃO DE CANCELAMENTOS</div>
                <div class="panel-body ">
                    <!-- inicio dados inscrição-->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php
                                // OBSERVAÇÃO DA INSERÇÃO DA DIVIDA
                                criar_input_data('Data Inicial ', 'dt_inicial', 'dt_inicial', array('required' => 'true', 'placeholder' => 'Informe a Data Inicial'), '', 'Somente numeros');
                                ?> 
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <?php
                                // OBSERVAÇÃO DA INSERÇÃO DA DIVIDA
                                criar_input_data('Data Final ', 'dt_final', 'dt_final', array('required' => 'true', 'placeholder' => 'Informe a Data Final'), '', 'Somente numeros');
                               ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <?php
                            //   INPUT                         
                            criar_input_text('Inscrição Inicial', 'inscricao_inicial', 'inscricao_inicial', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            //   INPUT                              
                            criar_input_text('Inscrição Final', 'inscricao_final', 'inscricao_final', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                            ?>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success" id="id_gerar_relatorio">Gerar</button>
                </div>
            </div>     
        </div>     
    </div>     

</form>
<!--  Fim Fomulario  -->