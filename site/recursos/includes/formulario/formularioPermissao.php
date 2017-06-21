<?php
include_once '../estrutura/controle/validarSessao.php';
//validacao
include_once '../funcaoPHP/function_letraMaiscula.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>


    <?php
    
    $id = $_POST['id'];
     include_once '../estrutura/conexao/conexao.php';
    ?>

    <form method="post" action="recursos/includes/alterar/alterarPermissão.php">    

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Alterar Permissões Usuário</h4>
        </div>

        <div class="modal-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>op</th>
                        <th>Nome Programa</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // chamo a conexao com o banco de dados
                
                // preparo para realizar o comando sql
                $query = $pdo->prepare("select * FROM programas order by Nome_prog");
                //executo o comando sql
                $query->execute();

                //loop para listar todos os dados encontrados
                for ($i = 0; $dados = $query->fetch(); $i++) {
                ?>   	

                    <tr>
                        <td><input type="checkbox" name="" value="<?php echo $dados['Nome_prog'];?>"></td>
                        <td><?php echo $dados['Nome_prog'];?></td>
                    </tr>
                 <?php
                }
                $pdo = null;
                ?>
                </tbody>
                
                
            </table>



        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success" >Alterar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </form>
   