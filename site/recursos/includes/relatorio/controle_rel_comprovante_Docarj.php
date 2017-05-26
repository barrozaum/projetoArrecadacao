<?php

//ARRAY PARA ARMAZENAR ERROS
$array_erros = array();

//    aplica filtro na string enviada (LetraMaiuscula)
$numero_Docarj = letraMaiuscula($_POST['txt_numero_Docarj']);
$ano_Docarj = letraMaiuscula($_POST['txt_ano_Docarj']);
$parcela_Docarj = letraMaiuscula($_POST['txt_parcela']);

//    NUMERO ITBI
if (!fun_aplica_validacao_campo($numero_Docarj, 6,6)) {
    $array_erros['txt_numero_Docarj'] = 'POR FAVOR ENTRE COM UM NÚMERO DAM VÁLIDO \n';
}

//    ANO ITBI
if (!fun_aplica_validacao_campo($ano_Docarj,4,4)) {
    $array_erros['txt_ano_Docarj'] = 'POR FAVOR ENTRE COM ANO DAM VÁLIDO \n';
}
//    ANO ITBI
if (!fun_aplica_validacao_campo($parcela_Docarj,2,2)) {
    $array_erros['txt_parcela_Docarj'] = 'POR FAVOR ENTRE COM PARCELA DAM VÁLIDA \n';
}

if (empty($array_erros)) {
    
    montar_dados_comprovante($parcela_Docarj, $numero_Docarj, $ano_Docarj);
} else {
    mostrar_erro_validacao($array_erros);
}

function montar_dados_comprovante($parcela, $num_Docarj, $ano_Docarj) {
    exibir_comprovante($parcela, $num_Docarj, $ano_Docarj);
}


//mensagem de erro 
function mostrar_erro_validacao($array_erros) {

    $msg_erro = '';
    foreach ($array_erros as $msg) {
        $msg_erro = $msg_erro . $msg;
    }

    echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../EmissaoComprovanteDocarj.php";
        </script>';
}
