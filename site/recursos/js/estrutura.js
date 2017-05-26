$(document).ready(function () {
    estrutura();
});

function estrutura() {
    $('#cabecalho').load('recursos/includes/estrutura/cabecalho.php');
    $('#rodape').load('recursos/includes/estrutura/rodape.html');
    $('#modal').load('recursos/includes/estrutura/modal_grande.html');
}


//MODAL PARA ALTERAR A SENHA

$(function () {
// id = qual formulario irei chamer 
// cod = parametro enviado da linha (Codigo Rua, Bairrr
    $(document).on('click', '#id_btn_alterar_senha', function (e) {
        e.preventDefault();


        $(".modal-content").html('');
        $(".modal-content").addClass('loader');
        $("#dialog-example").modal('show');
        $.post('recursos/includes/formulario/formulario_alterar_senha.php',
                {id: 1,
                    codigo: $(this).attr('data-id')
                },
        function (html) {
            $(".modal-content").removeClass('loader');
            $(".modal-content").html(html);
        }
        );
    });

    $(document).on('click', '#btn_confirma_alterar_senha', function (e) {
//    formulario
        var senha_atual = $('#id_form_senha_atual_login').val();
        var nova_senha = $('#id_form_nova_senha_login').val();
        var conf_nova_senha = $('#id_form_conf_nova_senha_login').val();

//   mensagem
        var msg = "";

        if (senha_atual.length < 3) {
            msg += "SENHA ATUAL NÃO ATENDE EXIGENCIAS !!! <BR />";
        }

        if (nova_senha.length < 3) {
            msg += "NOVA SENHA NÃO ATENDE EXIGENCIAS !!! <BR />";
        }

        if (conf_nova_senha.length < 3) {
            msg += "CONFIRMAÇÃO NOVA SENHA NÃO ATENDE EXIGENCIAS !!! <BR />";
        }

        if (conf_nova_senha !== nova_senha) {
            msg += "SENHAS NÃO CONFEREM !!! <BR />";
        }

        if (msg !== "") {
//            MOSTRA MENSAGEM DE ERRO
            $('#msg_erro_alterar_senha').html("<div class='alert alert-danger'>" + msg + "</div>");
        } else {
//            LIMPO CASO EXISTA MENSAGEM DE ERRO
            $('#msg_erro_alterar_senha').html("");

//            VALIDO INFORMAÇÕES E TROCO A SENHA
            $.ajax({
//        Requisição pelo Method POST
                method: "POST",
                // url para o arquivo para validação
                url: "recursos/includes/alterar/alterar_senha_colaborador.php",
//        dados passados
                data: {
                    id: 3,
                    senha_atual : senha_atual,
                    nova_senha : nova_senha,
                    conf_nova_senha : conf_nova_senha
                    
                },
                // dataType json
                dataType: "text",
                // função para de sucesso
                success: function (data) {
                    $("#msg_erro_alterar_senha").html(data);
                }, error: function (erro) {
                    $("#msg_erro_alterar_senha").html(erro);
                }
            });//termina o ajax

           
        }
    });




});
