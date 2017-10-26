<?php
include_once '../estrutura/controle/validarSessao.php';
//validacao
include_once '../funcaoPHP/function_letraMaiscula.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>

<form role="form" method="post" name="formularioRelCertidaoNegativa" action="recursos/includes/relatorio/controle_rel_certidao_regularidade_fiscal.php">   
    <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
        <div class="well"><!-- div que coloca a cor no formulário -->
            <div class="panel panel-default">
                <!-- INICIO Dados do imóvel -->
                <div class="panel-heading text-center">EMISSÃO CERTIDÃO REGULARIDADE FISCAL</div>
                <div class="panel-body ">
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="msg_erro"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?php
                                //   INPUT -                         
                                criar_input_text('INSCRIÇÃO', 'num_inscricao', 'num_inscricao', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            //   INPUT -                           
                            criar_input_text('PROPRIETÁRIO', 'proprietario_imovel', 'proprietario_imovel', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '50', 'placeholder' => 'INFORME O NOME DO PROPRIETARIO'), '', '');
                            ?>
                        </div>
                        <div class="col-sm-2">
                            <?php
                            //   INPUT -                         
                            criar_input_text('ÁREA TERRENO', 'area_terreno', 'area_terreno', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '11', 'placeholder' => 'AREA TERRENO', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                            ?>

                        </div>
                        <div class="col-sm-2">
                            <?php
                            //   INPUT -                         
                            criar_input_text('ÁREA CONSTRUIDA', 'area_construida', 'area_construida', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '11', 'placeholder' => 'AREA CONSTRUCAO', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                            ?>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-2">
                            <?php
                            //   INPUT -                         
                            criar_input_text('FRAÇÃO IDEAL', 'fracao_ideal', 'fracao_ideal', array('required' => 'true', 'maxlength' => '11', 'placeholder' => 'FRACAO IDEAL', 'onkeypress' => 'return SomenteNumero(event)'), '1', '');
                            ?>
                        </div>
                        <div class="col-sm-2">
                            <?php
                            //   INPUT -                         
                            criar_input_text('UTILIZAÇÃO', 'utilizacao', 'utilizacao', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '12', 'placeholder' => 'UTILIZACAO', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                            criar_input_hidden('codigo_utilizacao_imovel', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '1'));
                            ?>
                        </div>
                        <div class="col-sm-2">
                            <?php
                            //   INPUT -                         
                            criar_input_text('VALOR VENAL', 'valor_venal', 'valor_venal', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '11', 'placeholder' => 'R$XXXX,XX', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                            ?>

                        </div>
                        <div class="col-sm-6">
                            <?php
                            //   INPUT -                         
                            criar_input_text('LOGRADOURO', 'logradouro_imovel', 'logradouro_imovel', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '50', 'placeholder' => 'LOGRADOURO', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                            criar_input_hidden('codigo_rua_imovel', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '5'));
                            ?>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-2">
                            <?php
                            criar_input_text('N°', 'numero_endereco_imovel', 'numero_endereco_imovel', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '5', 'placeholder' => 'XXXXX', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                            ?>

                        </div>
                        <div class="col-sm-3">
                            <?php
                            criar_input_text('COMPLEMENTO', 'complemento_endereco_imovel', 'complemento_endereco_imovel', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '30', 'placeholder' => 'COMPLEMENTO'), '', '');
                            ?>

                        </div>

                        <div class="col-sm-2">
                            <?php
                            criar_input_text('QUADRA', 'quadra_endereco_imovel', 'quadra_endereco_imovel', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '4', 'placeholder' => 'QUADRA'), '', '');
                            ?>

                        </div>
                        <div class="col-sm-2">
                            <?php
                            criar_input_text('LOTE', 'lote_endereco_imovel', 'lote_endereco_imovel', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '4', 'placeholder' => 'LOTE'), '', '');
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <?php
                            //   INPUT -                         
                            criar_input_text('BAIRRO', 'bairro_imovel', 'bairro_imovel', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '20', 'placeholder' => 'BAIRRO', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                            criar_input_hidden('codigo_bairro_imovel', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '3'));
                            ?>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <?php
                            criar_input_text('DATA AVERBAÇÃO', 'data_averbacao', 'data_averbacao', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '5', 'placeholder' => 'XXXXX', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                            ?>

                        </div>
                        <div class="col-sm-3">
                            <?php
                            criar_input_text('NUMERO PROCESSO', 'numero_processo', 'numero_processo', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                            ?>

                        </div>

                        <div class="col-sm-3">
                            <?php
                            criar_input_text('ANO PROCESSO', 'ano_processo', 'ano_processo', array('required' => 'true', 'maxlength' => '4', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                            ?>
                        </div>

                    </div>
                </div>
                <!-- FIM Dados do imóvel -->
                <div class="panel-heading text-center">IDENTIFICAÇÃO DO CONTRIBUINTE</div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-9">
                            <?php
                            //   INPUT -                           
                            criar_input_text('NOME COMPLETO', 'nome_completo_requerente', 'nome_completo_requerente', array('required' => 'true', 'maxlength' => '50', 'placeholder' => 'INFORME O NOME DO TRANSMITENTE'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                            ?>
                        </div>
                        <div class="col-sm-3">
                            <?php
                            //   INPUT -                           
                            criar_input_text('TIPO PESSOA', 'tipo_pessoa_requerente', 'tipo_pessoa_requerente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '12', 'placeholder' => 'FISICA'), '', 'Preencher o campo CPF/CNPJ');
                            ?>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-6">
                            <?php
                            //   INPUT -      
                            criar_input_text('CPF/CNPJ', 'cpf_cnpj_requerente', 'cpf_cnpj_requerente', array('required' => 'true', 'maxlength' => '17', 'placeholder' => 'INFORME CPF / CNPJ DO TRANSMITENTE', 'onkeypress' => 'return SomenteNumero(event)', 'onkeyUp' => 'mascaraMutuario(this, cpfCnpj)', 'onblur' => 'validar_cpf_cnpj(this, \'id_tipo_pessoa_requerente\')'), '', 'somente os numeros');
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            //   INPUT -                           
                            criar_input_text('IDENTIDADE', 'identidade_requerente', 'identidade_requerente', array('required' => 'true', 'maxlength' => '20', 'placeholder' => 'INFORME IDENTIDADE DO TRANSMITENTE'), '', '(letras - numeros)');
                            ?>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-4">
                            <?php
                            criar_input_text('Cep', 'cep_requerente', 'cep_requerente', array('required' => 'true', 'maxlength' => '8', 'placeholder' => 'xx.xxx-xxx', 'onkeypress' => 'return SomenteNumero(event)', ' onblur' => 'retornaCep(this.id, txt_cep_requerente, txt_rua_requerente, txt_bairro_requerente, txt_cidade_requerente, txt_uf_requerente)'), '', 'somente os numeros');
                            ?>
                        </div> 
                        <div class="col-sm-8">
                            <?php
                            criar_input_text('Rua', 'rua_requerente', 'rua_requerente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '50', 'placeholder' => 'RUA'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                            ?>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-5">
                            <?php
                            criar_input_text('Bairro', 'bairro_requerente', 'bairro_requerente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '20', 'placeholder' => 'BAIRRO'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                            ?>
                        </div>
                        <div class="col-sm-5">
                            <?php
                            criar_input_text('Cidade', 'cidade_requerente', 'cidade_requerente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '20', 'placeholder' => 'CIDADE'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                            ?>
                        </div>
                        <div class="col-sm-2">
                            <?php
                            criar_input_text('UF', 'uf_requerente', 'uf_requerente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'UF'), '', 'conter no minímo 2 caracteres [a-z A-Z]');
                            ?>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-sm-2">
                            <?php
                            criar_input_text('N°', 'numero_endereco_requerente', 'numero_endereco_requerente', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                            ?>
                        </div>
                        <div class="col-sm-8">
                            <?php
                            criar_input_text('Complemento', 'complemento_endereco_requerente', 'complemento_endereco_requerente', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'COMPLEMENTO'), '', 'caracteres [a-z A-Z]');
                            ?>

                        </div>
                    </div>
                </div>
                <!-- FIM Dados do imóvel -->
                <div class="panel-heading text-center">OBSERVAÇÃO</div>
                <div class="panel-body">
                    <?php
                    criar_textarea("obs", "obs", "obs");
                    ?>
                </div>
            </div>
            <div id="divButonn">
            </div>
        </div>
    </div>     
</form>
<!--  Fim Fomulario  -->