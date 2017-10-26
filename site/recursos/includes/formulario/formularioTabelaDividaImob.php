<?php
include_once '../estrutura/controle/validarSessao.php';
//validacao
include_once '../funcaoPHP/function_letraMaiscula.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';

include_once '../funcaoPHP/funcaoData.php';
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
    <?php
    include_once '../estrutura/conexao/conexao.php';
    $sql = "SELECT TOP 1 Cod_Divida_Imob
            FROM Divida_Imob
            ORDER BY Cod_Divida_Imob DESC";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();

    $pdo = null;

    // inicializo a variavel que irá mostrar o proximo numero
    if (empty($dados['Cod_Divida_Imob'])) {
        $cod = str_pad(1, 2, "0", STR_PAD_LEFT);
    } else {
        $cod = str_pad( ++$dados['Cod_Divida_Imob'], 2, "0", STR_PAD_LEFT);
    }
    ?>

    <form method="post" action="recursos/includes/cadastrar/cadastrarDividaImob.php">    
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div class="well"><!-- div que coloca a cor no formulário -->
                <?php
                if (isset($_SESSION['MENSAGEM_RETORNO_OPERACAO'])) {
                    echo $_SESSION['MENSAGEM_RETORNO_OPERACAO'];
                    unset($_SESSION['MENSAGEM_RETORNO_OPERACAO']);
                }
                ?>
                <div class="panel panel-default">
                    <!-- INICIO Dados do imóvel -->
                    <div class="panel-heading text-center">CADASTRO DÍVIDA IMÓVEL</div>
                    <div class="panel-body">
                        <!-- inicio dados inscrição-->
                        <div id="msg"></div>
                        <div class="row">
                            <div class="col-sm-2">
                                <?php
                                //   INPUT - Codigo Divida                             
                                criar_input_text('Codigo', 'codigo', 'codigo', array('required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $cod, 'Somente numeros');
                                ?>
                            </div>
                            <div class="col-sm-10">
                                <?php
                                //   INPUT - Codigo Divida                             
                                criar_input_text('Descrição-Dívida', 'descricao', 'descricao', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe Nome da Dívida'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                                ?>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                //   INPUT - Codigo Divida                             
                                criar_input_text('Descrição-Completa Dívida', 'descricao_completa', 'descricao_completa', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Nome Completo'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                                ?>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Cota ùnica
                                        </div>
                                        <div class="panel-collapse collapse in">
                                            <div class="col-sm-7">
                                                <?php
                                                // OBSERVAÇÃO DA INSERÇÃO DA DIVIDA
                                                criar_input_data('Vencimento', 'data', 'data', array(), '', 'Somente numeros');
                                                ?> 
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label for="txt_desconto">Desconto :</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name ="txt_desconto" id="id_desconto" required="true" value="" placeholder="xx" maxlength="2" onkeypress='return SomenteNumero(event)'>
                                                        <span class="input-group-addon">
                                                            <span>%</span>
                                                        </span>
                                                    </div>  
                                                    <span class="help-block">Somente numeros</span>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Códigos Contábeis
                                        </div>
                                        <div class="panel-collapse collapse in">
                                            <div class="col-sm-4">
                                                <?php
                                                //   INPUT - Codigo Divida                             
                                                criar_input_text('Do Ano', 'codigo_ano', 'codigo_ano', array('required' => 'true', 'maxlength' => '3', 'placeholder' => 'XXX', 'onkeypress' => 'return SomenteNumero(event)'), '', 'Somente numeros');
                                                ?>
                                            </div>
                                            <div class="col-sm-4">
                                                <?php
                                                //   INPUT - Codigo Divida                             
                                                criar_input_text('Dív Ativ', 'divida_ativa', 'divida_ativa', array('required' => 'true', 'maxlength' => '3', 'placeholder' => 'XX', 'onkeypress' => 'return SomenteNumero(event)'), '', 'Somente numeros');
                                                ?>
                                            </div> 
                                            <div class="col-sm-4">
                                                <?php
                                                //   INPUT - Codigo Divida                             
                                                criar_input_text('Mult/Juros', 'multas_juros', 'multas_juros', array('required' => 'true', 'maxlength' => '2', 'placeholder' => 'XX', 'onkeypress' => 'return SomenteNumero(event)'), '', 'Somente numeros');
                                                ?>
                                            </div> 
                                        </div>
                                    </div>
                                </div>
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
    </form>
    <?php
}
?>
<?php

function formularioAlterar() {
    ?>
    <?php
    $codigo = $_POST['codigo'];
    include_once '../estrutura/conexao/conexao.php';
    $sql = "Select * FROM Divida_Imob WHERE Cod_Divida_Imob = '" . $codigo . "'";
    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();
    $pdo = null;


    $desconto = (int) $dados['Desconto'];
    if (strlen($desconto) == 1) {
        $desconto = '0' . $desconto;
    }
    ?>



    <form method="post" action="recursos/includes/alterar/alterarDividaImob.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Alterar Dívida Imobiliário</h4>
        </div>

        <div class="modal-body"> 
            <div class="row">

                <div class="col-sm-2">
                    <?php
                    //   INPUT - Codigo Divida                             
                    criar_input_text('Codigo', 'alterar_codigo', 'alterar_codigo', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Divida_Imob'], 'Somente numeros');
                    ?>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <?php
                        //   INPUT - Codigo Divida                             
                        criar_input_text('Descrição-Dívida', 'alterar_descricao', 'alterar_descricao', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe Nome da Dívida'), $dados['Desc_Divida'], 'Conter no Minimo 3 caracteres [a-z A-Z]');
                        ?>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <?php
                    //   INPUT - Codigo Divida                             
                    criar_input_text('Descrição-Completa Dívida', 'alterar_descricao_completa', 'alterar_descricao_completa', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Nome Completo'), $dados['DESC_COMPLETA'], 'Conter no Minimo 3 caracteres [a-z A-Z]');
                    ?>
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Cota ùnica
                            </div>
                            <div class="panel-collapse collapse in">
                                <div class="col-sm-6">
                                    <?php
                                    // OBSERVAÇÃO DA INSERÇÃO DA DIVIDA
                                    criar_input_data('Vencimento', 'alterar_data', 'alterar_data', array(), dataBrasileiro($dados['Venc_Cota_Unica']), 'Somente numeros');
                                    ?> 
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txtAltDesconto">Desconto:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name ="txt_alterar_desconto" id="id_alterar_desconto" required="true" value="<?php echo $desconto; ?>" placeholder="xx" maxlength="11" onkeypress='return SomenteNumero(event)'>

                                            <span class="input-group-addon">
                                                <span>%</span>
                                            </span>
                                        </div>  
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Códigos Contábeis
                            </div>
                            <div class="panel-collapse collapse in">
                                <div class="col-sm-4">
                                    <?php
                                    //   INPUT - Codigo Divida                             
                                    criar_input_text('Do Ano', 'alterar_codigo_ano', 'alterar_codigo_ano', array('required' => 'true', 'maxlength' => '3', 'placeholder' => 'XXX', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Contabil'], 'Somente numeros');
                                    ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php
                                    //   INPUT - Codigo Divida                             
                                    criar_input_text('Dív Ativ', 'alterar_divida_ativa', 'alterar_divida_ativa', array('required' => 'true', 'maxlength' => '3', 'placeholder' => 'XX', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Contabil_DA'], 'Somente numeros');
                                    ?>
                                </div> 
                                <div class="col-sm-4">
                                    <?php
                                    //   INPUT - Codigo Divida                             
                                    criar_input_text('Mult/Juros', 'alterar_multas_juros', 'alterar_multas_juros', array('required' => 'true', 'maxlength' => '2', 'placeholder' => 'XX', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Contabil_Multa_Juros'], 'Somente numeros');
                                    ?>
                                </div> 

                            </div>
                        </div>
                    </div>
                </div>
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
    $codigo = $_POST['codigo'];
    include_once '../estrutura/conexao/conexao.php';
    $sql = "Select * FROM Divida_Imob WHERE Cod_Divida_Imob = '" . $codigo . "'";
    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();
    $pdo = null;
    
    $desconto = (int) $dados['Desconto'];
    if (strlen($desconto) == 1) {
        $desconto = '0' . $desconto;
    }
    
    ?>



    <form method="post" action="recursos/includes/excluir/excluirDividaImob.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Excluir Dívida Imobiliário</h4>
        </div>

        <div class="modal-body"> 
            <p style="color: red">Deseja Prosseguir com a Exclusão da Dívida Imobiliária?</p>

            <div class="row">

                <div class="col-sm-2">
                    <?php
                    //   INPUT - Codigo Divida                             
                    criar_input_text('Codigo', 'excluir_codigo', 'excluir_codigo', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Divida_Imob'], 'Somente numeros');
                    ?>
                </div>
                <div class="col-sm-10">
                    <div class="form-group">
                        <?php
                        //   INPUT - Codigo Divida                             
                        criar_input_text('Descrição-Dívida', 'excluir_descricao', 'excluir_descricao', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe Nome da Dívida'), $dados['Desc_Divida'], 'Conter no Minimo 3 caracteres [a-z A-Z]');
                        ?>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <?php
                    //   INPUT - Codigo Divida                             
                    criar_input_text('Descrição-Completa Dívida', 'excluir_descricao_completa', 'excluir_descricao_completa', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Nome Completo'), $dados['DESC_COMPLETA'], 'Conter no Minimo 3 caracteres [a-z A-Z]');
                    ?>
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Cota ùnica
                            </div>
                            <div class="panel-collapse collapse in">
                                <div class="col-sm-6">
                                    <?php
                                    // OBSERVAÇÃO DA INSERÇÃO DA DIVIDA
                                    criar_input_data('Vencimento', 'excluir_data', 'excluir_data', array('readonly' => 'true',), dataBrasileiro($dados['Venc_Cota_Unica']), 'Somente numeros');
                                    ?> 
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="txtAltDesconto">Desconto:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name ="txt_excluir_desconto" id="id_alterar_esconto" required="true" readonly="true" value="<?php echo $desconto; ?>" placeholder="xx" maxlength="11" onkeypress='return SomenteNumero(event)'>

                                            <span class="input-group-addon">
                                                <span>%</span>
                                            </span>
                                        </div>  
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Códigos Contábeis
                            </div>
                            <div class="panel-collapse collapse in">
                                <div class="col-sm-4">
                                    <?php
                                    //   INPUT - Codigo Divida                             
                                    criar_input_text('Do Ano', 'excluir_codigo_ano', 'excluir_codigo_ano', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => 'XXX', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Contabil'], 'Somente numeros');
                                    ?>
                                </div>
                                <div class="col-sm-4">
                                    <?php
                                    //   INPUT - Codigo Divida                             
                                    criar_input_text('Dív Ativ', 'excluir_divida_ativa', 'excluir_divida_ativa', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => 'XX', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Contabil_DA'], 'Somente numeros');
                                    ?>
                                </div> 
                                <div class="col-sm-4">
                                    <?php
                                    //   INPUT - Codigo Divida                             
                                    criar_input_text('Mult/Juros', 'excluir_multas_juros', 'excluir_multas_juros', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '2', 'placeholder' => 'XX', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Contabil_Multa_Juros'], 'Somente numeros');
                                    ?>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-danger" >Excluir</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
    </form>
    <?php
}
?>
