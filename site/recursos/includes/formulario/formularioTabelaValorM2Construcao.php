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

    <form name="cadastro" method="post" action="recursos/includes/cadastrar/cadastrarValorM2Construcao.php">    
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0">
            <div id="msg"></div>
            <div class="well">
                <div class="panel panel-default">
                    <!-- INICIO Dados do imóvel -->
                    <div class="panel-heading text-center">VALOR M2 CONTRUÇÃO</div>
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
                                criar_input_text_com_lupa('Código Utilização', 'cod_utilizacao', 'cod_utilizacao', array('required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'Somente números', 'lupa_categoria');
                                ?>
                            </div>

                            <div class="col-sm-8">
                                <?php
                                //   INPUT -                         
                                criar_input_text('Desc - Utilização', 'desc_utilizacao', 'desc_utilizacao', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'INSIRA CÓDIGO UTILIZAÇÃO', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                                ?>

                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-3">
                                <?php
                                //   INPUT -                         
                                criar_input_text_com_lupa('Código Categoria', 'cod_cat', 'cod_cat', array('required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'Somente números', 'lupa_categoria');
                                ?>
                            </div>

                            <div class="col-sm-8">
                                <?php
                                //   INPUT -                         
                                criar_input_text('Desc - Categoria', 'desc_cat', 'desc_cat', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'INSIRA CÓDIGO CATEGORIA', 'onkeypress' => 'return SomenteNumero(event)'), '', '');
                                ?>

                            </div>
                        </div> 

                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success" onclick="validarConstrucao()">Cadastrar</button>
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

    $zona = $campos[0]; //zona_fiscal
    $valor = $campos[1]; //valor
    $cod_utilizacao = $campos[2]; //cod_utilizacao
    $utilizacao = $campos[3]; //utilizacao
    $cod_categoria = $campos[4]; //cod_categoria
    $categoria = $campos[5]; //categoria
    ?>

    <form method="post" action="recursos/includes/alterar/alterarValorM2Construcao.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Alterar  Valor M2 Construção</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-sm-3">
                    <?php
                    //   INPUT -                         
                    criar_input_text('Zona', 'alterar_zona', 'alterar_zona', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $zona, 'Somente números');
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    //   INPUT -                         
                    criar_input_text('Valor [Ufir]', 'alterar_valor', 'alterar_valor', array('required' => 'true', 'maxlength' => '11', 'placeholder' => 'R$000.00', 'onKeyPress' => "return formatarValor(this, '.', ',', event)"), $valor, 'Somente números');
                    ?>
                </div>

            </div>


            <div class="row">
                <div class="col-sm-3">
                    <?php
                    //   INPUT -                         
                    criar_input_text_com_lupa('Código Utilização', 'alterar_cod_utilizacao', 'alterar_cod_utilizacao', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $cod_utilizacao, 'Somente números');
                    ?>
                </div>

                <div class="col-sm-8">
                    <?php
                    //   INPUT -                         
                    criar_input_text('Desc - Utilização', 'alterar_desc_utilizacao', 'alterar_desc_utilizacao', array('readonly' => 'true', 'readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'INSIRA CÓDIGO UTILIZAÇÃO', 'onkeypress' => 'return SomenteNumero(event)'), $utilizacao, '');
                    ?>
                </div>
            </div> 

            <div class="row">
                <div class="col-sm-3">
                    <?php
                    //   INPUT -                         
                    criar_input_text_com_lupa('Código Categoria', 'alterar_cod_cat', 'alterar_cod_cat', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $cod_categoria, 'Somente números', '');
                    ?>
                </div>

                <div class="col-sm-8">
                    <?php
                    //   INPUT -                         
                    criar_input_text('Desc - Categoria', 'alterar_desc_cat', 'alterar_desc_cat', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'INSIRA CÓDIGO CATEGORIA', 'onkeypress' => 'return SomenteNumero(event)'), $categoria, '');
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

    $zona = $campos[0]; //zona_fiscal
    $valor = $campos[1]; //valor
    $cod_utilizacao = $campos[2]; //cod_utilizacao
    $utilizacao = $campos[3]; //utilizacao
    $cod_categoria = $campos[4]; //cod_categoria
    $categoria = $campos[5]; //categoria
    ?>

    <form method="post" action="recursos/includes/excluir/excluirValorM2Construcao.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Excluir Valor M2 Consrução</h4>
        </div>

        <div class="modal-body">
            <p style="color: red">Deseja Prosseguir com a Exclusão do Valor M2 Consrução ?</p>

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
                    criar_input_text('Valor [Ufir]', 'excluir_valor', 'excluir_valor', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '11', 'placeholder' => 'R$000.00', 'onKeyPress' => "return formatarValor(this, '.', ',', event)"), $valor, 'Somente números');
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
                    criar_input_text('Desc - Utilização', 'excluir_desc_utilizacao', 'excluir_desc_utilizacao', array('readonly' => 'true', 'readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'INSIRA CÓDIGO UTILIZAÇÃO', 'onkeypress' => 'return SomenteNumero(event)'), $utilizacao, '');
                    ?>
                </div>
            </div> 

            <div class="row">
                <div class="col-sm-3">
                    <?php
                    //   INPUT -                         
                    criar_input_text_com_lupa('Código Categoria', 'excluir_cod_cat', 'excluir_cod_cat', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $cod_categoria, 'Somente números', '');
                    ?>
                </div>

                <div class="col-sm-8">
                    <?php
                    //   INPUT -                         
                    criar_input_text('Desc - Categoria', 'excluir_desc_cat', 'excluir_desc_cat', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'INSIRA CÓDIGO CATEGORIA', 'onkeypress' => 'return SomenteNumero(event)'), $categoria, '');
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