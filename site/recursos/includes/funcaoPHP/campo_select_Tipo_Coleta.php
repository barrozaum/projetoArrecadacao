<?php
include_once '../estrutura/controle/validarSessao.php';
// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
if (empty($_REQUEST['selecionado'])) {
    mostraOptionTipoColeta($pdo);
} else if ($_REQUEST['selecionado'] == 0) {
    mostraCampoTipoColeta();
} else {
    mostraSelecionadoTipoColeta($pdo, $_REQUEST['selecionado']);
}
?>
<?php

function mostraCampoTipoColeta() {
    ?>
    <div class="form-group">
        <label for="tipo_coleta">Tipo Coleta:</label>
        <input type="text" class="form-control" name ="desc_tipo_coleta" id="desc_tipo_coleta" readonly="true" value="" maxlength="4" placeholder="" >
        <input type="hidden" class="form-control" name ="tipo_coleta" id="tipo_coleta" readonly="true" value="" maxlength="4" placeholder="" >
    </div>

    <?php
}
?>
<?php

function mostraSelecionadoTipoColeta($pdo, $tc_selec) {
    ?>

    <?php
    // preparo para realizar o comando sql
    $sql_tc = "select * FROM Tipo_Coleta WHERE Cod_Tipo_Coleta = '$tc_selec'";
    $query_tc = $pdo->prepare($sql_tc);
    //executo o comando sql
    $query_tc->execute();

    if (($dados_tc = $query_tc->fetch()) == true) {
        $achou = 1;
        $descricao = $dados_tc['Desc_Tipo_Coleta'];
        $Codigo = $dados_tc['Cod_Tipo_Coleta'];
    } else {
        $achou = "";
        $descricao = "";
        $Codigo = "";
    }

    $var = Array(
        "achou" => "$achou",
        "campo1" => "$descricao",
        "campo2" => "$Codigo"
    );
    echo json_encode($var);
}
?>
<?php

function mostraOptionTipoColeta($pdo) {
    ?>

    <div class="form-group">
        <label for="tipo_coleta">Tipo Coleta:</label>
        <select name="tipo_coleta" id="tipo_coleta" class="form-control" required="true">
            <option value="">Selecione a Coleta</option>
            <?php
            // chamo a conexao com o banco de dados
            include_once '../estrutura/conexao/conexao.php';
            // preparo para realizar o comando sql
            $sql_tc = "select * FROM Tipo_Coleta order by Desc_Tipo_Coleta";
            $query_tc = $pdo->prepare($sql_tc);
            //executo o comando sql
            $query_tc->execute();

            //loop para listar todos os dados encontrados
            for ($i = 0; $dados_tc = $query_tc->fetch(); $i++) {
                ?> 

                <option value="<?php echo $dados_tc['Cod_Tipo_Coleta']; ?>" ><?php echo $dados_tc['Desc_Tipo_Coleta']; ?></option>
                <?php
            }
            ?>

        </select>
    </div>
    <?php
}
?>