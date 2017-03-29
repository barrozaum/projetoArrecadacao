$(document).on('click', "#id_gerar_relatorio", function (e) {

//verifica erros
    var erros = 0;
    var mensagem = "<div class='alert alert-danger text-center'>";


// validação dos campos
//Data inicial
    if (valida_estrutura_data('dt_inicial') == false) {
        erros++;
        mensagem = mensagem + "DATA INICIAL INVÁLIDA <BR />";
    }


// data final
    if (valida_estrutura_data('dt_final') == false) {
        erros++;
        mensagem = mensagem + "DATA FINAL INVÁLIDA <BR />";
    }


//    inscricao inicial
    if ($('#id_inscricao_inicial').val().length !== 6) {
        erros++;
        mensagem = mensagem + "INSCRIÇÃO INICIAL INVÁLIDA <BR />";
    }

//    inscricao final
    if ($('#id_inscricao_final').val().length !== 6) {
        erros++;
        mensagem = mensagem + "INSCRIÇÃO FINAL INVÁLIDA <BR />";
    }

//    inscricao final

    if (erros > 0) {
        $("#msg").html(mensagem + '</div>');
        return false;
    } else {
        $("#msg").html('');
        document.formularioRelCancelamento.submit();
    }

});


// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_inscricao_inicial", function (e) {
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 6);
//    comparo se o valor é menor que
    if (valor < '000001') {
//        zero o campo cdigo
        $(this).val('000001');
//        disparo erro na tela 
    } else {
//        atribuo o valor informado pelo usario no campo
        $(this).val(valor);
    }

});

// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_inscricao_final", function (e) {
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 6);
//    comparo se o valor é menor que
    if (valor < '000001') {
//        zero o campo cdigo
        $(this).val('000001');
//        disparo erro na tela 
    } else {
//        atribuo o valor informado pelo usario no campo
        $(this).val(valor);
    }

});