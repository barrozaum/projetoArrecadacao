<?php
include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';

if ($_POST['op'] == '1') {
    retorna_inscricao($pdo);
    die();
}

if ($_POST['op'] == '2') {
    retorna_divida($pdo);
    die();
}


function tipo_pessoa($valor) {
    if ($valor == "F")
        return "Física";
    ELSE
        return "Juridica";
}


function retorna_inscricao($pdo){
    $inscricao = $_POST['inscricao'];

// preparo para realizar o comando sql
    $sql = "select * from Cad_Imobiliario WHERE Inscricao_Imob = '$inscricao'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $achou = 1;
        $Proprietario = $dados['Proprietario'];
        $cpf_cnpj_pagador = $dados['Cpf_Cgc_Contrib'];
        $tipo_pessoa_pagador = tipo_pessoa($dados['Tipo_Pessoa_Contrib']);
        $Cep_Contrib = $dados['Cep_Contrib'];
        $Rua_Contrib = $dados['Rua_Contrib'];
        $Numero_Contrib = $dados['Numero_Contrib'];
        $Complemento_Contrib = $dados['Complemento_Contrib'];
        $Bairro_Contrib = $dados['Bairro_Contrib'];
        $Cidade_Contrib = $dados['Cidade_Contrib'];
        $UF_Contrib = $dados['UF_Contrib'];
    } else {
        $achou = "";
        $Proprietario = "";
        $cpf_cnpj_pagador = "";
        $tipo_pessoa_pagador = "";
        $Cep_Contrib = "";
        $Rua_Contrib = "";
        $Numero_Contrib = "";
        $Complemento_Contrib = "";
        $Bairro_Contrib = "";
        $Cidade_Contrib = "";
        $UF_Contrib = "";
    }



    $var = Array(
        "achou" => "$achou",
        "Proprietario" => "$Proprietario",
        "cpf_cnpj_pagador" => "$cpf_cnpj_pagador",
        "tipo_pessoa_pagador" => "$tipo_pessoa_pagador",
        "Cep_Contrib" => "$Cep_Contrib",
        "Rua_Contrib" => "$Rua_Contrib",
        "Numero_Contrib" => "$Numero_Contrib",
        "Complemento_Contrib" => "$Complemento_Contrib",
        "Bairro_Contrib" => "$Bairro_Contrib",
        "Cidade_Contrib" => "$Cidade_Contrib",
        "UF_Contrib" => "$UF_Contrib"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}


function retorna_divida($pdo){
    $cod_divida = $_POST['cod_divida'];

// preparo para realizar o comando sql
    $sql = "SELECT * FROM Divida_Imob WHERE Cod_Divida_Imob= '$cod_divida'";
    $query = $pdo->prepare($sql);

//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $desc_divida = $dados['Desc_Divida'];
    }else{
        $desc_divida = "";
    }
    
    $var = Array(
        "Descricao_divida" => "$desc_divida"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}


