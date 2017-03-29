<?php
include_once '../estrutura/controle/validarSessao.php';
// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
if (empty($_REQUEST['selecionado'])) {
    mostraOptionIsencao($pdo);
} else if ($_REQUEST['selecionado'] == 0) {
    mostraCampoIsencao();
} else {
    mostraSelecionadoIsencao($pdo, $_REQUEST['selecionado']);
}
?>
<?php

function mostraCampoIsencao() {
    ?>
    <div class="form-group">
        <label for="tipo_isencao">Isenção:</label>
        <input type="text" class="form-control" name ="desc_tipo_isencao" id="desc_tipo_isencao" readonly="true" value="" maxlength="4" placeholder="" >
        <input type="hidden" class="form-control" name ="tipo_isencao" id="tipo_isencao" readonly="true" value="" maxlength="4" placeholder="" >
    </div>

    <?php
}
?>




<?php

function mostraSelecionadoIsencao($pdo, $is_selec) {
    ?>

    <?php
    // preparo para realizar o comando sql
    $sql_isn = "select * FROM Tipo_Isencao WHERE Codigo = '$is_selec'";
    $query_isn = $pdo->prepare($sql_isn);
    //executo o comando sql
    $query_isn->execute();

    //loop para listar todos os dados encontrados
    if (($dados_isn = $query_isn->fetch()) == true) {
        $achou = 1;
        $descricao = $dados_isn['Descricao'];
        $Codigo = $dados_isn['Codigo'];
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

function mostraOptionIsencao($pdo) {
    ?>
    <div class="form-group">
        <label for="tipo_isencao">Isenção:</label>
        <select name="tipo_isencao" id="tipo_isencao" class="form-control" required="true">
            <option value="">Selecione a Isenção</option>
            <?php
            // chamo a conexao com o banco de dados
            include_once '../estrutura/conexao/conexao.php';
            // preparo para realizar o comando sql
            $sql_isn = "select * FROM Tipo_Isencao order by Descricao";
            $query_isn = $pdo->prepare($sql_isn);
            //executo o comando sql
            $query_isn->execute();

            //loop para listar todos os dados encontrados
            for ($i = 0; $dados_isn = $query_isn->fetch(); $i++) {
                ?> 

                <option value="<?php echo $dados_isn['Codigo']; ?>" ><?php echo $dados_isn['Codigo']; ?> /<?php echo $dados_isn['Descricao']; ?></option>
                <?php
            }
            ?>

        </select>
    </div>
    <?php
}
?>