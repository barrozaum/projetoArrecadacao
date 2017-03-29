<?php
include_once '../estrutura/controle/validarSessao.php';
//inclusão das bibliotecas 
include_once '../funcaoPHP/funcaoData.php';
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
            <table id="table" class="display" cellspacing="0" >
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Divida</th>
                        <th>Vencimento</th>
                        <th>Desconto</th>
                        <th>Cod_Contabil</th>
                        <th>Cod_DA</th>
                        <th>Cod_Multa_Juros</th>
                        <th>Descrição</th>
                        <th>Alterar</th>
                        <th>Excluir</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                    // chamo a conexao com o banco de dados
                    include_once '../estrutura/conexao/conexao.php';
                    // preparo para realizar o comando sql
                    $sql = "select * FROM Divida_Imob order by Cod_Divida_Imob";
                    $query = $pdo->prepare($sql);
                    //executo o comando sql
                    $query->execute();

                    //loop para listar todos os dados encontrados
                    for ($i = 0; $dados = $query->fetch(); $i++) {
                        ?>   	


                        <tr>
                            <td><?php echo $dados['Cod_Divida_Imob']; ?></td>
                            <td><?php echo $dados['Desc_Divida']; ?></td>
                            <td><?php echo dataBrasileiro($dados['Venc_Cota_Unica']); ?></td>
                            <td><?php echo $dados['Desconto']; ?></td>
                            <td><?php echo $dados['Cod_Contabil']; ?></td>
                            <td><?php echo $dados['Cod_Contabil_DA']; ?></td>
                            <td><?php echo $dados['Cod_Contabil_Multa_Juros']; ?></td>
                            <td><?php echo $dados['DESC_COMPLETA']; ?></td>
                            <td><a href="#" id="edit-editar" data-id="<?php echo $dados['Cod_Divida_Imob']; ?>"><img src="recursos/imagens/estrutura/alterar.png" height="20px;" alt="alterar"></a></td>
                            <td><a href="#" id="edit-excluir"     data-id="<?php echo $dados['Cod_Divida_Imob']; ?>"><img src="recursos/imagens/estrutura/lixeira.png" alt="excluir" height="20px;"></a></td>
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


