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
    <?php
    include_once '../estrutura/conexao/conexao.php';
    $sql = "SELECT TOP 1 Cod_Rua
            FROM Rua
            ORDER BY Cod_Rua DESC";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();

    $pdo = null;

    // inicializo a variavel que irá mostrar o proximo numero
    if (empty($dados['Cod_Rua'])) {
        $cod = str_pad(1, 5, "0", STR_PAD_LEFT);
    } else {
        $cod = str_pad(++$dados['Cod_Rua'], 5, "0", STR_PAD_LEFT);
    }
    ?>

    <form method="post" action="recursos/includes/cadastrar/cadastrarRua.php">    
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
                    <div class="panel-heading text-center "> CADASTRO RUA 
                        <div class="col-md-12">
                            <div class="text-right" id="div_button">
                                <button type="button" name="listar_ruas" id="listar_ruas"> Listar Ruas</button> 
                            </div>
                        </div>

                    </div>
                    <div class="panel-body">
                        <!-- inicio dados inscrição-->
                        <div class="row">
                            <div class="col-sm-2">
                                <?php
                                //   INPUT - Codigo Bairro                             
                                criar_input_text('Codigo', 'codigo', 'codigo', array('required' => 'true', 'maxlength' => '5', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $cod);
                                criar_input_hidden('codigo_automatico', array('required' => 'true', 'maxlength' => '5'), $cod);
                                ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div  id="msg"></div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                //   INPUT - Descricao Rua                             
                                criar_input_text('Descrição-Rua', 'descricao', 'descricao', array('required' => 'true', 'maxlength' => '40', 'placeholder' => 'Informe o Nome da Rua'), '', 'conter no mínimo 3 caracteres');
                                ?>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                criar_input_text('Tipo', 'tipo', 'tipo', array('required' => 'true', 'maxlength' => '4', 'placeholder' => 'Av. Rua. Est'));
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                criar_input_text('Cep', 'cep', 'cep', array('required' => 'true', 'maxlength' => '8', 'placeholder' => 'xx.xxx-xxx', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente os numeros');
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
    $sql = "Select * FROM rua WHERE Cod_Rua = '" . $codigo . "'";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();
    $pdo = null;
    ?>

    <form method="post" action="recursos/includes/alterar/alterarRua.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Alterar Rua</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-sm-2">
                    <?php
                    //   INPUT - Codigo Bairro                             
                    criar_input_text('Codigo', 'alterar_codigo', 'alterar_codigo', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Rua']);
                    ?>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div  id="msg"></div>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    //   INPUT - Descricao Rua                             
                    criar_input_text('Descrição-Rua', 'alterar_descricao', 'alterar_descricao', array('required' => 'true', 'maxlength' => '40', 'placeholder' => 'Informe o Nome da Rua'), $dados['Desc_rua'], 'conter no minímo 3 caracteres [a-z A-Z]');
                    ?>

                </div>
            </div> 
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    criar_input_text('Tipo', 'alterar_tipo', 'alterar_tipo', array('required' => 'true', 'maxlength' => '4', 'placeholder' => 'Av. Rua. Est'), $dados['Tipo']);
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    criar_input_text('Cep', 'alterar_cep', 'alterar_cep', array('required' => 'true', 'maxlength' => '8', 'placeholder' => 'xx.xxx-xxx', 'onkeypress' => 'return SomenteNumero(event)'), $dados['cep'], 'somente os numeros');
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
    $codigo = $_POST['codigo'];
    include_once '../estrutura/conexao/conexao.php';
    $sql = "Select * FROM rua WHERE Cod_Rua = '" . $codigo . "'";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();
    $pdo = null;
    ?>



    <form method="post" action="recursos/includes/excluir/excluirRua.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Excluir Rua</h4>
        </div>

        <div class="modal-body">
            <p style="color: red">Deseja Prosseguir com a Exclusão da Rua ?</p>

            <div class="row">
                <div class="col-sm-2">
                    <?php
                    //   INPUT - Codigo Bairro                             
                    criar_input_text('Codigo', 'excluir_codigo', 'alterar_codigo', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Rua']);
                    ?>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div  id="msg"></div>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    //   INPUT - Descricao Rua                             
                    criar_input_text('Descrição-Rua', 'excluir_descricao', 'alterar_descricao', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '40', 'placeholder' => 'Informe o Nome da Rua'), $dados['Desc_rua'], 'conter no minímo 3 caracteres [a-z A-Z]');
                    ?>

                </div>
            </div> 
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    criar_input_text('Tipo', 'alterar_tipo', 'excluir_tipo', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '', 'placeholder' => 'Av. Rua. Est'), $dados['Tipo']);
                    ?>
                </div>
                <div class="col-sm-6">
                    <?php
                    criar_input_text('Cep', 'alterar_cep', 'excluir_cep', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '8', 'placeholder' => 'xx.xxx-xxx', 'onkeypress' => 'return SomenteNumero(event)'), $dados['cep'], 'somente os numeros');
                    ?>
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
