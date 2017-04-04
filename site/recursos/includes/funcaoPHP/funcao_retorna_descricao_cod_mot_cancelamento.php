<?php

function retorna_descricao_cod_mot_cancelamento($pdo, $cod) {
    $sql = "SELECT Desc_Motivo_Cancelamento FROM Motivo_Cancelamento WHERE Cod_Motivo_Cancelamento = '$cod'";
    $query = $pdo->prepare($sql);
    $query->execute();
    if (($dados = $query->fetch()) == true) {
        return $dados['Desc_Motivo_Cancelamento'];
    } else {
        return "";
    }
}
