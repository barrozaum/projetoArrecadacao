<?php
include_once '../estrutura/controle/validarSessao.php';
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
                    <th>Usuário</th>
                    <th>Mátricula</th>
                    <th>Nome Completo</th>
                    <th>Alterar</th>

                </tr>
            </thead>
            <tbody>

                <?php
                // chamo a conexao com o banco de dados
                 include_once '../estrutura/conexao/conexao.php';

                // preparo para realizar o comando sql
                $sql ="select * FROM usuario order by usuario";
                $query = $pdo->prepare($sql);
                //executo o comando sql
                $query->execute();

                //loop para listar todos os dados encontrados
                for ($i = 0; $dados = $query->fetch(); $i++) {
                    ?>   	


                    <tr>
                        <td><?php echo $dados['usuario']; ?></td>
                        <td><?php echo $dados['Matricula']; ?></td>
                        <td><?php echo $dados['Nome_Completo']; ?></td>
                        <td align="center"><a href="#" id="edit-editar" data-id="<?php echo $dados['usuario']; ?>"><img src="recursos/imagens/estrutura/alterar.png" height="20px;" alt="alterar"></a></td>

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


