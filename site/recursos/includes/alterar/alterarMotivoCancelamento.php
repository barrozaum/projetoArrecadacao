<?php
include_once '../estrutura/controle/validarSessao.php';
$codigo = $_REQUEST['txtAltCod'];
$descricao = $_REQUEST['txtAltDescricao'];

include_once '../estrutura/conexao/conexao.php';

$pdo->beginTransaction();/* Inicia a transação */
$sql = "UPDATE Motivo_Cancelamento SET Desc_Motivo_Cancelamento = '".$descricao. "' WHERE Cod_Motivo_Cancelamento = '".$codigo."'";
$executa = $pdo->query($sql);
  
if (!$executa) {
    ?> 
    <script>
        window.alert("<?php echo "Erro ao Alterar !!!"; ?> ");
        location.href = "../../../MotivoCancelamento.php";
    </script>
    <?php
    die(''); /* É disparado em caso de erro na inserção de movimento */
}
 
$pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
$pdo=null;
?>

<script>
    window.alert("<?php echo "Motivo Cancelamento Alterado com Sucesso !!!"; ?> ");
    location.href = "../../../MotivoCancelamento.php";
</script>