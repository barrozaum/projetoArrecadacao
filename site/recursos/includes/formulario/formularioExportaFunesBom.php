<?php
include_once '../estrutura/controle/validarSessao.php';
//validacao
include_once '../funcaoPHP/function_letraMaiscula.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>
<form method="post" action="recursos/includes/exportar/exportaFunesBom.php">    
    <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
        <div class="well"><!-- div que coloca a cor no formulário -->
            <div class="panel panel-default">
                <!-- INICIO Dados do imóvel -->
                <div class="panel-heading text-center">EXPORTAR FUNESBOM</div>
                <div class="panel-body text-center">
                    <div class="row ">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="form-group">
                                <label for="txtInscricaoInicial">Inscrição Inicial:</label>
                                <input type="text" class="form-control" name ="txtInscricaoInicial" id="txtInscricaoInicial" required="true" value="" maxlength="6" placeholder="" onkeypress='return SomenteNumero(event)' onblur="tamanhoCampo(txtInscricaoInicial)" style="text-align: center;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="form-group">
                                <label for="txtInscricaoFinal">Inscrição Final:</label>
                                <input type="text" class="form-control" name ="txtInscricaoFinal" id="txtInscricaoFinal" required="true" value="" maxlength="6" placeholder="" onkeypress='return SomenteNumero(event)' onblur="tamanhoCampo(txtInscricaoFinal)" style="text-align: center;">
                            </div>
                        </div>

                    </div> 

                    <div class="row">
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-success" >Gerar Relatório</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>