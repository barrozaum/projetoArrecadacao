<?php
include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
include_once '../funcaoPHP/function_letraMaiscula.php';
include_once '../funcaoPHP/funcaoCriacaoInput.php';
include_once '../funcaoPHP/funcao_retorna_situacao_divida.php';
include_once '../funcaoPHP/funcao_retorna_descricao_cod_banco.php';
?>
<?php
if (empty($_REQUEST['id'])) {
    formularioMenuLateral();
    formularioPesquisaNumero();
} else if ($_POST['id'] == '1') {
    formularioPesquisaNumero();
} else if ($_POST['id'] == '2') {
    formularioPesquisaContribuinte();
} else if ($_POST['id'] == '3') {
    formularioDadosDam();
} else if ($_POST['id'] == '4') {
    modalDadosDam();
}
?>

<?php

function formularioMenuLateral() {
    ?>

    <div class="row">
        <!-- Menu Lateral-->
        <div class="col-sm-3">
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion">
                            Pesquisa
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse in">
                        <div class="panel-body">
                            <ol class="list-group">
                                <li class="list-group-item"><a href="#" id="id_seleciona_pesquisa_numero_ano">Número</a></li>
                                <li class="list-group-item"><a href="#" id="id_seleciona_pesquisa_contribuinte">Contribuinte</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Menu Lateral-->
        <?php
    }
    ?>

    <?php

    function formularioPesquisaNumero() {
        ?>
        <div id="formularioPesquisaItbi">
            <div class="col-sm-9">
                <div class="well">
                    <div class="panel-title">Consulta Número DOCARJ (DAM)<hr></div>
                    <div class="row">
                        <div id="msg"></div>
                        <div class="col-sm-4">
                            <?php
                            //   INPUT - 
                            criar_input_text('Número', 'numero_Docarj', 'numero_Docarj', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente numeros');
                            ?>
                        </div>
                        <div class="col-sm-4">
                            <?php
                            //   INPUT -                              
                            criar_input_text('Ano', 'ano_Docarj', 'ano_Docarj', array('required' => 'true', 'maxlength' => '4', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente numeros');
                            ?>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success" id="id_numero_ano_Docarj">Procurar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php
}
?>


<?php

function formularioPesquisaContribuinte() {
    ?>


    <div id="formularioConsulta">
        <div class="col-sm-9">
            <div class="well">
                <div class="panel-title">Consulta Contribuinte DOCARJ (DAM)<hr></div>
                <div class="row">
                    <div id="msg"></div>
                    <div class="col-sm-12">
                        <?php
                        //   INPUT -                              
                        criar_input_text('CONTRIBUINTE', 'contribuinte', 'contribuinte', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Nome do Contribuinte'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-success" id="id_buscar_Docarj_contribuinte">Procurar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
    <?php
}
?>