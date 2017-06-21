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
} else if ($_POST['id'] == 1) {
    formularioAlterar();
} else if ($_POST['id'] == 2) {
    formularioExcluir();
}
?>

<?php

function formularioCadastro() {
    ?>
    <form name="cadastro" method="post" action="recursos/includes/cadastrar/cadastrarValorM2Terreno.php">    
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0">
            <div id="msg"></div>
            <div class="well">
                <div class="panel panel-default">
                    <!-- INICIO Dados do imóvel -->
                    <div class="panel-heading text-center">VALOR M2 TERRENO</div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-3">
                                <?php
                                //   INPUT -                         
                                criar_input_text('Zona', 'zona', 'zona', array('required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'Somente números');
                                ?>
                            </div>
                            <div class="col-sm-3">
                                <?php
                                //   INPUT -                         
                                criar_input_text('Valor [Ufir]', 'valor', 'valor', array('required' => 'true', 'maxlength' => '11', 'placeholder' => 'R$000.00', 'onKeyPress' => "return formatarValor(this, '.', ',', event)"), '', 'Somente números');
                                ?>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <?php
                                //   INPUT -                         
                                criar_input_text_com_lupa('Código Utilização', 'cod_utilizacao', 'cod_utilizacao', array('required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'Somente números', 'lupa_utilizacao');
                                ?>
                            </div>

                            <div class="col-sm-8">
                                <?php
                                //   INPUT -                         
                                criar_input_text('Desc - Utilização', 'desc_utilizacao', 'desc_utilizacao', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'INSIRA CÓDIGO DA SITUAÇÃO', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                                ?>

                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-success" onclick="validarTerreno()">Cadastrar</button>
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
    $zona = $campos[0];
    $cod_utilizacao = $campos[1];
    $valor = $campos[2];
    $desc_utilizacao = $campos[3];
    ?>

    <form method="post" action="recursos/includes/alterar/alterarValorM2Terreno.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Alterar  Valor M2 Terreno</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-sm-3">
                    <?php
                    //   INPUT -                         
                    criar_input_text('Zona', 'excluir_zona', 'excluir_zona', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $zona, 'Somente números');
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    //   INPUT -                         
                    criar_input_text('Valor [Ufir]', 'excluir_valor', 'excluir_valor', array('required' => 'true', 'maxlength' => '11', 'placeholder' => 'R$000.00', 'onKeyPress' => "return formatarValor(this, '.', ',', event)"), $valor, 'Somente números');
                    ?>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                    //   INPUT -                         
                    criar_input_text_com_lupa('Código Utilização', 'excluir_cod_utilizacao', 'excluir_cod_utilizacao', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $cod_utilizacao, 'Somente números');
                    ?>
                </div>

                <div class="col-sm-8">
                    <?php
                    //   INPUT -                         
                    criar_input_text('Desc - Utilização', 'excluir_desc_utilizacao', 'excluir_desc_utilizacao', array('readonly' => 'true', 'readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'INSIRA CÓDIGO UTILIZAÇÃO', 'onkeypress' => 'return SomenteNumero(event)'), $desc_utilizacao, '');
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


<?php

function formularioExcluir() {
    ?>
    <?php
    $campos = explode("|", $_POST['codigo']);
    $zona = $campos[0];
    $cod_utilizacao = $campos[1];
    $valor = $campos[2];
    $desc_utilizacao = $campos[3];
    ?>

    <form method="post" action="recursos/includes/excluir/excluirValorM2Terreno.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Excluir Valor M2 Terreno</h4>
        </div>

        <div class="modal-body">
            <p style="color: red">Deseja Prosseguir com a Exclusão do Valor M2 Terreno ?</p>

            <div class="row">
                <div class="col-sm-3">
                    <?php
                    //   INPUT -                         
                    criar_input_text('Zona', 'excluir_zona', 'excluir_zona', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $zona, 'Somente números');
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    //   INPUT -                         
                    criar_input_text('Valor [Ufir]', 'excluir_valor', 'excluir_valor', array('readonly' => 'true' ,'required' => 'true', 'maxlength' => '11', 'placeholder' => 'R$000.00', 'onKeyPress' => "return formatarValor(this, '.', ',', event)"), $valor, 'Somente números');
                    ?>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-3">
                    <?php
                    //   INPUT -                         
                    criar_input_text_com_lupa('Código Utilização', 'excluir_cod_utilizacao', 'excluir_cod_utilizacao', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $cod_utilizacao, 'Somente números');
                    ?>
                </div>

                <div class="col-sm-8">
                    <?php
                    //   INPUT -                         
                    criar_input_text('Desc - Utilização', 'excluir_desc_utilizacao', 'excluir_desc_utilizacao', array('readonly' => 'true', 'readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'INSIRA CÓDIGO UTILIZAÇÃO', 'onkeypress' => 'return SomenteNumero(event)'), $desc_utilizacao, '');
                    ?>
                </div>
            </div> 
        </div> 

        <div class="modal-footer">
            <button type="submit" class="btn btn-danger" >Excluir</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>

    </form>
    <?php
}
?>