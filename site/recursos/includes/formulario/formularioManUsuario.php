<?php
include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>

<?php
if (empty($_POST['id'])) {
    formularioCadastro();
} else if ($_POST['id'] == 1) {
    formularioAlterar();
}
?>
<!-- Java script para dar Focus no primeiro Campo do formulário -->
<script>
    $('#login').focus();
</script>
<!-- fim doJava script para dar Focus no primeiro Campo do formulário -->
<?php

function formularioCadastro() {
    ?>
<form method="post" action="recursos/includes/cadastrar/cadastrarManUsuario.php" name="form_cadastro_usuario" id="form_cadastro_usuario">   
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div  id="msg_erro"></div>
            <div class="well"><!-- div que coloca a cor no formulário -->
                <div class="panel panel-default">
                    <!-- INICIO Dados do imóvel -->
                    <div class="panel-heading text-center "> MANUTENÇÃO USUÁRIO
                        <div class="col-md-12">
                            <div class="text-right" id="div_button">
                                <button type="button" name="listar_usuarios" id="listar_usuarios"> Listar Usuários</button> 
                            </div>
                        </div>

                    </div>
                    <div class="panel-body">
                        <!-- inicio dados inscrição-->
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                //   INPUT - Codigo Bairro                             
                                criar_input_text('Login', 'login', 'login', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'LOGIN DO COLABORADOR'), '', 'Conter no Minimo 2 caracteres');
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                //   INPUT - Descricao Rua                             
                                criar_input_text('Matrícula', 'matricula', 'matricula', array('required' => 'true', 'maxlength' => '11', 'placeholder' => 'MATRICULA COLABORADOR'), '', 'Conter no Minimo 2 caracteres');
                                ?>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                criar_input_text('Nome Completo', 'nome_completo', 'nome_completo', array('required' => 'true', 'maxlength' => '50', 'placeholder' => 'NOME COMPLETO COLABORADOR'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                criar_input_select('Nível Permissão', 'nivel_permissao', 'nivel_permissao', array('required' => 'true'), array('O' => 'OPERADOR', 'A' => 'ADMINISTRADOR'));
                                ?>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                criar_input_password('Senha', 'senha_novo_login', 'senha_novo_login', array('required' => 'true', 'maxlength' => '50', 'placeholder' => 'INFORME SENHA'), '', 'Conter no Minimo 3 caracteres');
                                ?>
                            </div>
                            <div class="col-sm-6">
                                <?php
                                criar_input_password('Confirme Senha', 'confirma_senha_novo_login', 'confirma_senha_novo_login', array('required' => 'true', 'maxlength' => '50', 'placeholder' => 'CONFIRME SUA SENHA'), '', 'Conter no Minimo 3 caracteres');
                                ?>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-sm-6">
                                <?php
                                criar_input_checkbox('Informar Gratuidade Taxas/Custas TJ', 'informar_gratuidades', 'informar_gratuidades', array(), 'sim');
                                ?>

                            </div>
                        </div> 

                        <div class="row">
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-success" id="id_cadastrar" >Cadastrar</button>
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
    <form method="post" action="recursos/includes/alterar/alterarManUsuario.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Alterar Rua</h4>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="login">Login:</label>
                        <input type="text" class="form-control" name="login" id="login" required="true" value="" placeholder="Informe o login">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="matricula">Matricula:</label>
                        <input type="text" class="form-control" name="matricula" id="matricula" required="true" value="" placeholder="Informe a matricula">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-9">
                    <div class="form-group">
                        <label for="nome">Nome Completo:</label>
                        <input type="text" class="form-control" name ="nome" id="nome" required="true" value="" placeholder="Informe o Nome Completo">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="nivel">Nível:</label>
                        <select class="form-control" id="nivel" name="nivel">
                            <option value="Operador"> Operador</option>
                            <option value="Administrador"> Adminsitrador</option>
                        </select>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input type="password" class="form-control" name="senha" id="senha" required="true" value="" placeholder="Informe a sua Senha">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="confSenha">Conf Senha:</label>
                        <input type="text" class="form-control" name="confSenha" id="confSenha" required="true" value="" placeholder="Confirme sua senha">
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-sm-4">
                    <div class="checkbox">
                        <label><input type="checkbox" value="">Informar Gratuidade Taxas/Custas TJ</label>
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
