<?php

//inicia e finaliza a sessao e redireciona para a tela de login

session_start();
session_destroy();
unset($_SESSION);
header("Location: ../index.php");
?>
