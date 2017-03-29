<?php //inicia e finaliza a sessao e redireciona para a tela de login
echo 'entrei logout';
session_start();
session_destroy();
header("Location: ../index.php");
?>
