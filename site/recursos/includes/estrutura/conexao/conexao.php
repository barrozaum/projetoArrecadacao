<?php

try {
//      $Localizacao_Banco = "34.208.42.129";
    $Localizacao_Banco = "BARROZO\SQLEXPRESS";

    $nome_Base_Dados = "Japeri";
    $usuario_Banco = $_SESSION["usuario"];
    $senha_Banco = $_SESSION["senha"];
    $pdo = new PDO("sqlsrv:Server=$Localizacao_Banco;Database=$nome_Base_Dados", "$usuario_Banco", "$senha_Banco");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    $_SESSION["mensagem"] = "Usu&aacute;rio n&atilde;o cadastrado ou senha inv&aacute;lida";
}
?>