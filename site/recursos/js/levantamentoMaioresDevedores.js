function tamanhoCampoAno(nomeCampo) {
    var valor = nomeCampo.value;


    if (valor.length == 0 || valor < 2000)
        nomeCampo.value = "2001";
    if (valor.length == 1)
        nomeCampo.value = "200" + valor;
    if (valor.length == 2)
        nomeCampo.value = "20" + valor;
    if (valor.length == 3)
        nomeCampo.value = "2" + valor;

    if (nomeCampo.name == "txtAnoFinal")
    {
        var camp = document.getElementById('txtAnoInicial').value
        if (nomeCampo.value < camp) {
            alert("Data Final Menor Que inicial")
            document.getElementById('txtAnoInicial').focus();
        }
    }


}

function tamanhoCampoCod(nomeCampo, descricao) {
    var valor = nomeCampo.value;

    var descricao = descricao;

    if (valor.length == 1)
        valor = nomeCampo.value = "0" + valor;

    mostrarCodigo(valor, descricao, nomeCampo.name);

}


function validarData(e) {
    alert("");
}

function mostrarCodigo(param, descricao, campo) {
    // inicio uma requisição
    var param = param;
    $.ajax({
        // url para o arquivo json.php
        url: "recursos/includes/retornaValor/retornaDividaImob.php?cod=" + param,
        // dataType json
        dataType: "json",
        // função para de sucesso
        success: function (data) {
            var proprietario = "";
            for ($i = 0; $i < data.length; $i++) {
                proprietario += data[$i].proprietario;
            }
            if (proprietario != 0) {
                document.getElementById(descricao).value = proprietario;
            } else {
                document.getElementById(campo).focus();
                document.getElementById(descricao).value = "Dívida Inválida";

            }
        }
    });//termina o ajax
}
;//termina o jquery


