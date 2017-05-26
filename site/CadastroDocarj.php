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
        <script src="recursos/js/jquery.min.js"></script>
        <script src="recursos/js/bootstrap.min.js"></script>
        <link rel="apple-touch-icon" href="/bootstrap/img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/bootstrap/img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/bootstrap/img/apple-touch-icon-114x114.png">
        <script src="recursos/js/estrutura.js"></script>
        <script src="recursos/js/adiciona_zero.js"></script>
        <script src="recursos/js/CadastroDam.js"></script>
        <script src="recursos/js/camposNumeros.js"></script>

        <!-- Includes para Colocar o Calendário na data -->
        <link rel="stylesheet" href="recursos/css/redmond/jquery-ui-1.10.1.custom.css" />
        <script src="recursos/js/data_calendario.js" type="text/javascript"></script>
        <script src="recursos/js/calendario.js" type="text/javascript"></script>
        <script src="recursos/js/mascaraData.js"></script>
        <!-- fim dos includes para Colocar a Data -->

        <link rel="stylesheet" href="recursos/css/jquery.dataTables.min.css">
        <script src="recursos/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                estruturaPagina();
            });

            function estruturaPagina() {
                $('#formulario').load('recursos/includes/formulario/formularioCadastroDocarj.php');

            }
        </script>

    </head>
    <body>
        <div id="cabecalho">
            <!-- Não apagar, pois é onde encontra-se o cabecalho do site -->
        </div>

        <hr />
        <div class="container text center">
            <div id="formulario"></div>
        </div>
        <hr />

        <div id="modal"></div>

        <div id="rodape">
            <!-- Não apagar, pois é onde encontra-se o rodape da página -->
        </div>
    </body>
</html>