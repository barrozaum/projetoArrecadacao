<?php
    try {
//       $Localizacao_Banco = "35.160.6.139";
        $Localizacao_Banco = "BARROZO\SQLEXPRESS";
   
        $nome_Base_Dados = "Japeri";
        $usuario_Banco = $_SESSION["usuario"];
        $senha_Banco = $_SESSION["senha"];
        $pdo = new PDO("sqlsrv:Server=$Localizacao_Banco;Database=$nome_Base_Dados", "$usuario_Banco", "$senha_Banco");
       
      
    } catch (PDOException $e) {
            echo "Usuário não cadastrado ou senha inválida !";
            $_SESSION["mensagem"] = "Usu&aacute;rio n&atilde;o cadastrado ou senha inv&aacute;lida";
    }
?>