$(document).on('change', '#id_colaborador', function () {

    var cod_usu = $(this).val();
    if (cod_usu !== "") {
//
        $.ajax({
//        Requisição pelo Method POST
            method: "POST",
            // url para o arquivo para validação
            url: "recursos/includes/funcaoPHP/func_retorna_usuario.php",
//        dados passados
            data: {id: 1, txt_cod_usu: cod_usu},
            // dataType json
            dataType: "json",
            // função para de sucesso
            success: function (data) {
//                console.log(data);
                if (data.achou == "s") {
                    for (var i = 0; i < data.permissao.length; i++) {
                         document.f1.elements[data.permissao[i]].checked = 1;
                    }
                } else {
                    deselecionar_tudo();
                }
//
            }, error: function (error) {
                console.log(error.responseText);
            }
        });//termina o ajax
    } else {
        limpa_campos();
    }
});


function limpa_campos() {
    $("#id_setor").val('');
    deselecionar_tudo();
}

function selecionar_tudo() {
    for (i = 0; i < document.f1.elements.length; i++)
        if (document.f1.elements[i].type == "checkbox")
            document.f1.elements[i].checked = 1
}
function deselecionar_tudo() {
    for (i = 0; i < document.f1.elements.length; i++)
        if (document.f1.elements[i].type == "checkbox")
            document.f1.elements[i].checked = 0
}