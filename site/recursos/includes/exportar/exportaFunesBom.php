<?php

include_once '../estrutura/controle/validarSessao.php';
?>


<?php

set_time_limit(0);
$inscricaoInicial = $_REQUEST['txtInscricaoInicial'];
$inscricaoFinal = $_REQUEST['txtInscricaoFinal'];
?>


<?php

//	 Abre ou cria o arquivo bloco1.txt
//	 "a" representa que o arquivo é aberto para ser escrito
$destination_file = "temp/bloco1.TXT";
$fp = fopen($destination_file, "w");
?>

<?php

// chamo a conexao com o banco de dados
include_once '../estrutura/conexao/conexao.php';
// preparo para realizar o comando sql
$sql = "select *
        from cad_imobiliario c, rua r, bairro b
        where c.cod_rua *= r.cod_rua
        and   c.cod_bairro *= b.cod_bairro
        and   len(rtrim(c.inscricao_imob)) = 6
        and   c.inscricao_imob >= $inscricaoInicial
        and   c.inscricao_imob <= $inscricaoFinal
        order by c.inscricao_imob";
$query = $pdo->prepare($sql);
//executo o comando sql
$query->execute();

//loop para listar todos os dados encontrados
for ($i = 0; $dados = $query->fetch(); $i++) {

    // variaveis
    $inscricao_imob = $dados['Inscricao_Imob'];
    //$proprietario = acertarProprietario($dados['proprietario']);
    // escrevo no arquivo txt
    $data_Inscricao = data_Inscricao($pdo, $inscricao_imob);
    $proprietario = acertarProprietario($dados['Proprietario']);


    // instancio toda vez que o loop passar
    $cnpj = 0;
    $cpf = 0;
    if ($dados['Tipo_Pessoa'] == "J") {
        if (isset($dados['Cpf_Cgc'])) {
            $cnpj = $dados['Cpf_Cgc'];
            $cnpj = str_replace(" ", "", $cnpj);
        }
    } else {
        if (isset($dados['Cpf_Cgc'])) {
            $cpf = substr($dados['Cpf_Cgc'], -16);
            $cpf = str_replace(" ", "", $cpf);
        }
    }

    $cpf;
    $cnpj;
    $endereco_imob = utf8_decode($dados['Tipo'] . $dados['Desc_rua']);

    $numero_imob = validaNumero($dados['Numero']);
    $complemento_imob = utf8_decode($dados['Complemento']);
    $bairro_imob = utf8_decode($dados['Desc_Bairro']);
    $cep_imob = $dados['cep'];

    $destinatario = destinatario($dados['Nome_Corr'], $proprietario);
    $endereco_dest = endereco_dest($dados['Rua_Corr'], $endereco_imob);
    $numero_dest = numero_dest($dados['Numero_corr'], $numero_imob);
    $complemento_dest = complemento_dest($dados['Complemento_Corr'], $complemento_imob);
    $bairro_dest = bairro_dest($dados['Bairro_Corr'], $bairro_imob);
    $cep_dest = cep_dest($dados['Cep_Corr'], $cep_imob);
    $cidade_dest = cidade_dest($dados['Cidade_Corr']);
    $uf_dest = uf_dest($dados['Uf_Corr']);
    $tipoImovel = 0;
    $utilizacao_imob = utilizacao_imob($dados['Utilizacao_imovel']);
    $patrimonio_imob = patrimonio_imob($dados['Patrimonio_imovel']);
    $condicao_imob = condicao_imob($dados['Tipo_Imposto']);
    $fracao_imob = fracao_imob($dados['Fracao_Ideal']);
    $area_imob = area_imob($dados['Area_Construida']);
    $exclusao_imob = $dados['Excluido'];
    $data_exclusao_imob = data_exclusao_imob($dados['Excluido'], $dados['Data_Ultima_alteracao']);
    $motivo_exclusao_imob = 0;





    fwrite($fp, str_pad($inscricao_imob, 16, 0, STR_PAD_LEFT));
    fwrite($fp, str_pad($data_Inscricao, 8, 0, STR_PAD_LEFT));
    fwrite($fp, str_pad($proprietario, 43, ' ', STR_PAD_LEFT));
    fwrite($fp, str_pad($cpf, 11, '0', STR_PAD_RIGHT));
    fwrite($fp, str_pad($cnpj, 14, '0', STR_PAD_RIGHT));
    fwrite($fp, str_pad($endereco_imob, 50, ' ', STR_PAD_RIGHT));
    fwrite($fp, str_pad($numero_imob, 5, 0, STR_PAD_RIGHT));
    fwrite($fp, str_pad($complemento_imob, 30, ' ', STR_PAD_RIGHT));
    fwrite($fp, str_pad($bairro_imob, 30, ' ', STR_PAD_RIGHT));
    fwrite($fp, str_pad($cep_imob, 8, 0, STR_PAD_RIGHT));
    fwrite($fp, str_pad($destinatario, 43, ' ', STR_PAD_LEFT));
    fwrite($fp, str_pad($endereco_dest, 50, ' ', STR_PAD_RIGHT));
    fwrite($fp, str_pad($numero_dest, 5, 0, STR_PAD_RIGHT));
    fwrite($fp, str_pad($complemento_dest, 30, ' ', STR_PAD_RIGHT));
    fwrite($fp, str_pad($bairro_dest, 30, ' ', STR_PAD_RIGHT));
    fwrite($fp, str_pad($cep_dest, 8, ' ', STR_PAD_RIGHT));
    fwrite($fp, str_pad($cidade_dest, 30, ' ', STR_PAD_RIGHT));
    fwrite($fp, str_pad($uf_dest, 2, ' ', STR_PAD_RIGHT));
    fwrite($fp, $tipoImovel);
    fwrite($fp, $utilizacao_imob);
    fwrite($fp, $patrimonio_imob);
    fwrite($fp, $condicao_imob);
    fwrite($fp, str_pad($fracao_imob, 9, 0, STR_PAD_RIGHT));
    fwrite($fp, str_pad($area_imob, 9, 0, STR_PAD_LEFT));
    fwrite($fp, $exclusao_imob);
    fwrite($fp, $data_exclusao_imob);
    fwrite($fp, $motivo_exclusao_imob);
    fwrite($fp, str_pad(" ", 16, " ", STR_PAD_LEFT));
    fwrite($fp, str_pad(" ", 41, " ", STR_PAD_LEFT));


    fwrite($fp, "\n");
}
$pdo = null;

//_____________Download do servidor para a estação
$filename = $destination_file;
$cNomeArquivo = "Arquivo.txt";
header('Content-Description: File Transfer');
header('Content-type: text/plain charset=UTF-8');
header('Content-Disposition: attachment; filename= ' . $cNomeArquivo);
header('Content-Transfer-Encoding: binary');
header('Content-Length: ' . filesize($filename));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');

ob_clean();
flush();
readfile($filename);
return;

// funções para validar os campos
function data_Inscricao($pdo, $inscricao_imob) {

    $sql1 = "select min(ano_divida) as ano_divida
            from financeiro_imob
            where inscricao_imob = '$inscricao_imob'";
    $query1 = $pdo->prepare($sql1);
    //executo o comando sql
    $query1->execute();
    $dados1 = $query1->fetch();
    return "0201" . $dados1['ano_divida'];
}

function acertarProprietario($proprietario) {
    return str_pad(utf8_decode(substr($proprietario, 0, 43)), 43, ' ', STR_PAD_RIGHT);
}

function validaNumero($numero) {
    if ($numero == "     ") {
        return '00000';
    } else {
        return $numero;
    }
}

function destinatario($nome_corr, $proprietario) {
    if ($nome_corr == '' || $nome_corr == ' ') {
        return $proprietario;
    } else {
        return acertarProprietario($nome_corr);
    }
}

function endereco_dest($end_Destina, $endereco_imob) {
    if ($end_Destina == '' || $end_Destina == ' ') {
        return $endereco_imob;
    } else {
        return utf8_decode($end_Destina);
    }
}

function numero_dest($numero_corr, $numero_imob) {
    if ($numero_corr == '     ' || $numero_corr == '00000') {
        return $numero_imob;
    } else {
        return $numero_corr;
    }
}

function complemento_dest($complemento_dest, $complemento_imob) {
    if ($complemento_dest == '' || $complemento_dest == ' ') {
        return $complemento_imob;
    } else {
        return utf8_decode($complemento_dest);
    }
}

function bairro_dest($bairro_Corr, $bairro_imob) {
    if ($bairro_Corr == '                    ') {
        return $bairro_imob;
    } else {
        return utf8_decode($bairro_Corr);
    }
}

function cep_dest($cep_dest, $cep_imob) {

    if ($cep_dest == '00000000' || $cep_dest == ' ' || $cep_dest == '') {
        return $cep_imob;
    } else {
        return utf8_decode($cep_dest);
    }
}

function cidade_dest($cidade_dest) {
    if ($cidade_dest == ' ' || $cidade_dest == '') {
        return "JAPERI";
    } else {
        return utf8_decode($cidade_dest);
    }
}

function uf_dest($uf_Dest) {

    if ($uf_Dest == '  ' || $uf_Dest == '') {
        return "RJ";
    } else {
        return utf8_decode($uf_Dest);
    }
}

function utilizacao_imob($utilizacao_imob) {
    if ($utilizacao_imob == '1') {
        return 2;
    } else if ($utilizacao_imob == '2') {
        return 5;
    } else if ($utilizacao_imob == '3') {
        return 6;
    } else {
        return 0;
    }
}

function patrimonio_imob($parimonio_imob) {
    if ($parimonio_imob == 3 || $parimonio_imob == 4) {
        return 1;
    } else {
        return 0;
    }
}

function condicao_imob($cond_imob) {
    if ($cond_imob == '2') {// Terreno ou Ruinas
        return 1;
    } else {
        return 0;
    }
}

function fracao_imob($fracao_imob) {
    //return "|".$fracao_imob."|";
    if ($fracao_imob == '0.0')// Terreno ou Ruinas
        return '1,0000000';
    else
        return number_format($fracao_imob, 6, ",", ".");
}

function area_imob($area_imob) {
    return number_format($area_imob, 2, ",", ".");
}

function data_exclusao_imob($excluido_imob, $data_exclusao_imob) {

    if ($excluido_imob == 'S') {
         
        return date("dmY", strtotime($data_exclusao_imob));
    } else {
        return '00000000';
    }
}
?>
