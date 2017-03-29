function filtroImovel(){
    var nome_proprietario = document.getElementById('nome_proprietario').value;
    var tipo_imposto_imovel = document.getElementById('tipo_imposto_imovel').value;
    var tipo_isencao = document.getElementById('tipo_isencao').value;
    var cod_bairro_imovel = document.getElementById('cod_bairro_imovel').value;
    var cod_logr_imovel = document.getElementById('cod_logr_imovel').value;
    var numero_imov = document.getElementById('numero_imov').value;
    var lote_imov = document.getElementById('lote_imov').value;
    var quadra_imov = document.getElementById('quadra_imov').value;
   
    document.getElementById("listar").innerHTML = '<div style="margin-top:50px; margin-left:50%"><img src="recursos/imagens/ajax-loader.gif" alt="Atender" width="20px"></div>';
     
    $.post("recursos/includes/listar/listarConsultaDadosImovel.php",
    {
        nome_proprietario: nome_proprietario,
        tipo_imposto_imovel: tipo_imposto_imovel,
        tipo_isencao: tipo_isencao,
        cod_bairro_imovel: cod_bairro_imovel,
        cod_logr_imovel: cod_logr_imovel,
        numero_imov: numero_imov,
        lote_imov: lote_imov,
        quadra_imov: quadra_imov
    },
    function(data){
        $('#listar').html(data);
    });
}




// busca o nome da BAIRRO de acordo com o código
function retornaDescBairro(campo) {
  
        $("#desc_bairro_imovel").val("...");
        var cod_bairro = campo.value;
        cod_bairro = preencheZeros(cod_bairro, 3);
        campo.value = cod_bairro;

        if (cod_bairro < "001")
            $("#desc_bairro_imovel").val("");
        else
            buscarBairro(cod_bairro);
    
}

function buscarBairro(cod_bairro) {
    $.ajax({
        // url para o arquivo json.php
        //op == 2 equivale a função retornaBairro
        url: "recursos/includes/retornaValor/retornaCadastroImovel.php?cod=" + cod_bairro + "&op=2",
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            if (data.achou === "1")
                $("#desc_bairro_imovel").val(data.descricao);
            else {
                $("#desc_bairro_imovel").val("Não encontrado");
                $("#cod_bairro_imovel").val("").focus();
            }
        }
    }); //termina o ajax
}

// busca o nome da RUA de acordo com o código
function retornaDescRua(campo) {
    
        $("#desc_logr_imovel").val("...");
        $("#cod_cep_imovel").val("...");
        var cod_rua = campo.value;
        cod_rua = preencheZeros(cod_rua, 5);
        campo.value = cod_rua;

        if (cod_rua < "00001") {
            $("#desc_logr_imovel").val("");
            $("#cod_cep_imovel").val("");
        } else
            buscarRua(campo.value);
    
}

function buscarRua(cod_rua) {
    $.ajax({
        // url para o arquivo json.php
        //op == 1 equivale a função retornaRua
        url: "recursos/includes/retornaValor/retornaCadastroImovel.php?cod=" + cod_rua + "&op=1",
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            if (data.achou === "1") {
                $("#desc_logr_imovel").val(data.descricao);
                $("#cod_cep_imovel").val(data.cep);
                $("#cod_cep_imovel").val(data.cep);
            } else {
                $("#desc_logr_imovel").val("Não encontrado");
                $("#cod_cep_imovel").val("");
                $("#cod_logr_imovel").val("").focus();
            }
        }

    }); //termina o ajax
}




// insere zeros a esquerda
function preencheZeros(obj, tam)
{
    var qtd_zeros, zeros, i;
    qtd_zeros = (tam - obj.length);
    zeros = '';
    for (i = 1; i <= qtd_zeros; i++) {
        zeros = '0' + zeros;
    }
    return zeros + obj;
}



// MODAL NÂO APAGAR

$(function () {
// id = qual formulario irei chamer 
// cod = parametro enviado da linha (Codigo Rua, Bairrr
    $(document).on('click', '#btn_consultar', function (e) {
        e.preventDefault();

        $(".modal-content").html('');
        $(".modal-content").addClass('loader');
        $("#dialog-example").modal('show');
        $.post('recursos/includes/formulario/formularioModalConsultaDadosImovel.php',
                {
                    codigo: $(this).attr('data-id')
                },
        function (html) {
            $(".modal-content").removeClass('loader');
            $(".modal-content").html(html);
        }
        );
    });
});