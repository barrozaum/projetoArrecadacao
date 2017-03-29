
// inscricao incial
$(document).on('blur', '#id_inscricao_inicial', function (e) {

    var inscricao_inicial = $(this).val();
    inscricao_inicial = preencheZeros(inscricao_inicial, 6);
    $(this).val(inscricao_inicial);
});


//inscricao final
$(document).on('blur', '#id_inscricao_final', function (e) {

    var id_inscricao_final = $(this).val();
    id_inscricao_final = preencheZeros(id_inscricao_final, 6);
    $(this).val(id_inscricao_final);
});




// ano incial
$(document).on('blur', '#id_ano_inicial', function (e) {

    var id_ano_inicial = $(this).val();
    id_ano_inicial = preencheZeros(id_ano_inicial, 4);
    $(this).val(id_ano_inicial);
});


//ano final
$(document).on('blur', '#id_ano_final', function (e) {

    var id_ano_final = $(this).val();
    id_ano_final = preencheZeros(id_ano_final, 4);
    $(this).val(id_ano_final);
});


$(document).on('click', '#btn_calcular_iptu', function (e) {

//    valido o formulario de envio
    var inscricao_inicial = $('#id_inscricao_inicial').val();
    var inscricao_final = $('#id_inscricao_final').val();
    var ano_inicial = $('#id_ano_inicial').val();
    var ano_final = $('#id_ano_final').val();
    
//    variavel com erros
    var msg = '';
    
    if(inscricao_inicial.length != 6  ){
        msg += 'INSCRIÇÃO INICIAL INVÁLIDA <br />';
    }
    if(inscricao_final.length != 6 || inscricao_final === '000000' ){
        msg += 'INSCRIÇÃO FINAL INVÁLIDA <br />';
    }
    if(ano_inicial.length != 4 || ano_inicial === '0000' ){
        msg += 'ANO INICIAL INVÁLIDO <br />';
    }
    if(ano_final.length != 4 || ano_final === '0000' ){
        msg += 'ANO FINAL INVÁLIDO <br />';
    }
    
    if(msg !== ""){
        $('#msg_erro').html('<div class="alert alert-danger">'+msg+'</div>');
        return false;
    }else{
        $('#formulario_calculo_iptu').submit();
    }
});