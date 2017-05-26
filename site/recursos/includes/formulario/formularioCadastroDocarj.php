<?php
include_once '../estrutura/controle/validarSessao.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>
<?php
if (empty($_POST['id'])) {
    formularioCadastro();
}
?>

<?php

function formularioCadastro() {
    ?>

    <div class="row">
        <form  method="post" action="" name="formulario_imovel" id="formulario_imovel">   <!-- inicio do formulário --> 
            <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
                <div class="well"><!-- div que coloca a cor no formulário -->
                    <P ALIGN="CENTER">CADASTRO DE DOCARJ</P>
                    <HR />
                    <div class="row">
                        <div class="col-sm-4">
                            <?php
                            //   INPUT -                      
                            criar_input_text('Número', 'numero_docarj', 'numero_docarj', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '000000', 'onkeypress' => 'return SomenteNumero(event)'), '');
                            ?>
                        </div>
                        <div class="col-sm-4">
                            <?php
                            //   INPUT -                      
                            criar_input_text('Ano', 'ano_docarj', 'ano_docarj', array('required' => 'true', 'maxlength' => '4', 'placeholder' => '0000', 'onkeypress' => 'return SomenteNumero(event)'), '');
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <?php
                            //   INPUT -                      
                            criar_input_text('Valor Docarj', 'valor_docarj', 'valor_docarj', array('readonly' => 'true', 'placeholder' => '00,00'), '');
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <?php
                            //   INPUT -                      
                            criar_input_text('ATIVIDADE', 'atividade_Docarj', 'atividade_Docarj', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '000000', 'onkeypress' => 'return SomenteNumero(event)'), '');
                            ?>
                        </div>
                        <div class="col-sm-9">
                            <?php
                            //   INPUT -                      
                            criar_input_text('DESCRIÇÃO', 'descricao_atividade_Docarj', 'descricao_atividade_Docarj', array('required' => 'true', 'maxlength' => '50', 'placeholder' => 'DESCRICAO DA ATIVIDADE'), '');
                            ?>
                        </div>
                    </div>

                    <!-- menu das abas -->
                    <ul class="nav nav-tabs"> 
                        <li class="active"><a data-toggle="tab" href="#home">CONTRIBUINTE</a></li>
                        <li><a data-toggle="tab" href="#menu1">RECEITAS</a></li>
                        <li><a data-toggle="tab" href="#menu2">INFORMAÇÕES COMPLEMENTARES</a></li>
                    </ul> 
                    <!-- fim dos menu das abas -->


                    <div class="tab-content"><!-- abertura das abas do formulário -->

                        <div id="home" class="tab-pane fade in active"> <!-- primeira aba -->
                            <div class="panel panel-default">
                                <!-- INICIO Dados do imóvel -->

                                <div class="panel-heading text-center">IDENTIFICAÇÃO DO CONTRIBUINTE</div>
                                <div class="panel-body">
                                    <!-- bloco dos dados do contribuinte-->

                                    <div class="row">
                                        <div class="col-sm-3">
                                            <?php
                                            //   INPUT -                      
                                            criar_input_select('CADASTRO', 'cadastro_contribuinte', 'cadastro_contribuinte', array('required' => 'true'), array("" => "SELECIONE O CADASTRO", "1" => "1 - IMOBILIARIO", "2" => "2 - COMERCIAL", "3" => "3 - DAM", "4" => "4 - ITBI", "5" => "5 - FEIRANTE"));
                                            ?>
                                        </div>
                                        <div class="col-sm-3">
                                            <?php
                                            //   INPUT -                      
                                            criar_input_text('INSCRIÇÃO', 'inscricao_contribuinte', 'inscricao_contribuinte', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '0000', 'onkeypress' => 'return SomenteNumero(event)'), '');
                                            ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <?php
                                            //   INPUT -                      
                                            criar_input_text('NOME CONTRIBUINTE', 'nome_contribuinte', 'nome_contribuinte', array('required' => 'true', 'maxlength' => '50', 'placeholder' => 'NOME CONTRIBUINTE'), '');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?php
                                            //   INPUT -                           
                                            criar_input_text('CPF/CNPJ', 'cpf_cnpj_adquirinte', 'cpf_cnpj_adquirinte', array('required' => 'true', 'maxlength' => '17', 'placeholder' => 'INFORME CPF / CNPJ DO ADQUIRINTE', 'onkeypress' => 'return SomenteNumero(event)', 'onkeyUp' => 'mascaraMutuario(this, cpfCnpj)', 'onblur' => 'validar_cpf_cnpj(this, \'id_tipo_pessoa_adquirinte\')'), '', 'somente os numeros');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?php
                                            //   INPUT -                           
                                            criar_input_text('TIPO PESSOA', 'tipo_pessoa_adquirinte', 'tipo_pessoa_adquirinte', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '12', 'placeholder' => 'FISICA'), '', 'Preencher o campo CPF/CNPJ');
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?php
                                            //   INPUT -                              
                                            criar_input_text_telefone('TEL / CEL', 'telefone', 'telefone', array('required' => 'true', 'maxlength' => '12', 'placeholder' => '(xx)xxxxxxx'), '', 'somente os numeros');
                                            ?>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <?php
                                            criar_input_text('Cep', 'cep_adquirinte', 'cep_adquirinte', array('required' => 'true', 'maxlength' => '8', 'placeholder' => 'xx.xxx-xxx', 'onkeypress' => 'return SomenteNumero(event)', ' onblur' => 'retornaCep(this.id, txt_cep_adquirinte, txt_rua_adquirinte, txt_bairro_adquirinte, txt_cidade_adquirinte, txt_uf_adquirinte)'), '', 'somente os numeros');
                                            ?>
                                        </div> 
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <?php
                                                criar_input_text('Rua', 'rua_adquirinte', 'rua_adquirinte', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '50', 'placeholder' => 'RUA'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                                                ?>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <?php
                                            criar_input_text('Bairro', 'bairro_adquirinte', 'bairro_adquirinte', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '20', 'placeholder' => 'BAIRRO'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                                            ?>
                                        </div>
                                        <div class="col-sm-5">
                                            <?php
                                            criar_input_text('Cidade', 'cidade_adquirinte', 'cidade_adquirinte', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '20', 'placeholder' => 'CIDADE'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                                            ?>
                                        </div>
                                        <div class="col-sm-2">
                                            <?php
                                            criar_input_text('UF', 'uf_adquirinte', 'uf_adquirinte', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'UF'), '', 'conter no minímo 2 caracteres [a-z A-Z]');
                                            ?>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <?php
                                            criar_input_text('N°', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                            ?>
                                        </div>
                                        <div class="col-sm-8">
                                            <?php
                                            criar_input_text('Complemento', 'complemento_endereco_adquirinte', 'complemento_endereco_adquirinte', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'COMPLEMENTO'), '', 'caracteres [a-z A-Z]');
                                            ?>
                                        </div>
                                    </div> 


                                </div>
                            </div> 
                        </div><!-- fim da primeira aba -->

                        <div id="menu1" class="tab-pane fade"> <!-- segunda aba -->
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading text-center">ESPECIFICAÇÃO DAS RECEITAS </div>
                                    <div class="panel-body">

                                        <div id="collapse1" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <?php
                                                                criar_input_select('RECEITA', 'complemento_endereco_adquirinte', 'complemento_endereco_adquirinte', array(), array(), 'caracteres [a-z A-Z]');
                                                                ?>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <?php
                                                                criar_input_text('VALOR', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '');
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
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-sm-8">
                                                                <?php
                                                                criar_input_select('RECEITA', 'complemento_endereco_adquirinte', 'complemento_endereco_adquirinte', array(), array(), 'caracteres [a-z A-Z]');
                                                                ?>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <?php
                                                                criar_input_text('VALOR', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '');
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
                                                        <hr /><div class="row">
                                                            <div class="col-sm-8">
                                                                <?php
                                                                criar_input_select('RECEITA', 'complemento_endereco_adquirinte', 'complemento_endereco_adquirinte', array(), array(), 'caracteres [a-z A-Z]');
                                                                ?>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <?php
                                                                criar_input_text('VALOR', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '');
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
                                                        <hr /><div class="row">
                                                            <div class="col-sm-8">
                                                                <?php
                                                                criar_input_select('RECEITA', 'complemento_endereco_adquirinte', 'complemento_endereco_adquirinte', array(), array(), 'caracteres [a-z A-Z]');
                                                                ?>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <?php
                                                                criar_input_text('VALOR', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '');
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
                                                        <hr />
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- fim da segunda aba -->
                        </div>
                        <div id="menu2" class="tab-pane fade"> <!-- segunda aba -->
                            <div class="panel-group" id="accordion">
                                <div class="panel panel-default">
                                    <div class="panel-heading text-center">INFORMAÇÕES COMPLEMENTARES </div>
                                    <div class="panel-body">

                                        <div id="collapse1" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="row">
                                                 <div class="col-sm-12">
                                                        <div class="row">
                                                                <div class="col-sm-4">
                                                                    <?php
                                                                    criar_input_text('TX.Exp', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)', 'title'=>'taxa de expediente bancario'), '', 'somente os numeros');
                                                                    ?>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <?php
                                                                    criar_input_text('Multas', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                                    ?>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <?php
                                                                    criar_input_text('Juros', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                                    ?>
                                                                </div>
                                                        </div>
                                                        <div class="row">
                                                                <div class="col-sm-4">
                                                                    <?php
                                                                    criar_input_text('Qtd.Parc', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)', 'title'=>'taxa de expediente bancario'), '', 'somente os numeros');
                                                                    ?>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <?php
                                                                    criar_input_text('Parc.Inicial', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                                    ?>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <?php
                                                                    criar_input_text('Vencimento', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                                    ?>
                                                                </div>
                                                        </div>
                                                        <div class="row">
                                                                <div class="col-sm-6">
                                                                    <?php
                                                                    criar_input_text('Auto Infração', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)', 'title'=>'taxa de expediente bancario'), '', 'somente os numeros');
                                                                    ?>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <?php
                                                                    criar_input_text('N°.Proc', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                                    ?>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <?php
                                                                    criar_input_text('Ano', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                                    ?>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- fim da segunda aba -->
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
}
?>
