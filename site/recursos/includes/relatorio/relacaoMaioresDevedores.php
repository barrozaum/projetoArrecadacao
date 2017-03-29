<?php
session_start();
?>
<?php

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
        $this->Image('../../imagens/estrutura/logo.jpg', 10, 6, 30);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 15);
        // Move to the right
        $this->Cell(50);
        // Title
        $this->Cell(120, 10, utf8_decode('Relatório Maiores devedores'), 1, 0, 'C');
        // Line break
        $this->Ln(20);

        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.1);
        $this->SetFont('Arial', '', 7);
        $headertabela = array('Inscrição', 'Prorietario', 'Endereco', 'Ano', 'Dívida', 'SubDivida', 'Valor Principal', 'Valor Atualizado');
        // ALIMENTO O CABECALHO DA PAGINA
        $w = array(20, 78, 100, 9, 25, 15, 22, 22);

        for ($i = 0; $i < count($headertabela); $i++)
            $this->Cell($w[$i], 7, utf8_decode($headertabela[$i]), 1, 0, 'C', true);
        $this->Ln();
    }

// CRIEI A FUNÇÃO PARA ALIMETAR AS LINHA E DEIXAR COR SIM COR NÃO
    function tablePDF($anoIni,$anoFin,$qtd,$anoDivIni,$anoDivFin) {
        
        include_once '../estrutura/conexao/conexao.php';
        // CRIEI ARRAYS PARA SIMULAR DADOS VINDO DO BANCO DE DADOS
        // preparo para realizar o comando sql
        $sql = "SET ROWCOUNT $qtd
                SELECT F.INSCRICAO_IMOB,
                       TIPO_IMPOSTO,
                       PROPRIETARIO,
                       COD_RUA,
                       NUMERO,
                       COMPLEMENTO,
                       COD_BAIRRO,
                       STR(SUM(VALOR_PAGAMENTO),10,2) VL_TOTAL
                FROM FINANCEIRO_IMOB F, PAGAMENTOS_IMOB P, CAD_IMOBILIARIO C, DIVIDA_IMOB D 
                WHERE (F.ANO_DIVIDA >= '$anoIni'  AND   
                 F.ANO_DIVIDA <= '$anoFin') AND    
                (F.COD_DIVIDA >= '$anoDivIni'    AND    
                 F.COD_DIVIDA <= '$anoDivFin')   AND    
                P.INSCRICAO_IMOB = F.INSCRICAO_IMOB AND
                P.ANO_DIVIDA = F.ANO_DIVIDA AND
                P.COD_DIVIDA = F.COD_DIVIDA AND
                P.SUB_DIVIDA = F.SUB_DIVIDA AND
                P.PARCELA    = F.PARCELA    AND
                C.INSCRICAO_IMOB = F.INSCRICAO_IMOB AND
                F.COD_DIVIDA     = D.COD_DIVIDA_IMOB

                GROUP BY F.INSCRICAO_IMOB, TIPO_IMPOSTO, PROPRIETARIO, COD_RUA, NUMERO, COMPLEMENTO, COD_BAIRRO

                ORDER BY VL_TOTAL DESC


                SET ROWCOUNT 0";
        $query = $pdo->prepare($sql);
        //executo o comando sql
        $query->execute();
        $linha = false;
        //loop para listar todos os dados encontrados
        for ($i = 0; $dados = $query->fetch(); $i++) {
            $Cod_Bairro = $dados['INSCRICAO_IMOB'];

            // o CÓDIGO ABAIXO É PRA EU PEGAR OS DADOS DO ARRAY E COLOCAR DENTRO DO LOOP PARA CRIAR VÁRIAS PÁGINAS



            if ($linha == true)
                $linha = false;
            else
                $linha = true;

            // ALIMENTO A LINHA DA TABELA
            $this->Cell(20, 6, $dados['INSCRICAO_IMOB'], 1, 0, 'C', $linha);
            $this->Cell(78, 6, utf8_decode($dados['PROPRIETARIO']), 1, 0, 'C', $linha);
            $this->Cell(100, 6, utf8_decode($dados['COD_RUA'] . $dados['NUMERO'] . $dados['COMPLEMENTO'] . $dados['COD_BAIRRO']), 1, 0, 'C', $linha);
            $this->Cell(9, 6, 2016, 1, 0, 'C', $linha);
            $this->Cell(25, 6, $dados['TIPO_IMPOSTO'], 1, 0, 'C', $linha);
            $this->Cell(15, 6, '00', 1, 0, 'C', $linha);
            $this->Cell(22, 6, $dados['VL_TOTAL'], 1, 0, 'C', $linha);
            $this->Cell(22, 6, $dados['VL_TOTAL'], 1, 0, 'C', $linha);

            $this->Ln();
        }
    }

}
?>
<?php
$anoIni = $_REQUEST['txtAnoInicial'];
$anoFin = $_REQUEST['txtAnoFinal'];
$qtd = $_REQUEST['txtQtdListar'];
$anoDivIni = $_REQUEST['txtCodDivInicial'];
$anoDivFin = $_REQUEST['txtCodDivFinal'];


// INSTANCIO O OBJETO E PASSO L PARA QUE SEJA A FOLHA DEITADA
$pdf = new PDF('L'); // P = Portrait, em milimetros, e A4 (210x297)
// UTILIZO O MÉTODO PARA CALCULAR O NUMERO DE PAGINAS
$pdf->AliasNbPages();

// ESPECIFICO O TAMANHO DAS MARGINS
$pdf->SetMargins(3, 15, 20, 20);

// Color and font restoration
$pdf->SetFillColor(224, 235, 255);

// ESPECIFICO O TIPO E O TAMANHO DA FONT
$pdf->SetFont('Arial', '', 7);

// ADICIONO A PAGINA EM BRANCO
$pdf->AddPage();


// PREENCHO A PAGINA EM BRANCO COM O MÉTODO QUE EU CRIE ACIMA
$pdf->tablePDF($anoIni,$anoFin,$qtd,$anoDivIni,$anoDivFin);

// FECHO E GERO O ARQUIVO NA TELA
$pdf->Output();
?>