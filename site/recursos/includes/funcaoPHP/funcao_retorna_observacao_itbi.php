<?php

// inseri um campo na funcao 
//$codigo_divida ele vai passar o código do cadastro da divida (DAM, Itbi)
// cod_cadastro = 1 - IPTU
// cod_cadastro = 3 - DAM
// cod_cadastro = 4 - ITBI




function FUN_CONTROLE_OBSERVACAO($pdo, $cod_cadastro = '00', $numero = '000000', $ano = '0000', $observacao_enviada = '', $sub_divida = '00', $parcela = '00', $codigo_divida = '00') {
//    preparo a observação enviada pelo formulario
    $observacao = $observacao_enviada . " USUÁRIO :" . $_SESSION["usuario"] . " DATA :" . date("d/m/Y");

//     verifica se ibti ja tem alguma observação
   $valor_observacao_banco = buscarObservacao($pdo, $cod_cadastro, $numero, $ano, $sub_divida, $parcela, $codigo_divida);
  
    if ($valor_observacao_banco === "0") {
//      persisto no banco de dados a observação atraves do comando insert
        return FUN_INSERIR_OBSERVACAO($pdo, $cod_cadastro, $numero, $ano, $observacao, $sub_divida, $parcela, $codigo_divida);
    } else {
//         concateno a observação do formuário com o histórico
        $observacao = $observacao . " | " . $valor_observacao_banco;

//      FUNÇÃO QUE PERSISTE NO BANCO DE DADOS A OBSERVACÃO atraves do comando UPDATE         
        return FUN_ALTERAR_OBSERVACAO($pdo, $cod_cadastro, $numero, $ano, $observacao, $sub_divida, $parcela);
    }
}

// essa função serve para verificar se o itbi ja tem alguma observação existente, 
// caso ja contenha ele ira retornar a observação 
// caso contrário ele ira retorna 0

function buscarObservacao($pdo, $cod_cadastro, $numero, $ano, $sub_divida, $parcela) {
    $sql_obs = " SELECT  * "
            . " FROM observacao_financ "
            . " WHERE cod_cadastro = '$cod_cadastro' "
            . " AND Inscricao = '$numero' "
            . " AND ano_divida = '$ano'"
            . " AND sub_divida = '$sub_divida'"
            . " AND parcela = '$parcela'";

    $query = $pdo->prepare($sql_obs);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['Observacao'];
    } else {
        return '0';
    }
}

//ESSA FUNÇÃO IRA SER EXECUTA CASO O ITBI JA CONTENHA HISTÓRICO
function FUN_INSERIR_OBSERVACAO($pdo, $cod_cadastro, $numero, $ano, $observacao_enviada, $sub_divida, $parcela, $codigo_divida) {

    $sql_inserir = "INSERT INTO Observacao_Financ (cod_cadastro,Inscricao, ano_divida,cod_divida, Sub_divida, Parcela, Observacao) VALUES ('$cod_cadastro','$numero', '$ano', '$codigo_divida', '$sub_divida', '$parcela', '$observacao_enviada')";
    
    $executa = $pdo->query($sql_inserir);
    if ($executa) {
        return 1; // executado com sucesso
    } else {
        return 0; // erro na execução
    }
}

//ESSA FUNÇÃO IRA SER EXECUTA CASO O ITBI JA CONTENHA HISTÓRICO
function FUN_ALTERAR_OBSERVACAO($pdo, $cod_cadastro, $numero, $ano, $observacao_enviada, $sub_divida, $parcela) {


    $sql_update = "UPDATE Observacao_Financ "
            . "SET Observacao= '$observacao_enviada'"
            . "WHERE cod_cadastro =  '$cod_cadastro' "
            . "AND Inscricao = '$numero'"
            . "AND ano_divida = '$ano'"
            . "AND Sub_divida = '$sub_divida'"
            . "AND Parcela = '$parcela' ";

    $executa = $pdo->query($sql_update);
    
    if ($executa) {
        return 1; // executado com sucesso
    } else {
        return 0; // erro na execução
    }
}
