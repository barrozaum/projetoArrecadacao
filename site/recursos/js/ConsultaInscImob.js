// funcao
function validaInscricao(campo) {

    // numero da inscricao digitada
    var inscricao = preencheZeros(campo.value, 6);
    campo.value = inscricao;



    if (inscricao > 00000) {
        buscaImovel(inscricao);
    } else {
        limparCampos("");
    }
}



function buscaImovel(inscricao) {

    // inicio uma requisição
    var inscricao_imovel = inscricao;
    limparCampos("...");
    var msg = "";
    msg = msg + "<div class='alert alert-info text-center'>";
    msg = msg + "<strong> PROCURANDO </strong>";
    msg = msg + "</div>";
    $("#msg").html(msg)
    $.ajax({
        // url para o arquivo json.php
        //op == 0 equivale a função retornaCadImob
        url: "recursos/includes/retornaValor/retornaCadastroImovel.php?cod=" + inscricao_imovel + "&op=3",
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            if (data.achou == 1) {
                // mensagem do cabecalho

                insereHistoricoValoVenal(inscricao_imovel);
                insereHistoricoAlugados(inscricao_imovel);
                buscarBairro(data.Cod_Bairro);
                buscarRua(data.Cod_Rua);
                // dados retornado
                //IDENTIFICAÇÃO DO IMÓVEL / PROPRIETÁRIO
                $("#nome_proprietario_imovel").val(data.Proprietario);
                if (data.Tipo_Imposto == 1) {
                    var tipo_ipm = "PREDIAL";
                } else {
                    var tipo_ipm = "TERRITORIAL";
                }
                $("#tipo_imposto_imovel").val(tipo_ipm);
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
                retornaValorCategoria(data.Categoria);
                retornaValorUtilizacao(data.Utilizacao_imovel);
                retornaValorSituacao_Terreno(data.Situacao_Terreno);
                retornaValorPatrimonio(data.Patrimonio_imovel);
                retornaValorTipoColeta(data.Tipo_coleta);
                $("#ano_cadastramento_imovel").val(data.Ano_Cadastramento);


                //ISENÇÃO
                retornaValorTipoIsencao(data.Tipo_isencao);
                $("#fundamento_legal").val(data.Fundamento_Legal_Isencao);
                $("#processo_administrativo").val(data.Proc_Adm_Isencao);
                $("#data_concessao").val(data.Dt_Concessao_Isencao);
                $("#data_averbacao").val(data.Dt_Averbacao);
                $("#numero_processo_averbacao").val(data.Processo_Averbacao);
                selecionar("legalizacao_imovel", data.Legalizado);
                $("#numero_processo_legalizacao").val(data.Processo_Legalizacao);

                // Observacao
                $("#observacao_imovel").val(data.observacao);
                // mensagem do cabecalho
                var msg = "";
                msg = msg + "<div class='alert alert-success text-center'>";
                msg = msg + "<strong> INSCRIÇÃO ENCONTRADA</strong>";
                msg = msg + "</div>";
                $("#msg").html(msg)
            } else {
                limparCampos("");
                // mensagem do cabecalho
                var msg = "";
                msg = msg + "<div class='alert alert-danger text-center'>";
                msg = msg + "<strong> INSCRIÇÃO INVÁLIDA</strong>";
                msg = msg + "</div>";
                $("#msg").html(msg);


            }

        }
    });//termina o ajax
}
;//termina o jquery

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

function buscarBairro(cod_bairro) {
    $.ajax({
        // url para o arquivo json.php
        //op == 2 equivale a função retornaBairro
        url: "recursos/includes/retornaValor/retornaCadastroImovel.php?cod=" + cod_bairro + "&op=2",
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            if (data.achou === "1")
                $("#desc_bairro_imovel").val(data.descricao);
            else {
                $("#desc_bairro_imovel").val("Não encontrado");
                $("#cod_bairro_imovel").val("").focus();
            }
        }
    }); //termina o ajax
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
            } else {
                $("#desc_logr_imovel").val("Não encontrado");
                $("#cod_cep_imovel").val("");
                $("#cod_logr_imovel").val("").focus();
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
        url: "recursos/includes/retornaValor/retornaConsultaInscImob.php?cod=" + insc_imob + "&op=5",
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            if (data[0].Achou == 1) {

                for (var i = 1; i < data.length; i++) {

                    var tabela = "";
                    tabela = tabela + "<div class='panel-body'>";
                    tabela = tabela + "<div style='max-height: 200px; overflow: auto;'>";
                    tabela = tabela + "<table class='table table-bordered table-hover'>";
                    tabela = tabela + "<thead>";
                    tabela = tabela + "<tr>";
                    tabela = tabela + "<th>Processo</th>";
                    tabela = tabela + "<th>Data Inicio</th>";
                    tabela = tabela + "<th>Data Fim</th>";

                    tabela = tabela + "</tr>";
                    tabela = tabela + "</thead>";
                    tabela = tabela + "<tbody>";


                    for (var i = 1; i < data.length; i++) {
                        tabela = tabela + "<tr>";
                        tabela = tabela + "<th>" + data[i].Processo + "</th>";
                        tabela = tabela + "<th>" + data[i].Data_Inicio + "</th>";
                        tabela = tabela + "<th>" + data[i].Data_Fim + "</th>";
                        tabela = tabela + "</tr>";

                    }
                    tabela = tabela + "</tbody>";
                    tabela = tabela + "</table>";
                    tabela = tabela + "</div>";

                    var Titulo_Alugado_Pela_Prefeitura = "";
                    Titulo_Alugado_Pela_Prefeitura = Titulo_Alugado_Pela_Prefeitura + "<div class='well text-center' style='height:10px;'>";
                    Titulo_Alugado_Pela_Prefeitura = Titulo_Alugado_Pela_Prefeitura + " ALUGADO PELA PREFEITURA";
                    Titulo_Alugado_Pela_Prefeitura = Titulo_Alugado_Pela_Prefeitura + "</div>";


                    $("#Titulo_Alugado_Pela_Prefeitura").html(Titulo_Alugado_Pela_Prefeitura);
                    $("#tabela_Alugado_Pela_Prefeitura").html(tabela);

                }

            }

        }
    }); //termina o ajax


}

function limparCampos(mostrarnoCampo) {

    var msg = "";
    $("#msg").html(msg);

    //IDENTIFICAÇÃO DO IMÓVEL / PROPRIETÁRIO
    $("#nome_proprietario_imovel").val(mostrarnoCampo);
    $("#tipo_imposto_imovel").val(mostrarnoCampo);
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

    // Categoria
    $("#desc_categoria").val(mostrarnoCampo);
    $("#categoria").val(mostrarnoCampo);

    // Utilização
    $("#desc_utilizacao").val(mostrarnoCampo);
    $("#utilizacao").val(mostrarnoCampo);

    // Situação Terreno
    $("#desc_situacao_terreno").val(mostrarnoCampo);
    $("#situacao_terreno").val(mostrarnoCampo);

    // Patrimônio Líquido
    $("#desc_patrimonio").val(mostrarnoCampo);
    $("#patrimonio_liquido").val(mostrarnoCampo);

    // Tipo Coleta
    $("#desc_tipo_coleta").val(mostrarnoCampo);
    $("#tipo_coleta").val(mostrarnoCampo);

    // Tipo Isenção
    $("#desc_tipo_isencao").val(mostrarnoCampo);
    $("#tipo_isencao").val(mostrarnoCampo);
    $("#fundamento_legal").val(mostrarnoCampo);
    $("#processo_administrativo").val(mostrarnoCampo);
    $("#data_concessao").val(mostrarnoCampo);
    $("#data_averbacao").val(mostrarnoCampo);
    $("#numero_processo_averbacao").val(mostrarnoCampo);
    selecionar("legalizacao_imovel", "");
    $("#numero_processo_legalizacao").val(mostrarnoCampo);


    // Observacao 
    $("#observacao_imovel").val(mostrarnoCampo);

    // VALOR VENAL
    $("#tabela_valor_venal").html("");
    $("#Titulo_Tabela_Valor_Venal").html("");

    // ALUGADO PELA PREFEITURA
    $("#alugado_pela_prefeitura").load('recursos/includes/funcaoPHP/tabela_alugado_prefeitura.php');
}

function retornaValorCategoria(categoria) {
    $.ajax({
        // url para o arquivo json.php
        //op == 0 equivale a função retornaCadImob
        url: "recursos/includes/funcaoPHP/campo_select_Categoria.php?selecionado=" + categoria,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            console.log(data);
            $('#desc_categoria').val(data.campo1);
            $('#categoria').val(data.campo2);
            return true;
        }
    });
}

function retornaValorUtilizacao(utilizacao) {
    $.ajax({
        // url para o arquivo json.php
        //op == 0 equivale a função retornaCadImob
        url: "recursos/includes/funcaoPHP/campo_select_Utilizacao.php?selecionado=" + utilizacao,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            console.log(data);
            $('#desc_utilizacao').val(data.campo1);
            $('#utilizacao').val(data.campo2);
            return true;
        }
    });
}
function retornaValorSituacao_Terreno(situacao_terreno) {
    $.ajax({
        // url para o arquivo json.php
        //op == 0 equivale a função retornaCadImob
        url: "recursos/includes/funcaoPHP/campo_select_Situacao_Terreno.php?selecionado=" + situacao_terreno,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            console.log(data);
            $('#desc_situacao_terreno').val(data.campo1);
            $('#situacao_terreno').val(data.campo2);
            return true;
        }
    });
}
function retornaValorPatrimonio(patrimonio) {
    $.ajax({
        // url para o arquivo json.php
        //op == 0 equivale a função retornaCadImob
        url: "recursos/includes/funcaoPHP/campo_select_Patrimonio.php?selecionado=" + patrimonio,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            $('#desc_patrimonio').val(data.campo1);
            $('#patrimonio_liquido').val(data.campo2);
            return true;
        }
    });
}
function retornaValorTipoColeta(tipo_coleta) {
    $.ajax({
        // url para o arquivo json.php
        //op == 0 equivale a função retornaCadImob
        url: "recursos/includes/funcaoPHP/campo_select_Tipo_Coleta.php?selecionado=" + tipo_coleta,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            $('#desc_tipo_coleta').val(data.campo1);
            $('#tipo_coleta').val(data.campo2);
            return true;
        }
    });
}
function retornaValorTipoIsencao(isencao) {
    console.log(isencao);
    $.ajax({
        // url para o arquivo json.php
        //op == 0 equivale a função retornaCadImob
        url: "recursos/includes/funcaoPHP/campo_select_Tipo_Isencao.php?selecionado=" + isencao,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            $('#desc_tipo_isencao').val(data.campo1);
            $('#tipo_isencao').val(data.campo2);
            return true;
        }
    });
}