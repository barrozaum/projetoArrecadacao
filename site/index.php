<?php
session_start();
session_destroy();

// SABER SE É MANHÃ TARDE OU NOITE
$hora = date('H');
if ($hora >= 00 AND $hora <= 05) {
    $msg = "Boa Magruda";
} else if ($hora >= 6 AND $hora <= 11) {
    $msg = "Bom Dia";
} else if ($hora >= 12 AND $hora <= 18) {
    $msg = "Boa Tarde";
} else {
    $msg = "Boa Noite";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Parvaim</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="recursos/css/login.css">

    </head>
    <body>

        <div class="card card-container">
            <p align="center"> <?php print $msg; ?> !!!</p>
            <p align="center">Bem Vindo ao  <strong>SAM</strong> !!!</p>
            <p align="center"> <strong>SISTEMA DE ARRECADACAO MUNIICIPAL</strong></p>
            <img id="profile-img" class="profile-img-card" src="recursos/imagens/estrutura/logo.jpg" />
            <p id="profile-name" class="profile-name-card"></p>
            <!--<form class="form-signin">-->
            <form id="loginform" name="f1" class="form-signin" role="form" method="post" action= "recursos/includes/estrutura/controle/validarLogin.php">
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" id="txtlogin" name="txtlogin" class="form-control" placeholder="Login" required autofocus>
                <input type="password" id="txtsenha" name="txtsenha" class="form-control" placeholder="Senha" required>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Logar</button>
            </form>
            <!-- /form -->
            <!--            <a href="#" class="forgot-password">
                            Forgot the password?
                        </a>-->

            <?php
            if (isset($_SESSION["mensagem"])) {
                ?>
                <div class="alert alert-danger">
                    <?php
                    echo $_SESSION["mensagem"];
                    unset($_SESSION["mensagem"]);
                    ?>
                </div>
                <?php
            }
            ?>
        </div><!-- /card-container -->



    </body>
</html>
