<?php
include_once '../estrutura/controle/validarSessao.php';
//validacao
include_once '../funcaoPHP/function_letraMaiscula.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>

<form method="post" action="recursos/includes/relatorio/relacaoMaioresDevedores.php" target="_Blank">    
    <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
        <div class="well"><!-- div que coloca a cor no formulário -->
            <div class="panel panel-default">
                <!-- INICIO Dados do imóvel -->
                <div class="panel-heading text-center">RELAÇÃO MAIORES DEVEDORES</div>
                <div class="panel-body te">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="txtAnoInicial">Ano Inicial:</label>
                                <input type="text" class="form-control" name ="txtAnoInicial" id="txtAnoInicial" required="true" value="" maxlength="4" placeholder="" onkeypress='return SomenteNumero(event)' onblur="tamanhoCampoAno(txtAnoInicial)">

                            </div>
                            <div class="col-sm-3">
                                <label for="txtAnoFinal">Ano Final:</label>
                                <input type="text" class="form-control" name ="txtAnoFinal" id="txtAnoFinal" required="true" value="" maxlength="4" placeholder="" onkeypress='return SomenteNumero(event)' onblur="tamanhoCampoAno(txtAnoFinal)">

                            </div>
                            <div class="col-sm-3">
                                <label for="txtQtdListar">Quant. Listar:</label>
                                <input type="text" class="form-control" name ="txtQtdListar" id="txtQtdListar" required="true" value="" maxlength="4" placeholder="" onkeypress='return SomenteNumero(event)' >
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="txtCodDivInicial">Cód Dív Inicial: </label>
                                <input type="text" class="form-control" name ="txtCodDivInicial" id="txtCodDivInicial" required="true" value="" maxlength="8" placeholder="" onkeypress='return SomenteNumero(event)' onblur="tamanhoCampoCod(txtCodDivInicial, 'txtDescInicial')">

                            </div>
                            <div class="col-sm-9">
                                <label for="txtDescInicial">Descição</label>
                                <input type="text" class="form-control" name ="txtDescInicial" id="txtDescInicial" required="true" value="" maxlength="8" placeholder=""  readonly="true">
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="txtCodDivFinal">Cod Dív Final:</label>
                                <input type="text" class="form-control" name ="txtCodDivFinal" id="txtCodDivFinal" required="true" value="" maxlength="8" placeholder="" onkeypress='return SomenteNumero(event)' onblur="tamanhoCampoCod(txtCodDivFinal, 'txtDescFinal')">

                            </div>
                            <div class="col-sm-9">
                                <label for="txtDescFinal">Descição</label>
                                <input type="text" class="form-control" name ="txtDescFinal" id="txtDescFinal" required="true" value="" maxlength="8" placeholder="" readonly="true">
                                <br>
                            </div>
                        </div>
                    </div> 


                    <div class="row">
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-success" >Gerar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
