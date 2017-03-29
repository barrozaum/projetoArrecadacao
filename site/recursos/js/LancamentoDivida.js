// quando o usuario sair do campo (Inscricao) executa 
$(document).on('blur', '#id_inscricao', function (e) {
// passo o valor do campo e preencho de acordo com o temanho
    var num_incr = preencheZeros(this.value, 6);
// insere no campo id_inscricao o valor apos acrescentar zeros
    $(this).val(num_incr);

//limpa a div de erro 
    $("#msg_erro").html('');


// busca do nome do proprietário    
    $.ajax({
        method: "POST",
        url: "recursos/includes/retornaValor/retornaLancamentoDivida.php",
        data: {
            op: 1,
            num_insc: num_incr
        },
        dataType: "json"
    }).done(function (dados) {
//        comparacao para saber se encontrou algum proprietario da inscrição
        if (dados.achou == 1) {
            $('#id_descricao').val(dados.campo1);
        } else {
            $('#id_descricao').val('');
            $("#msg_erro").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>INSCRIÇÃO INVÁLIDA </strong></div>');

        }
    }).fail(function () {
        alert("error");
    });

});


// quando o usuario sair do campo (Inscricao) executa 
$(document).on('blur', '#id_cod_moeda', function (e) {
// passo o valor do campo e preencho de acordo com o temanho
    var cod_moeda = preencheZeros(this.value, 2);
// insere no campo id_inscricao o valor apos acrescentar zeros
    $(this).val(cod_moeda);

//limpa a div de erro 
    $("#msg_erro").html('');


// busca do nome do proprietário    
    $.ajax({
        method: "POST",
        url: "recursos/includes/retornaValor/retornaLancamentoDivida.php",
        data: {
            op: 2,
            cod_moeda: cod_moeda
        },
        dataType: "json"
    }).done(function (dados) {

//        comparacao para saber se encontrou algum proprietario da inscrição
        if (dados.achou == 1) {
            $('#id_descricao_moeda').val(dados.campo1);
        } else {
            $('#id_descricao_moeda').val('');
            $("#msg_erro").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>TIPO MOEDA INVÁLIDO </strong></div>');

        }

    }).fail(function () {
        alert("error");
    });

});


// quando o usuario sair do campo (COD_DIVIDA) executa 
$(document).on('blur', '#id_cod_divida', function (e) {
// passo o valor do campo e preencho de acordo com o temanho
    var cod_divida = preencheZeros(this.value, 2);
// insere no campo id_inscricao o valor apos acrescentar zeros
    $(this).val(cod_divida);

//limpa a div de erro 
    $("#msg_erro").html('');


// busca do nome do proprietário    
    $.ajax({
        method: "POST",
        url: "recursos/includes/retornaValor/retornaLancamentoDivida.php",
        data: {
            op: 3,
            cod_divida: cod_divida
        },
        dataType: "json"
    }).done(function (dados) {
//        comparacao para saber se encontrou algum proprietario da inscrição
        if (dados.achou == 1) {
            $('#id_descricao_div').val(dados.campo1);
        } else {
            $('#id_descricao_div').val('');
            $("#msg_erro").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>CÓDIGO DÍVIDA INVÁLIDA </strong></div>');

        }

    }).fail(function () {
        alert("error");
    });

});




$(document).on('blur', '#id_cod_sit_divida', function (e) {
// passo o valor do campo e preencho de acordo com o temanho
    var cod_sit_divida = preencheZeros(this.value, 2);
// insere no campo id_inscricao o valor apos acrescentar zeros
    $(this).val(cod_sit_divida);
    $("#msg_erro").html('');
    if (this.value === '01') {
        $('#id_descricao_sit_div').val('DO ANO');
    } else if (this.value === '02') {
        $('#id_descricao_sit_div').val('ATIVA');
    } else {
        $('#id_descricao_sit_div').val('');
        $("#msg_erro").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>CÓDIGO SITUAÇÃO DA DÍVIDA INVÁLIDA </strong></div>');

    }
});

$(document).on('blur', '#id_sub_divida', function (e) {
// passo o valor do campo e preencho de acordo com o temanho
    var sub_divida = preencheZeros(this.value, 2);
// insere no campo id_inscricao o valor apos acrescentar zeros
    $(this).val(sub_divida);

});
$(document).on('blur', '#id_parc_ini', function (e) {
// passo o valor do campo e preencho de acordo com o temanho
    var parc_inicial = preencheZeros(this.value, 2);
// insere no campo id_inscricao o valor apos acrescentar zeros
    $(this).val(parc_inicial);

});
$(document).on('blur', '#id_qtd_parc', function (e) {
// passo o valor do campo e preencho de acordo com o temanho
    var qtd_parc = preencheZeros(this.value, 2);
// insere no campo id_inscricao o valor apos acrescentar zeros
    $(this).val(qtd_parc);

});













$(document).on('click', '#id_salvar', function (e) {
//    inscricao
    var id_inscricao = $('#id_inscricao').val();
    var id_descricao = $('#id_descricao').val();
//    moeda
    var id_cod_moeda = $('#id_cod_moeda').val();
    var id_descricao_moeda = $('#id_descricao_moeda').val();
//    cod_divida
    var id_cod_divida = $('#id_cod_divida').val();
    var id_descricao_div = $('#id_descricao_div').val();
//    cod_divida
    var id_cod_sit_divida = $('#id_cod_sit_divida').val();
    var id_descricao_sit_div = $('#id_descricao_sit_div').val();
//    sub_divida
    var id_sub_divida = $('#id_sub_divida').val();
//    ano_divida
    var id_ano = $('#id_ano').val();
//    parc_ini
    var id_parc_ini = $('#id_parc_ini').val();
//    qtd_parc
    var id_qtd_parc = $('#id_qtd_parc').val();
//    data (vencimento)
    var id_data = $('#id_data').val();
//  parcela que esta sendo incluida
    var parc_atual = $('#id_parc_atual').val();
//  valor da parcela
    var valor_parcela = $('#id_valor_parcela').val();


    if ((id_inscricao === '') || (id_inscricao === '000000') || (id_descricao === '')) {
        alert('Inscrição Inválida');
        return false;
    } else {
        $('#id_inscricao').prop('readonly', true);
    }

    if ((id_cod_moeda === '') || (id_descricao_moeda === '')) {
        alert('Codigo Moeda Inválido');
        return false;
    } else {
        $('#id_cod_moeda').prop('readonly', true);
    }
    if ((id_cod_divida === '') || (id_cod_divida === '00') || (id_descricao_div === '')) {
        alert('Codigo Divida Inválido');
        return false;
    } else {
        $('#id_cod_divida').prop('readonly', true);
    }
    if ((id_cod_sit_divida === '') || (id_cod_sit_divida === '00') || (id_descricao_sit_div === '')) {
        alert('Codigo Situação Divida Inválido');
        return false;
    } else {
        $('#id_cod_sit_divida').prop('readonly', true);
    }
    if (id_sub_divida === '') {
        alert('Sub dívida Inválida');
        return false;
    } else {
        $('#id_sub_divida').prop('readonly', true);
    }
    if (id_ano === '' || id_ano < '1990') {
        alert('Ano Dívida Inválido');
        return false;
    } else {
        $('#id_ano').prop('readonly', true);
    }
    if ((id_parc_ini === '') || (id_parc_ini === '00')) {
        alert('Parcela Inicial Inválida');
        return false;
    } else {
        $('#id_parc_ini').prop('readonly', true);
    }
    if (id_qtd_parc === '' || (id_qtd_parc === '00')) {
        alert('Quantidade de Parcelas Inválida');
        return false;
    } else {
        $('#id_qtd_parc').prop('readonly', true);
    }
    if (valor_parcela === '' || (valor_parcela < '1')) {
        alert('Valor Parcelas Inválida');
        return false;
    } 
    if (id_data === '') {
        alert('Vencimento Inválido');
        return false;
    } else {
        var objDate = new Date();
        objDate.setYear(id_data.split("/")[2]);
        objDate.setMonth(id_data.split("/")[1] - 1);//- 1 pq em js é de 0 a 11 os meses
        objDate.setDate(id_data.split("/")[0]);

        if (objDate.getTime() <= new Date().getTime()) {
            alert('Data Pagamento Inválida n Menor ou Igual Data Corrente');
            return false;
        }
        $('#id_data').val('');
    }



    if ((id_qtd_parc === '01') || (parc_atual === id_qtd_parc)) {
        var campo_botao = '<hr>';
        campo_botao = campo_botao + '<div class="col-sm-6">';
        campo_botao = campo_botao + '<button class="btn btn-success" type="submit" >Lançar Dívida</button>';
        campo_botao = campo_botao + '</div>';
        campo_botao = campo_botao + '<div class="col-sm-6 text-right">';
        campo_botao = campo_botao + '<button class="btn btn-danger" type="button" id="id_reset">Cancelar</button>';
        campo_botao = campo_botao + '</div>';
        $('#div_botao').html('');
        $('#div_botao_enviar').html(campo_botao);
    }

//  Tabela com a simulação dos valores    
    $("#tabela-contrato").append(newRow);

    var newRow = $("<tr>");
    var cols = "";


    cols += '<td><input type="text" class="form-control" name ="parcela[]"  required="true" value="' + $('#id_parc_atual').val() + '" maxlength="11" placeholder="000000" readonly="true"/></td>';
    cols += '<td><input type="text" class="form-control" name ="parcela_vencimento[]"  required="true" value="' + id_data + '" maxlength="11" placeholder="000000" readonly="true"/></td>';
    cols += '<td><input type="text" class="form-control" name ="parcela_valor[]"  required="true" value="' + $('#id_valor_parcela').val() + '" maxlength="11" placeholder="000000" readonly="true"/></td>';
    cols += '<td><input type="text" class="form-control" name ="parcela_observacao[]"  required="true" value="' + $('#id_observacao').val() + '" maxlength="11" placeholder="000000" readonly="true"/></td>';



    newRow.append(cols);

    $("#tabela-contrato").append(newRow);


    if (id_qtd_parc === parc_atual) {
        return false;
    } else {
//  somar o valor da parcela + 1
        parc_atual = (parseInt(parc_atual) + 1);
        parc_atual = preencheZeros(parc_atual.toString(), 2);
        $('#id_parc_atual').val(parc_atual);
    }

});


$(document).on('blur', '#id_parc_ini', function (e) {
    $('#id_parc_atual').val(this.value);
});


$(document).on('click', '#id_reset', function (e){
   var campo_botao = '<button type="button" id="id_salvar" class="btn btn-info" >SIMULAR</button>';
    
//    limpa a tabela onde está a simulação dos valores
    $("#tabela-contrato-corpo").html('');
//   addiciona o botão para realizar simulação
    $('#div_botao').html(campo_botao);
//    limpa a opção com botoes para lancar a divida e cancelar
    $('#div_botao_enviar').html('');
    
    
//   habilita campos para digitar
//desmarcar atributo readonly
$('#id_inscricao').prop('readonly', false);
$('#id_cod_moeda').prop('readonly', false);
$('#id_cod_divida').prop('readonly', false);
$('#id_cod_sit_divida').prop('readonly', false);
$('#id_sub_divida').prop('readonly', false);
$('#id_ano').prop('readonly', false);
$('#id_parc_ini').prop('readonly', false);
$('#id_qtd_parc').prop('readonly', false);
    
});
