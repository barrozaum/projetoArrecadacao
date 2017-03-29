

$(function () {
//    adiciona formulario de numeros e anos
    $(document).on('click', '#id_seleciona_pesquisa_numero_ano', function (e) {
        $("#listar").html('');
        buscar_formulario("recursos/includes/formulario/formularioConsultaItbi.php", 1, "formularioPesquisaItbi");
    });

//    adiciona formulario para o campos do nome contribuinte
    $(document).on('click', '#id_seleciona_pesquisa_contribuinte', function (e) {
        $("#listar").html('');
        buscar_formulario("recursos/includes/formulario/formularioConsultaItbi.php", 2, "formularioPesquisaItbi");
    });


//    adiciona zeros no campo numero itbi
    $(document).on('blur', '#id_numero_itbi', function (e) {
        var valor = this.value;
        $(this).val(preencheZeros(valor, 6));
    });

//    adiciona zeros no campo ano itbi
    $(document).on('blur', '#id_ano_itbi', function (e) {
        var valor = this.value;
        $(this).val(preencheZeros(valor, 4));

    });

//    botão procurar numero ano
    $(document).on('click', '#id_buscar_itbi_numero_ano', function (e) {
        var numero = $('#id_numero_itbi').val();
        var ano = $('#id_ano_itbi').val();
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
            $("#listar").html('<div style="margin-top:50px; margin-left:50%"><img src="recursos/imagens/ajax-loader.gif" alt="Atender" width="20px"></div>');

            $.ajax({
//        Requisição pelo Method POST
                method: "POST",
                // url para o arquivo para validação
                url: "recursos/includes/formulario/formularioConsultaItbi.php",
//        dados passados
                data: {
                    id: 3,
                    txt_numero_itbi: numero,
                    txt_ano_itbi: ano
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

// botao procurar adquirinte
    $(document).on('click', '#id_buscar_itbi_adquirinte', function (e) {
        var adquirinte = $('#id_adquirinte').val();
        var data_inicial = $('#id_dt_inicial').val();
        var data_final = $('#id_dt_final').val();


        $.ajax({
//        Requisição pelo Method POST
            method: "POST",
            // url para o arquivo para validação
            url: "recursos/includes/listar/listarITBI.php",
//        dados passados
            data: {
                id: 2,
                adquirinte: adquirinte,
                data_incial: data_inicial,
                data_final: data_final
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