// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_numero_itbi", function (e) {
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
$(document).on('blur', "#id_ano_itbi", function (e) {
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

    buscarDadosItbi($('#id_numero_itbi').val(), valor);
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

function buscarDadosItbi(param, param2) {
    $("#formularioItbi").attr("action", "recursos/includes/cadastrar/cadastrarEstornoPagamentoItbi.php");
    $("#msg").html('');
    $("#button").html('');
    carregaTela();
    
    $.ajax({
//      Requisição pelo Method POST
        method: "POST",
//      url para o arquivo para validação
        url: "recursos/includes/retornaValor/retornaEstornoPagamentoItbi.php",
  //      dados passados
        data: {
            op: 1,
            numero: param,
            ano: param2
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
                $("#id_adquirinte").val(data.campo1);
                $("#id_data_vencimento").val(data.campo2);
                $("#id_valor_itbi").val(data.campo3);
                $("#id_data").val(data.campo4);
                $("#id_valor_pagamento").val(data.campo5);
                $("#id_numero_processo").val(data.campo6);
                $("#id_ano_processo").val(data.campo7);
                $("#id_lote").val(data.campo8);
                $("#id_banco").val(data.campo9);
                $("#id_descricao_banco").val(data.campo10);
                $("#id_obs_itbi").val(data.campo11);


                if (data.campo12 != "04")
                {
                    $("#msg").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>IBTI NÃO Pago ou Cancelado </strong></div>');
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
    $("#id_adquirinte").val("");
    $("#id_data_transacao").val("");
    $("#id_valor_itbi").val("");
    $("#id_data").val("");
    $("#id_valor_pagamento").val("");
    $("#id_numero_processo").val("");
    $("#id_ano_processo").val("");
    $("#id_lote").val("");
    $("#id_banco").val("");
    $("#id_descricao_banco").val("");
    $("#id_obs_itbi").val("");
    return;
}

function carregaTela() {
    $("#id_adquirinte").val("...");
    $("#id_data_transacao").val("...");
    $("#id_valor_itbi").val("...");
    $("#id_data").val("");
    $("#id_valor_pagamento").val("");
    $("#id_numero_processo").val("");
    $("#id_ano_processo").val("");
    $("#id_lote").val("");
    $("#id_banco").val("");
    $("#id_descricao_banco").val("");
    $("#id_obs_itbi").val("");
    return;
}

//validação dos campos
$(document).on('click', '#btn-enviar', function (e) {
//  armazeno valor dos campos do formuario em váriaveis

    var adquirinte = $('#id_adquirinte').val();
    var dt_transacao = $('#id_data_transacao').val();
    var valor_itbi = $('#id_valor_itbi').val();
    var dt_pagamento = $('#id_data').val();
    var vlr_pagamento = $('#id_valor_pagamento').val();
    var num_processo = $('#id_numero_processo').val();
    var ano_processo = $('#id_ano_processo').val();
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
        msg = msg + "POR FAVOR ENTRE COM VALOR ITBI VÁLIDO !!! <BR />";
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
    if ((num_processo.length < 5) || (num_processo < 000001)) {
        msg = msg + "POR FAVOR ENTRE COM NÚMERO PROCESSO VÁLIDO !!! <BR />";
    }
    if ((ano_processo.length < 3) || (ano_processo < 0001)) {
        msg = msg + "POR FAVOR ENTRE COM ANO PROCESSO VÁLIDO !!! <BR />";
    }

    if ((lote.length < 3) || (ano_processo < 0001)) {
        msg = msg + "POR FAVOR ENTRE COM LOTE VÁLIDO !!! <BR />";
    }

    if ((banco.length < 2) || (ano_processo < 001) || (descricao_banco.length < 2)) {
        msg = msg + "POR FAVOR ENTRE COM BANCO VÁLIDO !!! <BR />";
    }





    if (msg !== "") {
        msg = "<div class='alert alert-danger'>" + msg + "</div>";
        $('#msg_erro').html(msg);
        return false;
    } else {
//        limpo mensagem de erro na tela
        $('#msg_erro').html(msg);
        $('#formularioItbi').submit();
    }



});