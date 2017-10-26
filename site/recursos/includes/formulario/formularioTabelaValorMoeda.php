<?php
include_once '../estrutura/controle/validarSessao.php';
// importa função para mascarar data
include_once '../funcaoPHP/funcaoData.php';
// importa função para mascarar valores
include_once '../funcaoPHP/funcaoDinheiro.php';
// validacao
include_once '../funcaoPHP/function_letraMaiscula.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>

<?php
if (empty($_POST['id'])) {
    formularioCadastro();
} else {
    formularioAlterar();
}
?>

<?php

function formularioCadastro() {


    $anos = array(
        "2017" => "2017",
        "2016" => "2016",
        "2015" => "2015",
        "2014" => "2014",
        "2013" => "2013",
        "2012" => "2012"
    );

    $mes_ano = array(
        "" => "Escolha o mês",
        "01" => "Janeiro",
        "02" => "Fevereiro",
        "03" => "Março",
        "04" => "Abril",
        "05" => "Maio",
        "06" => "Junho",
        "07" => "Julho",
        "08" => "Agosto",
        "09" => "Setembro",
        "10" => "Outubro",
        "11" => "Novembro",
        "12" => "Dezembro"
    );
    ?>


    <form method="post" action="recursos/includes/cadastrar/cadastrarValorMoeda.php" name="cadastrar">    
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0">
            <div id="msg"></div>
            <div class="well">
                <?php
                if (isset($_SESSION['MENSAGEM_RETORNO_OPERACAO'])) {
                    echo $_SESSION['MENSAGEM_RETORNO_OPERACAO'];
                    unset($_SESSION['MENSAGEM_RETORNO_OPERACAO']);
                }
                ?>
                <div class="panel panel-default">
                    <!-- INICIO Dados do imóvel -->
                    <div class="panel-heading text-center">VALOR MOEDA</div>
                    <div class="panel-body">
                        <!-- inicio dados inscrição-->
                        <div class="row">
                            <div class="col-sm-2">
                                <?php
                                //   INPUT - Codigo Bairro                             
                                criar_input_text('Codigo', 'codigo', 'codigo', array('autofocus' => 'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'));
                                ?>
                            </div>
                            <div class="col-sm-10">
                                <?php
                                //   INPUT - Codigo Bairro                             
                                criar_input_text('Descricão', 'descricao', 'descricao', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'));
                                ?>

                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-3">
                                <?php
                                //   INPUT - Codigo Bairro                             
                                criar_input_select('Ano', 'ano', 'ano', array('required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $anos);
                                ?>

                            </div>
                            <div class="col-sm-3">
                                <?php
                                //   INPUT - Codigo Bairro                             
                                criar_input_select('Mês', 'mes', 'mes', array('required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $mes_ano);
                                ?>
                            </div>

                            <div class="col-sm-3">
                                <?php
                                //   INPUT - Descricao Tipo Coleta                             
                                criar_input_text('Valor(UFIR)', 'valor', 'valor', array('required' => 'true', 'maxlength' => '11', 'placeholder' => 'R$000.00', "onKeyPress" => "return formatarValor_5Casas(this, '.', ',', event);"), '', 'Conter apenas Numeros[0-9]');
                                ?>

                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-success" onclick="validaCamposFormulário()">Cadastrar</button>
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


<?php

function formularioAlterar() {
    ?>
    <?php
    $campos = explode("|", $_POST['codigo']);
    $cod_moeda = $campos[0];
    $desc_moeda = $campos[1];
    $data_moeda = $campos[2];
    $valor_moeda = $campos[3];
    ?>

    <form method="post" action="recursos/includes/alterar/alterarValorMoeda.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Alterar Valor Moeda</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-sm-2">
                    <?php
                    //   INPUT - Codigo Bairro                             
                    criar_input_text('Codigo', 'alterar_codigo', 'alterar_codigo', array('autofocus' => 'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $cod_moeda);
                    ?>
                </div>
                <div class="col-sm-10">
                    <?php
                    //   INPUT - Codigo Bairro                             
                    criar_input_text('Descricão', 'alterar_descricao', 'alterar_descricao', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $desc_moeda);
                    ?>
                </div>
            </div> 

            <div class="row">
                <div class="col-sm-6">
                    <?php
                    //   INPUT - Codigo Bairro                             
                    criar_input_text('Data Valor Moeda', 'alterar_data', 'alterar_data', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), dataBrasileiro($data_moeda));
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    //   INPUT - Descricao Tipo Coleta                             
                    criar_input_text('Valor(UFIR)', 'alterar_valor', 'alterar_valor', array('required' => 'true', 'maxlength' => '11', 'placeholder' => 'R$000.00', "onKeyPress" => "return formatarValor_5Casas(this, '.', ',', event);"), mostrarDinheiro5Casas($valor_moeda), 'Conter apenas Numeros[0-9]');
                    ?>

                </div>

            </div> 
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" >Alterar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </form>
    <?php
}
?>
