<?php
include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/function_letraMaiscula.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcao_retorna_descricao_cod_banco.php';
include_once '../funcaoPHP/funcao_retorna_situacao_divida.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    set_time_limit(0); //coloco para não haver limite de tempo


    $msg_erro = "";

    if ($_POST['id'] == 1) {
        //   filtrar campos enviados pelo formulario
        $numero_Letra_Maiscula = letraMaiuscula($_POST['txt_numero_dam']);
        $ano_Letra_Maiscula = letraMaiuscula($_POST['txt_ano_dam']);

        //     validação dos campos
        if ((strlen($numero_Letra_Maiscula) === 6) || is_int($numero_Letra_Maiscula) === TRUE) {
            $numero_dam = $numero_Letra_Maiscula;
        } else {
            $msg_erro .= 'POR FAVOR ENTRE COM UM NÚMERO DAM VÁLIDO <br />';
        }


        if ((strlen($ano_Letra_Maiscula) === 4) || is_int($numero_Letra_Maiscula) === TRUE) {
            $ano_dam = $ano_Letra_Maiscula;
        } else {
            $msg_erro .= 'POR FAVOR ENTRE COM UM NÚMERO DAM VÁLIDO <br />';
        }


        if ($msg_erro == "") {
//            campos de retorno da consulta
            $sql = "SELECT d.Num_Dam, d.Ano_Dam, fd.Parcela, d.Nome_Contribuinte, d.Inscricao, d.Total, fd.Vencimento, fd.Cod_Situacao_divida,  ";
            $sql = $sql . " fd.Valor_Pagamento, fd.Data_Pagamento, fd.Cod_Banco, fd.Lote ";
//            tabelas da consulta
            $sql = $sql . " FROM DAM d, Financeiro_Dam fd";
//            condições da consulta
            $sql = $sql . " WHERE d.Num_Dam = '$numero_dam'";
            $sql = $sql . " AND d.Ano_Dam = '$ano_dam'";
            $sql = $sql . " AND d.Num_Dam = fd.Num_Dam";
            $sql = $sql . " AND d.Ano_Dam = fd.Ano_Dam";


            func_buscar_dados_dam($sql);
        } else {
            print $msg_erro;
        }
    } else if ($_POST['id'] == 2) {

        $contrinbuinte_Letra_Maiscula = letraMaiuscula($_POST['txt_contribuinte']);
        if ((strlen($contrinbuinte_Letra_Maiscula) > 2) && (strlen($contrinbuinte_Letra_Maiscula) < 31)) {
            $contrinbuinte = $contrinbuinte_Letra_Maiscula;
        } else {
            $msg_erro .= 'POR FAVOR ENTRE COM O CONTRIBUINTE VÁLIDO <br />';
        }

        //            campos de retorno da consulta
        $sql = "SELECT d.Num_Dam, d.Ano_Dam, fd.Parcela, d.Nome_Contribuinte, d.Inscricao, d.Total, fd.Vencimento, fd.Cod_Situacao_divida,  ";
        $sql = $sql . " fd.Valor_Pagamento, fd.Data_Pagamento, fd.Cod_Banco, fd.Lote ";
//            tabelas da consulta
        $sql = $sql . " FROM DAM d, Financeiro_Dam fd";
//            condições da consulta
        $sql = $sql . " WHERE d.Nome_Contribuinte like'%$contrinbuinte%'";
        $sql = $sql . " AND d.Num_Dam = fd.Num_Dam";
        $sql = $sql . " AND d.Ano_Dam = fd.Ano_Dam";
        if ($msg_erro == "") {
            func_buscar_dados_dam($sql);
        } else {
            print $msg_erro;
        }
    }
    ?>



    <?php
// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>



<?php

function func_buscar_dados_dam($sql) {
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
                            <th>Num_DAM</th>
                            <th>Ano_DAM</th>
                            <th>Parcela</th>
                            <th>Nome_Contribuinte</th>
                            <th>Inscrição</th>
                            <th>Total</th>
                            <th>Vencimento</th>
                            <th>Cod_Situação</th>
                            <th>Situação</th>
                            <th>Valor_Pagamento</th>
                            <th>Data_Pagamento</th>
                            <th>Cod_Banco</th>
                            <th>Banco</th>
                            <th>Lote</th>

                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        include_once '../estrutura/conexao/conexao.php';

                     

                        $query = $pdo->prepare($sql);
                        //executo o comando sql
                        $query->execute();


                        //loop para listar todos os dados encontrados
                        for ($i = 0; $dados = $query->fetch(); $i++) {
                            ?>   	

                            <tr>
                                <td><?php echo $dados['Num_Dam']; ?></td>
                                <td><?php echo $dados['Ano_Dam']; ?></td>
                                <td><?php echo $dados['Parcela']; ?></td>
                                <td><?php echo $dados['Nome_Contribuinte']; ?></td>
                                <td><?php echo $dados['Inscricao']; ?></td>
                                <td><?php echo mostrarDinheiro($dados['Total']); ?></td>
                                <td><?php echo dataBrasileiro($dados['Vencimento']); ?></td>
                                <td><?php echo $dados['Cod_Situacao_divida']; ?></td>
                                <td><?php echo fun_retorna_situacao_divida($pdo, $dados['Cod_Situacao_divida']); ?></td>
                                <td><?php echo mostrarDinheiro($dados['Valor_Pagamento']); ?></td>
                                <td><?php echo dataBrasileiro($dados['Data_Pagamento']); ?></td>
                                <td><?php echo $dados['Cod_Banco']; ?></td>
                                <td><?php echo fun_retorna_descricao_cod_banco($pdo, $dados['Cod_Banco']); ?></td>
                                <td><?php echo  $dados['Lote']; ?></td>
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
}
?>
