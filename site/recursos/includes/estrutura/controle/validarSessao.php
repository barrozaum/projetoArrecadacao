<?php

session_start();

if (!isset($_SESSION["usuario"]) || !isset($_SESSION["senha"])) {
    session_destroy();
    echo "Acesso Negado !";
    header("Location: ../");
    exit();
}


//  Variaveis de sessão utilizaveis
if (isset($_SESSION['C_VALOR_MOEDA_DIA_UFIR'])) {
    $_SESSION['C_VALOR_MOEDA_DIA_UFIR'];
}
?>

