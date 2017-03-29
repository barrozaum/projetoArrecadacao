<?php
include_once '../estrutura/controle/validarSessao.php';
// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
if (empty($_REQUEST['selecionado'])) {
    mostraOptionSit_Ter($pdo);
} else if ($_REQUEST['selecionado'] == 0) {
    mostraCampoSit_Ter();
} else {
    mostraSelecionadoSit_Ter($pdo, $_REQUEST['selecionado']);
}
?>
<?php

function mostraCampoSit_Ter() {
    ?>
    <div class="form-group">
        <label for="situacao_terreno">Situação Terreno:</label>
        <input type="text" class="form-control" name ="desc_situacao_terreno" id="desc_situacao_terreno" readonly="true" value="" maxlength="4" placeholder="" >
        <input type="hidden" class="form-control" name ="situacao_terreno" id="situacao_terreno" readonly="true" value="" maxlength="4" placeholder="" >
    </div>

    <?php
}
?>
<?php

function mostraSelecionadoSit_Ter($pdo, $st_selec) {
    ?>

    <?php
    // preparo para realizar o comando sql
    $sql_st = "select * FROM Situacao_terreno WHERE Cod_situacao = '$st_selec'";
    $query_st = $pdo->prepare($sql_st);
    //executo o comando sql
    $query_st->execute();

    if (($dados_st = $query_st->fetch()) == true) {
        $achou = 1;
        $descricao = $dados_st['Desc_situacao'];
        $Codigo = $dados_st['Cod_situacao'];
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

function mostraOptionSit_Ter($pdo) {
    ?>

    <div class="form-group">
        <label for="situacao_terreno">Situação Terreno:</label>
        <select name="situacao_terreno" id="situacao_terreno" class="form-control" required="true">
            <option value="">Selecione a Situação Terreno</option>
    <?php
    // chamo a conexao com o banco de dados
    include_once '../estrutura/conexao/conexao.php';
    // preparo para realizar o comando sql
    $sql_st = "select * FROM Situacao_terreno order by Desc_situacao";
    $query_st = $pdo->prepare($sql_st);
    //executo o comando sql
    $query_st->execute();

    //loop para listar todos os dados encontrados
    for ($i = 0; $dados_st = $query_st->fetch(); $i++) {
        ?> 

                <option value="<?php echo $dados_st['Cod_situacao']; ?>"><?php echo $dados_st['Desc_situacao']; ?></option>
        <?php
    }
    ?>

        </select>
    </div>

<?php } ?>
