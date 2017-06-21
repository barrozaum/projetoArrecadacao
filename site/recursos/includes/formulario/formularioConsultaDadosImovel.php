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
    <!-- fim doJava script para dar Focus no primeiro Campo do formulário -->
    <div class="row">
        <div class="col-sm-12">
            <div  id="msg"></div>
        </div>
    </div>
    <div class="row">
        <form  method="post" action="" name="formulario_dados_imovel" id="formulario_imovel">   <!-- inicio do formulário --> 
            <div class="mainbox col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
                <div class="well"><!-- div que coloca a cor no formulário -->
                  
                    <div class="panel panel-default">
                        <!-- INICIO Dados do imóvel -->
                        <div class="panel-heading text-center">FILTRO IMÓVEL</div>
                        <div class="panel-body">
                            <!-- inicio dados inscrição-->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nome_proprietario">Nome Proprietário:</label>
                                        <input type="text" class="form-control" name ="nome_proprietario" id="nome_proprietario"  value="" maxlength="50" placeholder="NOME PROPRIETÁRIO" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="tipo_imposto_imovel">Tipo Imposto:</label>
                                        <select name="tipo_imposto_imovel" id="tipo_imposto_imovel" class="form-control">
                                            <option value="">SELECIONE </option>
                                            <option value="1">1 - PREDIAL</option>
                                            <option value="2">2 - TERRITORIAL</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <?php include('../funcaoPHP/campo_select_Tipo_Isencao.php');?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cod_bairro_imovel">Cod Bairro:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" onclick="chamarJanelaBairro()"><i class="glyphicon glyphicon-zoom-in"></i></span>
                                            <input type="text" class="form-control" name ="cod_bairro_imovel" id="cod_bairro_imovel"  value="" maxlength="50" placeholder="000" onblur="retornaDescBairro(this);"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="desc_bairro_imovel">Bairro:</label>
                                        <input type="text" class="form-control" name ="desc_bairro_imovel" id="desc_bairro_imovel"  value="" maxlength="50" placeholder=""  required="true" readonly="true" />
                                        <input type="hidden" class="form-control" name ="bairro_preenchido" id="bairro_preenchido"  value="0" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cod_logr_imovel">Cod Log:</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" onclick="chamarJanelaRua()"><i class="glyphicon glyphicon-zoom-in"></i></span>
                                            <input type="text" class="form-control" name ="cod_logr_imovel" id="cod_logr_imovel"  value="" maxlength="5" placeholder="00000" onblur="retornaDescRua(this);"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="desc_logr_imovel">Logradouro:</label>
                                        <input type="text" class="form-control" name ="desc_logr_imovel" id="desc_logr_imovel"  value="" maxlength="50" placeholder=""  required="true" readonly="true" />
                                        <input type="hidden"  name ="rua_preenchida" id="rua_preenchida" value="0" />
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                               <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="cod_cep_imovel">Cep:</label>
                                        <input type="text" class="form-control" name ="cod_cep_imovel" id="cod_cep_imovel"  value="" readonly="true" required="true" />
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="numero_imov">Número:</label>
                                        <input type="text" class="form-control" name ="numero_imov" id="numero_imov"  value="" maxlength="50" placeholder=""  required="true"  />
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="lote_imov">Lote:</label>
                                        <input type="text" class="form-control" name ="lote_imov" id="lote_imov"  value="" maxlength="50" placeholder=""  required="true"  />
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="quadra_imov">Quadra:</label>
                                        <input type="text" class="form-control" name ="quadra_imov" id="quadra_imov"  value="" maxlength="50" placeholder=""  required="true"  />
                                    </div>
                                </div>
                                
                            </div>


                            <div class="row">
                                <div class="col-sm-2 ">
                                    <button type="button" class="btn btn-primary" onclick="filtroImovel();">PROCURAR</button>
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
