function buscaImovel(campo) {
    var inscricao = preencheZeros(campo.value, 6);
    campo.value = inscricao;
    $("#nome_proprietario").val("...");
    $.ajax({
        // url para o arquivo json.php
        //op == 0 equivale a função retornaCadImob
        url: "recursos/includes/retornaValor/retornaConsultaFinanceira.php?cod=" + inscricao + "&op=1",
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            //IDENTIFICAÇÃO DO IMÓVEL / PROPRIETÁRIO
            $("#nome_proprietario").val(data.Proprietario);
        }
    });//termina o ajax
}
;//termina o jquery


function buscaDivida(campo) {
    var cod_divida = preencheZeros(campo.value, 2);
    campo.value = cod_divida;
    $("#desc_cod_divida").val("...");
    if (cod_divida < 01) {
        $("#desc_cod_divida").val("");
    } else
        $.ajax({
            // url para o arquivo json.php
            //op == 0 equivale a função retornaCadImob
            url: "recursos/includes/retornaValor/retornaConsultaFinanceira.php?cod=" + cod_divida + "&op=2",
            // dataType json
            dataType: "json",
            // função para de sucesso
            success: function (data) {
                //IDENTIFICAÇÃO DO IMÓVEL / PROPRIETÁRIO
                $("#desc_cod_divida").val(data.Descricao_divida);
            }
        });//termina o ajax
}
;//termina o jquery

function buscaSubDivida(campo) {
    var cod_divida = preencheZeros(campo.value, 2);
    campo.value = cod_divida;
}
;//termina o jquery

function buscaAno(campo) {
    var cod_divida = preencheAno(campo.value, 4);
    campo.value = cod_divida;
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

// insere zeros a esquerda
function preencheAno(obj, tam)
{
    var qtd_zeros, zeros, i;
    qtd_zeros = (tam - obj.length);
    if (qtd_zeros == 0) {
        return obj;
    } else {
        zeros = '';
        for (i = 2; i <= qtd_zeros; i++) {
            zeros = '0' + zeros;
        }
        return 2 + zeros + obj;
    }
}


function filtroConsultaFinanceira() {

    var inscricao = document.getElementById('inscricao_imob').value;
    var proprietario = document.getElementById('nome_proprietario').value;

    var dividas_ajuizada = $('#dividas_ajuizada').is(':checked');
    var dividas_nao_ajuizada = $('#dividas_nao_ajuizada').is(':checked');

    var cod_divida = document.getElementById('cod_divida').value;
    var desc_cod_divida = document.getElementById('desc_cod_divida').value;

    var dividas_aberta = $('#dividas_aberta').is(':checked');
    var sub_divida = document.getElementById('sub_divida').value;
    var ano_inicial = document.getElementById('ano_inicial').value;
    var ano_final = document.getElementById('ano_final').value;

    if (cod_divida == "") {
        $("#cod_divida").val('00');
    }
    if (sub_divida == "") {
        $("#sub_divida").val('00');
    }

    if (inscricao == 000000 || proprietario == "") {
        alert("Inscricao Inválida");
        document.getElementById('inscricao_imob').focus();
    }
    else if (cod_divida > 00 & desc_cod_divida == "") {
        alert("Divida Inválida");
        document.getElementById('cod_divida').focus();
    } else {
        document.getElementById("listar_dividas").innerHTML = '<div style="margin-top:50px; margin-left:50%"><img src="recursos/imagens/ajax-loader.gif" alt="Atender" width="20px"></div>';
        $("#listar_taxas").html("");
        $("#valor_vencido").val("");
        $("#valor_a_vencer").val("");
        $("#valor_total").val("");
        $.ajax({
            method: "POST",
            url: "recursos/includes/listar/listarConsultaFinanceira.php",
            data: {
                id: 1,
                inscricao: inscricao,
                proprietario: proprietario,
                dividas_ajuizada: dividas_ajuizada,
                dividas_nao_ajuizada: dividas_nao_ajuizada,
                cod_divida: cod_divida,
                desc_cod_divida: desc_cod_divida,
                dividas_aberta: dividas_aberta,
                sub_divida: sub_divida,
                ano_inicial: ano_inicial,
                ano_final: ano_final
            }
        })
                .done(function (msg) {
                    $("#listar_dividas").html(msg);
                });
    }
}

$(document).on('click', '#edit-editar', function (e) {


    var str = $(this).attr('data-id');
    var res = str.split("|");
    $("#obs_const_finc").val(res[0]);

    listarTaxas(res[1], res[2], res[3], res[4], res[5]);

});

$(document).on('click', '#taxas', function (e) {
    var taxas = $('#taxas').is(':checked');
    if (taxas == false) {
        $("#listar_taxas").html("");
    }

});



function listarTaxas(inscricao, ano_divida, cod_divida, sub_divida, parcela) {

    var taxas = $('#taxas').is(':checked');
    if (taxas == false) {
        $("#listar_taxas").html("");
    } else {

        $.ajax({
            method: "POST",
            url: "recursos/includes/listar/listarConsultaFinanceira.php",
            data: {
                id: 2,
                inscricao: inscricao,
                cod_divida: cod_divida,
                sub_divida: sub_divida,
                ano_divida: ano_divida,
                parcela: parcela
            }
        })
                .done(function (msg) {
                    $("#listar_taxas").html(msg);
                });
    }
}



function passagem_valores_consulta(valor_Total, valor_Vencido, valor_a_Vencer) {
    $("#valor_vencido").val(valor_Vencido);
    $("#valor_a_vencer").val(valor_a_Vencer);
    $("#valor_total").val(valor_Total);
}