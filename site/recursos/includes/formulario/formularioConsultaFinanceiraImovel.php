<?php
include_once '../estrutura/controle/validarSessao.php';
?>
<?php
if (empty($_POST['id'])) {
    formularioCadastro();
}
?>

<?php

function formularioCadastro() {
    ?>
    <!-- fim doJava script para dar Focus no primeiro Campo do formulário -->
    <div class="row">
        <div class="col-sm-12">
            <div  id="msg"></div>
        </div>
    </div>
    <div class="row">
        <form  method="post" action="" name="formulario_dados_imovel" id="formulario_imovel">   <!-- inicio do formulário --> 
            <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
                <div class="well"><!-- div que coloca a cor no formulário -->
                    <div class="panel panel-default">
                        <!-- INICIO Dados do imóvel -->
                        <div class="panel-heading text-center">CONSULTA FINANCEIRA</div>
                        <div class="panel-body">
                            <!-- inicio dados inscrição-->
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="inscricao_imob">INSCRIÇÃO:</label>
                                        <input type="text" class="form-control" name ="inscricao_imob" id="inscricao_imob"  value="" maxlength="6" placeholder="XXXXXX" onkeypress='return SomenteNumero(event)' onblur="buscaImovel(this);"/>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nome_proprietario">PROPRIETÁRIO:</label>
                                        <input type="text" class="form-control" name ="nome_proprietario" id="nome_proprietario"  value="" maxlength="50" placeholder="NOME PROPRIETÁRIO"   readonly="true" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="checkbox" name="dividas_ajuizada" id="dividas_ajuizada" ><label for="dividas_ajuizada">&nbsp;&nbsp; SÓ DÍVIDA AJUIZADA</label><br>
                                        <input type="checkbox" name="dividas_nao_ajuizada" id="dividas_nao_ajuizada" ><label for="dividas_nao_ajuizada"> &nbsp;&nbsp; SÓ DÍVIDA NÃO AJUIZADA</label> 
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="cod_divida">COD DIV:</label>
                                        <input type="text" class="form-control" name ="cod_divida" id="cod_divida"  value="" maxlength="2" placeholder="XX" onkeypress='return SomenteNumero(event)' onblur="buscaDivida(this);"/>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="desc_cod_divida">DESCRIÇÃO:</label>
                                        <input type="text" class="form-control" name ="desc_cod_divida" id="desc_cod_divida"  value="" maxlength="50" placeholder="DESC DIVIDA" readonly="true" />
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <input type="checkbox" name="dividas_aberta" id="dividas_aberta" value="S"><label for="dividas_aberta">&nbsp;&nbsp;DÍVIDAS EM ABERTO</label><br>
                                        <input type="checkbox" name="taxas" id="taxas" value="S"><label for="taxas">&nbsp;&nbsp;TAXAS</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="sub_divida">SUB. DÍV.:</label>
                                        <input type="text" class="form-control" name ="sub_divida" id="sub_divida"  value="" maxlength="2" placeholder="XX" onkeypress='return SomenteNumero(event)' onblur="buscaSubDivida(this);"/>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="ano_inicial">ANO INICIAL:</label>
                                        <input type="text" class="form-control" name ="ano_inicial" id="ano_inicial"  value="" maxlength="4" placeholder="XXXX" onkeypress='return SomenteNumero(event)' onblur="buscaAno(this);"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="ano_final">ANO FINAL:</label>
                                        <input type="text" class="form-control" name ="ano_final" id="ano_final"  value="<?php print date('Y'); ?>" maxlength="4" placeholder="XXXX" onkeypress='return SomenteNumero(event)' onblur="buscaAno(this);"/>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="valor_vencido">VALOR VENCIDO(R$):</label>
                                        <input type="text" class="form-control" name ="valor_vencido" id="valor_vencido"  value="" maxlength="50" placeholder="XXX,XX" readonly="true" />
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="valor_a_vencer">VALOR A VENCER(R$):</label>
                                        <input type="text" class="form-control" name ="valor_a_vencer" id="valor_a_vencer"  value="" maxlength="50" placeholder="XXX,XX" readonly="true" />
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="valor_total">VALOR TOTAL(R$):</label>
                                        <input type="text" class="form-control" name ="valor_total" id="valor_total"  value="" maxlength="50" placeholder="XXX,XX" readonly="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2 ">
                                    <button type="button" class="btn btn-primary" onclick="filtroConsultaFinanceira();">PROCURAR</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- Quarta aba -->
                </div>

            </div><!-- div que posiciona o formulário na tela -->
        </form> <!-- fim do Formulário -->
    </div>
    <?php
}
?>
