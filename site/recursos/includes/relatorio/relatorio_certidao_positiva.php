<?php

session_start();
if ($_SESSION['PASSOU_CONTROLE'] === 'OK') {
    include_once '../funcaoPHP/funcaoData.php';
    include_once '../funcaoPHP/funcaoDinheiro.php';
    include_once '../funcaoPHP/funcao_retorna_descricao_cod_banco.php';
    include_once '../funcaoPHP/funcao_calcular_juros_multa.php';


#Possibilita a correta operação no IE 
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename=arquivo.pdf');
    date_default_timezone_set("America/Sao_Paulo");
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */
// incluo a biblioteca do fpdf 

    include '../estrutura/fpdf/fpdf.php';

//CRIO MINHA CLASSE E UTILIZO HERANÇA DELA DA CLASSE fpdf
    class PDF extends FPDF {

        // Sobre escrevo o método implementado pela classe FPDF
        function Header() {
//        treta do titulo do form
// enviado pelo formulario
            // Arial bold 15
            $this->SetFont('Arial', 'B', 12);

            // Title
//        Image(caminho, espaco a esquerda, espaco a cima, largura, altura)
            $this->Image('../../imagens/estrutura/logo.jpg', 10, 10, 35, 15);
            $this->Cell(45, 0, '', 5, 0, 'R');
            $this->Cell(0, -5, $_SESSION['C_PREFEITURA'], 5, 0, 'L');
            $this->Ln(5);
            $this->SetFont('Arial', '', 10);
            $this->Cell(45, 0, '', 5, 0, 'R');
            $this->Cell(170, 0, $_SESSION['C_SECRETARIA'], 3, 1, 'L');
            $this->Cell(190, 0, date('d/m/Y'), 5, 0, 'R');
            $this->Ln(7);
            $this->Cell(0, -20, "", 1, 0, 'L');
            $this->Ln(5);
            $this->SetFont('Arial', '', 10);
//       titulo do relatório
            $this->setFont('arial', 'B', 9);
            $this->Cell(0, 0, utf8_decode("CERTIDAO DE DÉBITO FISCAL IMOBILIÁRIA"), 3, 0, 'C');
            $this->Ln(5);
            $this->Cell(0, 0, utf8_decode("N°" . $_SESSION['REL_NUMERO_CERTIDAO'] . "/" . $_SESSION['REL_ANO_CERTIDAO']), 3, 0, 'C');

            $this->Ln(5);
            $this->Cell(0, -15, "", 1, 0, 'L');
            // Line break
            $this->Ln(3);
        }

// CRIEI A FUNÇÃO PARA ALIMETAR AS LINHA E DEIXAR COR SIM COR NÃO
        function func_dados_imovel() {
//        INSRCICAO E CONTRIBUINTE 
            $this->SetFont('Arial', '', 9);
            $this->Cell(30, 5, utf8_decode("INSCRIÇÃO"), 3, 0, 'L');
            $this->Cell(170, 5, utf8_decode("CONTRIBUINTE"), 3, 0, 'L');
            $this->Ln(5);
            $this->Cell(35, 5, utf8_decode($_SESSION['REL_INSCRICAO']), 3, 0, 'C');
            $this->Cell(175, 5, utf8_decode($_SESSION['REL_CONTRIBUINTE']), 3, 0, 'L');
            $this->Ln(5);
            $this->Cell(30, -10, "", 1, 0, 'L');
            $this->Cell(0, -10, "", 1, 0, 'L');
            $this->Ln(0);

//        ENDEREÇO
            $this->MultiCell(0, 5, utf8_decode("ENDEREÇO: \n" . $_SESSION['REL_ENDERECO']), 1, 'J');
            $this->Ln(0);

//        BAIRRO CIDADE, ESTADO
            $this->Cell(68, 5, utf8_decode("BAIRRO"), 3, 0, 'L');
            $this->Cell(68, 5, utf8_decode("CIDADE"), 3, 0, 'L');
            $this->Cell(64, 5, utf8_decode("ESTADO"), 3, 0, 'L');
            $this->Ln(4);

            $this->Cell(68, 5, utf8_decode($_SESSION['REL_BAIRRO']), 3, 0, 'C');
            $this->Cell(68, 5, utf8_decode($_SESSION['REL_CIDADE']), 3, 0, 'C');
            $this->Cell(64, 5, utf8_decode($_SESSION['REL_ESTADO']), 3, 0, 'C');
            $this->Ln(5);
            $this->Cell(68, -9, "", 1, 0, 'L');
            $this->Cell(68, -9, "", 1, 0, 'L');
            $this->Cell(64, -9, "", 1, 0, 'L');
            $this->Ln(0);


//        ÁREA CONSTRUIDA, ÁREA TERRENO, AVERBADO EM, VALOR VENAL
            $this->Cell(50, 5, utf8_decode("ÁREA CONSTRUIDA"), 3, 0, 'L');
            $this->Cell(50, 5, utf8_decode("ÁREA TERRENO"), 3, 0, 'L');
            $this->Cell(50, 5, utf8_decode("AVERBADO EM"), 3, 0, 'L');
            $this->Cell(50, 5, utf8_decode("VALOR VENAL"), 3, 0, 'L');
            $this->Ln(4);

            $this->Cell(50, 5, utf8_decode(mostrarDinheiro($_SESSION['REL_AREA_CONSTRUIDA'])), 3, 0, 'C');
            $this->Cell(50, 5, utf8_decode(mostrarDinheiro($_SESSION['REL_AREA_TERRENO'])), 3, 0, 'C');
            $this->Cell(50, 5, utf8_decode($_SESSION['REL_AVERBADO_EM']), 3, 0, 'C');
            $this->Cell(50, 5, utf8_decode($_SESSION['REL_VALOR_VENAL']), 3, 0, 'C');
            $this->Ln(5);
            $this->Cell(50, -9, "", 1, 0, 'L');
            $this->Cell(50, -9, "", 1, 0, 'L');
            $this->Cell(50, -9, "", 1, 0, 'L');
            $this->Cell(50, -9, "", 1, 0, 'L');
            $this->Ln(0);

            $this->Cell(30, 5, utf8_decode("UTILIZAÇÃO"), 3, 0, 'L');
            $this->Cell(170, 5, utf8_decode("REQUERENTE"), 3, 0, 'L');
            $this->Ln(5);

            $this->Cell(35, 5, utf8_decode($_SESSION['REL_UTILIZACAO']), 3, 0, 'C');
            $this->Cell(175, 5, utf8_decode($_SESSION['REL_REQUERENTE']), 3, 0, 'L');
            $this->Ln(5);
            $this->Cell(30, -10, "", 1, 0, 'L');
            $this->Cell(0, -10, "", 1, 0, 'L');
            $this->Ln(3);
        }

        function func_descricao_divida() {

            $this->setFont('arial', '', 8);
            include_once '../estrutura/conexao/conexao.php';
            // CRIEI ARRAYS PARA SIMULAR DADOS VINDO DO BANCO DE DADOS
            // preparo para realizar o comando sql
            $sql = "SELECT F.INSCRICAO_IMOB,F.ANO_DIVIDA,F.COD_DIVIDA,D.DESC_DIVIDA,
       '99' PARCELA ,SUM(F.VALOR) VALOR , SUM(F.VLR_BASE) VLR_BASE ,
       '01/12/'+Ano_Divida vencimento
       FROM FINANCEIRO_IMOB F, DIVIDA_IMOB D WHERE
            F.COD_DIVIDA = D.COD_DIVIDA_IMOB AND
            F.INSCRICAO_IMOB='{$_SESSION['REL_INSCRICAO']}' AND
            F.COD_DIVIDA IN ('01','02') AND
            F.COD_SITUACAO_DIVIDA IN ('01','02','03') AND
            F.ANO_DIVIDA >=CONVERT(VARCHAR(4),DATEPART(YEAR,GETDATE())-8) AND
            F.ANO_DIVIDA < CONVERT(VARCHAR(4),DATEPART(YEAR,GETDATE()))
            GROUP BY F.INSCRICAO_IMOB,F.ANO_DIVIDA,F.COD_DIVIDA,D.DESC_DIVIDA
        union
        SELECT F.INSCRICAO_IMOB,F.ANO_DIVIDA,F.COD_DIVIDA,D.DESC_DIVIDA,
               '00' PARCELA ,SUM(F.VALOR) VALOR , SUM(F.VLR_BASE) VLR_BASE ,
               '31/03/'+Ano_Divida vencimento
               FROM FINANCEIRO_IMOB F, DIVIDA_IMOB D WHERE
        F.COD_DIVIDA = D.COD_DIVIDA_IMOB AND
        F.INSCRICAO_IMOB='{$_SESSION['REL_INSCRICAO']}' AND
        F.COD_DIVIDA IN ('01','02') AND
        F.COD_SITUACAO_DIVIDA IN ('01','02','03') AND
        F.ANO_DIVIDA = CONVERT(VARCHAR(4),DATEPART(YEAR,GETDATE())) and
        F.VENCIMENTO < GETDATE()
        GROUP BY F.INSCRICAO_IMOB,F.ANO_DIVIDA,F.COD_DIVIDA,D.DESC_DIVIDA
        ORDER BY F.ANO_DIVIDA";
            $query = $pdo->prepare($sql);
            //executo o comando sql
            $query->execute();
            $linha = false;
            $valor_base = 0.;
            $multas = 0.;
            $juros = 0.;
            $valor_em_reais = 0.;
            $valor_Total_debito = 0.;


//        cabecalho 
            $this->setFont('arial', 'B', 9);
            $this->Cell(200, 6, utf8_decode("DEMONSTRATIVO DOS DÉBITOS"), 1, 0, 'C');
            $this->Ln();
            $this->Cell(20, 6, "ANO", 1, 0, 'C');
            $this->Cell(20, 6, "COD ", 1, 0, 'C');
            $this->Cell(40, 6, "DESCRICAO", 1, 0, 'C');
            $this->Cell(30, 6, "VALOR BASE", 1, 0, 'C');
            $this->Cell(30, 6, "MULTAS", 1, 0, 'C');
            $this->Cell(30, 6, "JUROS", 1, 0, 'C');
            $this->Cell(30, 6, "VALOR", 1, 0, 'C');
            $this->setFont('arial', '', 8);
            $this->Ln();
            //loop para listar todos os dados encontrados
            for ($i = 0; $dados = $query->fetch(); $i++) {
                $Cod_Bairro = $dados['INSCRICAO_IMOB'];
                $valor_base = calcula_valor_base($dados['VALOR'], $_SESSION['C_VALOR_MOEDA_DIA_UFIR'], 1);
                $multas = mostrarDinheiro(calcula_multa(1, $dados['ANO_DIVIDA'], $dados['vencimento'], $valor_base));
                $juros = mostrarDinheiro(calcula_juros(1, $dados['vencimento'], $valor_base));
                $valor_em_reais = mostrarDinheiro(calcula_valor_total($valor_base, $multas, $juros));

                if ($linha == true)
                    $linha = false;
                else
                    $linha = true;

                // ALIMENTO A LINHA DA TABELA
                $this->Cell(20, 6, $dados['ANO_DIVIDA'], 1, 0, 'C', $linha);
                $this->Cell(20, 6, $dados['COD_DIVIDA'], 1, 0, 'C', $linha);
                $this->Cell(40, 6, $dados['DESC_DIVIDA'], 1, 0, 'C', $linha);
                $this->Cell(30, 6, "R$ " . mostrarDinheiro($valor_base), 1, 0, 'C', $linha);
                $this->Cell(30, 6, "R$ " . $multas, 1, 0, 'C', $linha);
                $this->Cell(30, 6, "R$ " . $juros, 1, 0, 'C', $linha);
                $this->Cell(30, 6, "R$ " . $valor_em_reais, 1, 0, 'C', $linha);
                $valor_Total_debito += inserirDinheiro($valor_em_reais);
                $this->Ln();
            }


            $this->setFont('arial', 'B', 9);
            $this->Cell(20, 6, "TOTAL ", 1, 0, 'C');
            $this->Cell(180, 6, "R$ " . mostrarDinheiro($valor_Total_debito), 1, 0, 'R');
            $this->setFont('arial', '', 8);
        }

        function func_composicao_carta() {
            $this->Ln(10);
            $this->setFont('arial', 'B', 10);
            $this->MultiCell(0, 6, utf8_decode($_SESSION['REL_CARTA']), 0, 'J');

            $this->Ln(10);
        }

        function func_observacao() {
            //Observações

            $this->SetFont('Arial', '', 8);
            $this->MultiCell(0, 5, utf8_decode("OBSERVAÇÃO: \n" . $_SESSION['REL_OBSERVACAO']), 1, 'J');
            $this->Ln(10);
            $this->Cell(0, 0, "Rio De Janeiro, " . date('d') . " de " . date("M") . " de " . date('Y'), 0, 0, 'C');
            $this->Ln(20);
            $this->Cell(0, 0, "_______________________________________________             _______________________________________________", 0, 0, 'C');
        }

    }

?>
    <?php

    try {
// INSTANCIO O OBJETO E PASSO L PARA QUE SEJA A FOLHA DEITADA
        $pdf = new PDF('P'); // P = Portrait, em milimetros, e A4 (210x297)
// UTILIZO O MÉTODO PARA CALCULAR O NUMERO DE PAGINAS
        $pdf->AliasNbPages();

// ESPECIFICO O TAMANHO DAS MARGINS
        $pdf->SetMargins(5, 15, 5, 5);

// Color and font restoration
        $pdf->SetFillColor(224, 235, 255);


// ADICIONO A PAGINA EM BRANCO
        $pdf->AddPage('P', 'A4');

// PREENCHO A PAGINA EM BRANCO COM O MÉTODO QUE EU CRIE ACIMA
        $pdf->func_dados_imovel();
        $pdf->func_descricao_divida();
        $pdf->func_composicao_carta();
        $pdf->func_observacao();


// FECHO E GERO O ARQUIVO NA TELA
        $pdf->Output();
    } catch (Exception $e) {
        print $e;
    }
} else {
    die(header("Location: ../../../RelCertidaoPositiva.php"));
}
//limpando variaveis de sessao
//VARIAVEIS DE SESSAO
unset($_SESSION['PASSOU_CONTROLE']);
unset($_SESSION['REL_NUMERO_CERTIDAO']);
unset($_SESSION['REL_ANO_CERTIDAO']);
unset($_SESSION['REL_INSCRICAO']);
unset($_SESSION['REL_CONTRIBUINTE']);
unset($_SESSION['REL_ENDERECO']);
unset($_SESSION['REL_CIDADE']);
unset($_SESSION['REL_BAIRRO']);
unset($_SESSION['REL_ESTADO']);
unset($_SESSION['REL_AREA_CONSTRUIDA']);
unset($_SESSION['REL_AREA_TERRENO']);
unset($_SESSION['REL_AVERBADO_EM']);
unset($_SESSION['REL_VALOR_VENAL']);
unset($_SESSION['REL_UTILIZACAO']);
unset($_SESSION['REL_REQUERENTE']);
unset($_SESSION['REL_REQUERENTE_CPF']);
unset($_SESSION['REL_REQUERENTE_IDENTIDADE']);
unset($_SESSION['REL_REQUERENTE_ENDERECO']);
unset($_SESSION['NUMERO_PROCESSO']);
unset($_SESSION['ANO_PROCESSO']);
unset($_SESSION['REL_AVERBADO_EM']);
unset($_SESSION['REL_CARTA']);
unset($_SESSION['REL_OBSERVACAO']);
    ?>