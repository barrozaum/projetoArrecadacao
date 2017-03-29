<?php
include_once '../estrutura/controle/validarSessao.php';
// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
if (empty($_REQUEST['selecionado'])) {
    mostraOptionUtilizacao($pdo);
} else if ($_REQUEST['selecionado'] == 0) {
    mostraCampoUtilizacao();
} else {
    mostraSelecionadoUtilizacao($pdo, $_REQUEST['selecionado']);
}
?>
<?php

function mostraCampoUtilizacao() {
    ?>
    <div class="form-group">
        <label for="utilizacao">Utilização:</label>
        <input type="text" class="form-control" name ="desc_utilizacao" id="desc_utilizacao" readonly="true" value="" maxlength="4" placeholder="" >
        <input type="hidden" class="form-control" name ="utilizacao" id="utilizacao" readonly="true" value="" maxlength="4" placeholder="" >
    </div>

    <?php
}
?>
<?php

function mostraSelecionadoUtilizacao($pdo, $ut_selec) {
    ?>

    <?php
    // preparo para realizar o comando sql
    $sql_ut = "select * FROM Utilizacao WHERE Codigo = '$ut_selec'";
    $query_ut = $pdo->prepare($sql_ut);
    //executo o comando sql
    $query_ut->execute();

    if (($dados_ut = $query_ut->fetch()) == true) {
        $achou = 1;
        $descricao = $dados_ut['Descricao'];
        $Codigo = $dados_ut['Codigo'];
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

function mostraOptionUtilizacao($pdo) {
    ?>
    <div class="form-group">
        <label for="utilizacao">Utilização:</label>
        <select name="utilizacao" id="utilizacao" class="form-control" required="true">
            <option value="">Selecione a Utilização</option>
            <?php
            // chamo a conexao com o banco de dados
            include_once '../estrutura/conexao/conexao.php';
            // preparo para realizar o comando sql
            $sql_ut = "select * FROM Utilizacao order by Descricao";
            $query_ut = $pdo->prepare($sql_ut);
            //executo o comando sql
            $query_ut->execute();

            //loop para listar todos os dados encontrados
            for ($i = 0; $dados_ut = $query_ut->fetch(); $i++) {
                ?> 

                <option value="<?php echo $dados_ut['Codigo']; ?>" ><?php echo $dados_ut['Descricao']; ?></option>
                <?php
            }
            ?>

        </select>
    </div>
    <?php
}
?>