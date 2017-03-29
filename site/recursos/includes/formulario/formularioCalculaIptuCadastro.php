<?php
include_once '../estrutura/controle/validarSessao.php';
include_once '../estrutura/conexao/conexao.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
?>
<?php
if (empty($_POST['id'])) {
    formularioCadastro($pdo);
    die();
} else if ($_POST['id'] == 1) {
    criacao_tabela();
    die();
}
?>


<?php

function criacao_tabela() {

    $ano_final = $_POST['ano_final'];
    $valor_iptu = $_POST['valor_iptu'];
    $valor_taxas = $_POST['valor_taxas'];
    $qtd_parcelas = $_POST['qtd_parcelas'];
    $desconto_industria = $_POST['desconto_industria'];

    $rs_tabela = " <div style='overflow: auto; max-height: 200px;'>";
    for ($ano_inicial = $_POST['ano_inicial']; $ano_inicial <= $ano_final; $ano_inicial++) {
        $rs_tabela = $rs_tabela . tabela_vencimentos($ano_inicial, $valor_iptu, $valor_taxas, $qtd_parcelas, $desconto_industria);
    }
    $rs_tabela = $rs_tabela . "</div>";
    print $rs_tabela;
}

function valor_metro_terreno($pdo) {

    $zona_imob = $_SESSION['ZONA_IMOVEL'];
    $situacao_terreno = $_SESSION['SITUACAO_TERRENO'];

    $sql_metro_terreno = "SELECT * ";
    $sql_metro_terreno = $sql_metro_terreno . " FROM Valor_M2_Terreno ";
    $sql_metro_terreno = $sql_metro_terreno . " WHERE Zona_Fiscal = '$zona_imob'";
    $sql_metro_terreno = $sql_metro_terreno . " AND Cod_Utilizacao ='$situacao_terreno'";

    $query = $pdo->prepare($sql_metro_terreno);
    //executo o comando sql
    $query->execute();

    // Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['vlr_m2_terreno'];
    } else {
        return 0;
    }
}

function valor_metro_construcao($pdo) {

    $zona_imob = $_SESSION['ZONA_IMOVEL'];
    $cod_utilizacao = $_SESSION['UTILIZACAO_IMOB'];
    $cod_cat = $_SESSION['CATEGORIA'];

    $sql_metro_construcao = "SELECT * ";
    $sql_metro_construcao = $sql_metro_construcao . " FROM Valor_M2_Construcao ";
    $sql_metro_construcao = $sql_metro_construcao . " WHERE Zona_Fiscal = '$zona_imob'";
    $sql_metro_construcao = $sql_metro_construcao . " AND Cod_Utilizacao ='$cod_utilizacao'";
    $sql_metro_construcao = $sql_metro_construcao . " AND Cod_Categoria ='$cod_cat'";

    $query = $pdo->prepare($sql_metro_construcao);
    //executo o comando sql
    $query->execute();

    // Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return $dados['Vlr_M2_Construcao'];
    } else {
        return 0;
    }
}

function valor_venal_terreno($valor_m2_terreno) {
    $area_terreno = $_SESSION['AREA_TERRENO'];

    return mostrarDinheiro4Casas(inserirDinheiro($valor_m2_terreno) * $area_terreno);
}

function valor_venal_construcao($valor_m2_construcao) {
    $area_construcao = $_SESSION['AREA_CONSTRUIDA'];
    inserirDinheiro($valor_m2_construcao);
    return mostrarDinheiro4Casas(inserirDinheiro($valor_m2_construcao) * $area_construcao);
}

function taxa_coleta_lixo($pdo) {
    $tipo_coleta = $_SESSION['TIPO_COLETA'];

    $tx_coleta = "SELECT * ";
    $tx_coleta = $tx_coleta . " FROM Tipo_Coleta";
    $tx_coleta = $tx_coleta . " WHERE Cod_Tipo_Coleta = '$tipo_coleta'";


    $query = $pdo->prepare($tx_coleta);
    //executo o comando sql
    $query->execute();

    // Faço uma comparação para saber se a busca trouxe algum resultado
    if (($dados = $query->fetch()) == true) {
        return mostrarDinheiro4Casas($dados['Valor']);
    } else {
        return 0;
    }
}

function tem_manutencao_esgoto() {
    if ($_SESSION['TEM_MAN_ESGOTO'] == "S") {
        return 4.8200;
    } else {
        return 0;
    }
}

function valor_iptu_ufir($valor_territorial, $valor_predial) {

    if ($_SESSION['TIPO_ISENCAO'] > 1) {
        return mostrarDinheiro4Casas(0);
    } else {


        $valor_iptu_territorial = (inserirDinheiro($valor_territorial) * 1) / 100;
        $valor_iptu_predial = (inserirDinheiro($valor_predial) * 1) / 100;
        $iptu = $valor_iptu_territorial + $valor_iptu_predial;

        return mostrarDinheiro4Casas($iptu);
    }
}

function valor_iptu_total_ufir($valor_iptu, $valor_taxas) {

    $valor_iptu = inserirDinheiro($valor_iptu);
    $valor_taxas = inserirDinheiro($valor_taxas);

    $iptu_ufir = $valor_iptu + $valor_taxas;

    return mostrarDinheiro4Casas($iptu_ufir);
}

function valor_taxas_total($taxa_coleta_lixo, $tem_manutencao_esgoto, $valor_te, $valor_tip) {
    $taxa_coleta_lixo = inserirDinheiro($taxa_coleta_lixo);
    $tem_manutencao_esgoto = inserirDinheiro($tem_manutencao_esgoto);
    $valor_te = inserirDinheiro($valor_te);
    $valor_tip = inserirDinheiro($valor_tip);

    $valor_taxas = $taxa_coleta_lixo + $tem_manutencao_esgoto + $valor_te + $valor_tip;

    return mostrarDinheiro4Casas($valor_taxas);
}
?>




<?php

function tabela_vencimentos($ano_divida, $iptu, $taxas, $qtd_parcelas, $desconto_industria) {
    $qtd_parcelas = $qtd_parcelas;
    $ano_corrente = date('Y');
    $calendario[0] = "30/04/" . date('Y');
    $calendario[1] = "31/05/" . date('Y');
    $calendario[2] = "30/06/" . date('Y');
    $calendario[3] = "31/07/" . date('Y');
    $calendario[4] = "31/08/" . date('Y');
    $calendario[5] = "30/09/" . date('Y');



    $tabela = "<table class='table table-striped table-hover'>";
    $tabela = $tabela . "<tr>";
    $tabela = $tabela . "<td>Vencimento </td>";
    $tabela = $tabela . "<td>Iptu</td>";
    $tabela = $tabela . "<td>Taxas</td>";
    $tabela = $tabela . "<td>Total</td>";
    $tabela = $tabela . "</tr>";

    if ($ano_divida < $ano_corrente) {
        if ($desconto_industria == 0 || $ano_divida < 2004) {
            $tabela = $tabela . "<tr>";
            $tabela = $tabela . "<td>31/12/$ano_divida </td>";
            $tabela = $tabela . "<td>" . $iptu . "</td>";
            $tabela = $tabela . "<td>" . $taxas . "</td>";
            $tabela = $tabela . "<td>" . mostrarDinheiro4Casas(inserirDinheiro($taxas) + inserirDinheiro($iptu)) . "</td>";
            $tabela = $tabela . "</tr>";
        } else {
            $parcela_iptu = aplicar_desconto($iptu, $desconto_industria);
            $parcela_taxas = aplicar_desconto($taxas, $desconto_industria);
            $total_parcela = inserirDinheiro($parcela_iptu) + inserirDinheiro($parcela_taxas);

            $tabela = $tabela . "<tr>";
            $tabela = $tabela . "<td>31/12/$ano_divida </td>";
            $tabela = $tabela . "<td>" . $parcela_iptu . "</td>";
            $tabela = $tabela . "<td>" . $parcela_taxas . "</td>";
            $tabela = $tabela . "<td>" . $total_parcela . "</td>";
            $tabela = $tabela . "</tr>";
        }
    } else {
        $parcela_iptu = aplicar_desconto($iptu, $desconto_industria);
        $parcela_taxas = aplicar_desconto($taxas, $desconto_industria);
        $total_parcela = inserirDinheiro($parcela_iptu) + inserirDinheiro($parcela_taxas);

        $parcela_iptu = mostrarDinheiro4Casas(inserirDinheiro($parcela_iptu) / $qtd_parcelas);
        $parcela_taxas = mostrarDinheiro4Casas(inserirDinheiro($parcela_taxas) / $qtd_parcelas);
        $total_parcela = mostrarDinheiro4Casas($total_parcela / $qtd_parcelas);


        for ($i = 0; $i < $qtd_parcelas; $i++) {
            $tabela = $tabela . "<tr>";
            $tabela = $tabela . "<td>$calendario[$i] </td>";
            $tabela = $tabela . "<td>$parcela_iptu</td>";
            $tabela = $tabela . "<td>$parcela_taxas</td>";
            $tabela = $tabela . "<td>$total_parcela</td>";
            $tabela = $tabela . "</tr>";
        }
    }

    $tabela = $tabela . "</table>";
    return "Ano da Dívida :" . $ano_divida . "<br />" . $tabela;
}

// {Desconto Aplicado a Industrias conforme Lei. Comp. 049/2004}
function desconto_industria($pdo, $inscricao) {
    if ($_SESSION['DESCONTO_INDUSTRIA'] == "N") {
        return 0;
    } else {
        $sql_desconto = "SELECT Tipo_Enquadramento, Data_Enquadramento";
        $sql_desconto = $sql_desconto . " FROM CAD_COMERCIAL";
        $sql_desconto = $sql_desconto . " WHERE INSCRICAO_IMOB = '$inscricao'";

        $query = $pdo->prepare($sql_desconto);
        //executo o comando sql
        $query->execute();

        if (($dados = $query->fetch()) == true) {
            if ($dados['Tipo_Enquadramento'] >= '1')
                return 50;
            else
                return 80;
        } else {
            return 80;
        }
    }
}

function aplicar_desconto($valor, $valor_desconto) {

    if ($_SESSION['DESCONTO_INDUSTRIA'] == "N") {
        return $valor;
    } else {
        if ($valor_desconto == 0) {
            return $valor;
        } else {
            return mostrarDinheiro4Casas(inserirDinheiro($valor) - ((inserirDinheiro($valor) * $valor_desconto) / 100));
        }
    }
}
?>


<?php

function formularioCadastro($pdo) {
    ?>

    <?php
    if ($_SESSION['TIPO_IMPOSTO_IMOVEL'] == 1)
        $tipo_imposto = '1 - PREDIAL';
    else
        $tipo_imposto = '2 - TERRITORIAL';

    $qtd_parcelas = 6;
    $ano_divida = date('Y');
    $inscricao = $_SESSION['INSC_IMOVEL'];
    $desconto_industria = desconto_industria($pdo, $inscricao);
    $proprietario = $_SESSION['NOME_PROPRIETARIO'];
    $zona_imovel = $_SESSION['ZONA_IMOVEL'];
    $valor_m2_terreno = mostrarDinheiro4Casas(valor_metro_terreno($pdo));
    $valor_m2_construcao = mostrarDinheiro4Casas(valor_metro_construcao($pdo));
    $aliquota = 1;
    $valor_venal_terreno = valor_venal_terreno($valor_m2_terreno);
    $valor_venal_construcao = valor_venal_construcao($valor_m2_construcao);
    $taxa_coleta_lixo = taxa_coleta_lixo($pdo);
    $taxa_coleta_lixo_desconto = aplicar_desconto($taxa_coleta_lixo, $desconto_industria);
    $valor_te = "0.00";
    $valor_tip = "0.00";
    $tem_manutencao_esgoto = mostrarDinheiro4Casas(tem_manutencao_esgoto());
    $tem_manutencao_esgoto_desconto = aplicar_desconto($tem_manutencao_esgoto, $desconto_industria);

    $valor_iptu = valor_iptu_ufir($valor_venal_terreno, $valor_venal_construcao);
    $valor_taxas = valor_taxas_total($taxa_coleta_lixo, $tem_manutencao_esgoto, $valor_te, $valor_tip);
    $valor_iptu_total = valor_iptu_total_ufir($valor_iptu, $valor_taxas);

    $valor_iptu_desconto = aplicar_desconto($valor_iptu, $desconto_industria);
    $valor_taxas_desconto = aplicar_desconto($valor_taxas, $desconto_industria);
    $valor_iptu_total_desconto = valor_iptu_total_ufir($valor_iptu_desconto, $valor_taxas_desconto);
    ?>
    <form name="calculariptu" action="recursos/includes/calculo/calcularIptuCadastro.php" method="post">
        <div class="mainbox col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0"> <!-- div que posiciona o formulário na tela -->
            <div class="well">
                <div class="panel panel-default">
                    <div class="panel-heading text-center" >CÁLCULO DE IPTU</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label for="insc_inicial">INSC. INICIAL:</label>
                                    <input type="text" value="<?php print $inscricao; ?>" class="form-control" name="insc_inicial" id="insc_inicial" readonly="true">
                                    <input type="hidden" value="<?php print $valor_iptu; ?>" class="form-control" name="valor_iptu_s_desconto" id="valor_iptu_s_desconto" readonly="true">
                                    <input type="hidden" value="<?php print $valor_taxas; ?>" class="form-control" name="valor_taxas_s_desconto" id="valor_taxas_s_desconto" readonly="true">
                                    <input type="hidden" value="<?php print $desconto_industria; ?>" class="form-control" name="desconto_industria" id="desconto_industria" readonly="true">
                                    <input type="hidden" value="<?php print $valor_iptu_total; ?>" class="form-control" name="valor_iptu_total" id="valor_iptu_total" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-2 ">
                                <div class="form-group">
                                    <label for="ano_inicial">ANO INICIAL:</label>
                                    <input type="text" value="<?php print $ano_divida; ?>" class="form-control" name="ano_inicial" id="ano_inicial" maxlength="4" onblur="formata_tabela_vencimento();">
                                </div>
                            </div>
                            <div class="col-sm-2 ">
                                <div class="form-group">
                                    <label for="ano_final">ANO FINAL:</label>
                                    <input type="text" value="<?php print $ano_divida; ?>" class="form-control" name="ano_final" id="ano_final" maxlength="4" onblur="formata_tabela_vencimento();">
                                </div>
                            </div>
                            <div class="col-sm-2 ">
                                <div class="form-group">
                                    <label for="qtd_parcelas">QTD PARCELAS:</label>
                                    <input type="text" class="form-control " name ="qtd_parcelas" id="qtd_parcelas"  value="<?php print $qtd_parcelas; ?>" maxlength="2" placeholder="06" readonly="true"/>
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-inline text-left ">
                                    &nbsp; &nbsp; &nbsp;<input type="checkbox" class="form-control" name ="agrupar_divida_ativa" id="agrupar_divida_ativa" value="S"  checked="checked"/>
                                    <label for="agrupar_divida_ativa">: AGRUPAR DÍVIDA ATIVA</label>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="panel-heading text-center" >DADOS IMÓVEL</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6 ">
                                <div class="form-group">
                                    <label for="proprietario">PROPRIETÁRIO:</label>
                                    <input type="text" value="<?php print $proprietario; ?>" class="form-control" name="proprietario" id="proprietario" readonly="true">
                                </div>
                            </div>

                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="valor_iptu_desconto">VALOR IPTU (UFIR):</label>
                                    <input type="text" value="<?php print $valor_iptu_desconto; ?>" class="form-control" name="valor_iptu_desconto" id="valor_iptu_desconto" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="valor_total_desconto">VALOR TOTAL (UFIR):</label>
                                    <input type="text" value="<?php print $valor_iptu_total_desconto; ?>" class="form-control" name="valor_total_desconto" id="valor_total_desconto"  readonly="true">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="zona_imovel">ZONA :</label>
                                    <input type="text" value="<?php print $zona_imovel; ?>" class="form-control" name="zona_imovel" id="zona_imovel" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="tipo_imposto">TIPO IMPOSTO:</label>
                                    <input type="text" value="<?php print $tipo_imposto; ?>" class="form-control" name="tipo_imposto" id="tipo_imposto" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="valor_terreno_m2">VALOR M² TERR. :</label>
                                    <input type="text" value="<?php print $valor_m2_terreno; ?>" class="form-control" name="valor_terreno_m2" id="valor_terreno_m2" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="valor_construcao_m2">VALOR M² CONST. :</label>
                                    <input type="text" value="<?php print $valor_m2_construcao; ?>" class="form-control" name="valor_construcao_m2" id="valor_construcao_m2" readonly="true">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="aliquota">ALÍQUOTA :</label>
                                    <input type="text" value="<?php print $aliquota; ?>" class="form-control" name="aliquota" id="aliquota" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="valor_venal_territorial">VENAL TERRITORIAL:</label>
                                    <input type="text" value="<?php print $valor_venal_terreno; ?>" class="form-control" name="valor_venal_territorial" id="valor_venal_territorial" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="valor_venal_predial">VENAL PREDIAL:</label>
                                    <input type="text" value="<?php print $valor_venal_construcao; ?>" class="form-control" name="valor_venal_predial" id="valor_venal_predial" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="valor_tcl">VALOR TCL :</label>
                                    <input type="text" value="<?php print $taxa_coleta_lixo_desconto; ?>" class="form-control" name="valor_tcl" id="valor_tcl" readonly="true">
                                    <input type="hidden" value="<?php print $taxa_coleta_lixo; ?>" class="form-control" name="valor_tcl_sem_desconto" id="valor_tcl_sem_desconto" readonly="true">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="valor_te">VALOR TE :</label>
                                    <input type="text" value="<?php print $valor_te; ?>" class="form-control" name="valor_te" id="valor_te" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="valor_tip">VALOR TIP:</label>
                                    <input type="text" value="<?php print $valor_tip; ?>" class="form-control" name="valor_tip" id="valor_tip" readonly="true">
                                </div>
                            </div>
                            <div class="col-sm-3 ">
                                <div class="form-group">
                                    <label for="valor_tme">VALOR TME:</label>
                                    <input type="text" value="<?php print $tem_manutencao_esgoto_desconto; ?>" class="form-control" name="valor_tme" id="valor_tme" readonly="true">
                                    <input type="hidden" value="<?php print $tem_manutencao_esgoto; ?>" class="form-control" name="valor_tme_sem_desconto" id="valor_tme_sem_desconto" readonly="true">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-heading text-center">PARCELAS</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div id="tabela_vencimentos_iptu">
                                    <div style='overflow: auto; max-height: 200px;'>
                                        <?php print tabela_vencimentos($ano_divida, $valor_iptu, $valor_taxas, $qtd_parcelas, $desconto_industria); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-left">
                        <button type="submit" class="btn btn-success" >Calcular</button>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button type="button" class="btn btn-danger" onclick="window.close()">Sair</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <?php
}
?>

