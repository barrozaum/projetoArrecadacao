<?php
include_once '../estrutura/controle/validarSessao.php';

// incluir a biblioteca para saber se o ano é bisesto
include_once '../funcaoPHP/funcaoDiaBisesto.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
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
                        <th>Data</th>
                        <th>Valor</th>
                        <th>Alterar</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    // chamo a conexao com o banco de dados
                    include_once '../estrutura/conexao/conexao.php';
                    // preparo para realizar o comando sql
                    $cod_moeda = $_REQUEST['cod'];
                    $mes = $_REQUEST['mes'];
                    $ano = $_REQUEST['ano'];

                    $data_inicial = dataAmericano("01/" . $mes . "/" . $ano);
                    $data_final = dataAmericano(diaBisesto($ano, $mes) . "/" . $mes . "/" . $ano);

                    $sql = "SELECT * 
                FROM moeda m,tipo_moeda t   
                WHERE m.cod_tipo_moeda = '$cod_moeda'
                AND m.data_moeda >= '$data_inicial'
                AND m.data_moeda <= '$data_final'
                AND m.cod_tipo_moeda = t.cod_tipo_moeda";
                    $query = $pdo->prepare($sql);
                    //executo o comando sql
                    $query->execute();

                    //loop para listar todos os dados encontrados
                    for ($i = 0; $dados = $query->fetch(); $i++) {
                        $button = $dados['cod_tipo_moeda'] . "|" . $dados['Desc_tipo_moeda'] . "|" . $dados['data_moeda'] . "|" . $dados['valor_moeda'];
                        ?>   	
                        <tr>
                            <td><?php echo dataBrasileiro($dados['data_moeda']) ?></td>
                            <td>R$ <?php echo mostrarDinheiro5Casas($dados['valor_moeda']); ?></td>
                            <td><a href="#" id="edit-editar" data-id="<?php echo $button; ?>"><img src="recursos/imagens/estrutura/alterar.png" height="20px;" alt="alterar"></a></td>
                        </tr>
                        <?php
                    }
                    $pdo = null;
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
