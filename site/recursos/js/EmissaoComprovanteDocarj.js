// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_numero_Docarj", function (e) {
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 6);
//    comparo se o valor é menor que
    if (valor < '000001') {
//        zero o campo cdigo
        $(this).val('000000');

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

$(document).on('click', '#id_procurar_comprovantes', function (e) {
//    limpo tela de erro
    $('#msg_error').html('');
    $('#listar').html('');

//    variaveis do formulario
    var numero_Docarj = $('#id_numero_Docarj').val();
    var ano_Docarj = $('#id_ano_Docarj').val();

    //mensagem de erro
    var msg = "";

    if ((numero_Docarj < '000001') || (numero_Docarj.length != 6)) {
        msg += "NÚMERO DOCARJ (DAM) INVÁLIDO, POR FAVOR VERIFIQUE !! <br />";
    }
    if ((ano_Docarj < '0001') || (ano_Docarj.length != 4)) {
        msg += "ANO DOCARJ (DAM) INVÁLIDO, POR FAVOR VERIFIQUE !! <br />";
    }

//caso tenha algum erro mostro na tela
    if (msg !== "") {
        $('#msg_error').html('<div class="alert alert-danger">' + msg + '</div>');
        return false;
    } else {
        $('#listar').html('<div style="margin-top:50px; margin-left:50%"><img src="recursos/imagens/ajax-loader.gif" alt="loading" width="20px"></div>');
        buscarDadosComprovanteDocarj(numero_Docarj, ano_Docarj);
    }
});


function buscarDadosComprovanteDocarj(numero_Docarj, ano_Docarj) {
    $.ajax({
//        Requisição pelo Method POST
        method: "POST",
        // url para o arquivo para validação
        url: "recursos/includes/retornaValor/retorna_dados_comprovante_pagamento_Docarj.php",
//        dados passados
        data: {
            txt_op: 1,
            txt_numero_Docarj: numero_Docarj,
            txt_ano_Docarj: ano_Docarj
        },
        // dataType json
        dataType: "text",
        // função para de sucesso
        success: function (data) {
            $("#listar").html(data);
        }
    });//termina o ajax
}


$(document).on('click', '#id_emitir_comprovante', function (e){
   $('#id_parcela').val($(this).attr('data-id'));
   $('#id_form_emissao_comprovante').submit();           
    
});