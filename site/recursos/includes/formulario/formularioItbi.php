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
    <form  method="post" action="" name="formularioItbi" id="formularioItbi" target="">   <!-- inicio do formulário --> 
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div class="well"><!-- div que coloca a cor no formulário -->
                <P ALIGN="CENTER">CADASTRO DE ITBI</P>
                <HR />
                <div class="row"><!-- primeira linha do formulário -->
                    <div class="col-sm-3">
                        <?php
                        //   INPUT -                         
                        criar_input_text('N° ITBI', 'numero_itbi', 'numero_itbi', array('autofocus' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', "somente numeros");
                        ?>
                    </div>
                    <div class="col-sm-3">
                        <?php
                        //   INPUT -                            
                        criar_input_text('ANO ITBI', 'ano_itbi', 'ano_itbi', array('required' => 'true', 'maxlength' => '4', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', "somente numeros");
                        ?>
                    </div>
                </div> <!-- fim da primeira linha do formulário -->

                <ul class="nav nav-tabs"> <!-- menu das abas -->
                    <li class="active"><a data-toggle="tab" href="#home">Adquirente</a></li>
                    <li><a data-toggle="tab" href="#menu1">Trasmitente-Cedente</a></li>
                    <li><a data-toggle="tab" href="#menu2">Imóvel</a></li>
                    <li><a data-toggle="tab" href="#menu3">Transação</a></li>
                </ul> <!-- fim dos menu das abas -->


                <div class="tab-content"><!-- abertura das abas do formulário -->
                    <div id="home" class="tab-pane fade in active"> <!-- primeira aba -->
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Adquirente </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <?php
                                                //   INPUT -                           
                                                criar_input_text('NOME COMPLETO', 'nome_completo_adquirinte', 'nome_completo_adquirinte', array('required' => 'true', 'maxlength' => '50', 'placeholder' => 'INFORME O NOME DO ADQUIRINTE'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                                                ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
                                                //   INPUT -                           
                                                criar_input_text('TIPO PESSOA', 'tipo_pessoa_adquirinte', 'tipo_pessoa_adquirinte', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '12', 'placeholder' => 'FISICA'), '', 'Preencher o campo CPF/CNPJ');
                                                ?>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?php
                                                //   INPUT -                           
                                                criar_input_text('CPF/CNPJ', 'cpf_cnpj_adquirinte', 'cpf_cnpj_adquirinte', array('required' => 'true', 'maxlength' => '17', 'placeholder' => 'INFORME CPF / CNPJ DO ADQUIRINTE', 'onkeypress' => 'return SomenteNumero(event)', 'onkeyUp' => 'mascaraMutuario(this, cpfCnpj)', 'onblur' => 'validar_cpf_cnpj(this, \'id_tipo_pessoa_adquirinte\')'), '', 'somente os numeros');
                                                ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php
                                                //   INPUT -                           
                                                criar_input_text('IDENTIDADE', 'identidade_adquirinte', 'identidade_adquirinte', array('required' => 'true', 'maxlength' => '20', 'placeholder' => 'INFORME IDENTIDADE DO ADQUIRINTE'), '', '(letras - numeros)');
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
                            </div>

                        </div>
                    </div> <!-- fim da primeira aba -->

                    <!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

                    <div id="menu1" class="tab-pane fade"> <!-- segunda aba -->
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Trasmitente-Cedente </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <?php
                                                //   INPUT -                           
                                                criar_input_text('NOME COMPLETO', 'nome_completo_transmitente', 'nome_completo_transmitente', array('required' => 'true', 'maxlength' => '50', 'placeholder' => 'INFORME O NOME DO TRANSMITENTE'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                                                ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
                                                //   INPUT -                           
                                                criar_input_text('TIPO PESSOA', 'tipo_pessoa_transmitente', 'tipo_pessoa_transmitente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '12', 'placeholder' => 'FISICA'), '', 'Preencher o campo CPF/CNPJ');
                                                ?>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <?php
                                                //   INPUT -      
                                                criar_input_text('CPF/CNPJ', 'cpf_cnpj_transmitente', 'cpf_cnpj_transmitente', array('required' => 'true', 'maxlength' => '17', 'placeholder' => 'INFORME CPF / CNPJ DO TRANSMITENTE', 'onkeypress' => 'return SomenteNumero(event)', 'onkeyUp' => 'mascaraMutuario(this, cpfCnpj)', 'onblur' => 'validar_cpf_cnpj(this, \'id_tipo_pessoa_transmitente\')'), '', 'somente os numeros');
                                                ?>
                                            </div>
                                            <div class="col-sm-6">
                                                <?php
                                                //   INPUT -                           
                                                criar_input_text('IDENTIDADE', 'identidade_transmitente', 'identidade_transmitente', array('required' => 'true', 'maxlength' => '20', 'placeholder' => 'INFORME IDENTIDADE DO TRANSMITENTE'), '', '(letras - numeros)');
                                                ?>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <?php
                                                criar_input_text('Cep', 'cep_transmitente', 'cep_transmitente', array('required' => 'true', 'maxlength' => '8', 'placeholder' => 'xx.xxx-xxx', 'onkeypress' => 'return SomenteNumero(event)', ' onblur' => 'retornaCep(this.id, txt_cep_transmitente, txt_rua_transmitente, txt_bairro_transmitente, txt_cidade_transmitente, txt_uf_transmitente)'), '', 'somente os numeros');
                                                ?>
                                            </div> 
                                            <div class="col-sm-8">
                                                <?php
                                                criar_input_text('Rua', 'rua_transmitente', 'rua_transmitente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '50', 'placeholder' => 'RUA'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                                                ?>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <?php
                                                criar_input_text('Bairro', 'bairro_transmitente', 'bairro_transmitente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '20', 'placeholder' => 'BAIRRO'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                                                ?>
                                            </div>
                                            <div class="col-sm-5">
                                                <?php
                                                criar_input_text('Cidade', 'cidade_transmitente', 'cidade_transmitente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '20', 'placeholder' => 'CIDADE'), '', 'conter no minímo 3 caracteres [a-z A-Z]');
                                                ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php
                                                criar_input_text('UF', 'uf_transmitente', 'uf_transmitente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'UF'), '', 'conter no minímo 2 caracteres [a-z A-Z]');
                                                ?>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <?php
                                                criar_input_text('N°', 'numero_endereco_transmitente', 'numero_endereco_transmitente', array('required' => 'true', 'maxlength' => '5', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                ?>
                                            </div>
                                            <div class="col-sm-8">
                                                <?php
                                                criar_input_text('Complemento', 'complemento_endereco_transmitente', 'complemento_endereco_transmitente', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'COMPLEMENTO'), '', 'caracteres [a-z A-Z]');
                                                ?>

                                            </div>
                                        </div> 

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- fim da segunda aba -->
                    <!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

                    <div id="menu2" class="tab-pane fade"> <!-- segunda aba -->
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Imóvel </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <div class="panel-body">
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
                                                criar_input_text('VALOR VENAL(R$)', 'valor_venal', 'valor_venal', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '11', 'placeholder' => 'R$XXXX,XX', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
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
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- fim da Terceira aba -->
                    <!--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->

                    <div id="menu3" class="tab-pane fade"> <!-- terceira aba -->
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">TRANSAÇÃO </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div id="campoNatureza">
                                                    <?php include '../funcaoPHP/campo_select_Natureza.php'; ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
                                                criar_input_text('N° PROCESSO', 'numero_processo', 'numero_processo', array('required' => 'true', 'maxlength' => '6', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                ?>

                                            </div>
                                            <div class="col-sm-3">
                                                <?php
                                                criar_input_text('ANO PROCESSO', 'ano_processo', 'ano_processo', array('required' => 'true', 'maxlength' => '4', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php
                                                criar_input_select('IMUNE', 'imunidade', 'imunidade', array('required' => 'true'), array('N' => 'NÃO', 'S' => 'SIM'));
                                                ?>

                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <?php
                                                criar_input_text('VALOR DECLARADO', 'valor_declarado', 'valor_declarado', array('required' => 'true', 'maxlength' => '11', 'placeholder' => 'xxxxx', 'onkeypress' => "return formatarValor(this, '.', ',', event)"), '', 'somente os numeros');
                                                ?>
                                            </div>
                                            <div class="col-sm-2">
                                                <?php
                                                criar_input_text('BASE CÁLCULO', 'base_calculo', 'base_calculo', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '11', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                ?>

                                            </div>
                                            <div class="col-sm-2">
                                                <?php
                                                criar_input_text('VALOR MULTA', 'valor_multa', 'valor_multa', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '11', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                ?>

                                            </div>
                                            <div class="col-sm-2">
                                                <?php
                                                criar_input_text('VALOR DO ITBI', 'valor_itbi', 'valor_itbi', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '11', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                ?>

                                            </div>
                                            <div class="col-sm-2">
                                                <?php
                                                criar_input_text('VALOR TOTAL', 'valor_total', 'valor_total', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '11', 'placeholder' => 'xxxxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
                                                ?>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <?php
                                                criar_input_data('DATA TRANSAÇÃO', 'data_transacao', 'dt_inicial', array('required' => 'true', 'placeholder' => 'DATA DA TRANSACAO'));
                                                ?>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
                                                criar_input_data('VENCIMENTO', 'vencimento', 'dt_final', array('required' => 'true', 'placeholder' => 'DATA DO VENCIMENTO'));
                                                ?>

                                            </div>

                                            <div class="col-sm-2">
                                                <?php
                                                criar_input_select('MULTA', 'multa', 'multa', array('required' => 'true'), array('N' => '0%', '1' => '50%', '2' => '100%'));
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?php
                                                //   INPUT -                           
                                                criar_input_text('DECLARANTE', 'declarante', 'declarante', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'INFORME O NOME DO DECLARANTE'), '', '');
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- fim da Quarta aba -->
                    <!-- Buttons do formulário -->
                    <div id="divButonn">
                    </div>
                    <!-- Fim dos Buttons do formulário -->
                </div><!-- fim da abertura das abas do formulário -->
            </div><!-- div que coloca a cor no formulário -->
        </div><!-- div que posiciona o formulário na tela -->
    </form> <!-- fim do Formulário -->
    <?php
}
?>