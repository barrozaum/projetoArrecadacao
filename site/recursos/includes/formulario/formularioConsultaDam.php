<?php
include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
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
                    <div class="panel-title">Consulta Número DAM<hr></div>
                    <div class="row">
                        <div id="msg"></div>
                        <div class="col-sm-4">
                            <?php
                            //   INPUT - 
                            criar_input_text('Número', 'numero_dam', 'numero_dam', array('required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente numeros');
                            ?>
                        </div>
                        <div class="col-sm-4">
                            <?php
                            //   INPUT -                              
                            criar_input_text('Ano', 'ano_dam', 'ano_dam', array('required' => 'true', 'maxlength' => '4', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '', 'somente numeros');
                            ?>
                        </div>
                    </div> 

                    <div class="row">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success" id="id_numero_ano_dam">Procurar</button>
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
                <div class="panel-title">Consulta Contribuinte DAM<hr></div>
                <div class="row">
                    <div class="col-sm-12">
                        <?php
                        //   INPUT -                              
                        criar_input_text('CONTRIBUINTE', 'contribuinte', 'contribuinte', array('required' => 'true', 'maxlength' => '30', 'placeholder' => 'Informe o Nome do Contribuinte'), '', 'Conter no Minimo 3 caracteres [a-z A-Z]');
                        ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-success" id="id_buscar_dam_contribuinte">Procurar</button>
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

function formularioDadosDam() {
    ?>
    <?php
    include_once '../funcaoPHP/function_letraMaiscula.php';


//   filtrar campos enviados pelo formulario
    $numero_Letra_Maiscula = letraMaiuscula($_POST['txt_numero_dam']);
    $ano_Letra_Maiscula = letraMaiuscula($_POST['txt_ano_dam']);


//     validação dos campos

    if ((strlen($numero_Letra_Maiscula) === 6) || is_int($numero_Letra_Maiscula) === TRUE) {
        $numero_dam = $numero_Letra_Maiscula;
    } else {
        $array_erros['txt_alterar_descricao'] = 'POR FAVOR ENTRE COM UM NÚMERO DAM VÁLIDO \n';
    }


    if ((strlen($ano_Letra_Maiscula) === 4) || is_int($numero_Letra_Maiscula) === TRUE) {
        $ano_dam = $ano_Letra_Maiscula;
    } else {
        $array_erros['txt_alterar_descricao'] = 'POR FAVOR ENTRE COM UM NÚMERO DAM VÁLIDO \n';
    }



    include_once '../estrutura/conexao/conexao.php';
// preparo para realizar o comando sql    
    $sql = "SELECT * FROM ";
    $sql = $sql . " DAM d, Financeiro_Dam fd";
    $sql = $sql . " WHERE d.Num_Dam = '$numero_dam'";
    $sql = $sql . " AND d.Ano_Dam = '$ano_dam'";
    $sql = $sql . " AND d.Num_Dam = fd.Num_Dam";
    $sql = $sql . " AND d.Ano_Dam = fd.Ano_Dam";

    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        ?>
        <div class="well">
            <div class="row">
                <div class="col-sm-4">
                    <?php
                    //   INPUT - 
                    criar_input_text('NUMERO', 'cons_numero_dam', 'cons_numero_dam', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Num_Dam'], '');
                    ?>
                </div>

                <div class="col-sm-4">
                    <?php
                    //   INPUT - 
                    criar_input_text('ANO', 'cons_ano_dam', 'cons_ano_dam', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Ano_Dam'], '');
                    ?>
                </div>

                <div class="col-sm-4">
                    <?php
                    //   INPUT - 
                    criar_input_text('PARCELA', 'cons_parcela_dam', 'cons_parcela_dam', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), '01', '');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    //   INPUT - 
                    criar_input_text('CONTRIBUINTE', 'cons_contribuinte_dam', 'valor_venal', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Nome_Contribuinte'], '');
                    ?>
                </div>

                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('INSCRIÇÃO', 'cons_inscricao_dam', 'cons_inscricao_dam', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Inscricao'], '');
                    ?>
                </div>

                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('VALOR (DAM)', 'cons_valor_dam', 'cons_valor_dam', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), mostrarDinheiro($dados['Total']), '');
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('VENCIMENTO', 'cons_vencimento_dam', 'cons_vencimento_dam', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), dataBrasileiro($dados['Vencimento']), '');
                    ?>
                </div>

                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('Situação', 'cons_situacao_divida_dam', 'cons_situacao_divida_dam', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), fun_retorna_situacao_divida($pdo, $dados['Cod_Situacao_divida']), '');
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('VALOR PAGEMENTO', 'cons_valor_pagamento_dam', 'cons_valor_pagamento_dam', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), mostrarDinheiro($dados['Valor_Pagamento']), '');
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('DATA PAGAMENTO', 'cons_data_pagamento_dam', 'cons_data_pagamento_dam', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), dataBrasileiro($dados['Data_Pagamento']), '');
                    ?>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('Lote', 'lote', 'lote', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Lote'], '');
                    ?>
                </div>

                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('Cod Banco', 'cod_banco', 'cod_banco', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Cod_Banco'], '');
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('Desc Banco', 'desc_banco', 'desc_banco', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), fun_retorna_descricao_cod_banco($pdo, $dados['Cod_Banco']), '');
                    ?>
                </div>
            </div>

        </div>

        <?php
    } else {
        ?>
        <div class="well-lg alert-danger text-center">DOCARJ (DAM) NÃO ENCONTRADO !!!</div>
        <?php
    }

    $pdo = null;
}
?>

<?php

function modalDadosItbi() {
    ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Dados ITBI</h4>
    </div>

    <div class="modal-body">
        <?php
        $array = explode("|", $_POST['codigo']);
        $numero_itbi = $array[0];
        $ano_itbi = $array[1];

        include_once '../estrutura/conexao/conexao.php';
// preparo para realizar o comando sql    
        $sql = "select * FROM Itbi WHERE Num_Itbi = '$numero_itbi' AND Ano_Itbi = '$ano_itbi'";

        $query = $pdo->prepare($sql);
//executo o comando sql
        $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
        if (($dados = $query->fetch()) == true) {
            ?>
            <div class="row">
                <div class="col-sm-2">
                    <?php
                    //   INPUT - 
                    criar_input_text('Inscrição', 'inscricao_imob', 'inscricao_imob', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Inscricao_Imob'], '');
                    ?>
                </div>

                <div class="col-sm-5">
                    <?php
                    //   INPUT - 
                    criar_input_text('Adquirente', 'adquirente', 'adquirente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Adquirente'], '');
                    ?>
                </div>

                <div class="col-sm-5">
                    <?php
                    //   INPUT - 
                    criar_input_text('Transmitente', 'transmitente', 'transmitente', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Transmitente'], '');
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?php
                    //   INPUT - 
                    criar_input_text('Valor Venal', 'valor_venal', 'valor_venal', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), mostrarDinheiro($dados['Valor_Venal']), '');
                    ?>
                </div>

                <div class="col-sm-4">
                    <?php
                    //   INPUT - 
                    criar_input_text('Valor Declarado', 'valor_declarado', 'valor_declarado', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), mostrarDinheiro($dados['Valor_Declarado']), '');
                    ?>
                </div>

                <div class="col-sm-4">
                    <?php
                    //   INPUT - 
                    criar_input_text('Data Transação', 'data_transacao', 'data_transacao', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), dataBrasileiro($dados['Data_Transacao']), '');
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('Valor ITBI', 'valor_itbi', 'valor_itbi', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), mostrarDinheiro($dados['Valor_Itbi']), '');
                    ?>
                </div>

                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('Vencimento', 'vencimento', 'vencimento', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), dataBrasileiro($dados['Vencimento']), '');
                    ?>
                </div>

                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('Situação', 'situacao_divida', 'situacao_divida', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), retornaSituacaoDivida($pdo, $dados['cod_situacao_divida']), '');
                    ?>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('Valor Pagamento', 'valor_pagamento', 'valor_pagamento', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), mostrarDinheiro($dados['valor_pagamento']), '');
                    ?>
                </div>

                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('Data Pagamento', 'data_pagamento', 'data_pagamento', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), dataBrasileiro($dados['data_pagamento']), '');
                    ?>
                </div>

                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('Lote', 'lote', 'lote', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['Lote'], '');
                    ?>
                </div>

                <div class="col-sm-3">
                    <?php
                    //   INPUT - 
                    criar_input_text('Banco', 'cod_banco', 'cod_banco', array('readonly' => 'true', 'required' => 'true', 'maxlength' => '6', 'placeholder' => '', 'onkeypress' => 'return SomenteNumero(event)'), $dados['cod_banco'], '');
                    ?>

                </div>
            </div>
            <?php
        }
        ?>
    </div>  
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>


    <?php
}
?>


