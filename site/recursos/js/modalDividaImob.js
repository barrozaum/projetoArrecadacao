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
        validaInsercao(valor);
    }

});

// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_desconto", function (e) {
   $(this).val(preencheZeros(this.value, 2));
});

// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_codigo_ano", function (e) {
   $(this).val(preencheZeros(this.value, 3));
});

// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_divida_ativa", function (e) {
   $(this).val(preencheZeros(this.value, 3));
});

// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_multas_juros", function (e) {
   $(this).val(preencheZeros(this.value, 2));
});
// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_alterar_desconto", function (e) {
   $(this).val(preencheZeros(this.value, 2));
});

// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_alterar_codigo_ano", function (e) {
   $(this).val(preencheZeros(this.value, 3));
});

// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_alterar_divida_ativa", function (e) {
   $(this).val(preencheZeros(this.value, 3));
});

// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_alterar_multas_juros", function (e) {
   $(this).val(preencheZeros(this.value, 2));
});


function validaInsercao(param) {
 //    adiciono a uma variavel local o valor passado 
    var param = param;
//    zero a div de erro 
    $("#msg").html('');
//    faç
    $.ajax({
//        Requisição pelo Method POST
        method: "POST",
        // url para o arquivo para validação
        url: "recursos/includes/validar/validarDividaImob.php?cod=" + param,
//        dados passados
        data: {
            cod: param
        },
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
//      comparo o retorno do da validação
//      caso retorno seja igual a 1
//      lança mensagem de erro
            if (data === 1) {
                $("#id_codigo").val('');
                $("#msg").html('<div class="alert alert-danger"><strong>Código Já Cadastrado!</strong></div>');
            }
        }
    });//termina o ajax
}
;//termina o jquery


$(function () {
// id = qual formulario irei chamer 
// cod = parametro enviado da linha (Codigo Rua, Bairrro)
    $(document).on('click', '#edit-editar', function (e) {
        e.preventDefault();

        $(".modal-content").html('');
        $(".modal-content").addClass('loader');
        $("#dialog-example").modal('show');
        $.post('recursos/includes/formulario/formularioTabelaDividaImob.php',
                {id: 1,
                    codigo: $(this).attr('data-id')
                },
        function (html) {
            $(".modal-content").removeClass('loader');
            $(".modal-content").html(html);
        }
        );
    });

    $(document).on('click', '#edit-excluir', function (e) {
        e.preventDefault();

        $(".modal-content").html('');
        $(".modal-content").addClass('loader');
        $("#dialog-example").modal('show');
        $.post('recursos/includes/formulario/formularioTabelaDividaImob.php',
                {id: 2,
                    codigo: $(this).attr('data-id')
                },
        function (html) {
            $(".modal-content").removeClass('loader');
            $(".modal-content").html(html);
        }
        );
    });



});