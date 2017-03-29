function tamanhoCampo(nomeCampo) {

    var valor = nomeCampo.value;

    if (valor.length == 1)
        nomeCampo.value = "0" + valor;
    if (nomeCampo.value < '01') {
        $("#msg").html('<div class="alert alert-danger"><strong>Código Inválido!</strong></div>');
        $("#txtCod").focus();
    } else
        validaInsercao(nomeCampo.value);
}


function validaInsercao(param) {
    // inicio uma requisição
    var param = param;
    $("#msg").html('');
    $.ajax({
        // url para o arquivo json.php
        url: "recursos/includes/validar/validarMotivoCancelamento.php?cod=" + param,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            // vamos gerar um html e guardar nesta variável
            var data = data;

            if (data == 1) {
                $("#txtCod").focus();
                $("#msg").html('<div class="alert alert-danger"><strong>Código Já Cadastrado!</strong></div>');
            }
        }
    });//termina o ajax
}
;//termina o jquery



$(function () {
// id = qual formulario irei chamer 
// cod = parametro enviado da linha (Codigo Rua, Bairrr
    $(document).on('click', '#edit-editar', function (e) {
        e.preventDefault();

        $(".modal-content").html('');
        $(".modal-content").addClass('loader');
        $("#dialog-example").modal('show');
        $.post('recursos/includes/formulario/formularioMotivoCancelamento.php',
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
        $.post('recursos/includes/formulario/formularioMotivoCancelamento.php',
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


