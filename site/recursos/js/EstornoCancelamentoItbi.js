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

function buscarDadosItbi(param, param2) {
    $("#formularioItbi").attr("action", "recursos/includes/cadastrar/cadastrarEstornoCancelamentoItbi.php");
    $("#msg").html('');
    $("#button").html('');
    tela_formulario('...');

    $.ajax({
//      Requisição pelo Method POST
        method: "POST",
        // url para o arquivo json.php
        url: "recursos/includes/retornaValor/retornaEstornoCancelamentoItbi.php",
        //      dados passados
        data: {
            op: 1,
            numero: param,
            ano: param2
        }, // dataType json
        dataType: "Json",
        // função para de sucesso
        success: function (data) {
            // vamos gerar um html e guardar nesta variável
            if (data.achou == 0) {
                $("#msg").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>IBTI Não Encontrado !!!</strong></div>');
                tela_formulario('');
            } else {
                console.log(data);
                $("#id_adquirinte").val(data.campo1);
                $("#id_transmitente").val(data.campo2);
                $("#id_data").val(data.campo3);
                $("#id_valor_itbi").val(data.campo4);
                $("#id_obs_itbi").val(data.campo6);
                $("#id_motivo_cancelamento").val(data.campo7);

                if (data.campo5 === "07")
                {
                    $("#button").html(' <button type="SUBMIT" class="btn btn-danger">Estornar ITBI</button>');
                } else {
                    $("#msg").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>IBTI Não Cancelado </strong></div>');

                }
            }
        }
    });//termina o ajax


}


function tela_formulario(valor) {
    $("#id_adquirinte").val(valor);
    $("#id_transmitente").val(valor);
    $("#id_data").val(valor);
    $("#id_valor_itbi").val(valor);
    $("#id_obs_itbi").val(valor);
    return;
}