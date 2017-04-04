<?php
include_once '../estrutura/controle/validarSessao.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
set_time_limit(0); //coloco para não haver limite de tempo
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
                        <th>Num_Itbi</th>
                        <th>Ano_Itbi</th>
                        <th>Inscrição</th>
                        <th>Adquirente</th>
                        <th>Transmitente</th>
                        <th>Consultar</th>

                    </tr>
                </thead>
                <tbody>

                    <?php
                    include_once '../funcaoPHP/function_letraMaiscula.php';
                    include_once '../funcaoPHP/funcaoData.php';

                    
                    $adquirinte = letraMaiuscula($_POST['adquirinte']);
                
                    
                    $data_inicial = dataAmericano(letraMaiuscula($_POST['data_incial']));
                    $data_final = dataAmericano(letraMaiuscula($_POST['data_final']));
                   
                    // chamo a conexao com o banco de dados
                    include_once '../estrutura/conexao/conexao.php';
                    // preparo para realizar o comando sql
                    $sql = "SELECT * ";
                    $sql = $sql ." FROM itbi ";
                    $sql = $sql ." WHERE Adquirente like '%$adquirinte%' ";
                    $sql = $sql ." AND Data_Transacao >= '$data_inicial' ";
                    $sql = $sql ." AND Data_Transacao <= '$data_final' ";
                    $sql = $sql ." order by Ano_Itbi ASC ";
                
                    $query = $pdo->prepare($sql);
                    //executo o comando sql
                    $query->execute();

                    //loop para listar todos os dados encontrados
                    for ($i = 0; $dados = $query->fetch(); $i++) {
                        ?>   	

                        <tr>
                            <td><?php echo $dados['Num_Itbi']; ?></td>
                            <td><?php echo $dados['Ano_Itbi']; ?></td>
                            <td><?php echo $dados['Inscricao_Imob']; ?></td>
                            <td><?php echo $dados['Adquirente']; ?></td>
                            <td><?php echo $dados['Transmitente']; ?></td>
                            <td align="center"><a href="#" id="edit-consultar" data-id="<?php echo $dados['Num_Itbi'] . "|" . $dados['Ano_Itbi']; ?>"><img src="recursos/imagens/estrutura/lupa.png" height="20px;" alt="alterar"></a></td>
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

<?php
// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>
