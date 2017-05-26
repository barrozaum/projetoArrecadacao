$(function () {

    $(document).on('click', '#id_gerar_relatorio', function () {
//        limpo mensagem de erro 
        $('#msg_erro').html('');
//      carrego variaveis
        var data_ini = $("#id_dt_inicial").val();
        var data_fin = $("#id_dt_final").val();
        var rel = $("#id_relacao_docarj").val();

//        mensagem 
        var msg = "";

//        aplico validacao
        if (data_ini.length > 0 && data_ini.length < 10) {
            msg += "VERIFIQUE A DATA INICIAL !!! <BR />";
        }


        if (data_fin.length > 0 && data_fin.length < 10) {
            msg += "VERIFIQUE A DATA FINAL !!! <BR />";
        }

        if (rel < 1 || rel > 2) {
            msg += "VERIFIQUE A RELAÇÃO !!! <BR />";
        }

//        verifico se tem erro
        if (msg !== "") {
            $('#msg_erro').html('<div class="alert alert-danger">' + msg + '</div>')
        } else {
            document.formularioRelCancelamento.submit();
        }
    })



});