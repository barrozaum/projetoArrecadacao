function mascaraData(nomeCampo) {
    var valor = document.getElementById(nomeCampo).value;
    var novaData = valor.substring(0, 2) + "/" + valor.substring(2, 4) + "/" + valor.substring(4, 8);
    document.getElementById(nomeCampo).value = novaData;
}