<?php
include_once '../estrutura/controle/validarSessao.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';

//foi realizado alteração no banco de dados 



?>
<?php
if (empty($_POST['id'])) {
    
    formularioCadastro();
}
?>

<?php

function formularioCadastro() {
    
    ?>

    <!-- bloco para mostrar mensagens retornados do sistema -->
    <div class="row">
        <div class="col-sm-12">
            <div  id="msg"></div>
            <div  id="msg_erro"></div>
        </div>
    </div>
    <!-- fim do bloco mensagens retornadas pelo sistema -->
    <form  method="post" action="recursos/includes/cadastrar/cadastra_configuracao_cliente.php" name="formularioItbi" id="formularioItbi" enctype="multipart/form-data">  <!-- inicio do formulário --> 
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div class="well"><!-- div que coloca a cor no formulário -->
                <P ALIGN="CENTER">CONFIGURAÇÃO SISTEMA</P>
                <HR />

                <ul class="nav nav-tabs"> <!-- menu das abas -->
                    <li class="active"><a data-toggle="tab" href="#home">Informações-Cliente</a></li>
                    <!--<li><a data-toggle="tab" href="#menu1">Outros</a></li>-->
                </ul> <!-- fim dos menu das abas -->


                <div class="tab-content"><!-- abertura das abas do formulário -->
                    <div id="home" class="tab-pane fade in active"> <!-- primeira aba -->
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">DADOS DO CLIENTE </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <!-- inicio dados inscrição-->
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <?php
                                                //   INPUT -                      
                                                criar_input_text('NOME CLIENTE', 'nome_cliente', 'nome_cliente', array('required' => 'true', 'maxlength' => '50', 'placeholder' => 'NOME DO CLIENTE'), $_SESSION['C_PREFEITURA']);
                                                ?>
                                            </div>
                                            <div class="col-sm-5">
                                                <?php
                                                //   INPUT -                      
                                                criar_input_file('LOGO TIPO', 'logo_tipo_cliente', 'logo_tipo_cliente', array('accept' => "image/jpg"));
                                                ?>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <?php
                                                //   INPUT -                      
                                                criar_input_text('UNIDADE', 'unidade_gestora', 'unidade_gestora', array('required' => 'true', 'maxlength' => '50', 'placeholder' => 'UNIDADE GESTORA'), $_SESSION['C_SECRETARIA']);
                                                ?>
                                            </div>
                                            <div class="col-sm-5">
                                                <?php
                                                //   INPUT -                           
                                                criar_input_text('CNPJ', 'cpf_cnpj_adquirinte', 'cpf_cnpj_adquirinte', array('required' => 'true', 'maxlength' => '17', 'placeholder' => 'INFORME CNPJ DO CLIENTE', 'onkeypress' => 'return SomenteNumero(event)', 'onkeyUp' => 'mascaraMutuario(this, cpfCnpj)', 'onblur' => 'validar_cpf_cnpj(this, \'id_tipo_pessoa_adquirinte\')'), $_SESSION['C_CNPJ'], 'somente os numeros');
                                                criar_input_hidden('tipo_pessoa_adquirinte', array('required' => 'true'), 'JURÍDICA');
                                                ?>

                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?php
                                                criar_input_text('Cep', 'cep_adquirinte', 'cep_adquirinte', array('required' => 'true', 'maxlength' => '8', 'placeholder' => 'xx.xxx-xxx', 'onkeypress' => 'return SomenteNumero(event)', ' onblur' => 'retornaCep(this.id, txt_cep_adquirinte, txt_rua_adquirinte, txt_bairro_adquirinte, txt_cidade_adquirinte, txt_uf_adquirinte)'), $_SESSION['C_CEP'], 'somente os numeros');
                                                ?>
                                            </div> 
                                            <div class="col-sm-8">
                                                <div class="form-group">
                                                    <?php
                                                    criar_input_text('Rua', 'rua_adquirinte', 'rua_adquirinte', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '50', 'placeholder' => 'RUA'), $_SESSION['C_ENDERECO'], 'conter no minímo 3 caracteres [a-z A-Z]');
                                                    ?>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <?php
                                                criar_input_text('Bairro', 'bairro_adquirinte', 'bairro_adquirinte', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '20', 'placeholder' => 'BAIRRO'), $_SESSION['C_BAIRRO'], 'conter no minímo 3 caracteres [a-z A-Z]');
                                                ?>
                                            </div>
                                            <div class="col-sm-5">
                                                <?php
                                                criar_input_text('Cidade', 'cidade_adquirinte', 'cidade_adquirinte', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '20', 'placeholder' => 'CIDADE'), $_SESSION['C_CIDADE'], 'conter no minímo 3 caracteres [a-z A-Z]');
                                                ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php
                                                criar_input_text('UF', 'uf_adquirinte', 'uf_adquirinte', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'UF'), $_SESSION['C_UF'], 'conter no minímo 2 caracteres [a-z A-Z]');
                                                ?>
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <?php
                                                criar_input_text('N°', 'numero_endereco_adquirinte', 'numero_endereco_adquirinte', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), $_SESSION['C_NUMERO'], 'somente os numeros');
                                                ?>
                                            </div>
                                            <div class="col-sm-8">
                                                <?php
                                                criar_input_text('Complemento', 'complemento_endereco_adquirinte', 'complemento_endereco_adquirinte', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'COMPLEMENTO'), $_SESSION['C_COMPLEMENTO'], 'caracteres [a-z A-Z]');
                                                ?>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <button type="submit" class="btn btn-success" >Cadastrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> <!-- fim da primeira aba -->

                </div><!-- fim da abertura das abas do formulário -->
            </div><!-- div que coloca a cor no formulário -->
        </div><!-- div que posiciona o formulário na tela -->
    </form> <!-- fim do Formulário -->
    <?php
}
?>