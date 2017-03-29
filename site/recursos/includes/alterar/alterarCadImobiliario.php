<?php

include_once '../estrutura/controle/validarSessao.php';
include_once '../funcaoPHP/funcaoData.php';


//IDENTIFICAÇÃO DO IMÓVEL / PROPRIETÁRIO
$inscricao_imob = $_POST['inscricao_imovel'];
$_SESSION['INSC_IMOVEL'] = $_POST['inscricao_imovel'];

$nome_proprietario_imovel = $_POST['nome_proprietario_imovel'];
$_SESSION['NOME_PROPRIETARIO'] = $_POST['nome_proprietario_imovel'];

$tipo_imposto_imovel = $_POST['tipo_imposto_imovel'];
$_SESSION['TIPO_IMPOSTO_IMOVEL'] = $_POST['tipo_imposto_imovel'];


if (isset($_POST['cadastro_provisorio'])) {
    $cadastro_provisorio = "S";
} else {
    $cadastro_provisorio = "N";
}

if (isset($_POST['excluido'])) {
    $excluido = "S";
} else {
    $excluido = "N";
}

if (isset($_POST['carne_devolvido'])) {
    $carne_devolvido = "S";
} else {
    $carne_devolvido = "N";
}

//IDENTIFICAÇÃO DO CONTRIBUINTE
$nome_contribuinte = $_POST['nome_contribuinte'];
$telefone_contribuinte = $_POST['telefone_contribuinte'];

if ($_POST['tipo_pessoa_contribuinte'] == "Física") {
    $tipo_pessoa_contribuinte = "F";
} else if ($_POST['tipo_pessoa_contribuinte'] == "Juridica") {
    $tipo_pessoa_contribuinte = "J";
} else {
    $tipo_pessoa_contribuinte = "";
}

$tipo_pessoa_contribuinte;

$cpf_cnpj_contribuinte = $_POST['cpf_cnpj_contribuinte'];
$rg_contribuinte = $_POST['rg_contribuinte'];
$orgao_rg_contribuinte = $_POST['orgao_rg_contribuinte'];
if (empty($_POST['emissao_rg_contribuinte'])) {
    $emissao_rg_contribuinte = null;
} else {
    $emissao_rg_contribuinte = dataAmericano($_POST['emissao_rg_contribuinte']);
}
if (empty($_POST['data_nascimento_contribuinte'])) {
    $data_nascimento_contribuinte = null;
} else {
    $data_nascimento_contribuinte = dataAmericano($_POST['data_nascimento_contribuinte']);
}

$cep_contribuinte = $_POST['cep_contribuinte'];
$rua_contribuinte = $_POST['rua_contribuinte'];
$bairro_contribuinte = substr($_POST['bairro_contribuinte'], 0, 19);
$cidade_contribuinte = $_POST['cidade_contribuinte'];
$uf_contribuinte = $_POST['uf_contribuinte'];
$numero_end_contribuinte = $_POST['numero_end_contribuinte'];
$complemento_end_contribuinte = $_POST['complemento_end_contribuinte'];

//IDENTIFICAÇÃO LOCALIZAÇÃO DO IMÓVEL
$cod_bairro_imovel = $_POST['cod_bairro_imovel'];
$desc_bairro_imovel = $_POST['desc_bairro_imovel'];
$cod_logr_imovel = $_POST['cod_logr_imovel'];
$desc_logr_imovel = $_POST['desc_logr_imovel'];
$num_end_imovel = $_POST['num_end_imovel'];
$quadra_imovel = $_POST['quadra_imovel'];
$lote_imovel = $_POST['lote_imovel'];
$zona_imovel = $_POST['zona_imovel'];
$_SESSION['ZONA_IMOVEL'] = $_POST['zona_imovel'];
$compl_end_imovel = $_POST['compl_end_imovel'];


//ENDEREÇO CORRESPÔNDENCIA
$nome_responsavel_correspondencia = $_POST['nome_responsavel_correspondencia'];
$telefone_responsavel_correspondencia = $_POST['telefone_responsavel_correspondencia'];
$cep_correspondencia = $_POST['cep_correspondencia'];
$rua_correspondencia = $_POST['rua_correspondencia'];
$bairro_correspondencia = substr($_POST['bairro_correspondencia'], 0, 19);
$cidade_correspondencia = $_POST['cidade_correspondencia'];
$uf_correspondencia = $_POST['uf_correspondencia'];
$numero_end_correspondencia = $_POST['numero_end_correspondencia'];
$complemento_end_correspondencia = $_POST['complemento_end_correspondencia'];
$cpf_cnpj_correspondencia = $_POST['cpf_cnpj_correspondencia'];

if ($_POST['tipo_pessoa_correspondencia'] == "Física") {
    $tipo_pessoa_correspondencia = "F";
} else if ($_POST['tipo_pessoa_correspondencia'] == "Juridica") {
    $tipo_pessoa_correspondencia = "J";
} else {
    $tipo_pessoa_correspondencia = "";
}


$tipo_pessoa_correspondencia;



//DIMENSÃO DO IMÓVEL
$largura_terreno_imovel = $_POST['largura_terreno_imovel'];
$comprimento_terreno_imovel = $_POST['comprimento_terreno_imovel'];
$area_terreno_imovel = $_POST['area_terreno_imovel'];
$_SESSION['AREA_TERRENO'] = $area_terreno_imovel;
$area_construida_imovel = $_POST['area_construida_imovel'];
$_SESSION['AREA_CONSTRUIDA'] = $area_construida_imovel;
$area_unidade = 0;
$fracao_ideal_imovel = $_POST['fracao_ideal_imovel'];

if (isset($_POST['contem_manutencao_esgoto'])) {
    $contem_manutencao_esgoto = "S";
} else {
    $contem_manutencao_esgoto = "N";
}
$_SESSION['TEM_MAN_ESGOTO'] = $contem_manutencao_esgoto;
if (isset($_POST['desconto_industria'])) {
    $desconto_industria = "S";
} else {
    $desconto_industria = "N";
}
$_SESSION['DESCONTO_INDUSTRIA'] = $desconto_industria;

//ESTADO DA CONSTRUÇÃO
if (isset($_POST['construcao_tijolo'])) {
    $construcao_tijolo = "S";
} else {
    $construcao_tijolo = "N";
}

if (isset($_POST['construcao_madeira'])) {
    $construcao_madeira = "S";
} else {
    $construcao_madeira = "N";
}

if (isset($_POST['construcao_embocada'])) {
    $construcao_embocada = "S";
} else {
    $construcao_embocada = "N";
}

if (isset($_POST['construcao_pintada'])) {
    $construcao_pintada = "S";
} else {
    $construcao_pintada = "N";
}

if (isset($_POST['construcao_telha'])) {
    $construcao_telha = "S";
} else {
    $construcao_telha = "N";
}

if (isset($_POST['construcao_laje'])) {
    $construcao_laje = "S";
} else {
    $construcao_laje = "N";
}

if (isset($_POST['construcao_taco'])) {
    $construcao_taco = "S";
} else {
    $construcao_taco = "N";
}

if (isset($_POST['construcao_ceramico'])) {
    $construcao_ceramico = "S";
} else {
    $construcao_ceramico = "N";
}

if (isset($_POST['construcao_outros'])) {
    $construcao_outros = "S";
} else {
    $construcao_outros = "N";
}

$utilizacao = $_POST['utilizacao'];
$_SESSION['UTILIZACAO_IMOB'] = $utilizacao;
$situacao_terreno = $_POST['situacao_terreno'];
$_SESSION['SITUACAO_TERRENO'] = $situacao_terreno;
$categoria = $_POST['categoria'];
$_SESSION['CATEGORIA'] = $categoria;
$patrimonio_liquido = $_POST['patrimonio_liquido'];
$tipo_coleta = $_POST['tipo_coleta'];
$_SESSION['TIPO_COLETA'] = $_POST['tipo_coleta'];
$ano_cadastramento_imovel = $_POST['ano_cadastramento_imovel'];

//ISENÇÃO
$tipo_isencao = $_POST['tipo_isencao'];
$_SESSION['TIPO_ISENCAO'] = $_POST['tipo_isencao'];
$fundamento_legal = $_POST['fundamento_legal'];
$processo_administrativo = $_POST['processo_administrativo'];
if (empty($_POST['data_concessao'])) {
    $data_concessao = null;
} else {
    $data_concessao = dataAmericano($_POST['data_concessao']);
}



//OUTROS >> AVERBACAO
if (empty($_POST['data_averbacao'])) {
    $data_averbacao = null;
} else {
    $data_averbacao = dataAmericano($_POST['data_averbacao']);
}
$numero_processo_averbacao = $_POST['numero_processo_averbacao'];

//OUTROS >> LEGALIZAÇÃO
$legalizacao_imovel = $_POST['legalizacao_imovel'];
$numero_processo_legalizacao = $_POST['numero_processo_legalizacao'];

//OUTROS >> ALTERAÇÕES
if (empty($_POST['data_ultima_alteracao'])) {
    $data_ultima_alteracao = null;
} else {
    $data_ultima_alteracao = dataAmericano($_POST['data_ultima_alteracao']);
}


$numero_processo_alteracao = $_POST['numero_processo_alteracao'];
$ano_processo_alteracao = $_POST['ano_processo_alteracao'];

// INFORMAÇÕES GERAIS
$observacao_imovel = $_POST['observacao_imovel'];

include_once '../estrutura/conexao/conexao.php';

$pdo->beginTransaction(); /* Inicia a transação */


$sql = " UPDATE Cad_Imobiliario ";
$sql = $sql . " SET Tipo_Imposto = '$tipo_imposto_imovel', ";
$sql = $sql . " Proprietario = '$nome_proprietario_imovel', ";
$sql = $sql . " Tipo_Pessoa = '$tipo_pessoa_correspondencia', ";
$sql = $sql . " Cpf_Cgc = '$cpf_cnpj_correspondencia', ";
$sql = $sql . " Cod_Rua = '$cod_logr_imovel', ";
$sql = $sql . " Cod_Bairro = '$cod_bairro_imovel', ";
$sql = $sql . " Numero = '$num_end_imovel', ";
$sql = $sql . " Complemento = '$compl_end_imovel', ";
$sql = $sql . " Quadra = '$quadra_imovel', ";
$sql = $sql . " Lote = '$lote_imovel', ";
$sql = $sql . " Zona_Fiscal = '$zona_imovel', ";
$sql = $sql . " Telefone = '$telefone_responsavel_correspondencia', ";
$sql = $sql . " Nome_Corr = '$nome_responsavel_correspondencia', ";
$sql = $sql . " Rua_Corr = '$rua_correspondencia', ";
$sql = $sql . " Numero_corr = '$numero_end_correspondencia', ";
$sql = $sql . " Complemento_Corr = '$complemento_end_correspondencia', ";
$sql = $sql . " Bairro_Corr = '$bairro_correspondencia', ";
$sql = $sql . " Cidade_Corr = '$cidade_correspondencia', ";
$sql = $sql . " Uf_Corr = '$uf_correspondencia', ";
$sql = $sql . " Cep_Corr = '$cep_correspondencia', ";
$sql = $sql . " Largura_Terreno = '$largura_terreno_imovel', ";
$sql = $sql . " Comprimento_Terreno = '$comprimento_terreno_imovel', ";
$sql = $sql . " Area_Terreno = '$area_terreno_imovel', ";
$sql = $sql . " Area_Construida = '$area_construida_imovel', ";
$sql = $sql . " Area_Unidade = '$area_unidade', ";
$sql = $sql . " Fracao_Ideal = '$fracao_ideal_imovel', ";
$sql = $sql . " Utilizacao_imovel = '$utilizacao', ";
$sql = $sql . " Categoria = '$categoria', ";
$sql = $sql . " Patrimonio_imovel = '$patrimonio_liquido', ";
$sql = $sql . " EC_Tijolo = '$construcao_tijolo', ";
$sql = $sql . " EC_Madeira = '$construcao_madeira', ";
$sql = $sql . " EC_Embocada = '$construcao_embocada', ";
$sql = $sql . " EC_Pintada = '$construcao_pintada', ";
$sql = $sql . " EC_Telha = '$construcao_telha', ";
$sql = $sql . " EC_laje = '$construcao_laje', ";
$sql = $sql . " EC_Taco = '$construcao_taco', ";
$sql = $sql . " EC_Ceramica = '$construcao_ceramico', ";
$sql = $sql . " EC_Outros = '$construcao_outros', ";
$sql = $sql . " Tipo_isencao = '$tipo_isencao', ";
$sql = $sql . " Dt_Averbacao = '$data_averbacao', ";
$sql = $sql . " Processo_Averbacao = '$numero_processo_averbacao', ";
$sql = $sql . " Data_Ultima_alteracao = '$data_ultima_alteracao', ";
$sql = $sql . " Proc_ultima_alteracao = '$numero_processo_alteracao', ";
$sql = $sql . " Excluido = '$excluido', ";
$sql = $sql . " Legalizado = '$legalizacao_imovel', ";
$sql = $sql . " Processo_Legalizacao = '$numero_processo_legalizacao', ";
$sql = $sql . " Cod_Tipo_coleta = '$tipo_coleta', ";
$sql = $sql . " Ano_Cadastramento = '$ano_cadastramento_imovel', ";
$sql = $sql . " Situacao_Terreno = '$situacao_terreno', ";
$sql = $sql . " Tem_Manutencao_Esgoto = '$contem_manutencao_esgoto', ";
$sql = $sql . " DESCONTO_INDUSTRIA = '$desconto_industria', ";
$sql = $sql . " Contribuinte = '$nome_contribuinte', ";
$sql = $sql . " cad_provisorio = '$cadastro_provisorio', ";
$sql = $sql . " carne_devolvido = '$carne_devolvido', ";
$sql = $sql . " Ano_Proc_ultima_alteracao = '$ano_processo_alteracao', ";
$sql = $sql . " RG_Contrib = '$rg_contribuinte', ";
$sql = $sql . " Orgao_Contrib = '$orgao_rg_contribuinte', ";
$sql = $sql . " Emissao_Contrib = '$emissao_rg_contribuinte', ";
$sql = $sql . " Tipo_Pessoa_Contrib = '$tipo_pessoa_contribuinte', ";
$sql = $sql . " Cpf_Cgc_Contrib = '$cpf_cnpj_contribuinte', ";
$sql = $sql . " Dt_Nascimento_Contrib = '$data_nascimento_contribuinte', ";
$sql = $sql . " Rua_Contrib = '$rua_contribuinte', ";
$sql = $sql . " Numero_Contrib = '$numero_end_contribuinte', ";
$sql = $sql . " Complemento_Contrib = '$complemento_end_contribuinte', ";
$sql = $sql . " Bairro_Contrib = '$bairro_contribuinte', ";
$sql = $sql . " Cidade_Contrib = '$cidade_contribuinte', ";
$sql = $sql . " UF_Contrib = '$uf_contribuinte', ";
$sql = $sql . " Cep_Contrib = '$cep_contribuinte', ";
$sql = $sql . " Telefone_Contrib = '$telefone_contribuinte', ";
$sql = $sql . " Fundamento_Legal_Isencao = '$fundamento_legal', ";
$sql = $sql . " Proc_Adm_Isencao = '$processo_administrativo', ";
$sql = $sql . " Dt_Concessao_Isencao = '$data_concessao' ";
$sql = $sql . " WHERE Inscricao_Imob = '$inscricao_imob'";

$executa = $pdo->query($sql);
if (!$executa) {
    die("Erro na realização do procedimento");
}



// DELETO TODOS OS CONTRATOS CADASTRADOS PELA INSCRICAO (ALUGADO PELA PREFEITURA)

$sql_delete_alugados = "DELETE FROM Alugado_Pela_Prefeitura WHERE Inscricao_Imob = '$inscricao_imob' ";

$executa = $pdo->query($sql_delete_alugados);
if (!$executa) {
    die("Erro na realização do procedimento");
}



//CADASTRADOS TODOS OS CONTRATOS  DE ALUGADO PELA PREFEITURA

if ($_POST) {
    $numeroDocumento = $_POST['numeroProcessoAluguel'];
    $dataInicialDocumento = $_POST['dataInicialProcessoAluguel'];
    $dataFinalDocumento = $_POST['dataFinalProcessoAluguel'];

    $quant_linhas = count($numeroDocumento);

    for ($i = 0; $i < $quant_linhas; $i++) {

        if (($numeroDocumento[$i] != "") && ($dataInicialDocumento[$i] != "") && ($dataFinalDocumento[$i] != "")) {

            $dataInicialDocumento[$i] = dataAmericano($dataInicialDocumento[$i]);
            $dataFinalDocumento[$i] = dataAmericano($dataFinalDocumento[$i]);



            $sql_alugado = " INSERT INTO Alugado_Pela_Prefeitura";
            $sql_alugado = $sql_alugado . "(Inscricao_Imob,";
            $sql_alugado = $sql_alugado . "Processo,";
            $sql_alugado = $sql_alugado . "Data_Inicio ,";
            $sql_alugado = $sql_alugado . "Data_Fim)";

            $sql_alugado = $sql_alugado . "VALUES";
            $sql_alugado = $sql_alugado . "('$inscricao_imob', ";
            $sql_alugado = $sql_alugado . "'$numeroDocumento[$i]', ";
            $sql_alugado = $sql_alugado . "'$dataInicialDocumento[$i]', ";
            $sql_alugado = $sql_alugado . "'$dataFinalDocumento[$i]') ";
            $executa_alugado = $pdo->query($sql_alugado);
            if (!$executa_alugado) {
                die("Erro na realização do procedimento");
            }
        }
    }
}




// INFORMAÇÕES GERAIS

if ($_POST['observacao_imovel'] != "") {
    $historico_obs = buscaHistoricoObs($pdo, $inscricao_imob);
    $observacao_imovel = $_POST['observacao_imovel'] . " USUÁRIO :" . $_SESSION["usuario"] . " DATA :" . date("d/m/Y") . "|" . $historico_obs;

    $sql_observacao = "UPDATE observacao_imob";
    $sql_observacao = $sql_observacao . " SET Observacao = '$observacao_imovel' ";
    $sql_observacao = $sql_observacao . " WHERE  Inscricao_imob = '$inscricao_imob'";


    $executa_observacao = $pdo->query($sql_observacao);


    if (!$executa_observacao) {
        die("Erro na realização do procedimento");
    }
}


$pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
?>

<script>

    var r = window.confirm("Deseja Calcular IPTU?");
    if (r == true) {
        location.href = '../../../CalcularIptuCadastro.php';
    }else{
    //    location.href = '../../../CalcularIptuCadastro.php'
    location.href = '../../../CadastroImovel.php'
}
</script>





<?php

// Funçãoa que retorna a ultima observação cadastrada
function buscaHistoricoObs($pdo, $inscricao_imob) {
    $sql_historico = "SELECT * ";
    $sql_historico = $sql_historico . " FROM observacao_imob";
    $sql_historico = $sql_historico . " WHERE Inscricao_imob = '$inscricao_imob'";

    $query = $pdo->prepare($sql_historico);

    //executo o comando sql
    $query->execute();

    // Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['Observacao'];
    } else {
        return "";
    }
}
?>