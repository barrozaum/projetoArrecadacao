function mascaraCep(nomeCampo) {
    var valor = document.getElementById(nomeCampo).value;

    if (valor.length <= 8 && valor.length > 1) {
        var novaData = valor.substring(0, 2) + "." + valor.substring(2, 5) + "-" + valor.substring(5, 8);
        document.getElementById(nomeCampo).value = novaData;
    }
}
