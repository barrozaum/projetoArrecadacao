<?php
include_once '../estrutura/controle/validarSessao.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>


<form role="form" method="post" name="formularioRelCancelamento" action="recursos/includes/relatorio/relatorio_docarj.php" target="_Blank">   
    <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->

        <div class="well"><!-- div que coloca a cor no formulário -->
            <div class="panel panel-default">
                <!-- INICIO Dados do imóvel -->
                <div class="panel-heading text-center">RELAÇÃO DE DOCARJ</div>
                <div class="panel-body ">
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="msg_erro"></div>
                        </div>
                    </div>
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
                                criar_input_data('Data Final ', 'dt_final', 'dt_final', array('required' => 'true', 'placeholder' => 'Informe a Data Final'), date('d/m/Y'), 'Somente numeros');
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <?php
                            criar_input_select("Escolha Relação", "relacao_docarj", "relacao_docarj", array(), array("1" => "Docarj Pagos", "2" => "Docarj Não Pagos"))
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