

$(function () {
//    adiciona formulario de numeros e anos
    $(document).on('click', '#id_seleciona_pesquisa_numero_ano', function (e) {
        $("#listar").html('');
        buscar_formulario("recursos/includes/formulario/formularioConsultaDocarj.php", 1, "formularioPesquisaItbi");
    });

//    adiciona formulario para o campos do nome contribuinte
    $(document).on('click', '#id_seleciona_pesquisa_contribuinte', function (e) {
        $("#listar").html('');
        buscar_formulario("recursos/includes/formulario/formularioConsultaDocarj.php", 2, "formularioPesquisaItbi");
    });


//    adiciona zeros no campo numero itbi
    $(document).on('blur', '#id_numero_Docarj', function (e) {
        var valor = this.value;
        $(this).val(preencheZeros(valor, 6));
    });

//    adiciona zeros no campo ano itbi
    $(document).on('blur', '#id_ano_Docarj', function (e) {
        var valor = this.value;
        $(this).val(preencheZeros(valor, 4));

    });

//    botão procurar numero ano
    $(document).on('click', '#id_numero_ano_Docarj', function (e) {
        var numero = $('#id_numero_Docarj').val();
        var ano = $('#id_ano_Docarj').val();
        var msg = '';

//      validar estrutura dos campos
        if ((numero.length < 5) || (numero === '000000')) {
            msg = msg + "NÚMERO INVÁLIDO !!! <BR />";
        }

        if ((ano.length < 3) || (ano === '0000')) {
            msg = msg + "ANO INVÁLIDO  !!! <BR />"
        }

//      se existir error mostrar mensagem
        if (msg !== "") {
            $('#msg').html('<div class="alert alert-danger text-center">' + msg + '</div>');
            return false;
        } else { //senão executa busca
            $('#msg').html('');
            $("#listar").html('<div style="margin-top:50px; margin-left:50%"><img src="recursos/imagens/ajax-loader.gif" alt="loading" width="20px"></div>');

            $.ajax({
//        Requisição pelo Method POST
                method: "POST",
                // url para o arquivo para validação
                url: "recursos/includes/listar/listarDOCARJ.php",
//        dados passados
                data: {
                    id: 1,
                    txt_numero_Docarj: numero,
                    txt_ano_Docarj: ano
                },
                // dataType json
                dataType: "text",
                // função para de sucesso
                success: function (data) {
                    $("#listar").html(data);
                }
            });//termina o ajax

        }
    });

// botao procurar contribuinte
    $(document).on('click', '#id_buscar_Docarj_contribuinte', function (e) {
        var contribuinte = $('#id_contribuinte').val();

        if (contribuinte.length < 3) {
            $('#msg').html('<div class="alert alert-danger text-center">POR FAVOR PREENCHA CONTRIBUINTE DE ACORDO COM A ESPECIFICAÇÃO ABAIXO DO CAMPO</div>');
            return false;
        } else {
            $('#msg').html('');
        }

        $("#listar").html('<div style="margin-top:50px; margin-left:50%"><img src="recursos/imagens/ajax-loader.gif" alt="loading" width="20px"></div>');

        $.ajax({
//        Requisição pelo Method POST
            method: "POST",
            // url para o arquivo para validação
            url: "recursos/includes/listar/listarDOCARJ.php",
//        dados passados
            data: {
                id: 2,
                txt_contribuinte: contribuinte,
            },
            // dataType json
            dataType: "text",
            // função para de sucesso
            success: function (data) {
                $("#listar").html(data);
            }
        });//termina o ajax


    });


});




$(document).on('click', '#edit-consultar', function (e) {
    e.preventDefault();

    $(".modal-content").html('');
    $(".modal-content").addClass('loader');
    $("#dialog-example").modal('show');
    $.post('recursos/includes/formulario/formularioConsultaItbi.php',
            {
                id: 4,
                codigo: $(this).attr('data-id')
            },
    function (html) {
        $(".modal-content").removeClass('loader');
        $(".modal-content").html(html);
    }
    );
});



function buscar_formulario(url, valor, saida) {
    $.ajax({
//        Requisição pelo Method POST
        method: "POST",
        // url para o arquivo para validação
        url: url,
//        dados passados
        data: {
            id: valor
        },
        // dataType json
        dataType: "text",
        // função para de sucesso
        success: function (data) {
            console.log(data);
            $("#" + saida).html(data);
        }
    });//termina o ajax
}