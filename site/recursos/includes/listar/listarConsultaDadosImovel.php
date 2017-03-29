<?php
include_once '../estrutura/controle/validarSessao.php';
?>

<?php
set_time_limit(0);
$nome_proprietario = $_POST['nome_proprietario'];
$tipo_imposto_imovel = $_POST['tipo_imposto_imovel'];
$tipo_isencao = $_POST['tipo_isencao'];
$cod_bairro_imovel = $_POST['cod_bairro_imovel'];
$cod_logr_imovel = $_POST['cod_logr_imovel'];
$numero_imov = $_POST['numero_imov'];
$lote_imov = $_POST['lote_imov'];
$quadra_imov = $_POST['quadra_imov'];
?>



<!DOCTYPE html>
<html>
    <head>
        <title>Arrecadação</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script>
            $(document).ready(function () {
                $('#table').DataTable();
            });
        </script>
    </head>
    <body>
        <div style="overflow: auto; max-width: 100%;">
            <table id="table" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Inscricao_Imob</th>
                        <th>Proprietario</th>
                        <th>Cod_Rua</th>
                        <th>Numero</th>
                        <th>Complemento</th>
                        <th>Quadra</th>
                        <th>Lote</th>
                        <th>Cod_Bairro</th>
                        <th>CONSULTAR</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                    // chamo a conexao com o banco de dados
                    include_once '../estrutura/conexao/conexao.php';
                    // preparo para realizar o comando sql
                    $sql = "SELECT * ";
                    $sql = $sql . " FROM Cad_Imobiliario";
                    $sql = $sql . " WHERE Proprietario like '%$nome_proprietario%'";
                    if ($tipo_imposto_imovel != "") {
                        $sql = $sql . " AND Tipo_Imposto = '$tipo_imposto_imovel'";
                    }
                    if ($tipo_isencao != "") {
                        $sql = $sql . " AND Tipo_isencao = '$tipo_isencao'";
                    }
                    if ($cod_bairro_imovel > "000") {
                        $sql = $sql . " AND Cod_Bairro = '$cod_bairro_imovel'";
                    }
                    if ($cod_logr_imovel > "000") {
                        $sql = $sql . " AND Cod_Rua = '$cod_logr_imovel'";
                    }
                    if ($numero_imov > "000") {
                        $sql = $sql . " AND Numero = '$numero_imov'";
                    }
                    if ($lote_imov > "000") {
                        $sql = $sql . " AND Lote = '$lote_imov'";
                    }
                    if ($quadra_imov > "000") {
                        $sql = $sql . " AND Quadra = '$quadra_imov'";
                    }




                    $query = $pdo->prepare($sql);
                    //executo o comando sql
                    $query->execute();

                    //loop para listar todos os dados encontrados
                    for ($i = 0; $dados = $query->fetch(); $i++) {
                        ?>   	


                        <tr>
                            <td><?php echo $dados['Inscricao_Imob']; ?></td>
                            <td><?php echo $dados['Proprietario']; ?></td>
                            <td><?php echo retornaRua($pdo, $dados['Cod_Rua']); ?></td>
                            <td><?php echo $dados['Numero']; ?></td>
                            <td><?php echo $dados['Complemento']; ?></td>
                            <td><?php echo $dados['Quadra']; ?></td>
                            <td><?php echo $dados['Lote']; ?></td>
                            <td><?php echo retornaBairro($pdo, $dados['Cod_Bairro']); ?></td>
                            <td align="center"><a href="#" id="btn_consultar" data-id="<?php echo $dados['Inscricao_Imob']; ?>"><img src="recursos/imagens/estrutura/lupa.png" height="20px;" alt="consultar"></a></td>
                        </tr>


                        <?php
                    }
                    $pdo = null;
                    ?>
                </tbody>

            </table>
        </div>
        <hr />
    </body>
</html>


<?php

function retornaRua($pdo, $cod_rua) {

// preparo para realizar o comando sql
    $sql = "SELECT * FROM rua WHERE Cod_Rua = '$cod_rua'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['Desc_rua'];
    } else {
        return $sql;
    }
}

function retornaBairro($pdo, $cod_bairro) {

// preparo para realizar o comando sql
    $sql = "SELECT * FROM Bairro WHERE Cod_Bairro = '$cod_bairro'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['Desc_Bairro'];
    } else {
        return $sql;
    }
}
?>