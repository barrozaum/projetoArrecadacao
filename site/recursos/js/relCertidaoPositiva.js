
$(document).on('blur', "#id_num_inscricao", function (e) {
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var num_insc_imovel = preencheZeros(this.value, 6);

    if (num_insc_imovel < '000001') {
//        zero o campo cdigo
        window.alert('Inscrição não pode Ser Menor que 000001');
        $('#id_num_inscricao').val("");
        return false;
    } else {
        $('#id_num_inscricao').val(num_insc_imovel);
//        atribuo o valor informado pelo usario no campo
        retornaDadosImovel(num_insc_imovel);

    }
});

$(document).on('blur', '#id_numero_processo', function (e) {
    $('#id_numero_processo').val(preencheZeros(this.value, 6));
});

$(document).on('blur', '#id_ano_processo', function (e) {
    $('#id_ano_processo').val(preencheZeros(this.value, 4));
});



// busca na base de dados informações do imóvel
function retornaDadosImovel(num_imovel) {
//    INDICA QUE VARIAVEL VAI SER ATUALIZADA
    limpaImovel('....');

//      adiciono a uma variavel local o valor passado 
    var op = 3;
//    zero a div de erro 
    $("#msg").html('');
//    faç
    $.ajax({
//      Requisição pelo Method POST
        method: "POST",
//      url para o arquivo para validação
        url: "recursos/includes/retornaValor/retornaRelatorioCertidaoPositiva.php",
//      dados passados
        data: {
            op: op,
            num_imovel: num_imovel
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            $("#msg_erro").html('');
            $("#divButonn").html('');

            if (data.ACHOU == '1') {
//                DESCRIÇÕES
                $("#id_num_inscricao").val(num_imovel);
                $("#id_proprietario_imovel").val(data.PROPRIETARIO);
                $("#id_area_terreno").val(data.AREA_TERRENO);
                $("#id_area_construida").val(data.AREA_CONSTRUIDA);
                $("#id_utilizacao").val(data.UTILIZACAO);
                $("#id_logradouro_imovel").val(data.LOGRADOURO);
                $("#id_numero_endereco_imovel").val(data.NUMERO);
                $("#id_complemento_endereco_imovel").val(data.COMPLEMENTO);
                $("#id_quadra_endereco_imovel").val(data.QUADRA);
                $("#id_lote_endereco_imovel").val(data.LOTE);
                $("#id_bairro_imovel").val(data.BAIRRO);
                $("#id_valor_venal").val(data.VALOR_VENAL);
                $("#id_data_averbacao").val(data.DATA_AVERBACAO);
//                CODIGOS 
                $("#id_codigo_utilizacao_imovel").val(data.COD_UTILIZACAO);
                $("#id_codigo_rua_imovel").val(data.COD_RUA);
                $("#id_codigo_bairro_imovel").val(data.COD_BAIRRO);

                if (data.POSSUI_DIVIDAS === "0") {
                    $("#msg_erro").html("<div class='alert alert-danger'>INSCRIÇÃO NÃO POSSUI DÉBITOS !!! </div>");
                    $("#divButonn").html("");
                } else {
                    $("#divButonn").html(' <button type="button" class="btn btn-success" id="validar_form" >Gerar Certidão</button>');

                }

            } else {
                limpaImovel('');
                $("#msg_erro").html(data.MENSAGEM);
            }


        }, error: function (error) {
            console.log(error.responseText);
        }
    }); //termina o ajax
}


function limpaImovel(mostrarnoCampo) {
    $("#id_num_inscricao").val(mostrarnoCampo);
    $("#id_proprietario_imovel").val(mostrarnoCampo);
    $("#id_area_terreno").val(mostrarnoCampo);
    $("#id_area_construida").val(mostrarnoCampo);
    $("#id_fracao_ideal").val('1');
    $("#id_utilizacao").val(mostrarnoCampo);
    $("#id_logradouro_imovel").val(mostrarnoCampo);
    $("#id_numero_endereco_imovel").val(mostrarnoCampo);
    $("#id_complemento_endereco_imovel").val(mostrarnoCampo);
    $("#id_quadra_endereco_imovel").val(mostrarnoCampo);
    $("#id_lote_endereco_imovel").val(mostrarnoCampo);
    $("#id_bairro_imovel").val(mostrarnoCampo);
    $("#id_valor_venal").val(mostrarnoCampo);
//                CODIGOS 
    $("#id_codigo_utilizacao_imovel").val(mostrarnoCampo);
    $("#id_codigo_rua_imovel").val(mostrarnoCampo);
    $("#id_codigo_bairro_imovel").val(mostrarnoCampo);

}

$(document).on('click', '#validar_form', function (e) {
    $("#msg_erro").html('');

//    mensagem de error 
    var msg = "";

//    validando campos no formulario
    if ($("#id_num_inscricao").val().length < 6 || $("#id_num_inscricao").val() < 000001) {
        msg = msg + "INSCRIÇÃO IMÓVEL INVÁLIDA !!! <BR />";
    }
    if ($('#id_proprietario_imovel').val().length < 3 && $('#id_proprietario_imovel').val().length > 50) {
        msg = msg + "PROPRIETÁRIO IMÓVEL INVÁLIDO !!! <BR />";
    }
    if ($('#id_logradouro_imovel').length < 3 && $('#id_logradouro_imovel').length > 50) {
        msg = msg + "LOGRADOURO IMÓVEL INVÁLIDO !!! <BR />";
    }

    //   VALIDANDO CAMPOS DO REQUERENTE
    if ($("#id_nome_completo_requerente").val().length < 3) {
        msg = msg + "NOME REQUERENTE INVÁLIDO !!! <BR />";
    }
    if ($("#id_tipo_pessoa_requerente").val().length < 3) {
        msg = msg + "TIPO  REQUERENTE INVÁLIDO !!! <BR />";
    }
    if ($("#id_identidade_requerente").val().length < 3) {
        msg = msg + "IDENTIDADE REQUERENTE INVÁLIDO !!! <BR />";
    }
    if ($("#id_cep_requerente").val().length !== 8) {
        msg = msg + "CEP REQUERENTE INVÁLIDO !!! <BR />";
    }
    if ($("#id_numero_processo").val().length !== 6 || $("#id_numero_processo").val() === "000000") {
        msg = msg + "NUMERO PROCESSO INVÁLIDO !!! <BR />";
    }
    if ($("#id_ano_processo").val().length !== 4 || $("#id_ano_processo").val() === "0000") {
        msg = msg + "ANO PROCESSO INVÁLIDO !!! <BR />";
    }


    if (msg !== "") {
        $('#msg_erro').html("<div class='alert alert-danger'>" + msg + "</div>");
    } else {
        document.formularioRelCertidaoNegativa.submit();
    }
});