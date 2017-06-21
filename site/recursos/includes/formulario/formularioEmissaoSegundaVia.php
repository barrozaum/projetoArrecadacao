<?php
include_once '../estrutura/controle/validarSessao.php';
//validacao
include_once '../funcaoPHP/function_letraMaiscula.php';
// criacao dos campos inputs 
include_once '../funcaoPHP/funcaoCriacaoInput.php';
?>
<?php
if (empty($_POST['id'])) {
    formularioCadastro();
}
?>

<?php

function formularioCadastro() {
    ?>
    <div id="msg"></div>

    <form name="calculariptu" action="recursos/includes/guias/guia_iptu.php" method="post">
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading text-center" >EMISSÃO 2° VIA DE CARNÊ</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="inscricao">INSCRIÇÃO:</label>
                                    <input type="text" value="" class="form-control" name="inscricao" id="inscricao" onblur="tamanho_campo(this, 'proprietario');" maxlength="6" onkeypress='return SomenteNumero(event)' >
                                </div>
                            </div>

                            <div class="col-sm-4 ">
                                <div class="form-group">
                                    <label for="proprietario">PROPRIETÁRIO:</label>
                                    <input type="text" value="" class="form-control" name="proprietario" id="proprietario" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-6 ">
                                <div class="form-inline text-left ">
                                    &nbsp; &nbsp; &nbsp;<input type="checkbox" class="form-control" name ="listar_debitos_ajuizados" id="listar_debitos_ajuizados" value="S"  />
                                    <label for="listar_debitos_ajuizados">: LISTAR SÓ DÉBITOS EM JUIZO</label>
                                </div> 
                                <div class="form-inline text-left ">
                                    &nbsp; &nbsp; &nbsp;<input type="checkbox" class="form-control" name ="listar_cota_unica" id="listar_cota_unica" value="S" checked  onclick="cota_unica()"/>
                                    <label for="listar_cota_unica">: LISTAR COTA ÚNICA</label>
                                    <input type="hidden" name="checado" id="checado" value="1">
                                </div> 

                            </div>
                        </div>
                    </div>
                    <div class="panel-heading text-center" >DÍVIDAS</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="divida">DIVIDA:</label>
                                    <input type="text" value="" class="form-control" name="divida" id="divida" max="2" onblur="tamanho_campo_divida(this, 'desc_divida');" onkeypress='return SomenteNumero(event)' >
                                </div>
                            </div>

                            <div class="col-sm-4 ">
                                <div class="form-group">
                                    <label for="desc_divida">DESC DIVIDA:</label>
                                    <input type="text" value="" class="form-control" name="desc_divida" id="desc_divida" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="ano_inicial">ANO INICIAL:</label>
                                    <input type="text" value="" class="form-control" name="ano_inicial" id="ano_inicial" maxlength="4" onkeypress='return SomenteNumero(event)' >
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="ano_final">ANO FINAL:</label>
                                    <input type="text" value="<?php print date('Y') ?>" class="form-control" name="ano_final" id="ano_final" maxlength="4" onkeypress='return SomenteNumero(event)' >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="sub_divida">SUB DIVIDA:</label>
                                    <input type="text" value="" class="form-control" name="sub_divida" id="sub_divida" onkeypress='return SomenteNumero(event)' >
                                </div>
                            </div>

                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="parc_inicial">PARC INICIAL:</label>
                                    <input type="text" value="99" class="form-control" name="parc_inicial" id="parc_inicial" readonly="true" onkeypress='return SomenteNumero(event)' >
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="parc_final">PARC FINAL:</label>
                                    <input type="text" value="99" class="form-control" name="parc_final" id="parc_final" readonly="true" onkeypress='return SomenteNumero(event)' >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="num_termo">N° TERMO:</label>
                                    <input type="text" value="" class="form-control" name="num_termo" id="num_termo" onkeypress='return SomenteNumero(event)' >
                                </div>
                            </div>

                            <div class="col-sm-4 ">
                                <div class="form-group">
                                    <label for="ano_termo">ANO TERMO:</label>
                                    <input type="text" value="" class="form-control" name="ano_termo" id="ano_termo" onkeypress='return SomenteNumero(event)' >
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="data">DATA VENCIMENTO:</label>
                                    <input type="text" value="" class="form-control" name="data" id="data" onkeypress='return SomenteNumero(event)' OnKeyUp='return mascaraData(this)'>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-heading text-center" >PAGADOR</div>
                    <div class="panel-body">

                        <div class="row">

                            <div class="col-sm-4 ">
                                <div class="form-group">
                                    <label for="nome_pagador">NOME. :</label>
                                    <input type="text" value="" class="form-control" name="nome_pagador" id="nome_pagador" >
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="cpf_cnpj_pagador">CPF/CNPJ:</label>
                                    <input type="text" class="form-control" name ="cpf_cnpj_pagador" id="cpf_cnpj_pagador"  value="" maxlength="15" placeholder="" onkeypress='return SomenteNumero(event)'  onkeyUp='mascaraMutuario(this, cpfCnpj)' onblur="validar(this, 'tipo_pessoa_pagador')">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="tipo_pessoa_pagador">TIPO PESSOA:</label>
                                    <input type="text" class="form-control" name ="tipo_pessoa_pagador" id="tipo_pessoa_pagador"  value="" required="true" readonly="true"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="cep_pagador">CEP:</label>
                                    <input type="text" value="" class="form-control" name="cep_pagador" id="cep_pagador" onkeypress='return SomenteNumero(event)' onblur="retornaCep(this.id, cep_pagador, rua_pagador, bairro_pagador, cidade_pagador, uf_pagador)" >
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="rua_pagador">RUA :</label>
                                    <input type="text" value="" class="form-control" name="rua_pagador" id="rua_pagador" >
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="numero_end_pagador">N°  :</label>
                                    <input type="text" value="" class="form-control" name="numero_end_pagador" id="numero_end_pagador" >
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="complemento_pagador">COMPLEMENTO  :</label>
                                    <input type="text" value="" class="form-control" name="complemento_pagador" id="complemento_pagador" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="bairro_pagador">BAIRRO :</label>
                                    <input type="text" value="" class="form-control" name="bairro_pagador" id="bairro_pagador" >
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="cidade_pagador">CIDADE:</label>
                                    <input type="text" value="" class="form-control" name="cidade_pagador" id="cidade_pagador" >
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="uf_pagador">UF:</label>
                                    <input type="text" value="" class="form-control" name="uf_pagador" id="uf_pagador">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-left">
                        <button type="button" class="btn btn-success" onclick="enviar_formulario()">Gerar Guia</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
}
?>

