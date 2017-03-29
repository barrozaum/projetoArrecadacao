<?php

//  Variaveis de sessão utilizaveis
if (isset($_SESSION['C_VALOR_MOEDA_DIA_UFIR'])) {
    $_SESSION['C_VALOR_MOEDA_DIA_UFIR'];
} else {
    echo "<div class='alert alert-danger text-center'> VALOR UFIR DIARIA NÃO CADASTRADA </div>";
}

// print $_SESSION['C_VALOR_MOEDA_DIA_UFIR'];

//
// $_SESSION['C_CAMINHO_LOGO'] ;
//        echo$_SESSION['C_PREFEITURA'];
//       echo $_SESSION['C_SECRETARIA'];
//       echo $_SESSION['C_ESTADO'];
//       echo $_SESSION['C_LOGO_PB']  ;
////  error_reporting(0);