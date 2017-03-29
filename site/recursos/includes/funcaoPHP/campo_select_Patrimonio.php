<?php
include_once '../estrutura/controle/validarSessao.php';
// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
if (empty($_REQUEST['selecionado'])) {
    mostraOptionPatrimonio($pdo);
} else if ($_REQUEST['selecionado'] == 0) {
    mostraCampoPatrimonio();
} else {
    mostraSelecionadoPatrimonio($pdo, $_REQUEST['selecionado']);
}
?>
<?php

function mostraCampoPatrimonio() {
    ?>
    <div class="form-group">
        <label for="patrimonio_liquido">Patrimônio Líquido:</label>
        <input type="text" class="form-control" name ="desc_patrimonio" id="desc_patrimonio" readonly="true" value="" maxlength="4" placeholder="" >
        <input type="hidden" class="form-control" name ="patrimonio_liquido" id="patrimonio_liquido" readonly="true" value="" maxlength="4" placeholder="" >
    </div>

    <?php
}
?>

<?php

function mostraSelecionadoPatrimonio($pdo, $pt_selec) {
    ?>
    <?php
    // preparo para realizar o comando sql
    $sql_pat = "select * FROM Patrimonio WHERE Codigo = '$pt_selec'";
    $query_pat = $pdo->prepare($sql_pat);
    //executo o comando sql
    $query_pat->execute();

    //loop para listar todos os dados encontrados
    if (($dados_pat = $query_pat->fetch()) == true) {
        $achou = 1;
        $descricao = $dados_pat['Descricao'];
        $Codigo = $dados_pat['Codigo'];
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

function mostraOptionPatrimonio($pdo) {
    ?>

    <div class="form-group">
        <label for="patrimonio_liquido">Patrimônio Líquido:</label>
        <select name="patrimonio_liquido" id="patrimonio_liquido" class="form-control" required="true">
            <option value="">Selecione o Patrimônio</option>
            <?php
            // chamo a conexao com o banco de dados
            include_once '../estrutura/conexao/conexao.php';
            // preparo para realizar o comando sql
            $sql_pat = "select * FROM Patrimonio order by Descricao";
            $query_pat = $pdo->prepare($sql_pat);
            //executo o comando sql
            $query_pat->execute();

            //loop para listar todos os dados encontrados
            for ($i = 0; $dados_pat = $query_pat->fetch(); $i++) {
                ?> 

                <option value="<?php echo $dados_pat['Codigo']; ?>" ><?php echo $dados_pat['Descricao']; ?></option>
                <?php
            }
            ?>

        </select>
    </div>
    <?php
}
?>