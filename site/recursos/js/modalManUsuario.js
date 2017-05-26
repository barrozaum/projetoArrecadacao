$(function () {
// id = qual formulario irei chamer 
// cod = parametro enviado da linha (Codigo Rua, Bairrr
    $(document).on('click', '#edit-editar', function (e) {
        e.preventDefault();

        $(".modal-content").html('');
        $(".modal-content").addClass('loader');
        $("#dialog-example").modal('show');
        $.post('recursos/includes/formulario/formularioManUsuario.php',
                {id: 1,
                    Cod_Bairro: $(this).attr('data-id')
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
        $.post('recursos/includes/formulario/formularioManUsuario.php',
                {id: 2,
                    Cod_Bairro: $(this).attr('data-id')
                },
        function (html) {
            $(".modal-content").removeClass('loader');
            $(".modal-content").html(html);
        }
        );
    });

    $(document).on('click', '#listar_usuarios', function (e) {
        $("#div_button").html('<button type="button" id="btn_nao_listar">Esconder Usuários </button>');
        document.getElementById("listar").innerHTML = '<div style="margin-top:50px; margin-left:50%"><img src="recursos/imagens/ajax-loader.gif" alt="Atender" width="20px"></div>';
        $('#listar').load('recursos/includes/listar/listarUsuarios.php');
    });

    $(document).on('click', '#btn_nao_listar', function (e) {
        $("#div_button").html('<button type="button" id="listar_usuarios">Listar Usuários </button>');
        $('#listar').html('');
    });

//  validar se usuario existe no sistema
    $(document).on('blur', '#id_login', function () {

        var login = $("#id_login").val();

        if (login.length < 1) {
            func_bloquear_form();
            return false;
        }

        if (login.length < 3) {
            func_bloquear_form();
            $('#msg_error').html('<div class="alert alert-danger">LOGIN INVÁLIDO</div>');
            return false;

        }
        $('#msg_error').html('');
        $.ajax({
//        Requisição pelo Method POST
            method: "POST",
            // url para o arquivo para validação
            url: "recursos/includes/funcaoPHP/func_validar_novo_login.php",
//        dados passados
            data: {
                cmd: 1,
                login: login
            },
            // dataType json
            dataType: "json",
            // função para de sucesso
            success: function (data) {
                if (data == "0") {
                    func_liberar_form();
                } else {
                    $('#msg_error').html("<div class='alert alert-danger'>Login já cadastrado no sistema</div>");
                    func_bloquear_form();

                }
            }, error: function (error) {
                $('#msg_error').html(error.responseText);
            }
        });//termina o ajax
    });

    function func_liberar_form() {
        $('#id_matricula').removeAttr('readonly');
        $('#id_nome_completo').removeAttr('readonly');
        $('#id_nivel_permissao').removeAttr('readonly');
        $('#id_nivel_permissao').empty();
        $('#id_nivel_permissao').append('<option value="">SELECIONE O NIVEL PERMISSÃO</option>');
        $('#id_nivel_permissao').append('<option value="0">USUARIO</option>');
        $('#id_nivel_permissao').append('<option value="1">ADMINISTRADOR</option>');
        $('#id_senha_novo_login').removeAttr('readonly');
        $('#id_confirma_senha_novo_login').removeAttr('readonly');
    }

    function func_bloquear_form() {
        $('#id_matricula').attr('readonly', 'true');
        $('#id_nome_completo').attr('readonly', 'true');
        $('#id_nivel_permissao').attr('readonly', 'true');
        $('#id_nivel_permissao').empty();
        $('#id_nivel_permissao').append('<option value="">SELECIONE O NIVEL PERMISSÃO</option>');
        $('#id_senha_novo_login').attr('readonly', 'true');
        $('#id_confirma_senha_novo_login').attr('readonly', 'true');
    }


// Cadastrando novo usuario no sistema
    $(document).on('click', '#id_cadastrar', function (e) {
//      campos do formulario
        var login = $("#id_login").val();
        var permissao = $("#id_nivel_permissao").val();
        var nome_completo = $("#id_nome_completo").val();
        var senha = $("#id_senha_novo_login").val();
        var confrma_senha = $("#id_confirma_senha_novo_login").val();
        

        var msg = "";

        if ((login.length < 2) || (login.length > 30)) {
            msg = msg + "POR FAVOR ENTRE COM LOGIN VÁLIDO !!! <BR />";
        }
        if (permissao === "") {
            msg = msg + "POR FAVOR ENTRE COM PERMISSAO VÁLIDO !!! <BR />";
        }
        if ((nome_completo.length < 3) || (nome_completo.length > 40)) {
            msg = msg + "POR FAVOR ENTRE COM NOME COMPLETO VÁLIDO !!! <BR />";
        }
        if (senha.length < 3) {
            msg = msg + "POR FAVOR ENTRE COM SENHA VÁLIDA !!! <BR />";
        }
        if (confrma_senha.length < 3) {
            msg = msg + "POR FAVOR ENTRE COM CONFIRMAÇÃO DE SENHA VÁLIDA !!! <BR />";
        }
        if (confrma_senha !== senha) {
            msg = msg + "SENHAS NÃO CONFEREM !!! <BR />";
        }
        if (msg !== "") {
            $("#msg_erro").html('<div class="alert alert-danger">' + msg + '</div>');
            return false;
        } else {
            $('#form_cadastro_usuario').submit();
        }

    });

});
