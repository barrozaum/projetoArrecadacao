<?php
//$data_vencimento= $_POST['data'];

if(isset($_POST['data'])){
    $data_vencimento = $_POST['data'];
}else{
    $data_vencimento = "";
}

include_once '../funcaoPHP/funcao_calcular_juros_multa.php';


function diasNoMes($mes, $ano) {
    if (($mes == '01') || ($mes == '03') || ($mes == '05') || ($mes == '07') ||
            ($mes == '08') || ($mes == '10') || ($mes == '12')) {
        $diasNoMes = '31';
    } elseif (($mes == '04') || ($mes == '06') || ($mes == '09') || ($mes == '11')) {
        $diasNoMes = '30';
    } elseif ($mes == '02') {
        if (($ano % 4) == 0) {  // bissexto 
            $diasNoMes = '29';
        } else {
            $diasNoMes = '28';
        };
    }

    return $diasNoMes;
}

function proxima_guia($pdo) {
    $sql_num_guia = "SELECT NUM_GUIA_CART175 FROM SISPARAMETROS";
    $query = $pdo->prepare($sql_num_guia);
    $query->execute();
    $dados = $query->fetch();
    $numero_da_guia = $dados['NUM_GUIA_CART175'] + 1;


    $sql_alt_num_guia = "UPDATE SISPARAMETROS SET NUM_GUIA_CART175=$numero_da_guia";
    $query = $pdo->prepare($sql_alt_num_guia);
    $query->execute();


    return $numero_da_guia;
}

function buscar_bairro($pdo, $cod_bairro) {
    global $bairro_imovel;


// preparo para realizar o comando sql
    $sql_bairro = "SELECT * FROM Bairro WHERE Cod_Bairro = '$cod_bairro'";
    $query = $pdo->prepare($sql_bairro);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $bairro_imovel = $dados['Desc_Bairro'];
    }
}

function buscar_rua($pdo, $cod_rua) {
    global $rua_imovel;

// preparo para realizar o comando sql
    $sql = "SELECT * FROM Rua WHERE Cod_Rua = '$cod_rua'";
    $query = $pdo->prepare($sql);
//executo o comando sql
    $query->execute();

// Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        $rua_imovel = $dados['Tipo'] . $dados['Desc_rua'];
    }
}

function dados_imovel($pdo, $inscricao) {
    global $proprietario;
    global $num_imovel;
    global $lote_imovel;
    global $quadra_imovel;
    global $Area_Terreno;
    global $Area_Construida;

    $sql_consulta = "SELECT * FROM cad_imobiliario WHERE Inscricao_Imob = '$inscricao'";
    $query = $pdo->prepare($sql_consulta);
//executo o comando sql
    $query->execute();
    if (($dados = $query->fetch()) == TRUE) {
        $proprietario = $dados['Proprietario'];

        // LOCALIZAÇÃO DO IMÓVEL 
        buscar_bairro($pdo, $dados['Cod_Bairro']);
        buscar_rua($pdo, $dados['Cod_Rua']);
        $num_imovel = $dados['Numero'];
        $quadra_imovel = $dados['Quadra'];
        $lote_imovel = $dados['Lote'];


        //DIMENSÃO DO IMÓVEL
        $Area_Terreno = $dados['Area_Terreno'] . " m2";
        $Area_Construida = $dados['Area_Construida'] . " m2";
    } else {
        die("<script>alert('erro'); location.href='../../../Emitir_segunda_via_boleto.php';</script>");
    }
}

function valor_venal($inscricao, $pdo, $ano) {

    global $valor_ufir_do_dia;
    $sql1 = "SELECT Valor FROM valor_venal WHERE ano = '$ano' AND inscricao_imob = '$inscricao'";
    $query1 = $pdo->prepare($sql1);
    //executo o comando sql
    $query1->execute();
    if (($dados1 = $query1->fetch()) == true) {
        return $dados1['Valor'] * $valor_ufir_do_dia;
    } else {
        return "";
    }
}

function calcular_iptu_real($valor_iptu_ufir) {
    global $valor_ufir_do_dia;
    return $valor_ufir_do_dia * $valor_iptu_ufir;
}

function moeda($pdo) {

    $data = dataAmericano(date('d/m/Y'));
    $sql1 = "SELECT * FROM moeda WHERE data_moeda = '$data'";

    $query1 = $pdo->prepare($sql1);
    //executo o comando sql
    $query1->execute();
    if (($dados1 = $query1->fetch()) == true) {
        return $dados1['valor_moeda'];
    }
}

function composicao_divida($pdo, $inscricao, $ano) {
    global $cod_divida_imob;
    global $valor_divida_imob;
    global $vr_iptu_ufir;


    $sql_comp = "SELECT * FROM composicao_divida_imob c, divida_imob d";
    $sql_comp = $sql_comp . " WHERE c.inscricao_imob = '$inscricao'";
    $sql_comp = $sql_comp . " AND c.ano_divida = '$ano'";
    $sql_comp = $sql_comp . " AND c.cod_divida_imob = d.Cod_Divida_Imob";
    $sql_comp = $sql_comp . " ORDER BY c.cod_divida_imob";

    $query = $pdo->prepare($sql_comp);

    $query->execute();
    $aux = 0;
    for ($i = 0; $dados = $query->fetch(); $i++) {
        if ($dados['cod_divida_imob'] != $aux) {
            $aux = $dados['cod_divida_imob'];
            $cod_divida_imob[$aux] = $dados['Desc_Divida'];
            $valor_divida_imob[$aux] = $dados['valor'];
        } else {
            $valor_divida_imob[$aux] += $dados['valor'];
        }

        $vr_iptu_ufir += $dados['valor'];
    }
    $vr_iptu_ufir += 3.1702;
}

function calcula_iptu($vr_tx_expediente) {
    global $vr_juros;
    global $vr_multa;
    global $vr_iptu_real;

    return $vr_iptu_real + $vr_tx_expediente + $vr_juros + $vr_multa;
}

function zeros($barra_vr_iptu) {
    $qtd_zeros = (10 - strlen($barra_vr_iptu));
    $zeros = '';
    for ($i = 1; $i <= $qtd_zeros; $i++) {
        $zeros = '0' . $zeros;
    }
    return $zeros;
}


function busca_juros_multas($pdo, $inscricao, $ano){
    global $valor_juros;
    global $valor_multa;
    global $valor_ufir_do_dia;
    $sql_finc = "SELECT * FROM financeiro_imob ";
    $sql_finc = $sql_finc . " WHERE inscricao_imob = '$inscricao'";
    $sql_finc = $sql_finc . " AND ano_divida = '$ano'";
    
    $query = $pdo->prepare($sql_finc);

    $query->execute();
    if (($dados = $query->fetch()) == true) {
        $vencimento = dataBrasileiro($dados['vencimento']);
        $situacao =     $dados['cod_situacao_divida'];
        $valor_base =   $dados['valor'] * $valor_ufir_do_dia;
        
        
        $valor_multa =  calcula_multa($situacao, $ano, $vencimento, $valor_base);
    }
}
