<?php
include_once '../estrutura/controle/validarSessao.php';
// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
if (empty($_REQUEST['selecionado'])) {
    mostraOptionCategoria($pdo);
} else if ($_REQUEST['selecionado'] == 0) {
    mostraCampoCategoria();
} else {
    mostraSelecionadoCategoria($pdo, $_REQUEST['selecionado']);
}
?>
<?php

function mostraCampoCategoria() {
    ?>
    <div class="form-group">
        <label for="categoria">Categoria:</label>
        <input type="text" class="form-control" name ="desc_categoria" id="desc_categoria" readonly="true" value="" maxlength="4" placeholder="" >
        <input type="hidden" class="form-control" name ="categoria" id="categoria" readonly="true" value="" maxlength="4" placeholder="" >
    </div>

    <?php
}
?>
<?php

function mostraSelecionadoCategoria($pdo, $cat_selec) {
    ?>
    <?php
    // preparo para realizar o comando sql
    $sql_cat = "select * FROM Categoria WHERE Codigo = '$cat_selec'";
    $query_cat = $pdo->prepare($sql_cat);
    //executo o comando sql
    $query_cat->execute();

    if (($dados_cat = $query_cat->fetch()) == true) {
        $achou = 1;
        $descricao = $dados_cat['Descricao'];
        $Codigo = $dados_cat['Codigo'];
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

function mostraOptionCategoria($pdo) {
    ?>
    <div class="form-group">
        <label for="categoria">Categoria:</label>
        <select name="categoria" id="categoria" class="form-control" required="true">
            <option value="">Selecione a Categoria</option>
            <?php
            // preparo para realizar o comando sql
            $sql_cat = "select * FROM Categoria order by Descricao";
            $query_cat = $pdo->prepare($sql_cat);
            //executo o comando sql
            $query_cat->execute();

            //loop para listar todos os dados encontrados
            for ($i = 0; $dados_cat = $query_cat->fetch(); $i++) {
                ?> 

                <option value="<?php echo $dados_cat['Codigo']; ?>" ><?php echo $dados_cat['Descricao']; ?></option>
                <?php
            }
            ?>

        </select>
    </div>

    <?php
}
?>