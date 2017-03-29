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
//    aplica filtro na string enviada (LetraMaiuscula)
    $codigo_Letra_Maiscula = letraMaiuscula($_POST['cod']);
    $op_Letra_Maiscula = letraMaiuscula($_POST['op']);

// variaves serão preenchidas por valores do formulario
// // valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($codigo_Letra_Maiscula) > 0 && strlen($codigo_Letra_Maiscula) < 7) || is_int($codigo_Letra_Maiscula) === TRUE) {
        $codigo = $codigo_Letra_Maiscula;
    } else {
        $array_erros['INSCRICAO'] = 'POR FAVOR ENTRE COM UMA INSCRIÇÃO VÁLIDA \n';
    }

    if ((strlen($op_Letra_Maiscula) > 0 && strlen($op_Letra_Maiscula) < 2) || is_int($op_Letra_Maiscula) === TRUE) {
        $op = $op_Letra_Maiscula;
    } else {
        $array_erros['OPERCAÇÃO'] = 'POR FAVOR ENTRE COM UMA OPERAÇÃO VÁLIDA \n';
    }

// verifico se tem erro na validação
    if (empty($array_erros)) {

        
// chamo a conexao com o banco de dados
    include_once '../estrutura/conexao/conexao.php';
    
        if ($op == 1) {
            echo buscar_imovel($pdo, $codigo);
        }else{
            echo buscar_dados_imovel($pdo, $codigo);
        }
        
        
//    fecha conexao com o banco
      $pdo = null;  
    } else { //   if (empty($array_erros)) {
//      declarado array para informar que o código enviado está errado
        $var = Array(
            "achou" => 0,
            "descricao" => "<div class='alert alert-danger'>POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO</div>"
        );
        echo json_encode($var);
    }
} else {// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
    die(header("Location: ../../../logout.php"));
}

// verifica se imóvel existe e retorna os dados ja cadastrado
function buscar_imovel($pdo, $codigo) {


// Comando sql a ser executado
    $sql = "SELECT * FROM Cad_Imobiliario WHERE Inscricao_Imob = '$codigo'";

//        executo o comando para saber se ira retornar valor
    $resultado_comando = $pdo->query($sql);

//        caso retorne valor maior que 0
    if ($resultado_comando->fetchColumn() > 0) {

//          preparo comando sql para execução
        $query = $pdo->prepare($sql);

//          executo o comando sql
        $query->execute();

//          coloco o retorno da consulta em um array (dados)  
        $dados = $query->fetch();

//            crio um array contento todos os dados retornados
        $var = Array(
            "achou" => 1,
            "proprietario" => $dados['Proprietario'],
            "nome_Corr" => $dados['Nome_Corr'],
            "rua_Corr" => $dados['Rua_Corr'],
            "numero_Corr" => $dados['Numero_corr'],
            "complemento_Corr" => $dados['Complemento_Corr'],
            "bairro_Corr" => $dados['Bairro_Corr'],
            "cidade_Corr" => $dados['Cidade_Corr'],
            "uf_Corr" => $dados['Uf_Corr'],
            "cep_Corr" => $dados['Cep_Corr'],
            "telefone" => $dados['Telefone']
        );

//          converto o array criado em arquivo json
        return json_encode($var);
    } else {  //  if ($resultado_comando->fetchColumn() > 0) {
//          caso não retorne valor 
        $var = Array(
            "achou" => 0,
            "descricao" => "<div class='alert alert-danger'>INSCRIÇÃO NÃO ENCONTRADA</div>"
        );
        return json_encode($var);
    }

}


// busca informações do cadastro de imovel
function buscar_dados_imovel($pdo, $codigo){
     
// Comando sql a ser executado
    $sql = "SELECT * FROM "
            . " Cad_Imobiliario c, Rua r, Bairro b"
            . " WHERE c.Inscricao_Imob = '$codigo' "
            . " AND c.Cod_Rua = r.Cod_Rua "
            . " AND c.Cod_Bairro = b.Cod_Bairro";

//        executo o comando para saber se ira retornar valor
    $resultado_comando = $pdo->query($sql);

//        caso retorne valor maior que 0
    if ($resultado_comando->fetchColumn() > 0) {

//          preparo comando sql para execução
        $query = $pdo->prepare($sql);

//          executo o comando sql
        $query->execute();

//          coloco o retorno da consulta em um array (dados)  
        $dados = $query->fetch();

        
//     variaveis do cadastro imobiliario   
        $proprietario = $dados['Proprietario'];
        $numero = $dados['Numero'];
        $telefone = $dados['Telefone'];
        
        
//        chamada para saber dados da rua 
        
//            crio um array contento todos os dados retornados
        $var = Array(
            "achou" => 1,
            "proprietario" => $proprietario,
            "nome_Corr" => $proprietario,
            "rua_Corr" => $dados['Tipo'] . $dados['Desc_rua'],
            "numero_Corr" => $numero,
            "complemento_Corr" => $dados['Complemento'],
            "bairro_Corr" => $dados['Desc_Bairro'],
            "cidade_Corr" => 'JAPERI',
            "uf_Corr" => 'RJ',
            "cep_Corr" => $dados['cep'],
            "telefone" => $telefone
        );

//          converto o array criado em arquivo json
        return json_encode($var);
    } else {  //  if ($resultado_comando->fetchColumn() > 0) {
//          caso não retorne valor 
        $var = Array(
            "achou" => 0,
            "descricao" => "<div class='alert alert-danger'>INSCRIÇÃO NÃO ENCONTRADA</div>"
        );
        return json_encode($var);
    }
}
?>