// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_numero_Docarj", function (e) {
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
$(document).on('blur', "#id_ano_Docarj", function (e) {
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
    buscarDadosDocarj(valor);
});

// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_numero_processo", function (e) {
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
$(document).on('blur', "#id_ano_processo", function (e) {
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

    $("#id_obs_Docarj").val("Baixa conforme processo: " + $('#id_numero_processo').val() + "/" + $('#id_ano_processo').val());
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
        buscaDescricaoBanco(valor);
    }


});

function buscarDadosDocarj(parcela) {
    var numero_Docarj = $('#id_numero_Docarj').val();
    var ano_Docarj = $('#id_ano_Docarj').val();
    var parcela_Docarj = parcela;



    $("#formularioDocarj").attr("action", "recursos/includes/cadastrar/cadastrarEstornoCancelamentoDocarj.php");
    $("#msg").html('');
    $("#button").html('');
    carregaTela();

    $.ajax({
//      Requisição pelo Method POST
        method: "POST",
//      url para o arquivo para validação
        url: "recursos/includes/retornaValor/retornaEstornoCancelamentoDocarj.php",
        //      dados passados
        data: {
            txt_op: 1,
            txt_numero_Docarj: numero_Docarj,
            txt_ano_Docarj: ano_Docarj,
            txt_parcela_Docarj: parcela_Docarj
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            console.log(data);
            // vamos gerar um html e guardar nesta variável
            if (data.achou == 0) {
                $("#msg").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>DOCARJ Não Encontrado !!!</strong></div>');
                limpaTela();
            } else {
                $("#id_contribuinte").val(data.campo1);
                $("#id_data_vencimento").val(data.campo3);
                $("#id_valor_Docarj").val(data.campo4);
                $("#id_historico").val(data.campo9);


                if (data.campo5 === "07")
                {

                    $("#button").html(' <button type="SUBMIT" class="btn btn-danger">Cancelar DOCARJ</button>');
                } else {
                    $("#msg").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>DOCARJ (DAM) Não Cancelado </strong></div>');
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
    $("#id_valor_Docarj").val("");
    $("#id_data").val("");
    $("#id_valor_pagamento").val("");
    $("#id_numero_processo").val("");
    $("#id_ano_processo").val("");
    $("#id_lote").val("");
    $("#id_banco").val("");
    $("#id_descricao_banco").val("");
    $("#id_obs_Docarj").val("");
    return;
}

function carregaTela() {
    $("#id_contribuinte").val("...");
    $("#id_data_vencimento").val("...");
    $("#id_valor_Docarj").val("...");
    $("#id_data").val("");
    $("#id_valor_pagamento").val("");
    $("#id_numero_processo").val("");
    $("#id_ano_processo").val("");
    $("#id_lote").val("");
    $("#id_banco").val("");
    $("#id_descricao_banco").val("");
    $("#id_obs_Docarj").val("");
    return;
}

function buscaDescricaoBanco(valor) {

    $.ajax({
//      Requisição pelo Method POST
        method: "POST",
//      url para o arquivo para validação
        url: "recursos/includes/retornaValor/retornaBaixaOnlineDocarj.php",
//      dados passados
        data: {
            txt_op: 2,
            txt_cod_banco: valor
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            if (data.achou == 1) {
                $("#id_descricao_banco").val(data.descricao);
                $("#msg_banco").html("");
            } else {
                $("#id_descricao_banco").val("");
                $("#msg_banco").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>BANCO NÃO ENCONTRADO !!!</strong></div>');
            }
        }, error: function (error) {
            console.log(error.responseText);
        }

    }); //termina o ajax


}

function descricaoNumeroProcesso() {

    var campNumero = $("#numeroProcesso");
    var campAno = $("#anoProcesso");

    $("#obs_Docarj").val("Baixa conforme processo: " + campNumero.val() + "/" + campAno.val());
}


//validação dos campos
$(document).on('click', '#btn-enviar', function (e) {
//  armazeno valor dos campos do formuario em váriaveis

    var contribuinte = $('#id_contribuinte').val();
    var dt_vencimento = $('#id_data_vencimento').val();
    var valor_Docarj = $('#id_valor_Docarj').val();
    var dt_pagamento = $('#id_data').val();
    var vlr_pagamento = $('#id_valor_pagamento').val();
    var num_processo = $('#id_numero_processo').val();
    var ano_processo = $('#id_ano_processo').val();
    var lote = $('#id_lote').val();
    var banco = $('#id_banco').val();
    var descricao_banco = $('#id_descricao_banco').val();

//    carrega mensagem de erro
    var msg = "";



    if (contribuinte.length < 3) {
        msg = msg + "POR FAVOR ENTRE COM ADQUIRINTE VÁLIDO !!! <BR />";
    }


    if (dt_vencimento === "") {
        msg = msg + "POR FAVOR ENTRE COM DATA VENCIMENTO VÁLIDA !!! <BR />";
    }



    if (valor_Docarj.length < 4) {
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
        $('#formularioDocarj').submit();
    }



});