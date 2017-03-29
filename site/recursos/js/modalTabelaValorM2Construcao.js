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
        retornaCampo(valor, 'id_desc_utilizacao', 1, error);
    }
});


// quando o campo código sofrer alteração executo
$(document).on('blur', "#id_cod_cat", function (e) {
    // atribuição mensagem de erro
    var error = '<div class="alert alert-danger"><strong>Código Categoria Inválido!</strong></div>';
// pego o valor informado no campo
// coloco no formato correto 
// atribuo o valor formatado na variavel valor
    var valor = preencheZeros(this.value, 1);
//    comparo se o valor é menor que
    if (valor < '1') {
//        zero o campo cdigo
        $(this).val('');
//        disparo erro na tela 

        $("#msg").html(error);
    } else {
//        atribuo o valor informado pelo usario no campo
        $(this).val(valor);
        retornaCampo(valor, 'id_desc_cat', 2, error);
    }
});






function retornaCampo(param, mostraCampo, escolha, error) {
    // inicio uma requisição
   
    var valor = param;
    $("#msg").html('');
    $.ajax({
        method: "POST",
        // url para o arquivo json.php
        url: "recursos/includes/retornaValor/retornaSituacaoValorM2Construcao.php?escolha=" + escolha + "&cod=" + valor,
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
        },
        error: function (err) {
            console.log(err);
        }
    });//termina o ajax
}
;//termina o jquery





function validarConstrucao() {
    var codzona = $('#id_zona').val();
    var valorUfir = $('#id_valor').val();
    var codUti = $('#id_cod_utilizacao').val();
    var descUti = $('#id_desc_utilizacao').val();
    var codCat = $('#id_cod_cat').val();
    var descCat = $('#id_desc_cat').val();

    if (codzona < '01') {
        alert("Campo Zona Inválido");
        $('#txtCodZona').focus();
        return false;
    } else if (valorUfir < 0 || valorUfir.length == 0) {
        alert("Valor [Ufir] Inválido");
        $('#txtValor').focus();
        return false;
    } else if ((codUti < '01') || (descUti == "")) {
        alert("Cod Utilização Inválido");
        $('#txtCodSit').focus();
        return false;
    } else if ((codCat < '01') || (descCat == "")) {
        alert("Cod Categoria Inválido");
        $('#txtCodCat').focus();
        return false;
    } else {
        $.ajax({
            // url para o arquivo json.php
            url: "recursos/includes/validar/validarSituacaoValorM2Construcao.php?Zona=" + codzona + "&Cod_Uti=" + codUti + "&Cod_Cat=" + codCat,
            // dataType json
            dataType: "json",
            // função para de sucesso
            success: function (data) {
                // vamos gerar um html e guardar nesta variável
                if (data == 1) {
                    $("#msg").html('<div class="alert alert-danger"> Zona e Situação e Categoria Já Cadastrados </div>');
                } else {
                    document.cadastro.submit();
                }
            }
        });//termina o ajax   
    }
    return true;
}






$(function () {
// id = qual formulario irei chamer 
// cod = parametro enviado da linha (Codigo Rua, Bairrr
    $(document).on('click', '#id_lupa_categoria', function (e) {
        var url = "recursos/includes/selecionar/selecionarCategoria.php?janela=1";
        window.open(url, 'galeria', 'width=1024,height=508');
        return false;
    });

    $(document).on('click', '#id_lupa_categoria', function (e) {
        var url = "recursos/includes/selecionar/selecionarUtilizacao.php?janela=1";
        window.open(url, 'galeria', 'width=1024,height=508');
        return false;
    });


    $(document).on('click', '#edit-editar', function (e) {
        e.preventDefault();

        $(".modal-content").html('');
        $(".modal-content").addClass('loader');
        $("#dialog-example").modal('show');
        $.post('recursos/includes/formulario/formularioTabelaValorM2Construcao.php',
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
        $.post('recursos/includes/formulario/formularioTabelaValorM2Construcao.php',
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


