// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_inscricao", function (e) {
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 6);
//    comparo se o valor é menor que
    if (valor < '000001') {
//        zero o campo cdigo
        $(this).val('');
//        disparo erro na tela 
        $("#msg").html('<div class="alert alert-danger"><strong>Código Inválido!</strong></div>');
    } else {
//     atribuo o valor informado pelo usario no campo
        $(this).val(valor);

//    retorna inscricao imobiliaria
        retorna_imovel(valor, 1);
    }

});


function retorna_imovel(param, op) {
//    adiciono a uma variavel local o valor passado 

    //    zero valores dos campos
    alterar_valor_campo('');

    $.ajax({
//        Requisição pelo Method POST
        method: "POST",
        // url para o arquivo para validação
        url: "recursos/includes/validar/validarEnderecoCorrespondencia.php",
//        dados passados
        data: {
            op: op,
            cod: param
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
//      comparo o retorno do da validação
//      caso retorno seja igual a 1
//      lança mensagem de erro
            console.log(data);
            if (data.achou === 1) {
                $("#id_proprietario").val(data.proprietario);
                $("#id_nome_completo").val(data.nome_Corr);
                $("#id_rua").val(data.rua_Corr);
                $("#id_numero").val(data.numero_Corr);
                $("#id_complemento").val(data.complemento_Corr);
                $("#id_bairro").val(data.bairro_Corr);
                $("#id_cidade").val(data.cidade_Corr);
                $("#id_uf").val(data.uf_Corr);
                $("#id_cep").val(data.cep_Corr);
                $("#id_telefone").val(data.telefone);
                $("#divButonnAlterar").html('<button type="button" class="btn btn-success"  id="btn_alterar">Alterar</button>');
                $("#divButonnCopiarEndereco").html('<button type="button" class="btn btn-danger"  id="btn_copiar_endereco">Copiar Endereço</button>');

            } else {
                $("#msg").html(data.descricao);
                $("#divButonnAlterar").html('');
                $("#divButonnCopiarEndereco").html('');

            }

        }

    }); //termina o ajax
}
; //termina o jquery


// quando o campo código sofrer alteração executo
$(document).on('click', "#btn_copiar_endereco", function (e) {
//    passo para a variavel o valor digitado na inscricao
    var inscricao = $('#id_inscricao').val();

//    envio para a funcao e seleciono a opcao 2
    retorna_imovel(inscricao, 2);
});


// funcção para zerar valor dos campos
// pode ser usada para passar (...) informando que esta sendo 
// utilizado para buscar
function alterar_valor_campo(value) {
    $("#msg").html('');
    $("#id_proprietario").val(value);
    $("#id_nome_completo").val(value);
    $("#id_rua").val(value);
    $("#id_numero").val(value);
    $("#id_complemento").val(value);
    $("#id_bairro").val(value);
    $("#id_cidade").val(value);
    $("#id_uf").val(value);
    $("#id_cep").val(value);
    $("#id_telefone").val(value);
    $("#divButonn").html('');
}


// ação com o botal alterar
$(document).on('click', "#btn_alterar", function (e) {
//    alert("aqui").


//    campos formulario
    var inscricao = $('#id_inscricao').val();
    var proprietario = $('#id_proprietario').val();
    var nome_completo = $('#id_nome_completo').val();
    var cep = $('#id_cep').val();
    var telefone = $('#id_telefone').val();
    var rua = $('#id_rua').val();
    var numero = $('#id_numero').val();
    var bairro = $('#id_bairro').val();
    var cidade = $('#id_cidade').val();
    var uf = $('#id_uf').val();


// VALIDAÇÃO DE ERROS     
    var erros = 0;

// MENSAGEM DE ERROS
    var mensagem = "<div class='alert alert-danger text-center'>";

//VALIDADORES
    if (inscricao.length < 6 || inscricao < '000001' || proprietario == "") {
        erros = 1;
        mensagem = mensagem + 'IMÓVEL INVÁLIDO <br />\n';
    }

    if (nome_completo.length < 3 || nome_completo.length > 50) {
        erros = 2;
        mensagem = mensagem + 'NOME COMPLETO INVÁLIDO <br />\n';
    }

    if (cep.length != 8 || cep == '00000000' || cep == '11111111' || cep == "22222222" || cep == "33333333"
            || cep == '44444444' || cep == "55555555" || cep == "66666666"
            || cep == '77777777' || cep == "88888888" || cep == "99999999") {
        erros = 3;
        mensagem = mensagem + 'CEP INVÁLIDO <br />\n';
    }

    if (telefone.length < 10 || telefone.length > 11) {
        erros = 4;
        mensagem = mensagem + 'TELEFONE INVÁLIDO <br />\n';
    }

    if (rua.length < 3 || rua.length > 50) {
        erros = 5;
        mensagem = mensagem + 'RUA INVÁLIDA <br />\n';
    }

    if (numero.length < 1 || numero.length > 5) {
        erros = 6;
        mensagem = mensagem + 'NUMERO INVÁLIDA <br />\n';
    }
    if (bairro.length < 3 || numero.length > 20) {
        erros = 7;
        mensagem = mensagem + 'BAIRRO INVÁLIDO <br />\n';
    }
    if (cidade.length < 3 || cidade.length > 20) {
        erros = 8;
        mensagem = mensagem + 'CIDADE INVÁLIDA <br />\n';
    }
    if (uf.length !== 2) {
        erros = 9;
        mensagem = mensagem + 'UF INVÁLIDA <br />\n';
    }



//    FIM VALIDADORES

//    VERIFICA SE EXISTE ERROS
//    SE NÃO EXISTIR ENVIA FORMULARIO
    if (erros > 0) {
        mensagem = mensagem + '</div>';
        $('#msg').html(mensagem);
        return false;
    } else {
        document.formulario_endereco_correspondencia.submit();
    }
});