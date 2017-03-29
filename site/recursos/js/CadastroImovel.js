// funcao
function validaInscricao(campo) {

    // numero da inscricao digitada
    var inscricao = preencheZeros(campo.value, 6);
    campo.value = inscricao;
    $("#formulario_imovel").attr("action", "#");
    $("#msg").html("");

    if (inscricao > 00000) {
        procurar(inscricao);
    } else {
        cadastro();
    }
}


function procurar(inscricao) {
    var Inscricao = inscricao;
    limparCampos("...");

    $("#formulario_imovel").attr("action", "recursos/includes/alterar/alterarCadImobiliario.php");

    $.ajax({
        // url para o arquivo json.php
        //op == 0 equivale a função retornaCadImob
        url: "recursos/includes/retornaValor/retornaCadastroImovel.php?cod=" + Inscricao + "&op=3",
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            if (data.achou == 1) {
                //$("#formulario_imovel").attr("action", "recursos/includes/alterar/alterarCadImobiliario.php");
                // mensagem do cabecalho
                var msg = "";
                msg = msg + "<div class='alert alert-info text-center'>";
                msg = msg + "<strong> ALTERAR DADOS IMÓVEL</strong>";
                msg = msg + "</div>";
                $("#msg").html(msg);
                var botoesALTEXC = "";
                botoesALTEXC += "<div class='row'>";
                botoesALTEXC += "<div class='col-md-6 text-left'>";
                botoesALTEXC = botoesALTEXC + '<button type="button" class="btn btn-success" onclick="validarCampos()">ALTERA</button>';
                botoesALTEXC += "</div><div class='col-md-6'>";
                botoesALTEXC = botoesALTEXC + '<button type="button" class="btn btn-danger" id="edit-excluir">EXCLUIR</button>';
                botoesALTEXC += "</div>";
                $("#buttons").html(botoesALTEXC);

                insereHistoricoValoVenal(Inscricao);
                insereHistoricoAlugados(Inscricao);
                insereHistoricoObservacao(data.observacao);



                // dados retornado
                //IDENTIFICAÇÃO DO IMÓVEL / PROPRIETÁRIO
                $("#nome_proprietario_imovel").val(data.Proprietario);
                selecionar("tipo_imposto_imovel", data.Tipo_Imposto);
                checar("cadastro_provisorio", data.cad_provisorio);
                checar("excluido", data.Excluido);
                checar("carne_devolvido", data.carne_devolvido);

                //IDENTIFICAÇÃO DO CONTRIBUINTE
                $("#nome_contribuinte").val(data.nome_contribuinte);
                $("#telefone_contribuinte").val(data.Telefone_Contrib);
                $("#cpf_cnpj_contribuinte").val(data.Cpf_Cgc_Contrib);
                $("#tipo_pessoa_contribuinte").val(data.Tipo_Pessoa_Contrib);
                $("#rg_contribuinte").val(data.RG_Contrib);
                $("#orgao_rg_contribuinte").val(data.Orgao_Contrib);
                $("#emissao_rg_contribuinte").val(data.Emissao_Contrib);
                $("#data_nascimento_contribuinte").val(data.Dt_Nascimento_Contrib);
                $("#cep_contribuinte").val(data.Cep_Contrib);
                $("#rua_contribuinte").val(data.Rua_Contrib);
                $("#bairro_contribuinte").val(data.Bairro_Contrib);
                $("#cidade_contribuinte").val(data.Cidade_Contrib);
                $("#uf_contribuinte").val(data.UF_Contrib);
                $("#numero_end_contribuinte").val(data.Numero_Contrib);
                $("#complemento_end_contribuinte").val(data.Complemento_Contrib);

                //IDENTIFICAÇÃO LOCALIZAÇÃO DO IMÓVEL
                $("#cod_bairro_imovel").val(data.Cod_Bairro);
                buscarBairro(data.Cod_Bairro);
                $("#cod_logr_imovel").val(data.Cod_Rua);
                buscarRua(data.Cod_Rua);
                $("#cod_logr_imovel").val(data.Cod_Rua);
                $("#num_end_imovel").val(data.Numero);
                $("#quadra_imovel").val(data.Quadra);
                $("#lote_imovel").val(data.Lote);
                $("#zona_imovel").val(data.Zona_Fiscal);
                $("#compl_end_imovel").val(data.Complemento);

                //ENDEREÇO CORRESPÔNDENCIA
                $("#nome_responsavel_correspondencia").val(data.Nome_Corr);
                $("#telefone_responsavel_correspondencia").val(data.Telefone);
                $("#cpf_cnpj_correspondencia").val(data.Cpf_Cgc_Corr);
                $("#tipo_pessoa_correspondencia").val(data.Tipo_Pessoa_Corr);
                $("#cep_correspondencia").val(data.Cep_Corr);
                $("#rua_correspondencia").val(data.Rua_Corr);
                $("#bairro_correspondencia").val(data.Bairro_Corr);
                $("#cidade_correspondencia").val(data.Cidade_Corr);
                $("#uf_correspondencia").val(data.Uf_Corr);
                $("#numero_end_correspondencia").val(data.Numero_corr);
                $("#complemento_end_correspondencia").val(data.Complemento_Corr);

                //DIMENSÃO DO IMÓVEL

                $("#largura_terreno_imovel").val(data.Largura_Terreno);
                $("#comprimento_terreno_imovel").val(data.Comprimento_Terreno);
                $("#area_terreno_imovel").val(data.Area_Terreno);
                $("#area_construida_imovel").val(data.Area_Construida);
                $("#fracao_ideal_imovel").val(data.Fracao_Ideal);
                checar("contem_manutencao_esgoto", data.Tem_Manutencao_Esgoto);
                checar("desconto_industria", data.DESCONTO_INDUSTRIA);

                //ESTADO DA CONSTRUÇÃO
                checar("construcao_tijolo", data.EC_Tijolo);
                checar("construcao_madeira", data.EC_Madeira);
                checar("construcao_embocada", data.EC_Embocada);
                checar("construcao_pintada", data.EC_Pintada);
                checar("construcao_telha", data.EC_Telha);
                checar("construcao_laje", data.EC_laje);
                checar("construcao_taco", data.EC_Taco);
                checar("construcao_ceramico", data.EC_Ceramica);
                checar("construcao_outros", data.EC_Outros);
                selecionar("utilizacao", data.Utilizacao_imovel);
                selecionar("situacao_terreno", data.Situacao_Terreno);
                selecionar("categoria", data.Categoria);
                selecionar("patrimonio_liquido", data.Patrimonio_imovel);
                selecionar("tipo_coleta", data.Tipo_coleta);
                $("#ano_cadastramento_imovel").val(data.Ano_Cadastramento);

                //ISENÇÃO
                selecionar("tipo_isencao", data.Tipo_isencao);
                $("#fundamento_legal").val(data.Fundamento_Legal_Isencao);
                $("#processo_administrativo").val(data.Proc_Adm_Isencao);
                $("#data_concessao").val(data.Dt_Concessao_Isencao);
                $("#data_averbacao").val(data.Dt_Averbacao);
                $("#numero_processo_averbacao").val(data.Processo_Averbacao);
                selecionar("legalizacao_imovel", data.Legalizado);
                $("#numero_processo_legalizacao").val(data.Processo_Legalizacao);

            } else {
                cadastro_formulario(Inscricao);
            }
        }

    }); //termina o ajax
}



function cadastro() {
    limparCampos("...");
    $.ajax({
        // url para o arquivo json.php
        //op == 0 equivale a função retornaProximoValor
        url: "recursos/includes/retornaValor/retornaCadastroImovel.php?op=0",
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            cadastro_formulario(preencheZeros(data.achou, 6));

        }
    }); //termina o ajax
}


function cadastro_formulario(inscricao) {
    limparCampos("");
    // acao do formulario
    $("#formulario_imovel").attr("action", "recursos/includes/cadastrar/cadastrarCadImobiliario.php");
    $("#inscricao_imovel").val(inscricao);

    // mensagem do cabecalho
    var msg = "";
    msg = msg + "<div class='alert alert-success text-center'>";
    msg = msg + "<strong> Cadastrar Imóvel</strong>";
    msg = msg + "</div>";
    $("#msg").html(msg);

var button = "";
button += "<div class='row'>";
                button += "<div class='col-md-6 text-left'>";
                button = button + '<button type="button" class="btn btn-success" onclick="validarCampos()">Cad. Imóvel</button>';
                button += "</div>";

    $("#buttons").html(button);


}

function copiarEndereco() {
    // dados vem da aba localizacao imovel
    //carrego os dados
    var cep = $("#cod_cep_imovel").val();
    var bairro = $("#desc_bairro_imovel").val();
    var logradouro = $("#desc_logr_imovel").val();
    var complemento = $("#compl_end_imovel").val();
    var numero = $("#num_end_imovel").val();
    var cidade = "JAPERI";
    var uf = "RJ";

    // insiro nos campos
    $("#cep_correspondencia").val(cep);
    $("#rua_correspondencia").val(logradouro);
    $("#bairro_correspondencia").val(bairro);
    $("#cidade_correspondencia").val(cidade);
    $("#uf_correspondencia").val(uf);
    $("#numero_end_correspondencia").val(numero);
    $("#complemento_end_correspondencia").val(complemento);
}


// busca o nome da RUA de acordo com o código
function retornaDescRua(campo) {

    $("#desc_logr_imovel").val("...");
    $("#cod_cep_imovel").val("...");
    var cod_rua = campo.value;
    cod_rua = preencheZeros(cod_rua, 5);
    campo.value = cod_rua;

    if (cod_rua < "00001") {
        $("#desc_logr_imovel").val("");
        $("#cod_cep_imovel").val("");
    } else
        buscarRua(campo.value);

}

function buscarRua(cod_rua) {
    $.ajax({
        // url para o arquivo json.php
        //op == 1 equivale a função retornaRua
        url: "recursos/includes/retornaValor/retornaCadastroImovel.php?cod=" + cod_rua + "&op=1",
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            if (data.achou === "1") {
                $("#desc_logr_imovel").val(data.descricao);
                $("#cod_cep_imovel").val(data.cep);
                $("#rua_preenchida").val("1");
            } else {
                $("#desc_logr_imovel").val("Não encontrado");
                $("#cod_cep_imovel").val("");
                $("#rua_preenchida").val("0");
                $("#cod_logr_imovel").val("");
            }
        }

    }); //termina o ajax
}


// busca o nome da BAIRRO de acordo com o código
function retornaDescBairro(campo) {
    $("#desc_bairro_imovel").val("...");
    var cod_bairro = campo.value;
    cod_bairro = preencheZeros(cod_bairro, 3);
    campo.value = cod_bairro;

    if (cod_bairro < "001")
        $("#desc_bairro_imovel").val("");
    else
        buscarBairro(cod_bairro);

}

function buscarBairro(cod_bairro) {
    $.ajax({
        // url para o arquivo json.php
        //op == 2 equivale a função retornaBairro
        url: "recursos/includes/retornaValor/retornaCadastroImovel.php?cod=" + cod_bairro + "&op=2",
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            if (data.achou === "1") {
                $("#desc_bairro_imovel").val(data.descricao);
                $("#bairro_preenchido").val("1");
            } else {
                $("#desc_bairro_imovel").val("Não encontrado");
                $("#bairro_preenchido").val("0");
                $("#cod_bairro_imovel").val("");
            }
        }
    }); //termina o ajax
}


//seleciona o campo do chebox escolhido
function checar(campo, value)
{
    if (value == "S")
        $("#" + campo).prop("checked", true);
    else
        $("#" + campo).prop("checked", false);
}



//seleciona o campo do select escolhido
function selecionar(campo, valor)
{
    var combo = document.getElementById(campo);

    for (var i = 0; i < combo.options.length; i++)
    {
        if (combo.options[i].value == valor)
        {
            combo.options[i].selected = "true";
            break;
        }
    }
}


// insere zeros a esquerda
function preencheZeros(obj, tam)
{
    var qtd_zeros, zeros, i;
    qtd_zeros = (tam - obj.length);
    zeros = '';
    for (i = 1; i <= qtd_zeros; i++) {
        zeros = '0' + zeros;
    }
    return zeros + obj;
}

//zerar formulario
function insereHistoricoObservacao(observacao) {

    // coloco o campo oservação maior
    var campoObservacao = "";
    campoObservacao = campoObservacao + "<div class='col-md-12'>";
    campoObservacao = campoObservacao + "<textarea rows='4' class='form-control' name='historico_observacao_imovel' id='historico_observacao_imovel' readonly='TRUE'>" + observacao + "</textarea>";
    campoObservacao = campoObservacao + "</div>";
    $("#mostra_campo_observação").html(campoObservacao);


}


function insereHistoricoValoVenal(insc_imob) {
    $.ajax({
        // url para o arquivo json.php
        //op == 2 equivale a função retornaBairro
        url: "recursos/includes/retornaValor/retornaCadastroImovel.php?cod=" + insc_imob + "&op=4",
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            if (data[0].Achou == 1) {
                var tabela = "";
                tabela = tabela + "<div class='panel-body'>";
                tabela = tabela + "<div style='max-height: 200px; overflow: auto;'>";
                tabela = tabela + "<table class='table table-bordered table-hover'>";
                tabela = tabela + "<thead>";
                tabela = tabela + "<tr>";
                tabela = tabela + "<th>Ano</th>";
                tabela = tabela + "<th>Valor</th>";
                tabela = tabela + "<th>Alíquota</th>";
                tabela = tabela + "<th>Data Calculo</th>";
                tabela = tabela + "</tr>";
                tabela = tabela + "</thead>";
                tabela = tabela + "<tbody>";


                for (var i = 1; i < data.length; i++) {
                    tabela = tabela + "<tr>";
                    tabela = tabela + "<th>" + data[i].Ano + "</th>";
                    tabela = tabela + "<th>" + data[i].Valor + "</th>";
                    tabela = tabela + "<th>" + data[i].Aliquota + "</th>";
                    tabela = tabela + "<th>" + data[i].Data_Calculo + "</th>";
                    tabela = tabela + "</tr>";

                }
                tabela = tabela + "</tbody>";
                tabela = tabela + "</table>";
                tabela = tabela + "</div>";

                var Titulo_Tabela_Valor_Venal = "";
                Titulo_Tabela_Valor_Venal = Titulo_Tabela_Valor_Venal + "<div class='well text-center' style='height:10px;'>";
                Titulo_Tabela_Valor_Venal = Titulo_Tabela_Valor_Venal + " VALOR VENAL";
                Titulo_Tabela_Valor_Venal = Titulo_Tabela_Valor_Venal + "</div>";


                $("#Titulo_Tabela_Valor_Venal").html(Titulo_Tabela_Valor_Venal);
                $("#tabela_valor_venal").html(tabela);

            } else {
                $("#tabela_valor_venal").html("");
                $("#Titulo_Tabela_Valor_Venal").html("");
            }

        }
    }); //termina o ajax
}

function insereHistoricoAlugados(insc_imob) {


    $.ajax({
        // url para o arquivo json.php
        //op == 2 equivale a função retornaBairro
        url: "recursos/includes/retornaValor/retornaCadastroImovel.php?cod=" + insc_imob + "&op=5",
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            if (data[0].Achou == 1) {

                for (var i = 1; i < data.length; i++) {

                    var newRow = $("<tr>");
                    var cols = "";
                    var numeroContratoAluguel = data[i].Processo;
                    var dataInicialContrato = data[i].Data_Inicio;
                    var dataFinalContrato = data[i].Data_Fim;


                    cols += '<td>     <input type="text" class="form-control" name ="numeroProcessoAluguel[]"  required="true" value="' + numeroContratoAluguel + '" maxlength="11" placeholder="000000" readonly="true"/></td>';
                    cols += '<td>     <input type="text" class="form-control" name ="dataInicialProcessoAluguel[]" required="true" value="' + dataInicialContrato + '" maxlength="12" placeholder="00/00/0000" readonly="true"/></td>';
                    cols += '<td>     <input type="text" class="form-control" name ="dataFinalProcessoAluguel[]"  required="true" value="' + dataFinalContrato + '" maxlength="12" placeholder="00/00/0000" readonly="true"/></td>';

                    cols += '<td class="actions">';
                    cols += '<button class="btn btn-large btn-danger" onclick="RemoveTableRow(this)" type="button">Remover</button>';
                    cols += '</td>';

                    newRow.append(cols);

                    $("#tabela-contrato").append(newRow);

                }

            }

        }
    }); //termina o ajax


}

function limparCampos(mostrarnoCampo) {
    $("#msg_erro").html("");


    //IDENTIFICAÇÃO DO IMÓVEL / PROPRIETÁRIO
    $("#nome_proprietario_imovel").val(mostrarnoCampo);
    selecionar("tipo_imposto_imovel", "");
    checar("cadastro_provisorio", "");
    checar("excluido", "");
    checar("carne_devolvido", "");


    //IDENTIFICAÇÃO DO CONTRIBUINTE
    $("#nome_contribuinte").val(mostrarnoCampo);
    $("#telefone_contribuinte").val(mostrarnoCampo);
    $("#cpf_cnpj_contribuinte").val(mostrarnoCampo);
    $("#tipo_pessoa_contribuinte").val(mostrarnoCampo);
    $("#rg_contribuinte").val(mostrarnoCampo);
    $("#orgao_rg_contribuinte").val(mostrarnoCampo);
    $("#emissao_rg_contribuinte").val(mostrarnoCampo);
    $("#data_nascimento_contribuinte").val(mostrarnoCampo);
    $("#cep_contribuinte").val(mostrarnoCampo);
    $("#rua_contribuinte").val(mostrarnoCampo);
    $("#bairro_contribuinte").val(mostrarnoCampo);
    $("#cidade_contribuinte").val(mostrarnoCampo);
    $("#uf_contribuinte").val(mostrarnoCampo);
    $("#numero_end_contribuinte").val(mostrarnoCampo);
    $("#complemento_end_contribuinte").val(mostrarnoCampo);

    //IDENTIFICAÇÃO LOCALIZAÇÃO DO IMÓVEL
    $("#cod_bairro_imovel").val(mostrarnoCampo);
    $("#desc_bairro_imovel").val(mostrarnoCampo);
    $("#desc_logr_imovel").val(mostrarnoCampo);
    $("#cod_cep_imovel").val(mostrarnoCampo);
    $("#cod_logr_imovel").val(mostrarnoCampo);
    $("#num_end_imovel").val(mostrarnoCampo);
    $("#quadra_imovel").val(mostrarnoCampo);
    $("#lote_imovel").val(mostrarnoCampo);
    $("#zona_imovel").val(mostrarnoCampo);
    $("#compl_end_imovel").val(mostrarnoCampo);

    //ENDEREÇO CORRESPÔNDENCIA
    $("#nome_responsavel_correspondencia").val(mostrarnoCampo);
    $("#telefone_responsavel_correspondencia").val(mostrarnoCampo);
    $("#cpf_cnpj_correspondencia").val(mostrarnoCampo);
    $("#tipo_pessoa_correspondencia").val(mostrarnoCampo);
    $("#cep_correspondencia").val(mostrarnoCampo);
    $("#rua_correspondencia").val(mostrarnoCampo);
    $("#bairro_correspondencia").val(mostrarnoCampo);
    $("#cidade_correspondencia").val(mostrarnoCampo);
    $("#uf_correspondencia").val(mostrarnoCampo);
    $("#numero_end_correspondencia").val(mostrarnoCampo);
    $("#complemento_end_correspondencia").val(mostrarnoCampo);

    //DIMENSÃO DO IMÓVEL

    $("#largura_terreno_imovel").val(mostrarnoCampo);
    $("#comprimento_terreno_imovel").val(mostrarnoCampo);
    $("#area_terreno_imovel").val(mostrarnoCampo);
    $("#area_construida_imovel").val(mostrarnoCampo);
    $("#fracao_ideal_imovel").val(mostrarnoCampo);
    checar("contem_manutencao_esgoto", "");
    checar("desconto_industria", "");

    //ESTADO DA CONSTRUÇÃO
    checar("construcao_tijolo", "");
    checar("construcao_madeira", "");
    checar("construcao_embocada", "");
    checar("construcao_pintada", "");
    checar("construcao_telha", "");
    checar("construcao_laje", "");
    checar("construcao_taco", "");
    checar("construcao_ceramico", "");
    checar("construcao_outros", "");
    selecionar("utilizacao", "");
    selecionar("situacao_terreno", "");
    selecionar("categoria", "");
    selecionar("patrimonio_liquido", "");
    selecionar("tipo_coleta", "");
    $("#ano_cadastramento_imovel").val(mostrarnoCampo);

    //ISENÇÃO
    selecionar("tipo_isencao", "");
    $("#fundamento_legal").val(mostrarnoCampo);
    $("#processo_administrativo").val(mostrarnoCampo);
    $("#data_concessao").val(mostrarnoCampo);
    $("#data_averbacao").val(mostrarnoCampo);
    $("#numero_processo_averbacao").val(mostrarnoCampo);
    selecionar("legalizacao_imovel", "");
    $("#numero_processo_legalizacao").val(mostrarnoCampo);


    // Observacao 
    $("#mostra_campo_observação").html("");

    // VALOR VENAL
    $("#tabela_valor_venal").html("");
    $("#Titulo_Tabela_Valor_Venal").html("");

    // ALUGADO PELA PREFEITURA
    $("#alugado_pela_prefeitura").load('recursos/includes/funcaoPHP/tabela_alugado_prefeitura.php');
}


$(function () {
    $(document).on('click', '#edit-excluir', function (e) {
        e.preventDefault();


        $(".modal-content").html('');
        $(".modal-content").addClass('loader');
        $("#dialog-example").modal('show');
        $.post('recursos/includes/formulario/formularioCadastroImovel.php',
                {id: 2,
                    codigo: $('#inscricao_imovel').val(),
                    nome: $('#nome_proprietario_imovel').val()
                },
        function (html) {
            $(".modal-content").removeClass('loader');
            $(".modal-content").html(html);
        }
        );
    });

    $(document).on('change', '#tipo_isencao', function (e) {

        var tipo_isencao = document.getElementById('tipo_isencao').value;
        if (tipo_isencao < '2') {
            $("#fundamento_legal").prop('readonly', true);
            $("#processo_administrativo").prop('readonly', true);
            $("#data_concessao").prop('readonly', true);

            document.getElementById('fundamento_legal').value = "";
            document.getElementById('processo_administrativo').value = "";
            document.getElementById('data_concessao').value = "";
        } else {
            $("#fundamento_legal").prop('readonly', false);
            $("#processo_administrativo").prop('readonly', false);
            $("#data_concessao").prop('readonly', false);
        }

    });
});


function validarCampos() {
    $("#msg_erro").html("");
    var msg = "";

    var nome_proprietario = document.getElementById('nome_proprietario_imovel').value;
    var nome_contribuinte = document.getElementById('nome_contribuinte').value;
    var cpf_cnpj_contribuinte = document.getElementById('cpf_cnpj_contribuinte').value;
    var tipo_pessoa_contribuinte = document.getElementById('tipo_pessoa_contribuinte').value;
    var cep_contribuinte = document.getElementById('cep_contribuinte').value;
    var cod_bairro_imovel = document.getElementById('cod_bairro_imovel').value;
    var desc_bairro_imovel = document.getElementById('desc_bairro_imovel').value;
    var cod_logr_imovel = document.getElementById('cod_logr_imovel').value;
    var desc_logr_imovel = document.getElementById('desc_logr_imovel').value;
    var cod_cep_imovel = document.getElementById('cod_cep_imovel').value;
    var num_end_imovel = document.getElementById('num_end_imovel').value;
    var nome_responsavel_correspondencia = document.getElementById('nome_responsavel_correspondencia').value;
    var cpf_cnpj_correspondencia = document.getElementById('cpf_cnpj_correspondencia').value;
    var tipo_pessoa_correspondencia = document.getElementById('tipo_pessoa_correspondencia').value;
    var cep_correspondencia = document.getElementById('cep_correspondencia').value;
    var numero_end_correspondencia = document.getElementById('numero_end_correspondencia').value;
    var largura_terreno_imovel = document.getElementById('largura_terreno_imovel').value;
    var comprimento_terreno_imovel = document.getElementById('comprimento_terreno_imovel').value;
    var area_terreno_imovel = document.getElementById('area_terreno_imovel').value;
    var area_construida_imovel = document.getElementById('area_construida_imovel').value;
    var fracao_ideal_imovel = document.getElementById('fracao_ideal_imovel').value;
    var utilizacao = document.getElementById('utilizacao').value;
    var situacao_terreno = document.getElementById('situacao_terreno').value;
    var categoria = document.getElementById('categoria').value;
    var patrimonio_liquido = document.getElementById('patrimonio_liquido').value;
    var tipo_coleta = document.getElementById('tipo_coleta').value;
    var tipo_isencao = document.getElementById('tipo_isencao').value;
    var fundamento_legal = document.getElementById('fundamento_legal').value;
    var processo_administrativo = document.getElementById('processo_administrativo').value;
    var data_concessao = document.getElementById('data_concessao').value;


    if (nome_proprietario === "") {
        msg = msg + "IDENTIFICAÇÃO DO CONTRIBUINTE <BR />";
        msg = msg + "* POR FAVOR PREENCHER O NOME DO PROPRIETÁRIO ";
    }
    else if (nome_contribuinte === "") {
        msg = msg + "IDENTIFICAÇÃO DO CONTRIBUINTE <BR />";
        msg = msg + "* POR FAVOR PREENCHER O NOME DO CONTRIBUINTE";
    }
    else if (cpf_cnpj_contribuinte === "") {
        msg = msg + "IDENTIFICAÇÃO DO CONTRIBUINTE <BR />";
        msg = msg + "* POR FAVOR PREENCHER O CPF/CNPJ DO CONTRIBUINTE ";
    }
    else if (tipo_pessoa_contribuinte === "") {
        msg = msg + "IDENTIFICAÇÃO DO CONTRIBUINTE <BR />";
        msg = msg + "* POR FAVOR PREENCHER O TIPO PESSOA DO CONTRIBUINTE ";
    }
    else if (cep_contribuinte === "") {
        msg = msg + "IDENTIFICAÇÃO DO CONTRIBUINTE <BR />";
        msg = msg + "* POR FAVOR PREENCHER O CEP DO CONTRIBUINTE ";
    }
    else if (cod_bairro_imovel === "") {
        msg = msg + "IDENTIFICAÇÃO LOCALIZAÇÃO DO IMÓVEL <BR />";
        msg = msg + "* POR FAVOR PREENCHER O COD BAIRRO DO IMÓVEL";
    }
    else if (desc_bairro_imovel === "" || desc_bairro_imovel === "Não encontrado") {
        msg = msg + "IDENTIFICAÇÃO LOCALIZAÇÃO DO IMÓVEL <BR />";
        msg = msg + "* POR FAVOR PREENCHER O BAIRRO DO IMÓVEL";
    }
    else if (cod_logr_imovel === "") {
        msg = msg + "IDENTIFICAÇÃO LOCALIZAÇÃO DO IMÓVEL <BR />";
        msg = msg + "* POR FAVOR PREENCHER O COD LOG DO IMÓVEL:";
    }
    else if (desc_logr_imovel === "" || desc_bairro_imovel === "Não encontrado") {
        msg = msg + "IDENTIFICAÇÃO LOCALIZAÇÃO DO IMÓVEL <BR />";
        msg = msg + "* POR FAVOR PREENCHER O LOGRADOURO DO IMÓVEL:";
    }
    else if (cod_cep_imovel === "") {
        msg = msg + "IDENTIFICAÇÃO LOCALIZAÇÃO DO IMÓVEL <BR />";
        msg = msg + "* POR FAVOR PREENCHER O CEP DO IMÓVEL:";
    }
    else if (num_end_imovel === "") {
        msg = msg + "IDENTIFICAÇÃO LOCALIZAÇÃO DO IMÓVEL <BR />";
        msg = msg + "* POR FAVOR PREENCHER O NUMERO DO IMÓVEL:";
    }
    else if (nome_responsavel_correspondencia === "") {
        msg = msg + "ENDEREÇO CORRESPÔNDENCIA <BR />";
        msg = msg + "* POR FAVOR PREENCHER O NOME DO CORRESPONDENTE :";
    }
    else if (cpf_cnpj_correspondencia === "") {
        msg = msg + "ENDEREÇO CORRESPÔNDENCIA <BR />";
        msg = msg + "* POR FAVOR PREENCHER O CPF/CNPJ DO CORRESPONDENTE :";
    }
    else if (tipo_pessoa_correspondencia === "") {
        msg = msg + "ENDEREÇO CORRESPÔNDENCIA <BR />";
        msg = msg + "* POR FAVOR PREENCHER O TIPO PESSOA DO CORRESPONDENTE :";
    }
    else if (cep_correspondencia === "") {
        msg = msg + "ENDEREÇO CORRESPÔNDENCIA <BR />";
        msg = msg + "* POR FAVOR PREENCHER O CEP DO CORRESPONDENTE :";
    }
    else if (numero_end_correspondencia === "") {
        msg = msg + "ENDEREÇO CORRESPÔNDENCIA <BR />";
        msg = msg + "* POR FAVOR PREENCHER O NÚMERO ENDEREÇO DO CORRESPONDENTE :";
    }
    else if (largura_terreno_imovel === "") {
        msg = msg + "DIMENSÃO DO IMÓVEL <BR />";
        msg = msg + "* POR FAVOR PREENCHER A LARGURA DO IMÓVEL:";
    }
    else if (comprimento_terreno_imovel === "") {
        msg = msg + "DIMENSÃO DO IMÓVEL <BR />";
        msg = msg + "* POR FAVOR PREENCHER O COMPRIMENTO DO IMÓVEL:";
    }
    else if (area_terreno_imovel === "") {
        msg = msg + "DIMENSÃO DO IMÓVEL <BR />";
        msg = msg + "* POR FAVOR PREENCHER A ÁREA DO IMÓVEL:";
    }
    else if (area_construida_imovel === "") {
        msg = msg + "DIMENSÃO DO IMÓVEL <BR />";
        msg = msg + "* POR FAVOR PREENCHER A ÁREA CONSTRUÍDA DO IMÓVEL:";
    }
    else if (fracao_ideal_imovel === "") {
        msg = msg + "DIMENSÃO DO IMÓVEL <BR />";
        msg = msg + "* POR FAVOR PREENCHER A FRAÇÃO IDEAL DO IMÓVEL:";
    }
    else if (utilizacao === "") {
        msg = msg + "ESTADO DA CONSTRUÇÃO <BR />";
        msg = msg + "* POR FAVOR PREENCHER A UTILIZAÇÃO DO IMÓVEL:";
    }
    else if (situacao_terreno === "") {
        msg = msg + "ESTADO DA CONSTRUÇÃO <BR />";
        msg = msg + "* POR FAVOR PREENCHER A SITUAÇÃO DO TERRENO DO IMÓVEL:";
    }
    else if (categoria === "") {
        msg = msg + "ESTADO DA CONSTRUÇÃO <BR />";
        msg = msg + "* POR FAVOR PREENCHER A CATEGORIA DO IMÓVEL:";
    }
    else if (patrimonio_liquido === "") {
        msg = msg + "ESTADO DA CONSTRUÇÃO <BR />";
        msg = msg + "* POR FAVOR PREENCHER O PATRIMÔNIO LÍQUIDO DO IMÓVEL:";
    }
    else if (tipo_coleta === "") {
        msg = msg + "ESTADO DA CONSTRUÇÃO <BR />";
        msg = msg + "* POR FAVOR PREENCHER O TIPO COLETA DO IMÓVEL:";
    }
    else if (tipo_isencao === "") {
        msg = msg + "ISENÇÃO <BR />";
        msg = msg + "* POR FAVOR PREENCHER O TIPO ISENÇÃO DO IMÓVEL:";
    } else if (tipo_isencao > "1") {
        if (fundamento_legal === "") {
            msg = msg + "ISENÇÃO <BR />";
            msg = msg + "* POR FAVOR PREENCHER A FUNDAMENTACAO:";
        } else if (processo_administrativo === "") {
            msg = msg + "ISENÇÃO <BR />";
            msg = msg + "* POR FAVOR PREENCHER PROCESSO ADMINISTRATIVO:";
        } else if (data_concessao === "" || data_concessao === '00/00/0000') {
            msg = msg + "ISENÇÃO <BR />";
            msg = msg + "* POR FAVOR PREENCHER A DATA CONCESSÃO:";
        }
    }

    if (msg !== "") {
        msg = "<div class='alert alert-danger text-left'>" + msg + "</div>";
        $("#msg_erro").html(msg);
    } else {
        document.formulario_imovel.submit();
    }
}