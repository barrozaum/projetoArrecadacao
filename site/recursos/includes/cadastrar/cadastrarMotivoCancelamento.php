<?php
include_once '../estrutura/controle/validarSessao.php';
$codigo = $_REQUEST['txtCod'];

$descricao = $_REQUEST['txtDescricao'];

include_once '../estrutura/conexao/conexao.php';

$pdo->beginTransaction(); /* Inicia a transação */

$sql = "INSERT INTO Motivo_Cancelamento (Cod_Motivo_Cancelamento, Desc_Motivo_Cancelamento) VALUES ('$codigo', '$descricao')";
$executa = $pdo->query($sql);

if (!$executa) {
?> 
<script>
    window.alert("<?php echo "Erro ao Cadastrar !!!"; ?> ");
    location.href = "../../../MotivoCancelamento.php";
</script>
<?php
    die(''); /* É disparado em caso de erro na inserção de movimento */
}

$pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
$pdo = null;
?>

<script>
    window.alert("<?php echo "Cadastrado com Sucesso !!!"; ?> ");
    location.href = "../../../MotivoCancelamento.php";
</script>