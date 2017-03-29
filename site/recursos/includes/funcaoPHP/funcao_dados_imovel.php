<?php

// funcao que vai retornar alguns campos apartir da inscricao

function fun_retorna_dados_imovel_para_formulario_calculo_iptu($pdo, $inscricao) {

    $sql = "SELECT * FROM Cad_Imobiliario WHERE Inscricao_Imob = " . $inscricao;

    $query = $pdo->prepare($sql);
    //executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $_SESSION['SESSION_INSCRICAO_VALIDA'] = "TRUE";
        $_SESSION['SESSION_ZONA_IMOVEL'] = $dados['Zona_Fiscal'];
        $_SESSION['SESSION_SITUACAO'] = $dados['Situacao_Terreno'];
        $_SESSION['SESSION_UTILIZACAO'] = $dados['Utilizacao_imovel'];
        $_SESSION['SESSION_CATEGORIA'] = $dados['Categoria'];
        $_SESSION['SESSION_AREA_TERRENO'] = $dados['Area_Terreno'];
        $_SESSION['SESSION_AREA_CONSTRUIDA'] = $dados['Area_Construida'];
        $_SESSION['SESSION_COD_TIPO_COLETA'] = $dados['Cod_Tipo_coleta'];
        $_SESSION['SESSION_TEM_MANUTENCAO_ESGOTO'] = $dados['Tem_Manutencao_Esgoto'];
        $_SESSION['SESSION_TIPO_ISENCAO'] = $dados['Tipo_isencao'];
        $_SESSION['SESSION_TEM_DESCONTO_INDUSTRIA'] = $dados['DESCONTO_INDUSTRIA'];
        $_SESSION['SESSION_TIPO_IMPOSTO'] = $dados['Tipo_Imposto'];
        $_SESSION['SESSION_PROPIETARIO'] = $dados['Proprietario'];
    } else {
        $_SESSION['SESSION_INSCRICAO_VALIDA'] = "FALSE";
        $_SESSION['SESSION_ZONA_IMOVEL'] = "";
        $_SESSION['SESSION_SITUACAO'] = "";
        $_SESSION['SESSION_UTILIZACAO'] = "";
        $_SESSION['SESSION_CATEGORIA'] = "";
        $_SESSION['SESSION_AREA_TERRENO'] = "";
        $_SESSION['SESSION_AREA_CONSTRUIDA'] = "";
        $_SESSION['SESSION_COD_TIPO_COLETA'] = "";
        $_SESSION['SESSION_TEM_MANUTENCAO_ESGOTO'] = "";
        $_SESSION['SESSION_TIPO_ISENCAO'] = "";
        $_SESSION['SESSION_DESCONTO_INDUSTRIA'] = "";
        $_SESSION['SESSION_TIPO_IMPOSTO'] = "";
        $_SESSION['SESSION_PROPIETARIO'] = "";
    }
}
