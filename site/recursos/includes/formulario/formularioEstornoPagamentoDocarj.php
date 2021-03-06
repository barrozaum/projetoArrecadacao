<?php
include_once '../estrutura/controle/validarSessao.php';
//validacao
include_once '../funcaoPHP/function_letraMaiscula.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>
<?php
if (empty($_REQUEST['id'])) {
    ?>

    <form  method="post" action="" name="formularioDocarj" id="formularioDocarj">   <!-- inicio do formulário --> 
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div id="msg"></div>
            <div id="msg_erro"></div>
            <div class="well"><!-- div que coloca a cor no formulário -->
                <div class="panel panel-default">
                    <!-- INICIO Dados do imóvel -->
                    <div class="panel-heading text-center">ESTORNO PAGAMENTO DOCARJ (DAM)</div>
                    <div class="panel-body">
                        <!-- inicio dados inscrição-->
                        <div class="row">
                            <div class="col-sm-4">
                                <?php
                                //   INPUT -                      
                                criar_input_text('Número', 'numero_Docarj', 'numero_Docarj', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '000000', 'onkeypress' => 'return SomenteNumero(event)'), '');
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                //   INPUT -                      
                                criar_input_text('Ano', 'ano_Docarj', 'ano_Docarj', array('required' => 'true', 'maxlength' => '4', 'placeholder' => '0000', 'onkeypress' => 'return SomenteNumero(event)'), '');
                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                //   INPUT -                      
                                criar_input_text('Parcela', 'parcela', 'parcela', array('required' => 'true', 'maxlength' => '2', 'placeholder' => '00', 'onkeypress' => 'return SomenteNumero(event)'), '');
                                ?>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                //   INPUT -                              
                                criar_input_text('Contribuinte', 'contribuinte', 'contribuinte', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Nome do Contribuinte'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                                ?>
                            </div>
                            <div class="col-sm-3">
                                <?php
                                //   INPUT -                              
                                criar_input_text('Data Vencimento', 'data_vencimento', 'data_vencimento', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '30', 'placeholder' => '00/00/0000'), '', '');
                                ?>                               


                            </div>
                            <div class="col-sm-3">
                                <?php
                                //   INPUT -                              
                                criar_input_text('Valor DAM', 'valor_Docarj', 'valor_Docarj', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '30', 'placeholder' => 'R$00,00'), '', '');
                                ?>
                            </div>

                        </div> 
                        <hr />
                        <div class="row">

                            <div class="col-sm-3">
                                <?php
                                criar_input_data('DATA PAGT', 'data_pagto', 'data', array('readonly' => 'true', 'required' => 'true', 'placeholder' => '00/00/0000'), '', 'somente numeros');
                                ?>

                            </div>
                            <div class="col-sm-3">
                                <?php
                                //   INPUT - Descricao Tipo Coleta                             
                                criar_input_text('Valor Pagamento(R$)', 'valor_pagamento', 'valor_pagamento', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '11', 'placeholder' => 'R$000.00', "onKeyPress" => "return formatarValor(this, '.', ',', event);"), '', 'Conter apenas Numeros[0-9]');
                                ?>


                            </div>

                            <!--                            <div class="col-sm-3">
                            <?php
                            //   INPUT -                      
                            criar_input_text('Número Processo', 'numero_processo', 'numero_processo', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '000000', 'onkeypress' => 'return SomenteNumero(event)'), '');
                            ?>
                                                        </div>
                                                        <div class="col-sm-3">
                            <?php
                            //   INPUT -                      
                            criar_input_text('Ano Processo', 'ano_processo', 'ano_processo', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '4', 'placeholder' => '0000', 'onkeypress' => 'return SomenteNumero(event)'), '');
                            ?>
                                                        </div>-->

                        </div> 
                        <div class="row">
                            <div class="col-sm-3">
                                <?php
                                //   INPUT -                      
                                criar_input_text('Lote', 'lote', 'lote', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '4', 'placeholder' => '0000', 'onkeypress' => 'return SomenteNumero(event)'), '');
                                ?>

                            </div>
                            <div class="col-sm-3">
                                <?php
                                //   INPUT -                      
                                criar_input_text('Banco', 'banco', 'banco', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '4', 'placeholder' => '0000', 'onkeypress' => 'return SomenteNumero(event)'), '');
                                ?>

                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <?php
                                        //   INPUT -                              
                                        criar_input_text('DESCRIÇÃO DO BANCO', 'descricao_banco', 'descricao_banco', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '30', 'placeholder' => 'DESCRICÃO DO BANCO'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                                        ?>
                                    </div>
                                    <div class="col-sm-5">
                                        <div id="msg_banco"></div>
                                    </div>
                                </div>
                            </div>

                        </div> 

                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                criar_textarea('HISTÓRICO', 'historico', 'historico', '', array('readonly' => 'true', 'maxlength' => '254'));
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                criar_textarea('OBSERVAÇÃO', 'obs_Docarj', 'obs_Docarj', '', array( 'required' => 'true', 'maxlength' => '254'));
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