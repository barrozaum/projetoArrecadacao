// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_numero_dam", function (e) {
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 6);
//    comparo se o valor é menor que
    if (valor < '000001') {
//        zero o campo cdigo
        $(this).val('00000');

    } else {
//        atribuo o valor informado pelo usario no campo
        $(this).val(valor);

    }

});



// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_ano_dam", function (e) {
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


});

// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_parcela", function (e) {
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 2);
//    comparo se o valor é menor que
    if (valor < '01') {
//        zero o campo cdigo
        $(this).val('01');
        valor = '01';

    } else {
//        atribuo o valor informado pelo usario no campo
        $(this).val(valor);

    }
    buscarDadosDam(valor);
});


// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_lote", function (e) {
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
});

// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_banco", function (e) {
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 3);
//    comparo se o valor é menor que
    if (valor < '001') {
//        zero o campo cdigo
        $(this).val('000');
        $("#id_descricao_banco").val("");
        $("#msg_banco").html("");

    } else {
//        atribuo o valor informado pelo usario no campo
        $(this).val(valor);

    }


});

function buscarDadosDam(parcela) {
    var numero_dam = $('#id_numero_dam').val();
    var ano_dam = $('#id_ano_dam').val();
    var parcela_dam = parcela;


    $("#formularioDam").attr("action", "recursos/includes/cadastrar/cadastrarEstornoPagamentoDam.php");
    $("#msg").html('');
    $("#button").html('');
    carregaTela();

    $.ajax({
//      Requisição pelo Method POST
        method: "POST",
//      url para o arquivo para validação
        url: "recursos/includes/retornaValor/retornaEstornoPagamentoDam.php",
        //      dados passados
        data: {
            txt_op: 1,
            txt_numero_dam: numero_dam,
            txt_ano_dam: ano_dam,
            txt_parcela_dam: parcela_dam
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            console.log(data);
            // vamos gerar um html e guardar nesta variável
            if (data.achou == 0) {
                $("#msg").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>IBTI Não Encontrado !!!</strong></div>');
                limpaTela();
            } else {
                $("#id_contribuinte").val(data.campo1);
                $("#id_data_vencimento").val(data.campo2);
                $("#id_valor_dam").val(data.campo3);
                $("#id_data").val(data.campo4);
                $("#id_valor_pagamento").val(data.campo5);
                $("#id_lote").val(data.campo6);
                $("#id_banco").val(data.campo7);
                $("#id_descricao_banco").val(data.campo8);
                $("#id_obs_dam").val(data.campo9);


                if (data.campo12 != "04")
                {
                    $("#msg").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>DAM NÃO PAGO OU CANCELADO </strong></div>');
                } else {
                    $("#button").html(' <button type="SUBMIT" class="btn btn-danger">Estornar Pagamento</button>');
                }
            }
        }, error: function (error) {
            console.log(error.responseText);
        }
    });//termina o ajax


}

function limpaTela() {
    $("#id_contribuinte").val("");
    $("#id_data_vencimento").val("");
    $("#id_valor_dam").val("");
    $("#id_data").val("");
    $("#id_ano_processo").val("");
    $("#id_lote").val("");
    $("#id_banco").val("");
    $("#id_descricao_banco").val("");
    $("#id_obs_dam").val("");
    return;
}

function carregaTela() {
    $("#id_contribuinte").val("...");
    $("#id_data_vencimento").val("...");
    $("#id_valor_dam").val("...");
    $("#id_data").val("");
    $("#id_valor_pagamento").val("");
    $("#id_lote").val("");
    $("#id_banco").val("");
    $("#id_descricao_banco").val("");
    $("#id_obs_dam").val("");
    return;
}

//validação dos campos
$(document).on('click', '#btn-enviar', function (e) {
//  armazeno valor dos campos do formuario em váriaveis

    var adquirinte = $('#id_contribuinte').val();
    var dt_transacao = $('#id_data_vencimento').val();
    var valor_itbi = $('#id_valor_dam').val();
    var dt_pagamento = $('#id_data').val();
    var vlr_pagamento = $('#id_valor_pagamento').val();
    var lote = $('#id_lote').val();
    var banco = $('#id_banco').val();
    var descricao_banco = $('#id_descricao_banco').val();

//    carrega mensagem de erro
    var msg = "";



    if (adquirinte.length < 3) {
        msg = msg + "POR FAVOR ENTRE COM ADQUIRINTE VÁLIDO !!! <BR />";
    }


    if (dt_transacao === "") {
        msg = msg + "POR FAVOR ENTRE COM DATA TRANSAÇÃO VÁLIDA !!! <BR />";
    } else {
        var objDate = new Date();
        objDate.setYear(dt_transacao.split("/")[2]);
        objDate.setMonth(dt_transacao.split("/")[1] - 1);//- 1 pq em js é de 0 a 11 os meses
        objDate.setDate(dt_transacao.split("/")[0]);

        if (objDate.getTime() > new Date().getTime()) {
            msg = msg + "POR FAVOR ENTRE COM DATA TRANSAÇÃO VÁLIDA (DATA TRANSAÇÃO DEVE SER MENOR QUE DATA ATUAL)!!! <BR />";
        }
    }


    if (valor_itbi.length < 4) {
        msg = msg + "POR FAVOR ENTRE COM VALOR DAM VÁLIDO !!! <BR />";
    }


    if (dt_pagamento === "") {
        msg = msg + "POR FAVOR ENTRE COM DATA PAGAMENTO VÁLIDA !!! <BR />";
    } else {
        var objDate = new Date();
        objDate.setYear(dt_pagamento.split("/")[2]);
        objDate.setMonth(dt_pagamento.split("/")[1] - 1);//- 1 pq em js é de 0 a 11 os meses
        objDate.setDate(dt_pagamento.split("/")[0]);

        if (objDate.getTime() > new Date().getTime()) {
            msg = msg + "POR FAVOR ENTRE COM DATA PAGAMENTO VÁLIDA (DATA PAGAMENTO DEVE SER MENOR QUE DATA ATUAL)!!! <BR />";
        }
    }

    if (vlr_pagamento.length < 4) {
        msg = msg + "POR FAVOR ENTRE COM VALOR PAGAMENTO  VÁLIDO !!! <BR />";
    }

    if (lote.length < 3) {
        msg = msg + "POR FAVOR ENTRE COM LOTE VÁLIDO !!! <BR />";
    }

    if ((banco.length < 2) || (descricao_banco.length < 2)) {
        msg = msg + "POR FAVOR ENTRE COM BANCO VÁLIDO !!! <BR />";
    }


    if (msg !== "") {
        msg = "<div class='alert alert-danger'>" + msg + "</div>";
        $('#msg_erro').html(msg);
        return false;
    } else {
//        limpo mensagem de erro na tela
        $('#msg_erro').html(msg);
        $('#formularioDam').submit();
    }



});