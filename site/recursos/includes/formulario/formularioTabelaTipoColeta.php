<?php
//biblioteca para validar se usuário ta logado
include_once '../estrutura/controle/validarSessao.php';
//biblioteca para converter dinheiro
include_once '../funcaoPHP/funcaoDinheiro.php';
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
    $sql = "SELECT TOP 1 Cod_Tipo_Coleta
            FROM Tipo_Coleta
            ORDER BY Cod_Tipo_Coleta DESC";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();

    $pdo = null;

    // inicializo a variavel que irá mostrar o proximo numero
    if (empty($dados['Cod_Tipo_Coleta'])) {
        $cod = str_pad(1, 1, "0", STR_PAD_LEFT);
    } else {
        $cod = str_pad( ++$dados['Cod_Tipo_Coleta'], 1, "0", STR_PAD_LEFT);
    }
    ?>

    <form method="post" action="recursos/includes/cadastrar/cadastrarTipoColeta.php">    
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div class="well"><!-- div que coloca a cor no formulário -->
                <div class="panel panel-default">
                    <!-- INICIO Dados do imóvel -->
                    <div class="panel-heading text-center">CADASTRO TIPO COLETA</div>
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
                            <div class="col-sm-6">
                                 <?php
                                //   INPUT - Descricao Tipo Coleta                             
                                criar_input_text('Descrição-Coleta', 'descricao', 'descricao', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Tipo da Coleta'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
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
    $sql = "Select * FROM Tipo_Coleta WHERE Cod_Tipo_Coleta = '" . $codigo . "'";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();
    $pdo = null;
    ?>

    <form method="post" action="recursos/includes/alterar/alterarTipoColeta.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Alterar Tipo Coleta</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-sm-2">
                     <?php
                    //   INPUT - Codigo Bairro                             
                    criar_input_text('Codigo', 'alterar_codigo', 'alterar_codigo', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Tipo_Coleta']);
                    ?>
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-8">
                    <?php
                   //   INPUT - Descricao Tipo Coleta                             
                   criar_input_text('Descrição-Coleta', 'alterar_descricao', 'alterar_descricao', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Tipo da Coleta'), $dados['Desc_Tipo_Coleta'], 'Conter no Minimo 3 caracteres [a-z A-Z]');
                   ?>
               </div>

               <div class="col-sm-4">
                   <?php
                   //   INPUT - Descricao Tipo Coleta                             
                   criar_input_text('Valor(UFIR)', 'alterar_valor', 'alterar_valor', array('required' => 'true', 'maxlength' => '11', 'placeholder' => 'R$000.00', "onKeyPress" => "return formatarValor(this, '.', ',', event);"), mostrarDinheiro($dados['Valor']), 'Conter apenas Numeros[0-9]');
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
    $sql = "Select * FROM Tipo_Coleta WHERE Cod_Tipo_Coleta = '" . $codigo . "'";

    $query = $pdo->prepare($sql);
    $query->execute();
    $dados = $query->fetch();
    $pdo = null;
    ?>



    <form method="post" action="recursos/includes/excluir/excluirTipoColeta.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Excluir Tipo Coleta</h4>
        </div>

        <div class="modal-body">
            <p style="color: red">Deseja Prosseguirr com a Exclusão da Coleta ?</p>

            <div class="row">
                <div class="col-sm-2">
                     <?php
                    //   INPUT - Codigo Bairro                             
                    criar_input_text('Codigo', 'excluir_codigo', 'excluir_codigo', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '3', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Tipo_Coleta']);
                    ?>
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-8">
                    <?php
                   //   INPUT - Descricao Tipo Coleta                             
                   criar_input_text('Descrição-Coleta', 'excluir_descricao', 'excluir_descricao', array('readonly'=>'true','required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Tipo da Coleta'), $dados['Desc_Tipo_Coleta'], 'Conter no Minimo 3 caracteres [a-z A-Z]');
                   ?>
               </div>

               <div class="col-sm-4">
                   <?php
                   //   INPUT - Descricao Tipo Coleta                             
                   criar_input_text('Valor(UFIR)', 'excluir_valor', 'excluir_valor', array('readonly'=>'true','required' => 'true', 'maxlength' => '11', 'placeholder' => 'R$000.00', "onKeyPress" => "return formatarValor(this, '.', ',', event);"), mostrarDinheiro($dados['Valor']), 'Conter apenas Numeros[0-9]');
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
