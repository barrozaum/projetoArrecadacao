<?php

//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();

// biblioteca para validar string informada    
    include ('../funcaoPHP/function_letraMaiscula.php');

//   BIBLIOTECA PARA FORMATAR CPF_CNPJ
    include_once '../funcaoPHP/funcaoCpfCnpj.php';

//    aplica filtro na string enviada (LetraMaiuscula)
    $caminho = $_SESSION['C_CAMINHO_LOGO'];
    $nome_cliente_Letra_Maiscula = letraMaiuscula($_POST['txt_nome_cliente']);
    $unidade_gestora_Letra_Maiscula = letraMaiuscula($_POST['txt_unidade_gestora']);
    $cnpj_Letra_Maiscula = letraMaiuscula($_POST['txt_cpf_cnpj_adquirinte']);
    $tipo_pessoa_Letra_Maiscula = letraMaiuscula($_POST['txt_tipo_pessoa_adquirinte']);
    $cep_Letra_Maiscula = letraMaiuscula($_POST['txt_cep_adquirinte']);
    $rua_Letra_Maiscula = letraMaiuscula($_POST['txt_rua_adquirinte']);
    $bairro_Letra_Maiscula = letraMaiuscula($_POST['txt_bairro_adquirinte']);
    $cidade_Letra_Maiscula = letraMaiuscula($_POST['txt_cidade_adquirinte']);
    $uf_Letra_Maiscula = letraMaiuscula($_POST['txt_uf_adquirinte']);
    $numero_endereco_Letra_Maiscula = letraMaiuscula($_POST['txt_numero_endereco_adquirinte']);
    $complemento_endereco_Letra_Maiscula = letraMaiuscula($_POST['txt_complemento_endereco_adquirinte']);


// variaves serão preenchidas por valores do formulario
// valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($nome_cliente_Letra_Maiscula) > 2 && strlen($nome_cliente_Letra_Maiscula) < 81)) {
        $nome_empresa_cliente = $nome_cliente_Letra_Maiscula;
    } else {
        $array_erros['txt_nome_cliente'] = 'POR FAVOR ENTRE COM UM NOME CLIENTE VÁLIDO \n';
    }

    if ((strlen($unidade_gestora_Letra_Maiscula) > 2 && strlen($unidade_gestora_Letra_Maiscula) < 81)) {
        $unidade_gestora_sistema_cliente = $unidade_gestora_Letra_Maiscula;
    } else {
        $array_erros['txt_unidade_gestora'] = 'POR FAVOR ENTRE COM UM UNIDADE VÁLIDA \n';
    }

    if ((strlen($cnpj_Letra_Maiscula) == 18) && ($tipo_pessoa_Letra_Maiscula === "JURIDICA")) {
        $cnpj_empresa_cliente = FUN_TIRAR_MASCARA_CPF_CNPJ($cnpj_Letra_Maiscula);
    } else {
        $array_erros['txt_cpf_cnpj_adquirinte'] = 'POR FAVOR ENTRE COM UM CNPJ VÁLIDO \n';
    }

    //   ADQUIRENTE -- CEP   
    if ((strlen($cep_Letra_Maiscula) == 8) || is_int($cep_Letra_Maiscula) === TRUE) {
        $cep_empresa = $cep_Letra_Maiscula;
    } else {
        $array_erros['txt_adquirente_cep'] = 'POR FAVOR ENTRE COM CEP VÁLIDO  \n';
    }

    //   ADQUIRENTE -- RUA
    if ((strlen($rua_Letra_Maiscula) > 2) && strlen($rua_Letra_Maiscula) < 51) {
        $rua_empresa = $rua_Letra_Maiscula;
    } else {
        $array_erros['txt_adquirente_rua'] = 'POR FAVOR ENTRE COM RUA VÁLIDA  \n';
    }

    //   ADQUIRENTE -- BAIRRO
    if ((strlen($bairro_Letra_Maiscula) > 2) && strlen($bairro_Letra_Maiscula) < 21) {
        $bairro_empresa = $bairro_Letra_Maiscula;
    } else {
        $array_erros['txt_adquirente_bairro'] = 'POR FAVOR ENTRE COM BAIRRO VÁLIDO \n ';
    }

    //   ADQUIRENTE -- CIDADE
    if ((strlen($cidade_Letra_Maiscula) > 2) && strlen($cidade_Letra_Maiscula) < 21) {
        $cidade_empresa = $cidade_Letra_Maiscula;
    } else {
        $array_erros['txt_adquirente_cidade'] = 'POR FAVOR ENTRE COM CIDADE VÁLIDA \n';
    }

    //   ADQUIRENTE -- UF
    if ((strlen($uf_Letra_Maiscula) == 2)) {
        $uf_empresa = $uf_Letra_Maiscula;
    } else {
        $array_erros['txt_adquirente_uf'] = 'POR FAVOR ENTRE COM UF VÁLIDA ';
    }

    //   ADQUIRENTE -- NUMERO
    if ((strlen($numero_endereco_Letra_Maiscula) < 6) || is_int($numero_endereco_Letra_Maiscula) === TRUE) {
        $numero_end_empresa = $numero_endereco_Letra_Maiscula;
    } else {
        $array_erros['txt_adquirente_numero'] = 'POR FAVOR ENTRE COM NUMERO ENDEREÇO VÁLIDO  \n';
    }

    //   ADQUIRENTE -- COMPLEMENTO
    if (strlen($complemento_endereco_Letra_Maiscula) < 31) {
        $complemento_end_empresa = $complemento_endereco_Letra_Maiscula;
    } else {
        $array_erros['txt_adquirente_complemento'] = 'POR FAVOR ENTRE COM COMPLEMENTO ENDEREÇO VÁLIDO  \n';
    }

//logo do sistema
    if (isset($_FILES['txt_logo_tipo_cliente'])) {
        
        if ($_FILES['txt_logo_tipo_cliente']['error'] == 0) {
            $logo_name = $_FILES['txt_logo_tipo_cliente']['tmp_name'];
            $fundo = $_FILES['txt_logo_tipo_cliente']['name'];

            $diretorio = '../../imagens/estrutura/'.$fundo;
            $caminho = 'recursos/imagens/estrutura/'.$fundo;
            $_SESSION['C_CAMINHO_LOGO'] = $caminho; 
            if (!move_uploaded_file($logo_name, $diretorio)) {
                   
            }
        }
    }



// verifico se tem erro na validação
    if (empty($array_erros)) {
        try {
            include_once '../estrutura/conexao/conexao.php';
            $pdo->beginTransaction();

            //  preparo comando sql para receber valores
            $sql = "UPDATE configuracao_sistema SET ";
            $sql = $sql . "Caminho_logo = :caminho, ";
            $sql = $sql . "Prefeitura = :prefeitura, ";
            $sql = $sql . "Secretaria = :secretaria, ";
            $sql = $sql . "logo_pb = :logo, ";
            $sql = $sql . "CNPJ_Prefeitura = :cnpj, ";
            $sql = $sql . "Endereco_Prefeitura = :endereco, ";
            $sql = $sql . "Bairro_Prefeitura = :bairro, ";
            $sql = $sql . "Cep_Prefeitura = :cep, ";
            $sql = $sql . "numero = :numero, ";
            $sql = $sql . "uf = :uf, ";
            $sql = $sql . "cidade = :cidade, ";
            $sql = $sql . "complemento = :complemento";

            $stmt = $pdo->prepare($sql);

            //  passando valores para o sql
            $stmt->bindParam(':caminho', $caminho);
            $stmt->bindParam(':prefeitura', $nome_empresa_cliente);
            $stmt->bindParam(':secretaria', $unidade_gestora_sistema_cliente);
            $stmt->bindParam(':logo', $caminho);
            $stmt->bindParam(':cnpj', $cnpj_empresa_cliente);
            $stmt->bindParam(':endereco', $rua_empresa);
            $stmt->bindParam(':bairro', $bairro_empresa);
            $stmt->bindParam(':cep', $cep_empresa);
            $stmt->bindParam(':numero', $numero_end_empresa);
            $stmt->bindParam(':uf', $uf_empresa);
            $stmt->bindParam(':cidade', $cidade_empresa);
            $stmt->bindParam(':complemento', $complemento_end_empresa);
            //  executa comando sql
            $stmt->execute();

//            variaveis de sessao

            $_SESSION['C_PREFEITURA'] = $nome_empresa_cliente;
            $_SESSION['C_SECRETARIA'] = $unidade_gestora_sistema_cliente;
            $_SESSION['C_CNPJ'] = FUN_COLOCAR_MASCARA_CPF_CNPJ($cnpj_empresa_cliente);
            $_SESSION['C_CEP'] = $cep_empresa;
            $_SESSION['C_ENDERECO'] = $rua_empresa;
            $_SESSION['C_BAIRRO'] = $bairro_empresa;
            $_SESSION['C_CIDADE'] = $cidade_empresa;
            $_SESSION['C_UF'] = $uf_empresa;
            $_SESSION['C_NUMERO'] = $numero_end_empresa;
            $_SESSION['C_COMPLEMENTO'] = $complemento_end_empresa;
           

            //  persiste comando sql
            $pdo->commit();
            $_SESSION['MENSAGEM_RETORNO_OPERACAO'] = "<div class='alert alert-info'>ALTERADO COM SUCESSO !!!</div>";
        } catch (Exception $exc) {
            $_SESSION['MENSAGEM_RETORNO_OPERACAO'] = "<div class='alert alert-danger'>" . $exc->getMessage() . "</div>";
        }
    } else {//  if (empty($array_erros)) {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }
        $_SESSION['MENSAGEM_RETORNO_OPERACAO'] = "<div class='alert alert-danger'>" . $msg_erro . "</div>";
    }
    header("Location: ../../../Man_Configuracao.php");


// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>