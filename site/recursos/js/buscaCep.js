function retornaCep(campo, campo_cep, rua, bairro, cidade, uf) {
    var cep = document.getElementById(campo).value;

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.]
            rua.value = "...";
            bairro.value = "...";
            cidade.value = "...";
            uf.value = "...";



            //Consulta o webservice viacep.com.br/
            $.getJSON("//viacep.com.br/ws/" + cep + "/json/?callback=?", function (dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    rua.value = dados.logradouro;
                    bairro.value = dados.bairro;
                    cidade.value = dados.localidade;
                    uf.value = dados.uf;


                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    limpa_formulário_cep(campo_cep, rua, bairro, cidade, uf);
                    alert("CEP não encontrado.");

                }
            });
        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep(campo_cep, rua, bairro, cidade, uf);
            alert("Formato de CEP inválido.");

        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep(campo_cep, rua, bairro, cidade, uf);
    }

}


function limpa_formulário_cep(campo_cep, rua, bairro, cidade, uf) {
   
    campo_cep.value = "";
    rua.value = "";
    bairro.value = "";
    cidade.value = "";
    uf.value = "";

}