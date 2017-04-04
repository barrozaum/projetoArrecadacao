<?php

//Converto a letra para maisculo
function letraMaiuscula($string) {
    // envio para a função aplicar filtro string
    return strtoupper(aplicar_filtro_string($string));
}

// função para altera caracteres indejados (retira acentos)
function aplicar_filtro_string($filtra_string) {


//     Letra A
    $filtra_string = str_replace("Á", "a", $filtra_string);
    $filtra_string = str_replace("À", "a", $filtra_string);
    $filtra_string = str_replace("Ã", "a", $filtra_string);
    $filtra_string = str_replace("Â", "a", $filtra_string);
    $filtra_string = str_replace("Ä", "a", $filtra_string);
    $filtra_string = str_replace("á", "a", $filtra_string);
    $filtra_string = str_replace("à", "a", $filtra_string);
    $filtra_string = str_replace("ã", "a", $filtra_string);
    $filtra_string = str_replace("â", "a", $filtra_string);
    $filtra_string = str_replace("ä", "a", $filtra_string);

//    Letra E
    $filtra_string = str_replace("É", "e", $filtra_string);
    $filtra_string = str_replace("È", "e", $filtra_string);
    $filtra_string = str_replace("Ê", "e", $filtra_string);
    $filtra_string = str_replace("Ë", "e", $filtra_string);
    $filtra_string = str_replace("é", "e", $filtra_string);
    $filtra_string = str_replace("è", "e", $filtra_string);
    $filtra_string = str_replace("ê", "e", $filtra_string);
    $filtra_string = str_replace("ë", "e", $filtra_string);


//    Letra I
    $filtra_string = str_replace("Í", "i", $filtra_string);
    $filtra_string = str_replace("Ì", "i", $filtra_string);
    $filtra_string = str_replace("Î", "i", $filtra_string);
    $filtra_string = str_replace("Ï", "i", $filtra_string);
    $filtra_string = str_replace("í", "i", $filtra_string);
    $filtra_string = str_replace("ì", "i", $filtra_string);
    $filtra_string = str_replace("î", "i", $filtra_string);
    $filtra_string = str_replace("ï", "i", $filtra_string);

//    Letra O
    $filtra_string = str_replace("Ó", "o", $filtra_string);
    $filtra_string = str_replace("Ò", "o", $filtra_string);
    $filtra_string = str_replace("Ô", "o", $filtra_string);
    $filtra_string = str_replace("Õ", "o", $filtra_string);
    $filtra_string = str_replace("Ö", "o", $filtra_string);
    $filtra_string = str_replace("ó", "o", $filtra_string);
    $filtra_string = str_replace("ò", "o", $filtra_string);
    $filtra_string = str_replace("ô", "o", $filtra_string);
    $filtra_string = str_replace("õ", "o", $filtra_string);
    $filtra_string = str_replace("ö", "o", $filtra_string);

//    Letra U
    $filtra_string = str_replace("Ú", "u", $filtra_string);
    $filtra_string = str_replace("Ù", "u", $filtra_string);
    $filtra_string = str_replace("Û", "u", $filtra_string);
    $filtra_string = str_replace("Ü", "u", $filtra_string);
    $filtra_string = str_replace("ú", "u", $filtra_string);
    $filtra_string = str_replace("ù", "u", $filtra_string);
    $filtra_string = str_replace("û", "u", $filtra_string);
    $filtra_string = str_replace("ü", "u", $filtra_string);
    $filtra_string = str_replace("   ", "", $filtra_string);


//    Letra C
    $filtra_string = str_replace("Ç", "c", $filtra_string);
    $filtra_string = str_replace("ç", "c", $filtra_string);

//    aplica filtro para aceitar letras (a-z A-Z) (0 - 9) ( @ _ .)
    $filtra_string = preg_replace("/[^a-zA-Z0-9 @ _.,\/-]/", "", $filtra_string);


//    retorna dados após filtro
    return $filtra_string;
}
