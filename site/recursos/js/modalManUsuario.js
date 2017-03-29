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

    $(document).on('click', '#id_cadastrar', function (e) {
//      campos do formulario
        var login = $("#id_login").val();
        var matricula = $("#id_matricula").val();
        var nome_completo = $("#id_nome_completo").val();
        var senha = $("#id_senha_novo_login").val();
        var confrma_senha = $("#id_confirma_senha_novo_login").val();

        var msg = "";

        if ((login.length < 2) || (login.length > 30)) {
            msg = msg + "POR FAVOR ENTRE COM LOGIN VÁLIDO !!! <BR />";
        }
        if ((matricula.length < 1) || (matricula.length > 5)) {
            msg = msg + "POR FAVOR ENTRE COM MATRÍCULA VÁLIDO !!! <BR />";
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
