<?php

session_start();
$usuario = $_POST["txtlogin"];
$senha = $_POST["txtsenha"];

try {
//   $Localizacao_Banco = "34.208.42.129";
    $Localizacao_Banco = "BARROZO\SQLEXPRESS";

    $nome_Base_Dados = "Japeri";
    $usuario_Banco = $usuario;
    $senha_Banco = $senha;
    $pdo = new PDO("sqlsrv:Server=$Localizacao_Banco;Database=$nome_Base_Dados", "$usuario_Banco", "$senha_Banco");

    $_SESSION["usuario"] = $usuario;
    $_SESSION["senha"] = $senha;
    $_SESSION['carregar_parametros'] = TRUE;
    echo "<meta http-equiv='refresh' content='0;url=carrega_parametros.php'>";
} catch (PDOException $e) {
   
    $_SESSION['mensagem'] = "USUÁRIO NÃO ENCONTRADO !!! <br /> VERIFIQUE SEU USUÁRIO E SENHA !!";
     echo "<meta http-equiv='refresh' content='0;url=../../../../'>";
}
?>
