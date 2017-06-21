<?php
include_once '../estrutura/controle/validarSessao.php';
//validacao
include_once '../funcaoPHP/function_letraMaiscula.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>

<form method="post" name="formulario_endereco_correspondencia" action="recursos/includes/alterar/alterarEnderecoCorrespondencia.php">    
    <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0">
        <div id="msg"></div>
        <div class="well">
            <div class="panel panel-default">
                <!-- INICIO Dados do imóvel -->
                <div class="panel-heading text-center">CADASTRO ENDEREÇO CORRESPÔNDENCIA</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <?php
                            //   INPUT -                            
                            criar_input_text('Inscrição', 'inscricao', 'inscricao', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                            ?>
                        </div>

                        <div class="col-sm-10">
                            <?php
                            //   INPUT -                             
                            criar_input_text('Proprietário', 'proprietario', 'proprietario', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '50', 'placeholder' => 'PROPRIETÁRIO IMÓVEL'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                            ?>
                        </div>
                    </div> 
                    <div class="row">      
                        <div class="col-sm-12">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Endereço de Remessa de Avisos
                                    </div>
                                    <div class="panel-collapse collapse in">
                                        <br/>
                                        <div class="col-sm-12">
                                            <?php
                                            //   INPUT -                              
                                            criar_input_text('NOME COMPLETO', 'nome_completo', 'nome_completo', array('required' => 'true', 'maxlength' => '50', 'placeholder' => 'NOME COMPLETO'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                                            ?>
                                        </div>

                                        <div class="col-sm-4">
                                            <?php
                                            criar_input_text('Cep', 'cep', 'cep', array('required' => 'true', 'maxlength' => '8', 'placeholder' => 'xx.xxx-xxx', 'onkeypress' => 'return SomenteNumero(event)', ' onblur' => 'retornaCep(this.id, txt_cep, txt_rua, txt_bairro, txt_cidade, txt_uf)'), '', 'somente os numeros');
                                            ?>
                                        </div> 

                                        <div class="col-sm-4">
                                            <?php
                                            criar_input_text('Telefone', 'telefone', 'telefone', array('title' => 'Exemplo : 21926511048', 'required' => 'true', 'maxlength' => '12', 'placeholder' => '(xx)xxxxx-xxxx', 'onkeypress' => 'return SomenteNumero(event)', ' onblur' => 'mascaraTelefone(this.id)'), '', 'somente os numeros');
                                            ?>
                                        </div> 

                                        <div class="col-sm-12">
                                            <?php
                                            criar_input_text('Rua', 'rua', 'rua', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '50', 'placeholder' => 'RUA'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                                            ?>
                                        </div> 
                                        <div class="col-sm-2">
                                            <?php
                                            criar_input_text('N°', 'numero', 'numero', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                            ?>
                                        </div> 
                                        <div class="col-sm-10">

                                            <?php
                                            criar_input_text('Complemento', 'complemento', 'complemento', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'COMPLEMENTO'), '', 'caracteres [a-z A-Z]');
                                            ?>


                                        </div> 
                                        <div class="col-sm-6">
                                            <?php
                                            criar_input_text('Bairro', 'bairro', 'bairro', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '20', 'placeholder' => 'BAIRRO'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                                            ?>
                                        </div> 
                                        <div class="col-sm-6">
                                            <?php
                                            criar_input_text('Cidade', 'cidade', 'cidade', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '20', 'placeholder' => 'CIDADE'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                                            ?>
                                        </div> 
                                        <div class="col-sm-4">
                                            <?php
                                            criar_input_text('UF', 'uf', 'uf', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'UF'), '', 'conter no minímo 2 caracteres [a-z A-Z]');
                                            ?>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div id="divButonnAlterar"></div>
                        </div>
                        <div class="col-sm-8 text-right">
                            <div id="divButonnCopiarEndereco"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
