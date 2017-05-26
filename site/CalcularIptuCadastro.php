<?php
//valida para saber se o usuário está logado
include "recursos/includes/estrutura/controle/validarSessao.php";
//valida para saber se os parametros estão carregados
include "recursos/includes/estrutura/controle/validarParametrosSistema.php";
?>
<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Arrecadação</title>

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="recursos/css/bootstrap.css" rel="stylesheet">
        <link href="recursos/css/menu.css" rel="stylesheet">

        <!--[if lt IE 9]>
          <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="recursos/js/jquery.min.js"></script>
        <script src="recursos/js/bootstrap.min.js"></script>
        <link rel="apple-touch-icon" href="/bootstrap/img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/bootstrap/img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/bootstrap/img/apple-touch-icon-114x114.png">
        <script src="recursos/js/estrutura.js"></script>
        <script src="recursos/js/modalUtilizacao.js"></script>
        <script src="recursos/js/camposNumeros.js"></script>
        <script src="recursos/js/CalcularIptu.js"></script>

        <link rel="stylesheet" href="recursos/css/jquery.dataTables.min.css">
        <script src="recursos/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                estruturaPagina();
            });

            function estruturaPagina() {
                $('#formulario').load('recursos/includes/formulario/formularioCalculaIptuCadastro.php');
            }
        </script>

    </head>
    <body>
        
        <div class="container text center">
            <div id="formulario"></div>
        </div>

        <div id="modal"></div>  
    </body>
</html>