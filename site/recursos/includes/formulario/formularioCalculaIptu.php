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
    die();
}
?>


<?php

function formularioCadastro() {
    ?>
    <form name="calculariptu" action="recursos/includes/calculo/calcularIptu.php" method="post" id="formulario_calculo_iptu">
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div class="well">
                <div id="msg_erro"></div>
                <div class="panel panel-default">
                    <div class="panel-heading text-center" >CÁLCULO DE IPTU</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                //   INPUT -                      
                                criar_input_text('Inscrição Inicial', 'inscricao_inicial', 'inscricao_inicial', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente numeros');
                                ?>
                            </div>

                            <div class="col-sm-6">
                                <?php
                                //   INPUT -                      
                                criar_input_text('Inscrição Final', 'inscricao_final', 'inscricao_final', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente numeros');
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 ">
                                <?php
                                //   INPUT -                      
                                criar_input_text('Ano Inicial', 'ano_inicial', 'ano_inicial', array('required' => 'true', 'maxlength' => '4', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente numeros');
                                ?> </div>

                            <div class="col-sm-6 ">
                                <?php
                                //   INPUT -                      
                                criar_input_text('Ano Final', 'ano_final', 'ano_final', array('required' => 'true', 'maxlength' => '4', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente numeros');
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                //   INPUT -                      
                                criar_input_text('QTD PARCELAS', 'qtd_parcelas', 'qtd_parcelas', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '4', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '06', 'somente numeros');
                                ?>

                            </div>
                            <div class="col-sm-3 ">
                                <?php
                                //   INPUT -                      
                                criar_input_checkbox(' AGRUPAR DÍVIDA ATIVA', 'agrupar_divida_ativa', 'agrupar_divida_ativa', array('checked' => 'true'));
                                ?>


                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <button type="buttn" class="btn btn-success" id="btn_calcular_iptu" >Calcular</button>
                        </div>
                    </div>
                </div>
            </div>
    </form>
    <?php
}
?>

