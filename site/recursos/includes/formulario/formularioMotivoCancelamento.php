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
    $sql = "SELECT TOP 1 Cod_Motivo_Cancelamento
            FROM Motivo_Cancelamento
            ORDER BY Cod_Motivo_Cancelamento DESC";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();

    $pdo = null;

    // inicializo a variavel que irá mostrar o proximo numero
    if (empty($dados['Cod_Motivo_Cancelamento'])) {
        $cod = str_pad(1, 2, "0", STR_PAD_LEFT);
    } else {
        $cod = str_pad(++$dados['Cod_Motivo_Cancelamento'], 2, "0", STR_PAD_LEFT);
    }
    ?>

    <form method="post" action="recursos/includes/cadastrar/cadastrarMotivoCancelamento.php">    
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div class="well"><!-- div que coloca a cor no formulário -->
                <div class="panel panel-default">
                    <!-- INICIO Dados do imóvel -->
                    <div class="panel-heading text-center">CADASTRO MOTIVO CANCELAMENTO</div>
                    <div class="panel-body">
                        <!-- inicio dados inscrição-->
                        <div class="row">
                            <div class="col-sm-1">
                                <div class="form-group">
                                    <label for="txtCod">Cod:</label>
                                    <input type="text" class="form-control" name ="txtCod" id="txtCod" required="true" value="<?php echo $cod; ?>" maxlength="3" placeholder="" onkeypress='return SomenteNumero(event)' onblur="tamanhoCampo(txtCod)">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div  id="msg"></div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="txtDescricao">Descricão:</label>
                                    <input type="text" class="form-control" name ="txtDescricao" id="txtDescricao" required="true" value="" placeholder="Informe o Motivo Cancelamento" maxlength="20">
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
    $sql = "Select * FROM Motivo_Cancelamento WHERE Cod_Motivo_Cancelamento = '" . $codigo . "'";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();
    $pdo = null;
    ?>

    <form method="post" action="recursos/includes/alterar/alterarMotivoCancelamento.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Alterar Motivo Cancelamento</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="txtAltCod">Cod:</label>
                        <input type="text" class="form-control" name ="txtAltCod"  id="txtAltCod"  readonly="true" required="true"  value="<?php echo $dados['Cod_Motivo_Cancelamento']; ?>" maxlength="3" placeholder="" >
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="txtAltDescricao">Descricão:</label>
                        <input type="text" class="form-control" name ="txtAltDescricao" id="txtAltDescricao" required="true" value="<?php echo $dados['Desc_Motivo_Cancelamento']; ?>" placeholder="Informe o Motivo Cancelamento" maxlength="20">
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
    $sql = "Select * FROM  Motivo_Cancelamento WHERE Cod_Motivo_Cancelamento = '" . $codigo . "'";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();
    $pdo = null;
    ?>



    <form method="post" action="recursos/includes/excluir/excluirMotivoCancelamento.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Excluir Motivo Cancelamento</h4>
        </div>

        <div class="modal-body">
            <p style="color: red">Deseja Prosseguir com a Exclusão do  Motivo Cancelamento ?</p>

            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="txtExcCod">Cod:</label>
                        <input type="text" class="form-control" name ="txtExcCod" id="txtExcCod" required="true"  value="<?php echo $dados['Cod_Motivo_Cancelamento']; ?>" readonly="true" maxlength="3" placeholder="">
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="txtExcDescricao">Descricão:</label>
                        <input type="text" class="form-control" name ="txtExcDescricao" id="txtExcDescricao" required="true" value="<?php echo $dados['Desc_Motivo_Cancelamento']; ?>"  readonly="true" placeholder="Informe o Motivo Cancelamento" maxlength="20">
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