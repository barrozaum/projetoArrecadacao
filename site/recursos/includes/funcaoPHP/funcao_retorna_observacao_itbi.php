<?php
// inseri um campo na funcao 
//$codigo_divida ele vai passar o código do cadastro da divida (DAM, Itbi)

// cod_cadastro = 1 - IPTU
// cod_cadastro = 3 - DAM
// cod_cadastro = 4 - ITBI




function FUN_CONTROLE_OBSERVACAO($pdo, $cod_cadastro, $numero, $ano, $observacao_enviada) {
//    preparo a observação enviada pelo formulario
    $observacao = $observacao_enviada . " USUÁRIO :" . $_SESSION["usuario"] . " DATA :" . date("d/m/Y");

//     verifica se ibti ja tem alguma observação
    $valor_observacao_banco = buscarObservacao($pdo, $cod_cadastro, $numero, $ano);
    if ($valor_observacao_banco === "0") {
//      persisto no banco de dados a observação atraves do comando insert
        return FUN_INSERIR_OBSERVACAO($pdo,$cod_cadastro, $numero, $ano, $observacao);
        
    } else {
//         concateno a observação do formuário com o histórico
        $observacao = $observacao . " | " . $valor_observacao_banco;

//      FUNÇÃO QUE PERSISTE NO BANCO DE DADOS A OBSERVACÃO atraves do comando UPDATE         
        return FUN_ALTERAR_OBSERVACAO($pdo,$cod_cadastro, $numero, $ano, $observacao);
    }
}

// essa função serve para verificar se o itbi ja tem alguma observação existente, 
// caso ja contenha ele ira retornar a observação 
// caso contrário ele ira retorna 0

function buscarObservacao($pdo, $cod_cadastro, $numero, $ano) {
    $sql_obs = "SELECT  * "
            . "FROM observacao_financ "
            . "WHERE cod_cadastro = '$cod_cadastro' "
            . "AND Inscricao = '$numero' "
            . "AND ano_divida = '$ano'";

    $query = $pdo->prepare($sql_obs);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['Observacao'];
    } else {
        return $sql_obs;
    }
}

//ESSA FUNÇÃO IRA SER EXECUTA CASO O ITBI JA CONTENHA HISTÓRICO
function FUN_INSERIR_OBSERVACAO($pdo, $cod_cadastro, $numero, $ano, $observacao_enviada) {

    $sql_inserir = "INSERT INTO Observacao_Financ (cod_cadastro,Inscricao, ano_divida,cod_divida, Sub_divida, Parcela, Observacao) VALUES ('$cod_cadastro','$numero', '$ano', '$codigo_divida', '00', '00', '$observacao_enviada')";

    $executa = $pdo->query($sql_inserir);
    if ($executa) {
        return 1; // executado com sucesso
    } else {
        return 0; // erro na execução
    }
}

//ESSA FUNÇÃO IRA SER EXECUTA CASO O ITBI JA CONTENHA HISTÓRICO
function FUN_ALTERAR_OBSERVACAO($pdo, $cod_cadastro, $numero, $ano , $observacao_enviada) {


    $sql_update = "UPDATE Observacao_Financ "
            . "SET Observacao= '$observacao_enviada'"
            . "WHERE cod_cadastro =  '$cod_cadastro' "
            . "AND Inscricao = '$numero'"
            . "AND ano_divida = '$ano'"
            . "AND Sub_divida = '00'"
            . "AND Parcela = '00' ";

    $executa = $pdo->query($sql_update);
    if ($executa) {
        return 1; // executado com sucesso
    } else {
        return 0; // erro na execução
    }
}
