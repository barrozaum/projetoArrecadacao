<?php
include_once '../estrutura/controle/validarSessao.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>
<?php
if ($_POST['id'] == 1) {
    formularioAlterar();
}
?>



<?php

function formularioAlterar() {
    ?>


    <form method="post" action="#">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ALTERAR SENHA USUÁRIO</h4>
        </div>

        <div class="modal-body">

            <div class="row">
                <div class="col-sm-12">
                    <div id="msg_erro_alterar_senha"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    //   INPUT - Codigo senha                             
                    criar_input_password('SENHA ATUAL', 'form_senha_atual_login', 'form_senha_atual_login', array( 'required' => 'true', 'maxlength' => '30', 'placeholder' => 'INFORME SENHA ATUAL'), '', 'Conter no Minimo 3 caracteres [a-z A-Z 0-9]');
                    ?>
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    //   INPUT - Codigo nova senha                             
                    criar_input_password('NOVA SENHA', 'form_nova_senha_login', 'form_nova_senha_login', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'INFORME NOVA SENHA'), '', 'Conter no Minimo 3 caracteres [a-z A-Z 0-9]');
                    ?>
                </div>
            </div> 
            <div class="row">
                <div class="col-sm-12">
                    <?php
                    //   INPUT - Codigo conf  nova senha                             
                    criar_input_password('CONFIRME NOVA SENHA', 'form_conf_nova_senha_login', 'form_conf_nova_senha_login', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'CONFIRME NOVA SENHA'), '', 'Conter no Minimo 3 caracteres [a-z A-Z 0-9]');
                    ?>
                </div>
            </div> 
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn_confirma_alterar_senha" onclick="javascript:validar_form_senha(this);">Alterar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </form>
    <?php
}
?>

