<?php
include_once '../estrutura/controle/validarSessao.php';
$codigo = $_REQUEST['txtExcCod'];

include_once '../estrutura/conexao/conexao.php';

$pdo->beginTransaction();/* Inicia a transação */
$sql = "DELETE  FROM Motivo_Cancelamento  WHERE Cod_Motivo_Cancelamento = '".$codigo."'";
$executa = $pdo->query($sql);
  

if (!$executa) {
?> 
<script>
    window.alert("<?php echo "Erro ao Excluir !!!"; ?> ");
    location.href = "../../../MotivoCancelamento.php";
</script>
<?php
    die(''); /* É disparado em caso de erro na inserção de movimento */
}
 
$pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
$pdo=null;
?>

<script>
    window.alert("<?php echo "Motivo Cancelamento Excluido com Sucesso !!!"; ?> ");
    location.href = "../../../MotivoCancelamento.php";
</script>