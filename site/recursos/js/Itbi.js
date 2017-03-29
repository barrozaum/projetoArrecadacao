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

    controllerAcao();
});



// controla qual ação vai ter o formulário
function controllerAcao() {
    $("#msg").html('');
    $("#msg_erro").html('');
    $("#divButonn").html('');
    var param1 = $('#id_numero_itbi').val();
    var param2 = $('#id_ano_itbi').val();


    if (param1 === "" || param2 === "" || param1 < '000001' || param2 < '1990') {
        cadastrar();
    } else {
        alterar(param1, param2);
    }
}

//busca o próximo valor a ser inserido no banco de dados
function cadastrar() {
    $("#formularioItbi").attr({"action": "recursos/includes/cadastrar/cadastrarItbi.php", "target" :"_blank"});

    limparCampos('');
//    adiciono a uma variavel local o valor passado 
    var op = 1;
//    zero a div de erro 
    $("#msg").html('');
//    faç
    $.ajax({
//      Requisição pelo Method POST
        method: "POST",
//      url para o arquivo para validação
        url: "recursos/includes/retornaValor/retornaItbi.php",
//      dados passados
        data: {
            op: op
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            $("#msg").html('<div class="alert alert-success" style="text-align:center; font-size:15px;"><strong>Cadastrar </strong></div>');
            $("#id_numero_itbi").val(data.numero_itbi);
            $("#id_ano_itbi").val(data.ano_itbi);
            $("#divButonn").html(' <button type="button" class="btn btn-success" id="validar_form" >Cadastrar ITBI</button>');

        }, error: function (error) {
            console.log(error.responseText);
        }

    }); //termina o ajax

}

// retorna com o itbi já cadastrado
function alterar(param1, param2) {
    $("#formularioItbi").attr({"action": "recursos/includes/alterar/alterarItbi.php" , "target" :"_blank"});
//    adiciono a uma variavel local o valor passado 
    var op = 2;
//    zero a div de erro 
    $("#msg").html('');
//    faç
    $.ajax({
//      Requisição pelo Method POST
        method: "POST",
//      url para o arquivo para validação
        url: "recursos/includes/retornaValor/retornaItbi.php",
//      dados passados
        data: {
            op: op,
            itbi: param1,
            ano: param2
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        // Adquirente --

        success: function (data) {
//            console.log(data);
            // Adquirente --


            if (data.ACHOU == 1) {
                // Div que indica qual acção ta sendo executada
                if (data.SITUACAO_DIVIDA === "04" || data.SITUACAO_DIVIDA === "07")
                {
                    $("#msg").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>Itbi Pago ou Cancelado </strong></div>');
                    $("#divButonn").html('');
                } else {
                    $("#msg").html('<div class="alert alert-warning" style="text-align:center; font-size:15px;"><strong>Alterar </strong></div>');
                    $("#divButonn").html('<button type="button" class="btn btn-warning" id="validar_form">Alterar</button>');

                }


                // Adquirente --
                $("#id_nome_completo_adquirinte").val(data.ADQUIRENTE);
                $("#id_cpf_cnpj_adquirinte").val(data.CGC_CPF_ADQUIRENTE);
                $("#id_tipo_pessoa_adquirinte").val(data.TIPO_PESSOA_ADQUIRENTE);
                $("#id_identidade_adquirinte").val(data.IDENTIDADE_ADQUIRENTE);
                $("#id_cep_adquirinte").val(data.CEP_ADQUIRENTE);
                $("#id_rua_adquirinte").val(data.RUA_ADQUIRENTE);
                $("#id_bairro_adquirinte").val(data.BAIRRO_ADQUIRENTE);
                $("#id_cidade_adquirinte").val(data.CIDADE_ADQUIRENTE);
                $("#id_uf_adquirinte").val(data.UF_ADQUIRENTE);
                $("#id_numero_endereco_adquirinte").val(data.NUMERO_ADQUIRENTE);
                $("#id_complemento_endereco_adquirinte").val(data.COMPLEMENTO_ADQUIRENTE);


                // Transmitente Cedente -- 
                $("#id_nome_completo_transmitente").val(data.TRANSMITENTE);
                $("#id_cpf_cnpj_transmitente").val(data.CGC_CPF_TRANSMITENTE);
                $("#id_tipo_pessoa_transmitente").val(data.TIPO_PESSOA_TRANSMITENTE);
                $("#id_identidade_transmitente").val(data.IDENTIDADE_TRANSMITENTE);
                $("#id_cep_transmitente").val(data.CEP_TRANSMITENTE);
                $("#id_rua_transmitente").val(data.RUA_TRANSMITENTE);
                $("#id_bairro_transmitente").val(data.BAIRRO_TRANSMITENTE);
                $("#id_cidade_transmitente").val(data.CIDADE_TRANSMITENTE);
                $("#id_uf_transmitente").val(data.UF_TRANSMITENTE);
                $("#id_numero_endereco_transmitente").val(data.NUMERO_TRANSMITENTE);
                $("#id_complemento_endereco_transmitente").val(data.COMPLEMENTO_TRANSMITENTE);

                //IMOVEL ---
                $("#id_num_inscricao").val(data.INSCRICAO_IMOVEL);
                $("#id_proprietario_imovel").val(data.PROPRIETARIO);
                $("#id_area_terreno").val(data.AREA_TERRENO);
                $("#id_area_construida").val(data.AREA_CONSTRUIDA);
                $("#id_utilizacao").val(data.UTILIZACAO_IMOVEL);
                $("#id_logradouro_imovel").val(data.LOGRADOURO_IMOVEL);
                $("#id_numero_end_imovel").val(data.NUMERO_IMOVEL);
                $("#id_complemento_imovel").val(data.COMPLEMENTO_IMOVEL);
                $("#id_quadra_imovel").val(data.QUADRA_IMOVEL);
                $("#id_lote_imovel").val(data.LOTE_IMOVEL);
                $("#id_bairro_imovel").val(data.BAIRRO_IMOVEL);
                $("#id_valor_venal").val(data.VALOR_VENAL_IMOVEL);
                $("#id_fracao_ideal").val(data.FRACAO_IDEAL_IMOVEL);

                //NATUREZA --
//                MÉTODO SELECIONAR ENCONTRA-SE NO ARQUIVO SELECIONAR_DENTRO_DO_SELECT.JS
                selecionar('id_natureza', data.NATUREZA_TRANSACAO);
                $("#id_numero_processo").val(data.NUM_PROCESSO_TRANSACAO);
                $("#id_ano_processo").val(data.ANO_PROCESSO_TRANSACAO);
                selecionar('id_imunidade', data.IMUNE_TRANSACAO);

                $("#id_valor_declarado").val(data.VALOR_DECLARADO_TRANSACAO);
                $("#id_base_calculo").val(data.BASE_CALCULO_TRANSACAO);
                $("#id_valor_multa").val(data.VALOR_MULTA);
                $("#id_valor_itbi").val(data.VALOR_ITBI_TRANSACAO);
                $("#id_valor_total").val(data.VALOR_TOTAL_ITBI);
                $("#id_dt_inicial").val(data.DATA_TRANSACAO);
                $("#id_dt_final").val(data.VENCIMENTO);
                selecionar('id_multa', data.TEM_MULTA);
                $("#id_declarante").val(data.DECLARANTE);
                $("#id_obs_itbi").val(data.OBSERVACAO);

                //CODIGOS
                $("#id_codigo_bairro_imovel").val(data.CODIGO_BAIRRO_IMOVEL);
                $("#id_codigo_rua_imovel").val(data.CODIGO_RUA_IMOVEL);
                $("#id_codigo_utilizacao_imovel").val(data.CODIGO_UTILIZACAO_IMOVEL);


//           itbi do ano corrente porem não encontrado
            } else if (data.ACHOU == 2) {
                limparCampos('');
                $("#formularioItbi").attr({"action": "recursos/includes/cadastrar/cadastrarItbi.php", "target" :"_blank"});
                $("#msg").html('<div class="alert alert-success" style="text-align:center; font-size:15px;"><strong>Cadastrar </strong></div>');
                $("#divButonn").html(' <button type="button" class="btn btn-success" id="validar_form" >Cadastrar ITBI</button>');

            } else {
//              limpa campos do formulario
                limparCampos('');

                //                Itbi dos anos anteriores, necessidade de cadastra ano atual

                cadastrar();
            }

        }, error: function (error) {
            console.log(error.responseText);
        }

    }); //termina o ajax


}



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
        url: "recursos/includes/retornaValor/retornaItbi.php",
//      dados passados
        data: {
            op: op,
            num_imovel: num_imovel
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {

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
//                CODIGOS 
                $("#id_codigo_utilizacao_imovel").val(data.COD_UTILIZACAO);
                $("#id_codigo_rua_imovel").val(data.COD_RUA);
                $("#id_codigo_bairro_imovel").val(data.COD_BAIRRO);

//                FUNÇÃO PARA CALCULAR O VALOR BASE QUANDO O IMOVEL FOR SELECIONADO              
                fun_valor_declarado();

            } else {
                limpaImovel('');
                $("#msg").html(data.MENSAGEM);
            }


        }, error: function (error) {
            console.log(error.responseText);
        }
    }); //termina o ajax
}

// função para preencher o Base de Calculo
// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_valor_declarado", function (e) {
    var Imune = $('#id_imunidade').val();

//    console.log(Imune); 


    if (Imune != 'S') {
        fun_valor_declarado();
    } else {
        fun_valores_imune();
    }
});



// função para preencher o Base de Calculo
// quando o campo código sofrer alteração executo
$(document).on('change', "#id_multa", function (e) {
    var Imune = $('#id_imunidade').val();



    if (Imune != 'S') {
        fun_valor_declarado();
    } else {
        fun_valores_imune();
    }
});


// Calcula o valor da Multa do Itbi
// Pego o valor do itbi e somo ao valor da multa caso ela ocorra
function multa_itbi(campo) {

    var valor_Multa = campo.value;

    var valor_Itbi = document.getElementById('valor_itbi').value;
    var valor_Total = document.getElementById('valor_total').value;
    $.ajax({
//      Requisição pelo Method POST
        method: "POST",
//      url para o arquivo para validação
        url: "recursos/includes/retornaValor/retornaItbi.php",
//      dados passados
        data: {
            op: 5,
            valor_Multa: valor_Multa,
            valor_Itbi: valor_Itbi,
            valor_Total: valor_Total
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            // coloco o nome e sobre nome
            $("#id_valor_multa").val(data.campo1);
            $("#id_valor_total").val(data.campo2);
            //fim do laço
        }, error: function (error) {
            console.log(error.responseText);
        }


    }); //termina o ajax
}

//CAMPO IMUNIDADE 
// quando o campo código sofrer alteração executo
$(document).on('change', "#id_imunidade", function (e) {
    console.log($(this).val());
    if ($(this).val() === 'S') {
        fun_valores_imune();
    } else {
        fun_valor_declarado();
    }
});


// FUNCAO PARA IMUNIDADE NI ITBI
function fun_valores_imune() {
    $("#id_base_calculo").val('0,00');
    $("#id_valor_itbi").val('0,00');
    $("#id_valor_multa").val('0,00');
    $("#id_valor_total").val('0,00');
    selecionar("id_multa", "");
}

// FUNÇÃO PARA INSERIR VALORES NOS CAMPOS VALOR_DECLARADO, BASE_CALCULO, VALOR_MULTA, VALOR_ITBI, VALOR_TOTAL
function fun_valor_declarado() {
//    PASSA VALOR DOS CAMPOS PARA VARIAVEIS 
    var valor_Declarado = $('#id_valor_declarado').val();
    var fracao_Ideal = $('#id_fracao_ideal').val();
    var valor_Venal = $('#id_valor_venal').val();
    var valor_multa = $('#id_valor_multa').val();
    var porcentagem = $('#id_multa').val();

//  VALIDA DADOS INFORMADOS
    if (fracao_Ideal == "") {
        window.alert('Campo Fração Ideal Não pode ser Menor que 1');
        return false;
    } else if (valor_Venal < '1,00' && valor_Declarado < '1,00') {
        window.alert('Valor Venal e Valor Declarado Não Informado');
        return false;
    } else {
        $.ajax({
//      Requisição pelo Method POST
            method: "POST",
//      url para o arquivo para validação
            url: "recursos/includes/retornaValor/retornaItbi.php",
//      dados passados
            data: {
                op: 4,
                valor_declarado: valor_Declarado,
                valor_venal: valor_Venal,
                fracao_ideal: fracao_Ideal,
                valor_multa: valor_multa,
                porcentagem: porcentagem
            },
//          dataType json
            dataType: "json",
//          função para de sucesso
            success: function (data) {
                $("#id_base_calculo").val(data.VALOR_BASE);
                $("#id_valor_itbi").val(data.VALOR_ITBI);
                $("#id_valor_multa").val(data.VALOR_MULTA);
                $("#id_valor_total").val(data.VALOR_TOTAL);

            }, error: function (error) {
                console.log(error.responseText);
            }

        }); //termina o ajax
    }
}

//limpa todos os dados do formulario preenchido
function limparformulario(){
    $('#msg').html("");
    $('#msg_erro').html("");
    $('#id_numero_itbi').html("");
    $('#id_ano_itbi').html("");
    limparCampos();
}


// zera o valor de todos os campos do formulário
function limparCampos(mostrarnoCampo) {


    // Adquirente --
    $("#id_nome_completo_adquirinte").val(mostrarnoCampo);
    $("#id_cpf_cnpj_adquirinte").val(mostrarnoCampo);
    $("#id_tipo_pessoa_adquirinte").val(mostrarnoCampo);
    $("#id_identidade_adquirinte").val(mostrarnoCampo);
    $("#id_cep_adquirinte").val(mostrarnoCampo);
    $("#id_rua_adquirinte").val(mostrarnoCampo);
    $("#id_bairro_adquirinte").val(mostrarnoCampo);
    $("#id_cidade_adquirinte").val(mostrarnoCampo);
    $("#id_uf_adquirinte").val(mostrarnoCampo);
    $("#id_numero_endereco_adquirinte").val(mostrarnoCampo);
    $("#id_complemento_endereco_adquirinte").val(mostrarnoCampo);

    // Transmitente Cedente -- 
    $("#id_nome_completo_transmitente").val(mostrarnoCampo);
    $("#id_cpf_cnpj_transmitente").val(mostrarnoCampo);
    $("#id_tipo_pessoa_transmitente").val(mostrarnoCampo);
    $("#id_identidade_transmitente").val(mostrarnoCampo);
    $("#id_cep_transmitente").val(mostrarnoCampo);
    $("#id_rua_transmitente").val(mostrarnoCampo);
    $("#id_bairro_transmitente").val(mostrarnoCampo);
    $("#id_cidade_transmitente").val(mostrarnoCampo);
    $("#id_uf_transmitente").val(mostrarnoCampo);
    $("#id_numero_endereco_transmitente").val(mostrarnoCampo);
    $("#id_complemento_endereco_transmitente").val(mostrarnoCampo);


    // limpa Imóvel
    limpaImovel(mostrarnoCampo);
    selecionar("id_natureza", "");

    $('#id_numero_processo').val(mostrarnoCampo);
    $('#id_ano_processo').val(mostrarnoCampo);

    $('#id_valor_declarado').val('0,00');
    $('#id_base_calculo').val('0,00');
    $('#id_valor_multa').val('0,00');
    $('#id_valor_itbi').val('0,00');
    $('#id_valor_total').val('0,00');
    $('#id_dt_inicial').val(mostrarnoCampo);
    $('#id_dt_final').val(mostrarnoCampo);
    selecionar("id_multa", "");
    $('#id_declarante').val(mostrarnoCampo);
    $('#id_obs_itbi').val(mostrarnoCampo);

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



// quando o campo código sofrer alteração executo
$(document).on('click', "#validar_form", function (e) {

// limpa mensagem de erro do formulario
    $('#msg_erro').html("");

//    variavel para mensagem de erro
    var msg_ad = "";
    var msg_tr = "";
    var msg_im = "";
    var msg_nt = "";
//    var msg_ad = "";

//VALIDANDO CAMPOS DO ADQUIRENTE
    if ($("#id_nome_completo_adquirinte").val().length < 3) {
        msg_ad = msg_ad + "<OL>NOME INVÁLIDO !!! </OL>";
    }
    if (($("#id_cpf_cnpj_adquirinte").val().length < 14) || ($("#id_cpf_cnpj_adquirinte").val().length > 18)) {
        msg_ad = msg_ad + "<OL>CPF_CNPJ INVÁLIDO !!! </OL>";
    }
    if ($("#id_tipo_pessoa_adquirinte").val().length < 3) {
        msg_ad = msg_ad + "<OL>TIPO  INVÁLIDO !!! </OL>";
    }
    if ($("#id_identidade_adquirinte").val().length < 3) {
        msg_ad = msg_ad + "<OL>IDENTIDADE  INVÁLIDO !!! </OL>";
    }
    if ($("#id_cep_adquirinte").val().length !== 8) {
        msg_ad = msg_ad + "<OL>CEP  INVÁLIDO !!! </OL>";
    }
//    VERIFICO SE O ADQUIRENTE TEM ALGUM ERRO 
    if (msg_ad !== "") {
        msg_ad = "<UL> ADQUIRENTE <BR />" + msg_ad + "</UL>";
    }

//   VALIDANDO CAMPOS DO TRANSMITENTE
    if ($("#id_nome_completo_transmitente").val().length < 3) {
        msg_tr = msg_tr + "<OL>NOME INVÁLIDO !!! </OL>";
    }
    if (($("#id_cpf_cnpj_transmitente").val().length < 14) || ($("#id_cpf_cnpj_adquirinte").val().length > 18)) {
        msg_tr = msg_tr + "<OL>CPF_CNPJ INVÁLIDO !!! </OL>";
    }
    if ($("#id_tipo_pessoa_transmitente").val().length < 3) {
        msg_tr = msg_tr + "<OL>TIPO  INVÁLIDO !!! </OL>";
    }
    if ($("#id_identidade_transmitente").val().length < 3) {
        msg_tr = msg_tr + "<OL>IDENTIDADE  INVÁLIDO !!! </OL>";
    }
    if ($("#id_cep_transmitente").val().length !== 8) {
        msg_tr = msg_tr + "<OL>CEP  INVÁLIDO !!! </OL>";
    }

//     VERIFICO SE O TRANSMITENTE TEM ALGUM ERRO  
    if (msg_tr !== "") {
        msg_tr = "<UL> TRANSMITENTE <BR />" + msg_tr + "</UL>";
    }

//   VALIDANDO CAMPOS DO IMÓVEL
    if ($("#id_num_inscricao").val().length !== 6) {
        msg_im = msg_im + "<OL>INSCRIÇÃO INVÁLIDA !!! </OL>";
    }

    if ($("#id_fracao_ideal").val().length < 1) {
        msg_im = msg_im + "<OL>FRAÇÃO IDEAL INVÁLIDA !!! </OL>";
    }

//     VERIFICO SE O IMOVEL TEM ALGUM ERRO  
    if (msg_im !== "") {
        msg_im = "<UL> IMÓVEL <BR />" + msg_im + "</UL>";
    }



//   VALIDANDO CAMPOS DO TRANSAÇÃO
    if ($("#id_natureza").val() == "") {
        msg_nt = msg_nt + "<OL>NATUREZA INVÁLIDA !!! </OL>";
    }

    if (($("#id_numero_processo").val().length !== 6) || ($("#id_numero_processo").val() === "000000")) {
        msg_nt = msg_nt + "<OL>NÚMERO PROCESSO INVÁLIDO !!! </OL>";
    }

    if (($("#id_ano_processo").val().length < 3) || ($("#id_ano_processo").val() === "0000")) {
        msg_nt = msg_nt + "<OL>ANO PROCESSO INVÁLIDO !!! </OL>";
    }

    if (($("#id_valor_declarado").val().length < 3) && ($("#id_valor_declarado").val() > '1,00')) {
        msg_nt = msg_nt + "<OL>VALOR DECLARADO INVÁLIDO !!! </OL>";
    }

    if ($("#id_dt_inicial").val().length !== 10) {
        msg_nt = msg_nt + "<OL>DATA TRANSAÇÃO INVÁLIDO !!! </OL>";
    }
    if ($("#id_dt_final").val().length !== 10) {
        msg_nt = msg_nt + "<OL>VENCIMENTO INVÁLIDO !!! </OL>";
    }

    if ($("#id_declarante").val().length < 3) {
        msg_nt = msg_nt + "<OL>DECLARANTE INVÁLIDO !!! </OL>";
    }

    //     VERIFICO SE O IMOVEL TEM ALGUM ERRO  
    if (msg_nt !== "") {
        msg_nt = "<UL> TRANSAÇÃO <BR />" + msg_nt + "</UL>";
    }


//   VERIFICANDO EXISTENCIA DE ERROS
    if ((msg_tr !== "") || (msg_ad !== "") || (msg_im !== "") || (msg_nt !== "")) {
        $('#msg_erro').html('<div class="alert alert-danger ">PREENCHER CAMPOS <HR/>' + msg_ad + msg_tr + msg_im + msg_nt + "</div>");
        return false;
    } else {
        document.formularioItbi.submit();
         limparformulario('');
    }
});


// numero processo 
// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_numero_processo", function (e) {
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 6);
//    comparo se o valor é menor que
    $(this).val(valor);


});

// ano processo 
// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_ano_processo", function (e) {
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 4);
//    comparo se o valor é menor que
    $(this).val(valor);

});
