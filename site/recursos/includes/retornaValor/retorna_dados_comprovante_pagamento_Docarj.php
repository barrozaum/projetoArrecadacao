<?php
include_once '../estrutura/controle/validarSessao.php';
include_once '../estrutura/conexao/conexao.php';
include_once '../funcaoPHP/function_letraMaiscula.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcao_retorna_descricao_cod_banco.php';
include_once '../funcaoPHP/funcao_retorna_situacao_divida.php';
include_once '../funcaoPHP/funcaoCriacaoInput.php';


if ($_POST['txt_op'] == 1) {
    func_listar_dados_Docarj($pdo);
}

function func_listar_dados_Docarj($pdo) {
    $numero_Docarj = $_POST['txt_numero_Docarj'];
    $ano_Docarj = $_POST['txt_ano_Docarj'];

    $sql = "SELECT d.Num_Dam, d.Ano_Dam, fd.Parcela, d.Nome_Contribuinte, d.Inscricao, d.Total, fd.Vencimento, fd.Cod_Situacao_divida,  ";
    $sql = $sql . " fd.Valor_Pagamento, fd.Data_Pagamento, fd.Cod_Banco, fd.Lote ";
//            tabelas da consulta
    $sql = $sql . " FROM DAM d, Financeiro_Dam fd";
//            condições da consulta
    $sql = $sql . " WHERE d.Num_Dam = '$numero_Docarj'";
    $sql = $sql . " AND d.Ano_Dam = '$ano_Docarj'";
    $sql = $sql . " AND d.Num_Dam = fd.Num_Dam";
    $sql = $sql . " AND d.Ano_Dam = fd.Ano_Dam";

    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();
// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        ?>
        <form name="txt_form_emissao_comprovante" id="id_form_emissao_comprovante" method="post" action="recursos/includes/relatorio/relatorio_comprovante_Docarj.php" target="_blank">
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    criar_input_text('Nome Contribuinte', 'nome_contribuinte', 'nome_contribuinte', array('readonly' => 'true'), $dados['Nome_Contribuinte']);
                    ?></div>
                <div class="col-sm-6">
                    <?php
                    criar_input_text('Inscricao ', 'inscricao', 'inscricao', array('readonly' => 'true'), $dados['Inscricao']);
                    criar_input_hidden('numero_Docarj', array(), $dados['Num_Dam']);
                    criar_input_hidden('ano_Docarj', array(), $dados['Ano_Dam']);
                    criar_input_hidden('parcela');
                    ?>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-12">
                    <div style="overflow: auto; max-width: 100%;">
                        <table id="table" class="table table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Emitir</th>
                                    <th>Parcela</th>
                                    <th>Valor</th>
                                    <th>Vencimento</th>
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
                                $query = $pdo->prepare($sql);
                                //executo o comando sql
                                $query->execute();


                                //loop para listar todos os dados encontrados
                                for ($i = 0; $dados = $query->fetch(); $i++) {
                                    ?>   	

                                    <?php
                                    if ($dados['Cod_Situacao_divida'] != '04') {
                                        $cor = "#f0f0f0";
                                    } else {
                                        $cor = "#ffffff";
                                    }
                                    ?>
                                    <tr style="background-color: <?php echo $cor; ?>" >
                                        <?php
                                        if ($dados['Cod_Situacao_divida'] != '04') {
                                            print '<td></td>';
                                        } else {
                                            print '<td><a id="id_emitir_comprovante" class="btn btn-success" role="button" data-id="' . $dados["Parcela"] . '">Emitir Comprovante</a></td>';
                                        }
                                        ?>


                                        <td><?php echo $dados['Parcela']; ?></td>
                                        <td><?php echo mostrarDinheiro($dados['Total']); ?></td>
                                        <td><?php echo dataBrasileiro($dados['Vencimento']); ?></td>
                                        <td><?php echo fun_retorna_situacao_divida($pdo, $dados['Cod_Situacao_divida']); ?></td>
                                        <td><?php echo mostrarDinheiro($dados['Valor_Pagamento']); ?></td>
                                        <td><?php echo dataBrasileiro($dados['Data_Pagamento']); ?></td>
                                        <td><?php echo $dados['Cod_Banco']; ?></td>
                                        <td><?php echo fun_retorna_descricao_cod_banco($pdo, $dados['Cod_Banco']); ?></td>
                                        <td><?php echo $dados['Lote']; ?></td>
                                    </tr>

                                    <?php
                                }
                                $pdo = null;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </form>
        <?php
    } else {
        ?>
        <div class="alert alert-danger text-center">DOCARJ (DAM) NÃO ENCONTRADO !!! </div>
        <?php
    }

    $pdo = null;
}
