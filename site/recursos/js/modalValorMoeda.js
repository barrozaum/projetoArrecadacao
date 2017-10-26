// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_codigo", function (e) {
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 2);
//    comparo se o valor é menor que
    if (valor < '01') {
//        zero o campo cdigo
        $(this).val('');
//        disparo erro na tela 
        $("#msg").html('<div class="alert alert-danger"><strong>Código Inválido!</strong></div>');
    } else {
//        atribuo o valor informado pelo usario no campo
        $(this).val(valor);

//    valido no banco de dados se o codigo está sendo usado
        retornaCampo(valor, 'id_descricao');
    }

});


// função retornaCampo retorna o tipo da moeda através do código enviado pela função Tamanho campo
function retornaCampo(param, mostraCampo) {
    // inicio uma requisição

    $.ajax({
        //        Requisição pelo Method POST
        method: "POST",
        // url para o arquivo json.php
        url: "recursos/includes/retornaValor/retornaValorMoeda.php",
//        dados passados
        data: {
            cod: param
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            if (data.achou == 0) {
                $("#" + mostraCampo).val('');
                $("#msg").html('<div class="alert alert-danger"><strong>' + data.descricao + '</strong></div>');
            } else {
                $("#" + mostraCampo).val(data.descricao);
                $("#msg").html('');
            }
        }
    });//termina o ajax
}
;//termina o jquery


//função para cadastra o valor da moeda
function validaCamposFormulário() {

    var codigo = $("#id_codigo").val();
    var descricao = $("#id_descricao").val();
    var ano = $("#id_ano").val();
    var mes = $("#id_mes").val();
    var valor = $("#id_valor").val();

    if ((codigo === "") || (descricao === "")) {
        window.alert("Código Não Preenchido");
        return false;
    } else if (mes === "") {
        window.alert("Mês Não Preenchido");
        return false;

    } else if (valor < "0,01") {
        window.alert("Valor Não Preenchido");
        return false;
    } else {
        validarValorMoeda(codigo, mes, ano);
    }

}


function validarValorMoeda(cod, mes, ano) {
    $("#msg").html('');
    $("#listar").html('');
    
    $.ajax({
        // url para o arquivo json.php
        url: "recursos/includes/validar/validarValorMoeda.php?cod=" + cod + "&mes=" + mes + "&ano=" + ano,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            if (data == 1) {
                $("#txtCod").focus();
                $("#msg").html('<div class="alert alert-danger"><strong>VALOR JÁ INSERIDO !!!</strong></div>');
                listarValorMoeda(cod, mes, ano);
            } else {
                document.cadastrar.submit();
            }
         }, error: function (error) {
            $("#msg").html(error.responseText);
        }
    });//termina o ajax
}

function listarValorMoeda(cod, mes, ano) {
    $('#listar').load('recursos/includes/listar/listarValorMoeda.php?cod=' + cod + "&mes=" + mes + "&ano=" + ano);

}







$(function () {
// id = qual formulario irei chamer 
// cod = parametro enviado da linha (Codigo Rua, Bairrro)
    $(document).on('click', '#edit-editar', function (e) {
        e.preventDefault();

        $(".modal-content").html('');
        $(".modal-content").addClass('loader');
        $("#dialog-example").modal('show');
        $.post('recursos/includes/formulario/formularioTabelaValorMoeda.php',
                {id: 1,
                    codigo: $(this).attr('data-id')
                },
        function (html) {
            $(".modal-content").removeClass('loader');
            $(".modal-content").html(html);
        }
        );
    });

});
