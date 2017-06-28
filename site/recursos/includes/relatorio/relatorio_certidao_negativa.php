<?php
session_start();
if ($_SESSION['PASSOU_CONTROLE'] === 'OK') {
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
include_once '../funcaoPHP/funcao_retorna_descricao_cod_banco.php';


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
        $this->Cell(0, 0, utf8_decode("CERTIDAO DE QUITAÇÃO FISCAL IMOBILIÁRIA"), 3, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 0, utf8_decode("N°" . $_SESSION['REL_NUMERO_CERTIDAO'] . "/" . $_SESSION['REL_ANO_CERTIDAO']), 3, 0, 'C');

        $this->Ln(5);
        $this->Cell(0, -15, "", 1, 0, 'L');
        // Line break
        $this->Ln(8);
    }

// CRIEI A FUNÇÃO PARA ALIMETAR AS LINHA E DEIXAR COR SIM COR NÃO
    function func_dados_imovel() {
//        INSRCICAO E CONTRIBUINTE 
        $this->SetFont('Arial', '', 8);
        $this->Cell(30, 0, utf8_decode("INSCRICAO"), 3, 0, 'L');
        $this->Cell(170, 0, utf8_decode("CONTRIBUINTE"), 3, 0, 'L');
        $this->Ln(5);
        $this->SetFont('Arial', '', 10);
        $this->Cell(35, 0, utf8_decode($_SESSION['REL_INSCRICAO']), 3, 0, 'C');
        $this->Cell(175, 0, utf8_decode($_SESSION['REL_CONTRIBUINTE']), 3, 0, 'L');
        $this->Ln(5);
        $this->Cell(30, -15, "", 1, 0, 'L');
        $this->Cell(0, -15, "", 1, 0, 'L');
        $this->Ln(5);

//        ENDEREÇO
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 0, utf8_decode("ENDERECO"), 3, 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->Ln(5);
        $this->Write(5, utf8_decode($_SESSION['REL_ENDERECO']));
        $this->Ln(5);
        $this->Cell(0, -15, "", 1, 0, 'L');
        $this->Ln(5);

//        BAIRRO CIDADE, ESTADO
        $this->SetFont('Arial', '', 8);
        $this->Cell(68, 0, utf8_decode("BAIRRO"), 3, 0, 'L');
        $this->Cell(68, 0, utf8_decode("CIDADE"), 3, 0, 'L');
        $this->Cell(64, 0, utf8_decode("ESTADO"), 3, 0, 'L');
        $this->Ln(5);
        $this->SetFont('Arial', '', 10);
        $this->Cell(68, 0, utf8_decode($_SESSION['REL_BAIRRO']), 3, 0, 'C');
        $this->Cell(68, 0, utf8_decode($_SESSION['REL_CIDADE']), 3, 0, 'C');
        $this->Cell(64, 0, utf8_decode($_SESSION['REL_ESTADO']), 3, 0, 'C');
        $this->Ln(5);
        $this->Cell(68, -15, "", 1, 0, 'L');
        $this->Cell(68, -15, "", 1, 0, 'L');
        $this->Cell(64, -15, "", 1, 0, 'L');
        $this->Ln(5);


//        ÁREA CONSTRUIDA, ÁREA TERRENO, AVERBADO EM, VALOR VENAL
        $this->SetFont('Arial', '', 8);
        $this->Cell(50, 0, utf8_decode("ÁREA CONSTRUIDA"), 3, 0, 'L');
        $this->Cell(50, 0, utf8_decode("ÁREA TERRENO"), 3, 0, 'L');
        $this->Cell(50, 0, utf8_decode("AVERBADO EM"), 3, 0, 'L');
        $this->Cell(50, 0, utf8_decode("VALOR VENAL"), 3, 0, 'L');
        $this->Ln(5);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 0, utf8_decode($_SESSION['REL_AREA_CONSTRUIDA']), 3, 0, 'C');
        $this->Cell(50, 0, utf8_decode($_SESSION['REL_AREA_TERRENO']), 3, 0, 'C');
        $this->Cell(50, 0, utf8_decode($_SESSION['REL_AVERBADO_EM']), 3, 0, 'C');
        $this->Cell(50, 0, utf8_decode($_SESSION['REL_VALOR_VENAL']), 3, 0, 'C');
        $this->Ln(5);
        $this->Cell(50, -15, "", 1, 0, 'L');
        $this->Cell(50, -15, "", 1, 0, 'L');
        $this->Cell(50, -15, "", 1, 0, 'L');
        $this->Cell(50, -15, "", 1, 0, 'L');
        $this->Ln(5);

        $this->SetFont('Arial', '', 8);
        $this->Cell(30, 0, utf8_decode("UTILIZAÇÃO"), 3, 0, 'L');
        $this->Cell(170, 0, utf8_decode("REQUERENTE"), 3, 0, 'L');
        $this->Ln(5);
        $this->SetFont('Arial', '', 10);
        $this->Cell(35, 0, utf8_decode($_SESSION['REL_UTILIZACAO']), 3, 0, 'C');
        $this->Cell(175, 0, utf8_decode($_SESSION['REL_REQUERENTE']), 3, 0, 'L');
        $this->Ln(5);
        $this->Cell(30, -15, "", 1, 0, 'L');
        $this->Cell(0, -15, "", 1, 0, 'L');
    }

    function func_composicao_carta() {
        $this->Ln(10);
        $this->setFont('arial', '', 12);
        $this->MultiCell(0, 6, utf8_decode($_SESSION['REL_CARTA']), 0, 'J');

        $this->Ln(10);
    }

    function func_observacao() {
        //Observações

        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 5, utf8_decode("\nObservações: \n\n" . $_SESSION['REL_OBSERVACAO']), 1, 'J');
        $this->Ln(10);
        $this->Cell(0, 0, "Rio De Janeiro, " . date('d') . " de " . date("M") . " de " . date('Y'), 0, 0, 'C');
        $this->Ln(30);
        $this->Cell(0, 0, "_______________________________             ________________________________", 0, 0, 'C');
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
    $pdf->func_composicao_carta();
    $pdf->func_observacao();

// FECHO E GERO O ARQUIVO NA TELA
    $pdf->Output();
} catch (Exception $e) {
    print $e;
}
}else{
       die(header("Location: ../../../RelCertidaoNegativa.php"));
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