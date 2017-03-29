function cota_unica() {

    if ($("#checado").val() == 1)
    {
        $("#parc_final").val('06');
        $("#parc_inicial").val('01');
        $("#parc_final").prop('readonly', false);
        $("#parc_inicial").prop('readonly', false);
        $("#checado").val(0);
    } else {
        $("#checado").val(1);
        $("#parc_final").val(99);
        $("#parc_inicial").val(99);
        $("#parc_final").prop('readonly', true);
        $("#parc_inicial").prop('readonly', true);
    }
}

function campo_dados_pagador(nome_pagador, cpf_cnpj_pagador, tipo_pessoa_pagador, cep_pagador, rua_pagador,
        numero_end_pagador, numero_complemento_pagador, bairro_pagador, cidade_pagador, uf_pagador) {
    $('#nome_pagador').val(nome_pagador);
    $('#cpf_cnpj_pagador').val(cpf_cnpj_pagador);
    $('#tipo_pessoa_pagador').val(tipo_pessoa_pagador);
    $('#cep_pagador').val(cep_pagador);
    $('#rua_pagador').val(rua_pagador);
    $('#numero_end_pagador').val(numero_end_pagador);
    $('#complemento_pagador').val(numero_complemento_pagador);
    $('#bairro_pagador').val(bairro_pagador);
    $('#cidade_pagador').val(cidade_pagador);
    $('#uf_pagador').val(uf_pagador);
}


function mensagem_de_erro(mensagem, nome_campo) {
    var msg = '<div class="alert alert-warning" style="text-align:center; font-size:15px;">';
    msg = msg + '<strong>' + mensagem + '</strong>';
    msg = msg + '</div>';
    $("#msg").html(msg);
    $("#" + nome_campo).val("");
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

function buscar_inscricao(inscricao, proprietario) {

    $.post("recursos/includes/retornaValor/retornaEmissaoSegundaVia.php",
            {
                op: 1,
                inscricao: inscricao,
            },
            function (data) {
                if (data.achou === "1") {
                    var Proprietario = data.Proprietario;
                    var cpf_cnpj_pagador = data.cpf_cnpj_pagador;
                    var tipo_pessoa_pagador = data.tipo_pessoa_pagador;
                    var Cep_Contrib = data.Cep_Contrib;
                    var Rua_Contrib = data.Rua_Contrib;
                    var Numero_Contrib = data.Numero_Contrib;
                    var Complemento_Contrib = data.Complemento_Contrib;
                    var Bairro_Contrib = data.Bairro_Contrib;
                    var Cidade_Contrib = data.Cidade_Contrib;
                    var UF_Contrib = data.UF_Contrib;

                    $('#' + proprietario).val(Proprietario);
                    campo_dados_pagador(Proprietario, cpf_cnpj_pagador, tipo_pessoa_pagador, Cep_Contrib, Rua_Contrib, Numero_Contrib,
                            Complemento_Contrib, Bairro_Contrib, Cidade_Contrib, UF_Contrib);
                } else {
                    mensagem_de_erro("Inscrição não Localizada", proprietario);
                    campo_dados_pagador(" ", " ", " ", " ", " ", " ", " ", " ", " ", " ");
                }
            }, 'json');

}

function buscar_divida(cod_divida, desc_divida) {

    $.post("recursos/includes/retornaValor/retornaEmissaoSegundaVia.php",
            {
                op: 2,
                cod_divida: cod_divida,
            },
            function (data) {
                $('#' + desc_divida).val(data.Descricao_divida);

            }, 'json');

}

function tamanho_campo(campo, proprietario) {
    var inscricao = campo.value;
    $("#" + proprietario).val("...");
    inscricao = preencheZeros(inscricao, 6);
    campo.value = inscricao;

    if (inscricao < "000001") {
        mensagem_de_erro("Inscrição Inválida", proprietario);
        campo_dados_pagador(" ", " ", " ", " ", " ", " ", " ", " ", " ", " ");
    } else {
        $('#msg').html("");
        buscar_inscricao(inscricao, proprietario);
    }
}

function tamanho_campo_divida(campo, desc_divida) {
    var divida = campo.value;
    $("#" + desc_divida).val("...");
    cod_divida = preencheZeros(divida, 2);
    campo.value = cod_divida;
    if (cod_divida > 00) {
        buscar_divida(cod_divida, desc_divida);
    } else {
        $('#' + desc_divida).val('TODAS');
    }

}


function enviar_formulario() {
    $('#msg').html('');
    var inscricao = document.getElementById('inscricao').value;
    var proprietario = document.getElementById('proprietario').value;
    var divida = document.getElementById('divida').value;
    var sub_divida = document.getElementById('sub_divida').value;
    var ano_inicial = document.getElementById('ano_inicial').value;
    var ano_final = document.getElementById('ano_final').value;
    var parc_inicial = document.getElementById('parc_inicial').value;
    var parc_final = document.getElementById('parc_final').value;
    var data = document.getElementById('data').value;
    var nome_pagador = document.getElementById('nome_pagador').value;
    var cpf_cnpj_pagador = document.getElementById('cpf_cnpj_pagador').value;
    var tipo_pessoa_pagador = document.getElementById('tipo_pessoa_pagador').value;
    var cep_pagador = document.getElementById('cep_pagador').value;
    var rua_pagador = document.getElementById('rua_pagador').value;
    var numero_end_pagador = document.getElementById('numero_end_pagador').value;
    var complemento_pagador = document.getElementById('complemento_pagador').value;
    var bairro_pagador = document.getElementById('bairro_pagador').value;
    var cidade_pagador = document.getElementById('cidade_pagador').value;
    var uf_pagador = document.getElementById('uf_pagador').value;

    if (inscricao < '000001') {
        mensagem_de_erro('Inscrição Inválida', 'inscricao');
        return false;
    } else if (proprietario === "") {
        mensagem_de_erro('Inscrição Inválida', 'inscricao');
        return false;
    }

    if (divida === "") {
        document.getElementById('divida').value = '00';
        document.getElementById('desc_divida').value = 'TODAS';
    }
    if (sub_divida === "") {
        document.getElementById('sub_divida').value = '00';
    }
    if (ano_final < ano_inicial) {
        mensagem_de_erro('Ano Final Não pode ser menor que Ano Inicial', 'ano_inicial');
        return false;
    }



    if ((parc_inicial < '01' || parc_inicial > '06') && (parc_inicial !== '99')) {
        mensagem_de_erro('Parcela Final Inválida (01 - 06 ou 99)', 'parc_final');
        return false;
    }
    if ((parc_final < '01' || parc_final > '06') && (parc_final !== '99')) {
        mensagem_de_erro('Parcela Final Inválida (01 - 06 ou 99)', 'parc_final');
        return false;
    }



    if (data === "") {
        mensagem_de_erro('Data Pagamento Inválida ou Menor que Data Corrente', 'data');
        return false;
    } else {
        var objDate = new Date();
        objDate.setYear(data.split("/")[2]);
        objDate.setMonth(data.split("/")[1] - 1);//- 1 pq em js é de 0 a 11 os meses
        objDate.setDate(data.split("/")[0]);

        if (objDate.getTime() <= new Date().getTime()) {
            mensagem_de_erro('Data Pagamento Inválida n Menor ou Igual Data Corrente', 'data');
            return false;
        }
    }

    if (nome_pagador === "") {
        mensagem_de_erro("Nome pagador deve ser Preenchido", 'nome_pagador');
        return false;
    }
    if (cpf_cnpj_pagador === "") {
        mensagem_de_erro("Nome pagador deve ser Preenchido", 'cpf_cnpj_pagador');
        return false;
    }
    if (tipo_pessoa_pagador === "") {
        mensagem_de_erro("Tipo pagador deve ser Preenchido", 'tipo_pessoa_pagador');
        return false;
    }
    if (cep_pagador === "") {
        mensagem_de_erro("Cep pagador deve ser Preenchido", 'cep_pagador');
        return false;
    }
    if (rua_pagador === "") {
        mensagem_de_erro("Rua pagador deve ser Preenchido", 'rua_pagador');
        return false;
    }
    if (numero_end_pagador === "") {
        mensagem_de_erro("Número End. pagador deve ser Preenchido", 'numero_end_pagador');
        return false;
    }
    if (numero_end_pagador === "") {
        mensagem_de_erro("Número End. pagador deve ser Preenchido", 'numero_end_pagador');
        return false;
    }
    if (complemento_pagador === "") {
        mensagem_de_erro("Complemento End pagador deve ser Preenchido", 'numero_end_pagador');
        return false;
    }
    if (bairro_pagador === "") {
        mensagem_de_erro("Bairro pagador deve ser Preenchido", 'bairro_pagador');
        return false;
    }
    if (cidade_pagador === "") {
        mensagem_de_erro("Cidade pagador deve ser Preenchido", 'cidade_pagador');
        return false;
    }
    if (uf_pagador === "") {
        mensagem_de_erro("uf_pagador pagador deve ser Preenchido", 'uf_pagador');
        return false;
    }

document.calculariptu.submit();

}