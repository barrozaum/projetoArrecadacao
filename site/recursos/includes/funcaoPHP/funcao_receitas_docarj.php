<?php

include_once '../estrutura/controle/validarSessao.php';
include_once '../estrutura/conexao/conexao.php';


//verico qual funcao vou executar
if (isset($_POST['id'])) {
    if ($_POST['id'] == "receitas") {
        buscar_receitas_cadastro($pdo, $_POST['codigo']);
    }
}

function buscar_receitas_cadastro($pdo, $codigo_cadastro) {
    include_once './function_letraMaiscula.php';
//    array de retorno
    $array_retorno[] = array("cod" => "", "Descricao" => "SELECIONE A RECEITA");
    try {
//    verific ao tipo do cadastro 
        if ($codigo_cadastro == 1 || $codigo_cadastro == 3 || $codigo_cadastro == 4) {
            $sql = "SELECT * FROM Divida_Imob ";
            $query = $pdo->prepare($sql);
            $query->execute();
            for ($i = 0; $dados = $query->fetch(); $i++) {
                $array_retorno[] = array("cod" => $dados['Cod_Divida_Imob'], "Descricao" => $dados['Desc_Divida']);
            }
        } else if ($codigo_cadastro == 2) {
            $sql = "SELECT * FROM Divida";
            $query = $pdo->prepare($sql);
            $query->execute();
            for ($i = 0; $dados = $query->fetch(); $i++) {
                $array_retorno[] = array("cod" => $dados['Cod_Divida'], "Descricao" => $dados['Desc_Divida']);
            }
        } else {
            $sql = "SELECT * FROM Divida_Uap";
            $query = $pdo->prepare($sql);
            $query->execute();
            for ($i = 0; $dados = $query->fetch(); $i++) {
                $array_retorno[] = array("cod" => $dados['Cod_Divida'], "Descricao" => $dados['Desc_Divida']);
            }
        }

        echo json_encode($array_retorno);
    } catch (Exception $e) {
        print $e->getMessage();
    }
}

function funcao_descricao_receitas($pdo, $codigo_cadastro, $receita) {
//    array de retorno
    $array_retorno[] = array("cod" => "", "Descricao" => "SELECIONE A RECEITA");
    try {
//    verific ao tipo do cadastro 
        if ($codigo_cadastro == 1 || $codigo_cadastro == 3 || $codigo_cadastro == 4) {
            $sql = "SELECT * FROM Divida_Imob WHERE Cod_Divida_Imob = '$receita' ";
            $query = $pdo->prepare($sql);
            $query->execute();
            if ($dados = $query->fetch()) {
                return $dados['Desc_Divida'];
            } else {
                return "";
            }
        } else if ($codigo_cadastro == 2) {
            $sql = "SELECT * FROM Divida";
            $query = $pdo->prepare($sql);
            $query->execute();
            if ($dados = $query->fetch()) {
                return $dados['Desc_Divida'];
            } else {
                return "";
            }
        } else {
            $sql = "SELECT * FROM Divida_Uap";
            $query = $pdo->prepare($sql);
            $query->execute();
            if ($dados = $query->fetch()) {
                return $dados['Desc_Divida'];
            } else {
                return "";
            }
        }

        echo json_encode($array_retorno);
    } catch (Exception $e) {
        print $e->getMessage();
    }
}
