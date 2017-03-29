// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_zona", function (e) {
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 2);
//    comparo se o valor é menor que
    if (valor < '01') {
//        zero o campo cdigo
        $(this).val('');
//        disparo erro na tela 
        $("#msg").html('<div class="alert alert-danger"><strong>Zona Inválida!</strong></div>');
    } else {
//        atribuo o valor informado pelo usario no campo
        $(this).val(valor);
        $("#msg").html('');
    }
});



// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_cod_utilizacao", function (e) {
    // atribuição mensagem de erro
    var error = '<div class="alert alert-danger"><strong>Código Utilização Inválido!</strong></div>';

// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 1);
//    comparo se o valor é menor que
    if (valor < '1') {
//        zero o campo cdigo
        $(this).val('');
//        disparo erro na tela 
        $("#msg").html('<div class="alert alert-danger"><strong>Código Utilização Inválido!</strong></div>');
    } else {
//        atribuo o valor informado pelo usario no campo
        $(this).val(valor);
        retornaCampo(valor, 'id_desc_utilizacao', error);
    }
});



function retornaCampo(param, mostraCampo, error) {
    // inicio uma requisição
    var valor = param;
    $("#msg").html('');
    $.ajax({
        // url para o arquivo json.php
        url: "recursos/includes/retornaValor/retornaSituacaoValorM2Terreno.php?cod=" + valor,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            // vamos gerar um html e guardar nesta variável
            var descricao = "";
            for ($i = 0; $i < data.length; $i++) {
                descricao = data[$i].descricao;
            }
            if (descricao == "Código inválido") {
                $('#' + mostraCampo).val('');
                $("#msg").html(error);

            } else {
                //coloco a variável html na tela
                $('#' + mostraCampo).val(descricao);
            }
        }
    });//termina o ajax
}
;//termina o jquery





function validarTerreno() {
    var codzona = $('#id_zona').val();
    var valorUfir = $('#id_valor').val();
    var cod_utilizacao = $('#id_cod_utilizacao').val();
    var desc_utilizacao = $('#id_desc_utilizacao').val();

    if (codzona < '01') {
        alert("Campo Zona Inválido");
        $('#id_zona').focus();
        return false;
    } else if (valorUfir < 0 || valorUfir.length == 0) {
        alert("Valor [Ufir] Inválido");
        $('#id_valor').focus();
        return false;
    } else if ((cod_utilizacao < '01') || (desc_utilizacao === "")) {
        alert("Codigo Utilização Inválido");
        $('#id_cod_utilizacao').focus();
        return false;
    } else {
        $.ajax({
            // url para o arquivo json.php
            url: "recursos/includes/validar/validarSituacaoValorM2Terreno.php?Zona=" + codzona + "&Cod_Sit=" + cod_utilizacao,
            // dataType json
            dataType: "json",
            // função para de sucesso
            success: function (data) {
                // vamos gerar um html e guardar nesta variável
                if (data == 1) {
                    $("#msg").html('<div class="alert alert-danger"> Zona e Situação Já Cadastrados </div>');
                } else {
                    document.cadastro.submit();
                }
            }
        });//termina o ajax   

    }
}






$(function () {
    $(document).on('click', '#id_lupa_utilizacao', function (e) {
        var url = "recursos/includes/selecionar/selecionarUtilizacao.php?janela=1";
        window.open(url, 'galeria', 'width=1024,height=508');
        return false;
    });

// id = qual formulario irei chamer 
// cod = parametro enviado da linha (Codigo Rua, Bairrr
    $(document).on('click', '#edit-editar', function (e) {
        e.preventDefault();

        $(".modal-content").html('');
        $(".modal-content").addClass('loader');
        $("#dialog-example").modal('show');
        $.post('recursos/includes/formulario/formularioTabelaValorM2Terreno.php',
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
        $.post('recursos/includes/formulario/formularioTabelaValorM2Terreno.php',
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


