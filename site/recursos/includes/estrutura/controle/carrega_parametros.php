<?php

include_once './validarSessao.php';
include_once '../../funcaoPHP/funcaoCpfCnpj.php';

// função para pegar
// nome do cliente na base
// logo do cliente
// logo 
function arquivo_configuracao($pdo) {
//   comando sql para retornar dados do sistema
    $sql_arquivo = "SELECT * FROM configuracao_sistema";

//   preparo o comando sql
    $query = $pdo->prepare($sql_arquivo);
//    executo o comando sql
    $query->execute();

//    comparo pra saber se retornou valor
    if (($dados_arquivo = $query->fetch()) == true) {
        $_SESSION['C_CAMINHO_LOGO'] = $dados_arquivo['Caminho_logo'];
        $_SESSION['C_PREFEITURA'] = $dados_arquivo['Prefeitura'];
        $_SESSION['C_SECRETARIA'] = $dados_arquivo['Secretaria'];
        $_SESSION['C_ESTADO'] = $dados_arquivo['Estado'];
        $_SESSION['C_LOGO_PB'] = $dados_arquivo['logo_pb'];
        $_SESSION['C_CNPJ'] = FUN_COLOCAR_MASCARA_CPF_CNPJ($dados_arquivo['CNPJ_Prefeitura']);
        $_SESSION['C_CEP'] = str_replace('-', '', $dados_arquivo['Cep_Prefeitura']);
        $_SESSION['C_ENDERECO'] = $dados_arquivo['Endereco_Prefeitura'];
        $_SESSION['C_NUMERO'] = $dados_arquivo['numero'];
        $_SESSION['C_COMPLEMENTO'] = $dados_arquivo['complemento'];
        $_SESSION['C_BAIRRO'] = $dados_arquivo['Bairro_Prefeitura'];
        $_SESSION['C_CIDADE'] = $dados_arquivo['cidade'];
        $_SESSION['C_UF'] = $dados_arquivo['uf'];
    }
    
}

//função para pegar valor moeda dia (ufir)
function valor_moeda_dia($pdo) {

//      data para saber a data do dia
    $data = dataAmericano(date('d/m/Y'));

//        comando sql para buscar o valoe da moeda
    $sql = "SELECT * FROM moeda WHERE data_moeda = '$data' AND cod_tipo_moeda = '02'";

//     executo o comando sql
    $resultado = $pdo->query($sql);


//   verifico se existe valor na base de dados
    if ($resultado->fetchColumn() > 0) {

//     executo o comando sql novamente armazenando em
//      uma variavel onde ira conter o valor da ufir diaria  
        foreach ($pdo->query($sql) as $row) {
            $_SESSION['C_VALOR_MOEDA_DIA_UFIR'] = $row['valor_moeda'];
        }
    }

    unset($_SESSION['carregar_parametros']);
    $pdo = null;
    header('location:../../../../inicial.php');
    exit();
}

//validação para acesso apenas pelo apos efetuar login
if ($_SESSION['carregar_parametros'] == "TRUE") {



    try {
//    biblioteca data
        require_once '../../funcaoPHP/funcaoData.php';

//    biblioteca de conexao com o banco de dados
        include_once '../conexao/conexao.php';
//    chamada do arquivo de configuração do sistema
        arquivo_configuracao($pdo);

//    chamada da função valor moeda dia
        valor_moeda_dia($pdo);
    } catch (PDOException $ex) {
        $_SESSION['mensagem'] = $ex->getMessage();
        header('location:../../../../inicial.php');
    exit();
    }
} else {


    header('location:../../../../inicial.php');
    exit();
}
?>

