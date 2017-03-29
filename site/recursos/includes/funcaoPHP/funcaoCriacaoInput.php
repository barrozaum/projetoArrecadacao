<?php

// label = Nome em Cima do campo
// name = Nome do campo
// id = Id do campo
// Extras = atributos a mais no campo ex( readonly, size ,javascript)
// Value = valor padrão;
//  CAMPO TIPO TEXTO NORMAL
function criar_input_text($label, $name, $id, $extras = array(), $value = '', $span = '') {
    $saida = "<div class='form-group'>";
    $saida = $saida . "<label for='id_" . $name . "'>" . $label . " :</label>";
    $saida = $saida . "<input class='form-control' type='text' name='txt_" . $name . "'. id='id_" . $id . "'";

    foreach ($extras as $k => $v) {
        $saida = $saida . " $k = \"$v\" ";
    }

    $saida = $saida . "value='" . $value . "'>";
    $saida = $saida . '<span class="help-block">' . $span . '</span>';
    $saida = $saida . "</div>";
    print $saida;
}

//  CAMPO TIPO TEXTO OCULTO
function criar_input_hidden($name, $extras = array(), $value = '', $span = '') {
    $saida = "<input class='form-control' type='hidden' name='txt_" . $name . "'. id='id_" . $name . "'";

    foreach ($extras as $k => $v) {
        $saida = $saida . " $k = \"$v\" ";
    }

    $saida = $saida . "value='" . $value . "'>";
    print $saida;
}

//  CAMPO TIPO  DATA COM CALENDARIO
function criar_input_data($label, $name, $id, $extras = array(), $value = '', $span = '') {

    $saida = "<div class='form-group'>";
    $saida = $saida . "<label for='id_" . $name . "'>" . $label . " :</label>";
    $saida = $saida . "<input class='form-control' type='text' name='txt_" . $name . "'. id='id_" . $id . "'";

    foreach ($extras as $k => $v) {
        $saida = $saida . " $k = \"$v\" ";
    }

    $saida = $saida . "value='" . $value . "' onkeypress='return SomenteNumero(event)' OnKeyUp='return mascaraData(this)' >";
    $saida = $saida . '<span class="help-block">' . $span . '</span>';
    $saida = $saida . "</div>";
    print $saida;
}

//  CAMPO TIPO TEXT-AREA
function criar_textarea($label, $name, $id, $value = '', $extras = array()) {
    $saida = "<div class='form-group'>";
    $saida = $saida . "<label for='id_" . $name . "'>" . $label . " :</label>";
    $saida = $saida . "<textarea class='form-control'  name='txt_" . $name . "'. id='id_" . $id . "'";

    foreach ($extras as $k => $v) {
        $saida = $saida . " $k = \"$v\" ";
    }
    $saida = $saida . ">";

    $saida = $saida . $value;
    $saida = $saida . "</textarea>";
    $saida = $saida . "</div>";
    print $saida;
}

//  CAMPO TIPO CONSULTA (COM LUPA DE PESQUISA)
function criar_input_text_com_lupa($label, $name, $id, $extras = array(), $value = '', $span = '', $id_lupa = 'lupa') {
    $saida = "<div class='form-group'>";
    $saida = $saida . "<label for='id_" . $name . "'>" . $label . " :</label>";
    $saida = $saida . "<div class='input-group'>";
    $saida = $saida . "<span class='input-group-addon' id='id_" . $id_lupa . "'><i class='glyphicon glyphicon-zoom-in'></i></span>";
    $saida = $saida . "<input class='form-control' type='text' name='txt_" . $name . "'. id='id_" . $id . "'";

    foreach ($extras as $k => $v) {
        $saida = $saida . " $k = \"$v\" ";
    }

    $saida = $saida . "value='" . $value . "'>";
    $saida = $saida . "</div>";
    $saida = $saida . '<span class="help-block">' . $span . '</span>';

    $saida = $saida . "</div>";
    print $saida;
}

//  CAMPO TIPO  SELECT
function criar_input_select($label, $name, $id, $extras = array(), $value = array(), $span = '') {
    $saida = "<div class='form-group'>";
    $saida = $saida . "<label for='id_" . $name . "'>" . $label . " :</label>";
    $saida = $saida . "<select class='form-control'  name='txt_" . $name . "'. id='id_" . $id . "'";

    foreach ($extras as $k => $v) {
        $saida = $saida . " $k = \"$v\" ";
    }
    $saida = $saida . ">";

    foreach ($value as $k => $v) {
        $saida = $saida . "<option value='" . $k . "'>" . $v . "</option>";
    }
    $saida = $saida . "</select>";
    $saida = $saida . "</div>";
    print $saida;
}

//  CAMPO TIPO  CEP
function criar_input_text_cep($label, $name, $id, $extras = array(), $value = '', $span = '') {
    $saida = "<div class='form-group'>";
    $saida = $saida . "<label for='id_" . $name . "'>" . $label . " :</label>";
    $saida = $saida . "<input class='form-control' type='text' name='txt_" . $name . "'. id='id_" . $id . "'";

    foreach ($extras as $k => $v) {
        $saida = $saida . " $k = \"$v\" ";
    }

    $saida = $saida . "value='" . $value . "'>";
    $saida = $saida . '<span class="help-block">' . $span . '</span>';
    $saida = $saida . "</div>";
    print $saida;
}

// CAMPO TIPO SENHA (CRIPTOGRAFADO)

function criar_input_password($label, $name, $id, $extras = array(), $value = '', $span = '') {
    $saida = "<div class='form-group'>";
    $saida = $saida . "<label for='id_" . $name . "'>" . $label . " :</label>";
    $saida = $saida . "<input class='form-control' type='password' name='txt_" . $name . "'. id='id_" . $id . "'";

    foreach ($extras as $k => $v) {
        $saida = $saida . " $k = \"$v\" ";
    }

    $saida = $saida . "value='" . $value . "'>";
    $saida = $saida . '<span class="help-block">' . $span . '</span>';
    $saida = $saida . "</div>";
    print $saida;
}

// CAMPO TIPO CHECKBOX
function criar_input_checkbox($label, $name, $id, $extras = array(), $value = '', $span = '') {
    $saida = "<div class='form-group'>";
    $saida = $saida . "<input class='form-inline' type='checkbox' name='txt_" . $name . "'. id='id_" . $id . "'";

    foreach ($extras as $k => $v) {
        $saida = $saida . " $k = \"$v\" ";
    }

    $saida = $saida . "value='" . $value . "'> &nbsp &nbsp &nbsp&nbsp";
    $saida = $saida . "<label for='id_" . $name . "'>:" . $label . " </label>";
    $saida = $saida . '<span class="help-block">' . $span . '</span>';
    $saida = $saida . "</div>";
    print $saida;
}

// CAMPO TIPO FILE
function criar_input_file($label, $name, $id, $extras = array(), $value = '', $span = '') {
    $saida = "<div class='form-group'>";
    $saida = $saida . "<label for='id_" . $name . "'>" . $label . " :</label>";
    $saida = $saida . "<input class='form-control' type='file' name='txt_" . $name . "'. id='id_" . $id . "'";

    foreach ($extras as $k => $v) {
        $saida = $saida . " $k = \"$v\" ";
    }

    $saida = $saida . "value='" . $value . "'>";
    $saida = $saida . '<span class="help-block">' . $span . '</span>';
    $saida = $saida . "</div>";
    print $saida;
}
