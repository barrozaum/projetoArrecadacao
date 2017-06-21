$(function () {
    // quando o campo código sofrer alteração executo
    $(document).on('blur', "#id_numero_docarj", function (e) {
        // pego o valor informado no campo
        // coloco no formato correto 
        // atribuo o valor formatado na variavel valor
        var valor = preencheZeros(this.value, 6);
        //    comparo se o valor é menor que
        if (valor < '000001') {
            //        zero o campo cdigo
            $(this).val('000000');

        } else {
            //  atribuo o valor informado pelo usario no campo
            $(this).val(valor);

        }

    });

    // quando o campo código sofrer alteração executo
    $(document).on('blur', "#id_ano_docarj", function (e) {
        // pego o valor informado no campo
        // coloco no formato correto 
        // atribuo o valor formatado na variavel valor
        var valor = preencheZeros(this.value, 4);
        //    comparo se o valor é menor que
        if (valor < '0001') {
            //        zero o campo cdigo
            $(this).val('0000');

        } else {
            //        atribuo o valor informado pelo usario no campo
            $(this).val(valor);

        }
        limpar_formulario_docarj();
        $("#msg_error").html('');
        controllerAcao();
    });


    //    função que vai buscar as receitas de acordo com o cadastro escolhido 
    $(document).on('change', '#id_cadastro_contribuinte', function () {

        var codigo_cadastro = $(this).val();

        if (codigo_cadastro == 1) {
            $('#id_inscricao_contribuinte').removeAttr("readonly");
        } else {
            $('#id_inscricao_contribuinte').attr('readonly', 'true').val('');
        }
        preencher_campo_select_receitas(codigo_cadastro, "", "", "", "");
    });


    //    funcão que desbloqueia campos 
    $(document).on('change', '#id_receita_1', function (e) {
        if ($(this).val() !== "") {
            $('#id_valor_1').removeAttr("readonly");
            $('#id_valor_1').attr('onKeyPress', 'return formatarValor(this, ".", ",", event)');
            $('#id_obs_1').removeAttr("readonly");
        } else {
            $('#id_valor_1').attr('readonly', 'true').val('00,00');
            $('#id_valor_1').removeAttr('onKeyPress');
            $('#id_obs_1').attr('readonly', 'true').val('');
            soma_valor_docar();

        }

    });
    $(document).on('change', '#id_receita_2', function (e) {
        if ($(this).val() !== "") {
            $('#id_valor_2').removeAttr("readonly");
            $('#id_valor_2').attr('onKeyPress', 'return formatarValor(this, ".", ",", event)');
            $('#id_obs_2').removeAttr("readonly");
        } else {
            $('#id_valor_2').attr('readonly', 'true').val('00,00');
            $('#id_valor_2').removeAttr('onKeyPress');
            $('#id_obs_2').attr('readonly', 'true').val('');
            soma_valor_docar();

        }

    });
    $(document).on('change', '#id_receita_3', function (e) {
        if ($(this).val() !== "") {

            $('#id_valor_3').removeAttr("readonly");
            $('#id_valor_3').attr('onKeyPress', 'return formatarValor(this, ".", ",", event)');
            $('#id_obs_3').removeAttr("readonly");
        } else {
            $('#id_valor_3').attr('readonly', 'true').val('00,00');
            $('#id_valor_3').removeAttr('onKeyPress');
            $('#id_obs_3').attr('readonly', 'true').val('');
            soma_valor_docar();

        }

    });
    $(document).on('change', '#id_receita_4', function (e) {
        if ($(this).val() !== "") {
            $('#id_valor_4').removeAttr("readonly");
            $('#id_valor_4').attr('onKeyPress', 'return formatarValor(this, ".", ",", event)');
            $('#id_obs_4').removeAttr("readonly");
        } else {
            $('#id_valor_4').attr('readonly', 'true').val('00,00');
            $('#id_valor_4').removeAttr('onKeyPress');
            $('#id_obs_4').attr('readonly', 'true').val('');
            soma_valor_docar();

        }

    });

    //   FAZ O SOMATÓRIO DO VALOR DO DOCARJ
    $(document).on('blur', '#id_valor_1', function (e) {
        soma_valor_docar($(this).val());
    });
    $(document).on('blur', '#id_valor_2', function (e) {
        soma_valor_docar($(this).val());
    });
    $(document).on('blur', '#id_valor_3', function (e) {
        soma_valor_docar($(this).val());
    });
    $(document).on('blur', '#id_valor_4', function (e) {
        soma_valor_docar($(this).val());
    });
    $(document).on('blur', '#id_taxa_expediente', function (e) {
        soma_valor_docar($(this).val());
    });
    $(document).on('blur', '#id_multas', function (e) {
        soma_valor_docar($(this).val());
    });
    $(document).on('blur', '#id_juros', function (e) {
        soma_valor_docar($(this).val());
    });




    //    PREENCHE CAMPOS PELA INSCRICAO DO IMÓVEL
    $(document).on('blur', '#id_inscricao_contribuinte', function (e) {
        if (this.value != "") {
            //            colocar zeros no campos
            var valor = preencheZeros(this.value, 6);
            //            coloca no formulario o valor do campo
            $(this).val(valor);

            //            chama a função que mostra os dados da inscricao;
            retorna_dados_imovel(valor);
        }
    });


    $(document).on('click', '#validar_form', function (e) {
        var msg = "";
        var numero = $("#id_numero_docarj").val();
        var ano = $("#id_ano_docarj").val();
        var descricao_atividade_docajr = $("#id_descricao_atividade_Docarj").val();
        var cadastro_contribuinte = $("#id_cadastro_contribuinte").val();
        var nome_contribuinte = $("#id_nome_contribuinte").val();
        var cpf_cnpj = $("#id_cpf_cnpj").val();
        var tipo_pessoa = $("#id_tipo_pessoa").val();
        var telefone = $("#id_telefone").val();
        var cep = $("#id_cep").val();
        var rua = $("#id_rua").val();
        var receita_1 = $('#id_receita_1').val();
        var valor_1 = $('#id_valor_1').val();
        var receita_2 = $('#id_receita_2').val();
        var valor_2 = $('#id_valor_2').val();
        var receita_3 = $('#id_receita_3').val();
        var valor_3 = $('#id_valor_3').val();
        var receita_4 = $('#id_receita_4').val();
        var valor_4 = $('#id_valor_4').val();
        var dt_final = $('#id_dt_final').val();
        var quantidade_parcelas = $('#id_quantidade_parcelas').val();
        var parcela_inicial = $('#id_parcela_inicial').val();



        if (numero.length !== 6) {
            msg += "<li>NÚMERO DOCARJ INVÁLIDO !!! </li><BR />";
        }
        if (ano.length !== 4) {
            msg += "ANO DOCARJ INVÁLIDO !!! <BR />";
        }
        if (descricao_atividade_docajr.length < 3) {
            msg += "DESCRIÇÃO DOCARJ INVÁLIDO !!! <BR />";
        }
        if (cadastro_contribuinte < 1 || cadastro_contribuinte > 5) {
            msg += "CADASTRO DOCARJ INVÁLIDO !!! <BR />";
        }
        if (nome_contribuinte.length < 3 || nome_contribuinte > 50) {
            msg += "NOME CONTRIBUINTE DOCARJ INVÁLIDO !!! <BR />";
        }
        if (cpf_cnpj.length < 11 || cpf_cnpj > 13 || cpf_cnpj === "00.000.000/0000-00") {
            msg += "CPF_CNPJ CONTRIBUINTE DOCARJ INVÁLIDO !!! <BR />";
        }
        if (rua === "...") {
            msg += "POR FAVOR AGUARDE A BUSCA DO CEP !!! <BR />";
        }
        if (tipo_pessoa !== "FISICA" && tipo_pessoa !== "JURIDICA") {
            msg += "TIPO PESSOA CONTRIBUINTE DOCARJ INVÁLIDO !!! <BR />";
        }
        if (telefone.length < 10 || telefone.length > 11) {
            msg += "TELEFONE CONTRIBUINTE DOCARJ INVÁLIDO !!! <BR />";
        }
        if (cep.length !== 8) {
            msg += "CEP CONTRIBUINTE DOCARJ INVÁLIDO !!! <BR />";
        }
        if (receita_1 === "" && receita_2 === "" && receita_3 === "" && receita_4 === "") {
            msg += "NENHUMA RECEITA DO DOCARJ SELECIONADA!!! <BR />";
        }
        if (receita_1 !== "" && valor_1.length < 3) {
            msg += "VALOR DA RECEITA 1 INVÁLIDO!!! <BR />";
        }
        if (receita_2 !== "" && valor_2.length < 3) {
            msg += "VALOR DA RECEITA 2 INVÁLIDO!!! <BR />";
        }
        if (receita_3 !== "" && valor_3.length < 3) {
            msg += "VALOR DA RECEITA 3 INVÁLIDO!!! <BR />";
        }
        if (receita_4 !== "" && valor_4.length < 3) {
            msg += "VALOR DA RECEITA 4 INVÁLIDO!!! <BR />";
        }

        if (dt_final === "") {
            msg += "VENCIMENTO INVÁLIDO!!! <BR />";
        } else {
            var objDate = new Date();
            objDate.setYear(dt_final.split("/")[2]);
            objDate.setMonth(dt_final.split("/")[1] - 1);//- 1 pq em js é de 0 a 11 os meses
            objDate.setDate(dt_final.split("/")[0]);

            if (objDate.getTime() <= new Date().getTime()) {
                msg += "VENCIMENTO INVÁLIDO!!! <BR />";
            }
        }
        if (quantidade_parcelas.length < 2 || quantidade_parcelas < 01) {
            msg += "QUANTIDADE PARCELA INVÁLIDA!!! <BR />";
        }
        if (parcela_inicial.length < 2 || parcela_inicial < 01) {
            msg += "PARCELA INICIAL INVÁLIDA!!! <BR />";
        }
        if (msg !== "") {
            $("#msg_error").html("<div class='alert alert-danger'><ol>" + msg + "</ol></div> ");
        } else {
            document.formulario_docarj.submit();
        }


    });
});


// controla qual ação vai ter o formulário
function controllerAcao() {
    $("#msg").html('');
    $("#msg_erro").html('');
    $("#divButonn").html('');
    var param1 = $('#id_numero_docarj').val();
    var param2 = $('#id_ano_docarj').val();


    if (param1 === "" || param2 === "" || param1 < '000001' || param2 < '1990') {

        cadastrar();
    } else {
        alterar(param1, param2);
    }
}

function alterar(param1, param2) {
    $.ajax({
        method: "post",
        url: "recursos/includes/retornaValor/retornaDocarj.php",
        data: {
            op: 3,
            numero_docarj: param1,
            ano_docarj: param2
        },
        dataType: 'json',
        success: function (data) {

            if (data.achou == 0) {
                $("#msg").html('<div class="alert alert-success" style="text-align:center; font-size:15px;"><strong>Cadastrar </strong></div>');
                $("#divButonn").html('<button type="button" class="btn btn-success" id="validar_form" >Cadastrar DOCARJ</button>');
            } else {
                $('#id_atividade_Docarj').val(data.codigo_atividade);
                $('#id_descricao_atividade_Docarj').val(data.descricao_atividade);
                selecionar('id_cadastro_contribuinte', data.codigo_cadastro);
                preencher_campo_select_receitas(data.codigo_cadastro, data.receita_1, data.receita_2, data.receita_3, data.receita_4);
                if (data.codigo_cadastro == 1) {
                    $('#id_inscricao_contribuinte').removeAttr("readonly");

                }
                $('#id_inscricao_contribuinte').val(data.inscricao);
                $('#id_nome_contribuinte').val(data.nome_contribuinte);
                $('#id_cpf_cnpj').val(data.cpf_cnpj);
                $('#id_tipo_pessoa').val(data.tipo_pessoa);
                $('#id_telefone').val(data.telefone);
                $('#id_cep').val(data.cep);
                $('#id_rua').val(data.rua);
                $('#id_bairro').val(data.bairro);
                $('#id_cidade').val(data.cidade);
                $('#id_uf').val(data.uf);
                $('#id_numero_endereco').val(data.numero_endereco);
                $('#id_complemento_endereco').val(data.complemento_endereco);
                $('#id_valor_1').val(data.valor_1);
                $('#id_obs_1').val(data.obs_1);
                $('#id_valor_2').val(data.valor_2);
                $('#id_obs_2').val(data.obs_2);
                $('#id_valor_3').val(data.valor_3);
                $('#id_obs_3').val(data.obs_3);
                $('#id_valor_4').val(data.valor_4);
                $('#id_obs_4').val(data.obs_4);
                $('#id_taxa_expediente').val(data.tx_expediente);
                $('#id_multas').val(data.multas);
                $('#id_juros').val(data.juros);
                $('#id_auto_infracao').val(data.auto_infracao);
                $('#id_numero_processo').val(data.numero_processo);
                $('#id_ano_processo').val(data.ano_processo);
                $('#id_valor_docarj').val(data.total_docarj);
                $('#id_quantidade_parcelas').val(data.financeiro_docarj.quantidade_parcelas);
                $('#id_parcela_inicial').val(data.financeiro_docarj.parcela_inicial);
                $('#id_dt_final').val(data.financeiro_docarj.data_vencimento);
                if (data.financeiro_docarj.cod_situacao_dam != "04") {
                    $("#formulario_docarj").attr({"action": "recursos/includes/alterar/alterarDocarj.php"});
                    $("#msg").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>Alterar </strong></div>');
                    $("#divButonn").html('<button type="button" class="btn btn-success" id="validar_form" >Alterar DOCARJ</button>');
                } else {
                    $("#formulario_docarj").attr("");
                    $("#msg").html('<div class="alert alert-danger" style="text-align:center; font-size:15px;"><strong>DOCARJ COM PARCELAS PAGAS / CANCELADAS </strong></div>');
                    $("#divButonn").html('');

                }
            }
            //            console.log(data);
            console.log(data.financeiro_docarj.cod_situacao_dam);
        },
        error: function (erro) {
            console.log(erro.responseText);
        }
    });
}


//busca o próximo valor a ser inserido no banco de dados
function cadastrar() {

    $("#formulario_docarj").attr({"action": "recursos/includes/cadastrar/cadastrarDocarj.php"});

    //    adiciono a uma variavel local o valor passado 
    var op = 1;
    //    zero a div de erro 
    $("#msg").html('');
    $.ajax({
        //      Requisição pelo Method POST
        method: "POST",
        //      url para o arquivo para validação
        url: "recursos/includes/retornaValor/retornaDocarj.php",
        //      dados passados
        data: {
            op: op
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            $("#msg").html('<div class="alert alert-success" style="text-align:center; font-size:15px;"><strong>Cadastrar </strong></div>');
            $("#id_numero_docarj").val(data.numero_itbi);
            $("#id_ano_docarj").val(data.ano_itbi);
            $("#divButonn").html(' <button type="button" class="btn btn-success" id="validar_form" >Cadastrar DOCARJ</button>');

        }, error: function (error) {
            $("#msg").html(error.responseText);
        }
    }); //termina o ajax

}

function  retorna_dados_imovel(valor) {
    $.ajax({
        method: "post",
        url: 'recursos/includes/retornaValor/retornaDocarj.php',
        data: {
            op: 2,
            insricao_imobiliaria: valor
        },
        dataType: 'json',
        success: function (data) {

            $('#id_nome_contribuinte').val(data.proprietario);
            $('#id_tipo_pessoa').val(data.tipo_pessoa);
            $('#id_cpf_cnpj').val(data.cpf_cnpj);
            $('#id_telefone').val(data.telefone);
            $('#id_numero_endereco').val(data.numero);
            $('#id_complemento_endereco').val(data.complemento);

            retorna_dados_logradouro(data.rua);
            retorna_dados_bairro(data.bairro);
        },
        error: function (erro) {
            console.log(erro.responseText);
        }

    });
}


function preencher_campo_select_receitas(codigo_cadastro, receita1, receita2, receita3, receita4) {

    limpar_dados_receita_docarj(1);

    $.ajax({
        //      Requisição pelo Method POST
        method: "POST",
        //      url para o arquivo para validação
        url: 'recursos/includes/funcaoPHP/funcao_receitas_docarj.php',
        data: {
            id: 'receitas',
            codigo: codigo_cadastro
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

            //      Preeenche as receitas no campo select
            for (var i = 0; i < data.length; i++) {
                if (data[i].cod == receita1 && receita1 !== "") {
                    $('#id_receita_1').append('<option value="' + data[i].cod + '" selected>' + data[i].Descricao + '</option>');
                    $('#id_valor_1').removeAttr("readonly");
                    $('#id_valor_1').attr('onKeyPress', 'return formatarValor(this, ".", ",", event)');
                    $('#id_obs_1').removeAttr("readonly");
                } else {
                    $('#id_receita_1').append('<option value="' + data[i].cod + '">' + data[i].Descricao + '</option>');
                }
                if (data[i].cod == receita2 && receita2 !== "") {
                    $('#id_receita_2').append('<option value="' + data[i].cod + '" selected>' + data[i].Descricao + '</option>');
                    $('#id_valor_2').removeAttr("readonly");
                    $('#id_valor_2').attr('onKeyPress', 'return formatarValor(this, ".", ",", event)');
                    $('#id_obs_2').removeAttr("readonly");
                } else {
                    $('#id_receita_2').append('<option value="' + data[i].cod + '">' + data[i].Descricao + '</option>');
                }
                if (data[i].cod == receita3 && receita3 !== "") {
                    $('#id_receita_3').append('<option value="' + data[i].cod + '" selected>' + data[i].Descricao + '</option>');
                     $('#id_valor_3').attr('onKeyPress', 'return formatarValor(this, ".", ",", event)');
                   $('#id_valor_3').removeAttr("readonly");
                    $('#id_obs_3').removeAttr("readonly");
                } else {
                    $('#id_receita_3').append('<option value="' + data[i].cod + '">' + data[i].Descricao + '</option>');
                }
                if (data[i].cod == receita4 && receita4 !== "") {
                    $('#id_receita_4').append('<option value="' + data[i].cod + '" selected>' + data[i].Descricao + '</option>');
                    $('#id_valor_4').attr('onKeyPress', 'return formatarValor(this, ".", ",", event)');
                    $('#id_valor_4').removeAttr("readonly");
                    $('#id_obs_4').removeAttr("readonly");
                } else {
                    $('#id_receita_4').append('<option value="' + data[i].cod + '">' + data[i].Descricao + '</option>');
                }
            }
        }, error: function (error) {
            console.log(error.responseText);
        }
    });
}

function  retorna_dados_logradouro(cod_rua) {

    $.ajax({
        method: "post",
        url: 'recursos/includes/retornaValor/retornaDocarj.php',
        data: {
            op: 4,
            cod_rua: cod_rua
        },
        dataType: 'json',
        success: function (data) {
            if (data.achou != 0) {
                $('#id_rua').val(data.descricao);
                $('#id_cep').val(data.cep);
            } else {
                $('#msg_error').html('<div class="alert alert-danger">' + data.erro_validacao + '</div>');
            }
        },
        error: function (erro) {
            console.log(erro.responseText);
        }

    });
}

function  retorna_dados_bairro(cod_bairro) {

    $.ajax({
        method: "post",
        url: 'recursos/includes/retornaValor/retornaDocarj.php',
        data: {
            op: 5, cod_bairro: cod_bairro
        },
        dataType: 'json',
        success: function (data) {

            if (data.achou != 0) {
                $('#id_bairro').val(data.descricao);
                $('#id_cidade').val("JAPERI");
                $('#id_uf').val("RJ");
            } else {
                $('#msg_error').html('<div class="alert alert-danger">' + data.erro_validacao + '</div>');
            }
        },
        error: function (erro) {
            console.log(erro.responseText);
        }

    });
}


function limpar_formulario_docarj() {
    $('#id_valor_docarj').val('0,00');
    $('#id_atividade_Docarj').val('');
    $('#id_descricao_atividade_Docarj').val('');

    $('#id_inscricao_contribuinte').val('');
    $('#id_nome_contribuinte').val('');
    $('#id_cpf_cnpj').val('');
    $('#id_tipo_pessoa').val('');
    $('#id_telefone').val('');
    $('#id_cep').val('');
    $('#id_rua').val('');
    $('#id_rua').val('');
    $('#id_bairro').val('');
    $('#id_cidade').val('');
    selecionar('id_cadastro_contribuinte', '');
    $('#id_inscricao_contribuinte').attr('readonly', 'true').val('');
    $('#id_uf').val('');
    $('#id_numero_endereco').val('');
    $('#id_complemento_endereco').val('');

    //     LIMPA DADOS DA RECEITA
    limpar_dados_receita_docarj(0);


    //    LIMPA INFORMAÇÕES COMPLEMENTARES
    $('#id_taxa_expediente').val('00,00');
    $('#id_multas').val('00,00');
    $('#id_juros').val('00,00');
    $('#id_quantidade_parcelas').val('01');
    $('#id_parcela_inicial').val('01');
    $('#id_vencimento').val('');
    $('#id_auto_infracao').val('');
    $('#id_ano_processo').val('');

}


function limpar_dados_receita_docarj(valor) {
    if (valor == 1) {
        $('#id_receita_1').empty();
        $('#id_receita_2').empty();
        $('#id_receita_3').empty();
        $('#id_receita_4').empty();
    } else {
        $('#id_receita_1').empty().append('<option value="">SELECIONE O CADASTRO PRIMEIRO</option>');
        $('#id_receita_1').empty().append('<option value="">SELECIONE O CADASTRO PRIMEIRO</option>');
        $('#id_receita_1').empty().append('<option value="">SELECIONE O CADASTRO PRIMEIRO</option>');
        $('#id_receita_1').empty().append('<option value="">SELECIONE O CADASTRO PRIMEIRO</option>');
    }

    $('#id_valor_1').attr('readonly', 'true').val('00,00');
    $('#id_obs_1').attr('readonly', 'true').val('');

    $('#id_valor_2').attr('readonly', 'true').val('00,00');
    $('#id_obs_2').attr('readonly', 'true').val('');

    $('#id_valor_3').attr('readonly', 'true').val('00,00');
    $('#id_obs_3').attr('readonly', 'true').val('');

    $('#id_valor_4').attr('readonly', 'true').val('00,00');
    $('#id_obs_4').attr('readonly', 'true').val('');
}

function soma_valor_docar() {
    var receita_1 = $('#id_valor_1').val();
    var valor_receita_1 = tirar_pontos_valor(receita_1);
    valor_receita_1 = parseFloat(valor_receita_1) * 100;

    var receita_2 = $('#id_valor_2').val();
    var valor_receita_2 = tirar_pontos_valor(receita_2);
    valor_receita_2 = parseFloat(valor_receita_2) * 100;

    var receita_3 = $('#id_valor_3').val();
    var valor_receita_3 = tirar_pontos_valor(receita_3);
    valor_receita_3 = parseFloat(valor_receita_3) * 100;

    var receita_4 = $('#id_valor_4').val();
    var valor_receita_4 = tirar_pontos_valor(receita_4);
    valor_receita_4 = parseFloat(valor_receita_4) * 100;


    var taxa_expediente = $('#id_taxa_expediente').val();
    var valor_taxa_expediente = tirar_pontos_valor(taxa_expediente);
    valor_taxa_expediente = parseFloat(valor_taxa_expediente) * 100;

    var multas = $('#id_multas').val();
    var valor_multas = tirar_pontos_valor(multas);
    valor_multas = parseFloat(valor_multas) * 100;

    var juros = $('#id_juros').val();
    var valor_juros = tirar_pontos_valor(juros);
    valor_juros = parseFloat(valor_juros) * 100;

    var soma = (valor_receita_1 + valor_receita_2 + valor_receita_3 + valor_receita_4 + valor_taxa_expediente + valor_juros + valor_multas) / 100;
    soma = soma.toFixed(2);
    soma = soma.replace(".", ",");

    $('#id_valor_docarj').val(soma);

}

function tirar_pontos_valor(valor) {
    var tamanho = valor.length;
    var repeticoes = tamanho / 3;
    var saida = valor;
    for (var i = 0; i < repeticoes; i++) {
        saida = saida.replace(".", "");
    }
    saida = saida.replace(",", ".");

    return saida;
}
