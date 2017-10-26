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
    $sql = "SELECT TOP 1 Cod_Natureza
            FROM Natureza_Transmissao
            ORDER BY Cod_Natureza DESC";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();

    $pdo = null;

    // inicializo a variavel que irá mostrar o proximo numero
    if (empty($dados['Cod_Natureza'])) {
        $cod = str_pad(1, 2, "0", STR_PAD_LEFT);
    } else {
        $cod = str_pad(++$dados['Cod_Natureza'], 2, "0", STR_PAD_LEFT);
    }
    ?>

    <form method="post" action="recursos/includes/cadastrar/cadastrarNaturezaTransmissao.php">    
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
                    <div class="panel-heading text-center">CADASTRO NATUREZA TRANSMISSÃO</div>
                    <div class="panel-body">
                        <!-- inicio dados inscrição-->
                        <div class="row">
                            <div class="col-sm-2">
                                <?php
                                //   INPUT - Codigo Bairro                             
                                criar_input_text('Codigo', 'codigo', 'codigo', array('required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $cod);
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
                                //   INPUT - Descricao Bairro                             
                                criar_input_text('Descrição-Natureza', 'descricao', 'descricao', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Nome da Natureza'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
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
    $sql = "Select * FROM Natureza_Transmissao WHERE Cod_Natureza = '" . $codigo . "'";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();
    $pdo = null;
    ?>

    <form method="post" action="recursos/includes/alterar/alterarNaturezaTransmissao.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ALTERAR NATUREZA TRANSMISSÃO</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-sm-2">
                    <?php
                    //   INPUT - Codigo Bairro                             
                    criar_input_text('Codigo', 'alterar_codigo', 'alterar_codigo', array('readonly'=>'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Natureza']);
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
                    //   INPUT - Descricao Bairro                             
                    criar_input_text('Descrição-Natureza', 'alterar_descricao', 'alterar_descricao', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Nome da Natureza'), $dados['Desc_Natureza'], 'Conter no Minimo 3 caracteres [a-z A-Z]');
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
    $sql = "Select * FROM Natureza_Transmissao WHERE Cod_Natureza = '" . $codigo . "'";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();
    $pdo = null;
    ?>



    <form method="post" action="recursos/includes/excluir/excluirNaturezaTransmissao.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Excluir Natureza Transmissão</h4>
        </div>

        <div class="modal-body">
            <p style="color: red">Deseja Prosseguir com a Exclusão da Natureza Transmissão ?</p>

            <div class="row">
                <div class="col-sm-2">
                    <?php
                    //   INPUT - Codigo Bairro                             
                    criar_input_text('Codigo', 'excluir_codigo', 'excluir_codigo', array('readonly'=>'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Natureza']);
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
                    //   INPUT - Descricao Bairro                             
                    criar_input_text('Descrição-Natureza', 'excluir_descricao', 'excluir_descricao', array('readonly'=>'true','required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Nome da Natureza'), $dados['Desc_Natureza'], 'Conter no Minimo 3 caracteres [a-z A-Z]');
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