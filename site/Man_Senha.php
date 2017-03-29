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


    </head>
    <body>
        <div id="cabecalho">
            <!-- Não apagar, pois é onde encontra-se o cabecalho do site -->
        </div>
        <div id="menu">
            <!-- Não apagar, pois é onde encontra-se o menu do site -->
        </div>
        <div class="container bg-4 ">
            <h4>Manuntenção Senha</h4>
        </div>
        <hr />
        <div class="container text center">

            <form method="post" action="recursos/includes/alteraManUsuario.php">   

                <div class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="well">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="senha">Senha:</label>
                                    <input type="text" class="form-control" name ="senha" id="senha" required="true" value="" placeholder="Informe sua Nova Senha">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="novaSenha">Nova Senha:</label>
                                    <input type="text" class="form-control" name ="novaSenha" id="novaSenha" required="true" value="" placeholder="Informe sua Nova Senha">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="confSenha">Conf Senha:</label>
                                    <input type="text" class="form-control" name ="confSenha" id="confSenha" required="true" value="" placeholder="Confirme Sua nova Senha">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <hr>
                                <button type="submit" class="btn btn-success" >Alterar</button>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>