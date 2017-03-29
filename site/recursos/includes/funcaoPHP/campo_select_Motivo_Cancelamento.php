<?php
include_once '../estrutura/controle/validarSessao.php';
// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
if (empty($_REQUEST['selecionado'])) {
    mostraOptionMotivoCancelamento($pdo);
} else if ($_REQUEST['selecionado'] == 0) {
    mostraCampoMotivoCancelamento();
} else {
    mostraSelecionadoMotivoCancelamento($pdo, $_REQUEST['selecionado']);
}
?>
<?php

function mostraCampoMotivoCancelamento() {
    ?>
    <div class="form-group">
        <label for="motivo_cancelamento">Motivo Cancelamento:</label>
        <input type="text" class="form-control" name ="desc_motivo_cancelamento" id="desc_motivo_cancelamento" readonly="true" value="" maxlength="4" placeholder="" >
        <input type="hidden" class="form-control" name ="motivo_cancelamento" id="motivo_cancelamento" readonly="true" value="" maxlength="4" placeholder="" >
    </div>

    <?php
}
?>

<?php

function mostraSelecionadoMotivoCancelamento($pdo, $mt_selec) {
    ?>
    <?php
    // preparo para realizar o comando sql
    $sql_mt = "select * FROM Motivo_Cancelamento WHERE Cod_Motivo_Cancelamento = '$mt_selec'";
    $query_mt = $pdo->prepare($sql_mt);
    //executo o comando sql
    $query_mt->execute();

    if (($dados_mt = $query_mt->fetch()) == true) {
        $achou = 1;
        $descricao = $dados_mt['Desc_Motivo_Cancelamento'];
        $Codigo = $dados_mt['Cod_Motivo_Cancelamento'];
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

function mostraOptionMotivoCancelamento($pdo) {
    ?>
    <div class="form-group">
        <label for="id_motivo_cancelamento">Motivo Cancelamento:</label>
        <select name="txt_motivo_cancelamento" id="id_motivo_cancelamento" class="form-control" required="true">
            <option value="">Selecione Motivo Cancelamento</option>
            <?php
            // chamo a conexao com o banco de dados
            include_once '../estrutura/conexao/conexao.php';
            // preparo para realizar o comando sql
            $sql_mt = "select * FROM Motivo_Cancelamento order by Cod_Motivo_Cancelamento";
            $query_mt = $pdo->prepare($sql_mt);
            //executo o comando sql
            $query_mt->execute();

            //loop para listar todos os dados encontrados
            for ($i = 0; $dados_mt = $query_mt->fetch(); $i++) {
                ?> 

                <option value="<?php echo $dados_mt['Cod_Motivo_Cancelamento']; ?>" ><?php echo $dados_mt['Desc_Motivo_Cancelamento']; ?></option>
                <?php
            }
            ?>

        </select>
    </div>
    <?php
}
?>