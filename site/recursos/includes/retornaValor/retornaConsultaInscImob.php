<?php

include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';

if ($_REQUEST['op'] == '1') {
    retornaRua($pdo);
    die();
}
if ($_REQUEST['op'] == '2') {
    retornaBairro($pdo);
    die();
}
if ($_REQUEST['op'] == '3') {
    retornaCadImob($pdo);
    die();
}
if ($_REQUEST['op'] == '4') {
    buscaValorVenal($pdo);
    die();
}
if ($_REQUEST['op'] == '5') {
    buscaAlugados($pdo);
    die();
}
?>

<?php

// buscaCadastroImovel

function retornaCadImob($pdo) {



    $insc_imovel = $_REQUEST['cod'];


// preparo para realizar o comando sql
    $sql = "SELECT * FROM cad_imobiliario WHERE Inscricao_imob= '$insc_imovel'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $achou = 1;

        //IDENTIFICAÇÃO DO IMÓVEL / PROPRIETÁRIO
        $Proprietario = $dados['Proprietario'];
        $Tipo_Imposto = $dados['Tipo_Imposto'];
        $cad_provisorio = $dados['cad_provisorio'];
        $Excluido = $dados['Excluido'];
        $carne_devolvido = $dados['carne_devolvido'];

        //IDENTIFICAÇÃO DO CONTRIBUINTE
        $nome_contribuinte = $dados['Contribuinte'];
        $Telefone_Contrib = $dados['Telefone_Contrib'];
        $Cpf_Cgc_Contrib = $dados['Cpf_Cgc_Contrib'];
        $Tipo_Pessoa_Contrib = tipo_pessoa($dados['Tipo_Pessoa_Contrib']);
        $RG_Contrib = $dados['RG_Contrib'];
        $Orgao_Contrib = $dados['Orgao_Contrib'];
        $Emissao_Contrib = dataBrasileiro($dados['Emissao_Contrib']);
        $Dt_Nascimento_Contrib = dataBrasileiro($dados['Dt_Nascimento_Contrib']);
        $Cep_Contrib = $dados['Cep_Contrib'];
        $Rua_Contrib = $dados['Rua_Contrib'];
        $Bairro_Contrib = $dados['Bairro_Contrib'];
        $Cidade_Contrib = $dados['Cidade_Contrib'];
        $UF_Contrib = $dados['UF_Contrib'];
        $Numero_Contrib = $dados['Numero_Contrib'];
        $Complemento_Contrib = $dados['Complemento_Contrib'];

        // IDENTIFICAÇÃO LOCALIZAÇÃO DO IMÓVEL
        $Cod_Bairro = $dados['Cod_Bairro'];
        $Cod_Rua = $dados['Cod_Rua'];
        $Numero = $dados['Numero'];
        $Quadra = $dados['Quadra'];
        $Lote = $dados['Lote'];
        $Zona_Fiscal = $dados['Zona_Fiscal'];
        $Complemento = $dados['Complemento'];

        //ENDEREÇO CORRESPÔNDENCIA
        $Nome_Corr = $dados['Nome_Corr'];
        $Telefone_Corr = $dados['Telefone'];
        $Cpf_Cgc_Corr = $dados['Cpf_Cgc'];
        $Tipo_Pessoa_Corr = tipo_pessoa($dados['Tipo_Pessoa']);
        $Cep_Corr = $dados['Cep_Corr'];
        $Rua_Corr = $dados['Rua_Corr'];
        $Bairro_Corr = $dados['Bairro_Corr'];
        $Cidade_Corr = $dados['Cidade_Corr'];
        $Uf_Corr = $dados['Uf_Corr'];
        $Numero_corr = $dados['Numero_corr'];
        $Complemento_Corr = $dados['Complemento_Corr'];


        //DIMENSÃO DO IMÓVEL
        $Largura_Terreno = $dados['Largura_Terreno'];
        $Comprimento_Terreno = $dados['Comprimento_Terreno'];
        $Area_Terreno = $dados['Area_Terreno'];
        $Area_Construida = $dados['Area_Construida'];
        $Fracao_Ideal = $dados['Fracao_Ideal'];
        $Tem_Manutencao_Esgoto = $dados['Tem_Manutencao_Esgoto'];
        $DESCONTO_INDUSTRIA = $dados['DESCONTO_INDUSTRIA'];

        //ESTADO DA CONSTRUÇÃO
        $EC_Tijolo = $dados['EC_Tijolo'];
        $EC_Madeira = $dados['EC_Madeira'];
        $EC_Embocada = $dados['EC_Embocada'];
        $EC_Pintada = $dados['EC_Pintada'];
        $EC_Telha = $dados['EC_Telha'];
        $EC_laje = $dados['EC_laje'];
        $EC_Taco = $dados['EC_Taco'];
        $EC_Ceramica = $dados['EC_Ceramica'];
        $EC_Outros = $dados['EC_Outros'];
        $Utilizacao_imovel = $dados['Utilizacao_imovel'];
        $Situacao_Terreno = $dados['Situacao_Terreno'];
        $Categoria = $dados['Categoria'];
        $Patrimonio_imovel = $dados['Patrimonio_imovel'];
        $Tipo_coleta = $dados['Cod_Tipo_coleta'];
        $Ano_Cadastramento = $dados['Ano_Cadastramento'];

        //ISENÇÃO
        $Tipo_isencao = $dados['Tipo_isencao'];
        $Fundamento_Legal_Isencao = $dados['Fundamento_Legal_Isencao'];
        $Proc_Adm_Isencao = $dados['Proc_Adm_Isencao'];
        $Dt_Concessao_Isencao = dataBrasileiro($dados['Dt_Concessao_Isencao']);
        $Dt_Averbacao = dataBrasileiro($dados['Dt_Averbacao']);
        $Processo_Averbacao = $dados['Processo_Averbacao'];
        $Legalizado = $dados['Legalizado'];
        $Processo_Legalizacao = $dados['Processo_Legalizacao'];
        $observacao = buscaObsCadImob($pdo, $insc_imovel);
    } else {
        $achou = 0;
        $Proprietario = "";
        $Tipo_Imposto = "";
        $cad_provisorio = "";
        $Excluido = "";
        $carne_devolvido = "";
        $nome_contribuinte = "";
        $Telefone_Contrib = "";
        $Cpf_Cgc_Contrib = "";
        $Tipo_Pessoa_Contrib = "";
        $RG_Contrib = "";
        $Orgao_Contrib = "";
        $Emissao_Contrib = "";
        $Dt_Nascimento_Contrib = "";
        $Cep_Contrib = "";
        $Rua_Contrib = "";
        $Bairro_Contrib = "";
        $Cidade_Contrib = "";
        $UF_Contrib = "";
        $Numero_Contrib = "";
        $Complemento_Contrib = "";
        $Cod_Bairro = "";
        $Cod_Rua = "";
        $Numero = "";
        $Quadra = "";
        $Lote = "";
        $Zona_Fiscal = "";
        $Complemento = "";
        $Nome_Corr = "";
        $Telefone_Corr = "";
        $Cpf_Cgc_Corr = "";
        $Tipo_Pessoa_Corr = "";
        $Cep_Corr = "";
        $Rua_Corr = "";
        $Bairro_Corr = "";
        $Cidade_Corr = "";
        $Uf_Corr = "";
        $Numero_corr = "";
        $Complemento_Corr = "";
        $Largura_Terreno = "";
        $Comprimento_Terreno = "";
        $Area_Terreno = "";
        $Area_Construida = "";
        $Fracao_Ideal = "";
        $Tem_Manutencao_Esgoto = "";
        $DESCONTO_INDUSTRIA = "";
        $EC_Tijolo = "";
        $EC_Madeira = "";
        $EC_Embocada = "";
        $EC_Pintada = "";
        $EC_Telha = "";
        $EC_laje = "";
        $EC_Taco = "";
        $EC_Ceramica = "";
        $EC_Outros = "";
        $Utilizacao_imovel = "";
        $Situacao_Terreno = "";
        $Categoria = "";
        $Patrimonio_imovel = "";
        $Tipo_coleta = "";
        $Ano_Cadastramento = "";
        $Tipo_isencao = "";
        $Fundamento_Legal_Isencao = "";
        $Proc_Adm_Isencao = "";
        $Dt_Concessao_Isencao = "";
        $Dt_Averbacao = "";
        $Processo_Averbacao = "";
        $Legalizado = "";
        $Processo_Legalizacao = "";
        $observacao = "";
    }




    $var = Array(
        "Proprietario" => "$Proprietario",
        "Tipo_Imposto" => "$Tipo_Imposto",
        "cad_provisorio" => "$cad_provisorio",
        "Excluido" => "$Excluido",
        "carne_devolvido" => "$carne_devolvido",
        "nome_contribuinte" => "$nome_contribuinte",
        "Telefone_Contrib" => "$Telefone_Contrib",
        "Cpf_Cgc_Contrib" => "$Cpf_Cgc_Contrib",
        "Tipo_Pessoa_Contrib" => "$Tipo_Pessoa_Contrib",
        "RG_Contrib" => "$RG_Contrib",
        "Orgao_Contrib" => "$Orgao_Contrib",
        "Emissao_Contrib" => "$Emissao_Contrib",
        "Dt_Nascimento_Contrib" => "$Dt_Nascimento_Contrib",
        "Cep_Contrib" => "$Cep_Contrib",
        "Rua_Contrib" => "$Rua_Contrib",
        "Bairro_Contrib" => "$Bairro_Contrib",
        "Cidade_Contrib" => "$Cidade_Contrib",
        "UF_Contrib" => "$UF_Contrib",
        "Numero_Contrib" => "$Numero_Contrib",
        "Complemento_Contrib" => "$Complemento_Contrib",
        "Cod_Bairro" => "$Cod_Bairro",
        "Cod_Rua" => "$Cod_Rua",
        "Numero" => "$Numero",
        "Quadra" => "$Quadra",
        "Lote" => "$Lote",
        "Zona_Fiscal" => "$Zona_Fiscal",
        "Complemento" => "$Complemento",
        "Nome_Corr" => "$Nome_Corr",
        "Telefone" => "$Telefone_Corr",
        "Cpf_Cgc_Corr" => "$Cpf_Cgc_Corr",
        "Tipo_Pessoa_Corr" => "$Tipo_Pessoa_Corr",
        "Cep_Corr" => "$Cep_Corr",
        "Rua_Corr" => "$Rua_Corr",
        "Bairro_Corr" => "$Bairro_Corr",
        "Cidade_Corr" => "$Cidade_Corr",
        "Uf_Corr" => "$Uf_Corr",
        "Numero_corr" => "$Numero_corr",
        "Complemento_Corr" => "$Complemento_Corr",
        "Largura_Terreno" => "$Largura_Terreno",
        "Comprimento_Terreno" => "$Comprimento_Terreno",
        "Area_Terreno" => "$Area_Terreno",
        "Area_Construida" => "$Area_Construida",
        "Fracao_Ideal" => "$Fracao_Ideal",
        "Tem_Manutencao_Esgoto" => "$Tem_Manutencao_Esgoto",
        "DESCONTO_INDUSTRIA" => "$DESCONTO_INDUSTRIA",
        "EC_Tijolo" => "$EC_Tijolo",
        "EC_Madeira" => "$EC_Madeira",
        "EC_Embocada" => "$EC_Embocada",
        "EC_Pintada" => "$EC_Pintada",
        "EC_Telha" => "$EC_Telha",
        "EC_laje" => "$EC_laje",
        "EC_Taco" => "$EC_Taco",
        "EC_Ceramica" => "$EC_Ceramica",
        "EC_Outros" => "$EC_Outros",
        "Utilizacao_imovel" => "$Utilizacao_imovel",
        "Situacao_Terreno" => "$Situacao_Terreno",
        "Categoria" => "$Categoria",
        "Patrimonio_imovel" => "$Patrimonio_imovel",
        "Tipo_coleta" => "$Tipo_coleta",
        "Ano_Cadastramento" => "$Ano_Cadastramento",
        "Tipo_isencao" => "$Tipo_isencao",
        "Fundamento_Legal_Isencao" => "$Fundamento_Legal_Isencao",
        "Proc_Adm_Isencao" => "$Proc_Adm_Isencao",
        "Dt_Concessao_Isencao" => "$Dt_Concessao_Isencao",
        "Dt_Averbacao" => "$Dt_Averbacao",
        "Processo_Averbacao" => "$Processo_Averbacao",
        "Legalizado" => "$Legalizado",
        "Processo_Legalizacao" => "$Processo_Legalizacao",
        "observacao" => "$observacao",
        "achou" => "$achou"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}
?>







<?php

function retornaRua($pdo) {
    $cod_rua = $_REQUEST ['cod'];

// preparo para realizar o comando sql
    $sql = "SELECT * FROM Rua WHERE Cod_Rua = '$cod_rua'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $achou = 1;
        $descricao = $dados[
                'Desc_rua'];
        $cep = $dados['cep'];
    } else {
        $achou = "";
        $descricao = "";
        $cep = "" . $sql;
    }


    $var = Array(
        "achou" => "$achou",
        "descricao" => "$descricao",
        "cep" => "$cep"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}

function retornaBairro($pdo) {
    $cod_bairro = $_REQUEST['cod'];


// preparo para realizar o comando sql
    $sql = "SELECT * FROM Bairro WHERE Cod_Bairro = '$cod_bairro'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $achou = 1;
        $descricao = $dados[
                'Desc_Bairro'];
    } else {
        $achou = "";
        $descricao = "" . $sql;
    }


    $var = Array(
        "achou" => "$achou",
        "descricao" => "$descricao"
    );
// convertemos em json e colocamos na tela
    echo json_encode($var);
}

function tipo_pessoa($valor) {
    if ($valor == "F")
        return "Física";
    ELSE
        return "Juridica";
}

function buscaObsCadImob($pdo, $inscricao_imob) {

    // preparo para realizar o comando sql
    $sql = "SELECT * FROM Observacao_imob WHERE Inscricao_Imob = '$inscricao_imob'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['Observacao'];
    } else {
        return "";
    }
}

function buscaValorVenal($pdo) {
    $inscricao_imob = $_REQUEST['cod'];

// preparo para realizar o comando sql
    $sql = "SELECT * FROM Valor_Venal WHERE Inscricao_Imob = '$inscricao_imob' ORDER BY Ano DESC";
    $query = $pdo->prepare($sql);

//executo o comando sql
// Faço uma comparação para saber se a busca trouxe algum resultado
    $query->execute();
// crio um array através do comando fetchAll
    $result = $query->fetchAll();
// após executar o comando fetchAll() conto a quantidade de registro atráves do rowCount()
    $numero_registro = $query->rowCount();

// se existir algum registro encontrado    
    if ($numero_registro > 0) {
        $linha[0] = Array(
            "Achou" => "1",
        );
        for ($i = 0; $i < $numero_registro; $i++) {
            $linha[$i + 1] = Array(
                "Achou" => "1",
                "Ano" => $result[$i]['Ano'],
                "Valor" => $result[$i]['Valor'],
                "Aliquota" => $result[$i]['Aliquota'],
                "Data_Calculo" => dataBrasileiro($result[$i]['Data_Calculo'])
            );
        }
    } else {
        $linha[0] = Array(
            "Achou" => "0",
        );
    }


    echo json_encode($linha);
}

function buscaAlugados($pdo) {
    $inscricao_imob = $_REQUEST['cod'];

// preparo para realizar o comando sql
    $sql = "SELECT * FROM Alugado_Pela_Prefeitura WHERE Inscricao_Imob = '$inscricao_imob' ORDER BY Processo DESC";
    $query = $pdo->prepare($sql);

//executo o comando sql
// Faço uma comparação para saber se a busca trouxe algum resultado
    $query->execute();
// crio um array através do comando fetchAll
    $result = $query->fetchAll();
// após executar o comando fetchAll() conto a quantidade de registro atráves do rowCount()
    $numero_registro = $query->rowCount();

// se existir algum registro encontrado    
    if ($numero_registro > 0) {
        $linha[0] = Array(
            "Achou" => "1",
        );
        for ($i = 0; $i < $numero_registro; $i++) {
            $linha[$i + 1] = Array(
                "Achou" => "1",
                "Processo" => $result[$i]['Processo'],
                "Data_Inicio" => dataBrasileiro($result[$i]['Data_Inicio']),
                "Data_Fim" => dataBrasileiro($result[$i]['Data_Fim'])
            );
        }
    } else {
        $linha[0] = Array(
            "Achou" => "0",
        );
    }


    echo json_encode($linha);
}
?>