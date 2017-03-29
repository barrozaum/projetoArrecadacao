function tamanhoCampo(nomeCampo) {

    var valor = nomeCampo.value;

    if (valor.length == 1)
        nomeCampo.value = "00000" + valor;
    else if (valor.length == 2)
        nomeCampo.value = "0000" + valor;
    else if (valor.length == 3)
        nomeCampo.value = "000" + valor;
    else if (valor.length == 4)
        nomeCampo.value = "00" + valor;
    else if (valor.length == 5)
        nomeCampo.value = "0" + valor;




    if (nomeCampo.value < '000001') {
        nomeCampo.value='000001';
        nomeCampo.focus();
    }else if(nomeCampo.name== "txtInscricaoFinal"){
        var inscIni = document.getElementById("txtInscricaoInicial").value;
        if(nomeCampo.value < inscIni){
            alert("Inscrição Final não Pode ser Menor que a Inicial");
            document.getElementById("txtInscricaoFinal").focus();
        }
        
    }
    
}
