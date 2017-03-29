<?php
// validar login
include_once '../estrutura/controle/validarSessao.php';

// campo para criação dos inputs
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>
<?php
if (empty($_REQUEST['id'])) {
    ?>
    <form  method="post" action="" name="formularioItbi" id="formularioItbi">   <!-- inicio do formulário --> 
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div id="msg"></div>
            <div class="well"><!-- div que coloca a cor no formulário -->
                <div class="panel panel-default">
                    <!-- INICIO Dados do imóvel -->
                    <div class="panel-heading text-center">CANCELAMENTO ITBI</div>
                    <div class="panel-body">
                        <!-- inicio dados inscrição-->
                        <div class="row">
                            <div class="col-sm-4">
                                <?php
                                //   INPUT -                      
                                criar_input_text('Número', 'numero_itbi', 'numero_itbi', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '000000', 'onkeypress' => 'return SomenteNumero(event)'), '');
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                //   INPUT -                      
                                criar_input_text('Ano', 'ano_itbi', 'ano_itbi', array('required' => 'true', 'maxlength' => '4', 'placeholder' => '0000', 'onkeypress' => 'return SomenteNumero(event)'), '');
                                ?>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                //   INPUT -                              
                                criar_input_text('Adquirinte', 'adquirinte', 'adquirinte', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Nome do Adquirinte'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                //   INPUT -                              
                                criar_input_text('Transmitente', 'transmitente', 'transmitente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Nome do Transmitente'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <?php
                                //   INPUT -                              
                                criar_input_text('Data', 'data', 'data', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '30', 'placeholder' => '00/00/0000'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                                ?>
                            </div>
                            <div class="col-sm-3">
                                <?php
                                //   INPUT -                              
                                criar_input_text('Valor ITBI', 'valor_itbi', 'valor_itbi', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '30', 'placeholder' => 'R$00,00'), '', '');
                                ?>
                            </div>

                            <div class="col-sm-6">
                                <?php
                                include_once '../funcaoPHP/campo_select_Motivo_Cancelamento.php';
                                ?>
                            </div>

                        </div> 
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                criar_textarea('OBSERVAÇÃO', 'obs_itbi', 'obs_itbi', '', array('required' => 'true', 'maxlength' => '254'));
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                <div id="button"></div>
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