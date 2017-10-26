<?php
include_once '../estrutura/controle/validarSessao.php';
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
                    <th>Zona Fiscal</th>
                    <th>Vlr m2°</th>
                    <th>Descricao</th>
                    <th>Alterar</th>
                    <th>Excluir</th>

                </tr>
            </thead>
            <tbody>

                <?php
                // chamo a conexao com o banco de dados
                include_once '../estrutura/conexao/conexao.php';
                // preparo para realizar o comando sql
                $sql = "SELECT Zona_Fiscal, vlr_m2_terreno, Descricao, Cod_Utilizacao
                        FROM Valor_M2_Terreno v, Utilizacao u
                        WHERE v.Cod_Utilizacao = u.codigo";
                $query = $pdo->prepare($sql);
                //executo o comando sql
                $query->execute();

                //loop para listar todos os dados encontrados
                for ($i = 0; $dados = $query->fetch(); $i++) {
                    $valor = mostrarDinheiro5Casas($dados['vlr_m2_terreno']);
                    $button = $dados['Zona_Fiscal'] . "|" . $dados['Cod_Utilizacao'] . "|" . $valor . "|" . $dados['Descricao'];
                    ?>   	
                    <tr>
                        <td><?php echo $dados['Zona_Fiscal']; ?></td>
                        <td><?php echo $valor; ?></td>
                        <td><?php echo $dados['Descricao']; ?></td>
                        <td><a href="#" id="edit-editar" data-id="<?php echo $button; ?>"><img src="recursos/imagens/estrutura/alterar.png" height="20px;" alt="alterar"></a></td>
                        <td><a href="#" id="edit-excluir" data-id="<?php echo $button; ?>"><img src="recursos/imagens/estrutura/lixeira.png" height="20px;" alt="excluir"></a></td>
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


