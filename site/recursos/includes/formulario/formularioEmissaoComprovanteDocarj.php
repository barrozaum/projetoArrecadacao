<?php
include_once '../estrutura/controle/validarSessao.php';
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
    <form  method="post" action="recursos/includes/relatorio/relatorio_comprovante_Docarj.php">    
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div id="msg_error"></div>
            <div class="well"><!-- div que coloca a cor no formulário -->
                <div class="panel panel-default">
                    <!-- INICIO Dados do imóvel -->
                    <div class="panel-heading text-center">EMISSÃO COMPROVANTE DAM(DOCARJ)</div>
                    <div class="panel-body">
                        <!-- inicio dados inscrição-->
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                //   INPUT -                      
                                criar_input_text('Número Docarj', 'numero_Docarj', 'numero_Docarj', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '000000', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente numeros');
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                //   INPUT -                              
                                criar_input_text('Ano Docarj', 'ano_Docarj', 'ano_Docarj', array('required' => 'true', 'maxlength' => '4', 'placeholder' => '0000'), '', 'somente numeros');
                                ?>

                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-success" id="id_procurar_comprovantes" >Procurar Docarj</button>
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

