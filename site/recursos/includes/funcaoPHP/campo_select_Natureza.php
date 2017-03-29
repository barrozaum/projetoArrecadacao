<?php
include_once '../estrutura/controle/validarSessao.php';
// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
if (empty($_REQUEST['selecionado'])) {
    mostraOptionNatureza($pdo);
} else if ($_REQUEST['selecionado'] == 0) {
    mostraCampoNatureza();
} else {
    mostraSelecionadoNatureza($pdo, $_REQUEST['selecionado']);
}
?>
<?php

function mostraCampoNatureza() {
    ?>
    <div class="form-group">
        <label for="id_desc_natureza">NATUREZA:</label>
        <input type="text" class="form-control" name ="txt_desc_natureza" id="id_desc_natureza" readonly="true" value="" maxlength="4" placeholder="" >
        <input type="hidden" class="form-control" name ="txt_natureza" id="id_natureza" readonly="true" value="" maxlength="4" placeholder="" >
    </div>

    <?php
}
?>

<?php

function mostraSelecionadoNatureza($pdo, $codNat_selec) {
    ?>

    <?php
    // preparo para realizar o comando sql
    $sql_nat = "select * FROM Natureza_Transmissao WHERE Cod_Natureza = '$codNat_selec'";
    $query_nat = $pdo->prepare($sql_nat);
    //executo o comando sql
    $query_nat->execute();

    if (($dados_nat = $query_nat->fetch()) == true) {
        $achou = 1;
        $descricao = $dados_nat['Desc_Natureza'];
        $Codigo = $dados_nat['Cod_Natureza'];
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

function mostraOptionNatureza($pdo) {
    ?>
    <div class="form-group">
        <label for="id_natureza">NATUREZA:</label>
        <select name="txt_natureza" id="id_natureza" class="form-control" required="true">
            <option value="">Selecione Natureza</option>
            <?php
            // chamo a conexao com o banco de dados
            include_once '../estrutura/conexao/conexao.php';
            // preparo para realizar o comando sql
            $sql_nat = "select * FROM Natureza_Transmissao order by Cod_Natureza";
            $query_nat = $pdo->prepare($sql_nat);
            //executo o comando sql
            $query_nat->execute();

            //loop para listar todos os dados encontrados
            for ($i = 0; $dados_nat = $query_nat->fetch(); $i++) {
                ?> 

                <option value="<?php echo $dados_nat['Cod_Natureza']; ?>" ><?php echo $dados_nat['Desc_Natureza']; ?></option>
                <?php
            }
            ?>

        </select>
    </div>
    <?php
}
?>