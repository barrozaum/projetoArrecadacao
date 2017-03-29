<?php

function diaBisesto($ano, $mes) {
    if (((fmod($ano, 4) == 0) and ( fmod($ano, 100) != 0)) or ( fmod($ano, 400) == 0)) {
        $dias_fevereiro = "29";
    } else {
        $dias_fevereiro = "28";
    }

    if ($mes == "01" || $mes == "03" || $mes == "05" || $mes == "07" || $mes == "08" || $mes == "10" || $mes == "12")
        return "31";
    else if ($mes == "02")
        return $dias_fevereiro;
    else
        return "30";
}
