<?php

session_start();
include_once '../funcaoPHP/funcaoData.php';
include_once '../funcaoPHP/funcaoDinheiro.php';
include_once '../funcaoPHP/funcao_retorna_descricao_cod_banco.php';
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
//        treta do titulo do form
        global $relacao;
        
// enviado pelo formulario
        // Arial bold 15
        $this->SetFont('Arial', 'B', 20);
        // Move to the right
        // Title
//        Image(caminho, espaco a esquerda, espaco a cima, largura, altura)
        $this->Image('../../imagens/estrutura/logo.jpg', 10, 10, 35, 15);
        $this->Cell(45, 0, '', 5, 0, 'R');
        $this->Cell(0, -5, $_SESSION['C_PREFEITURA'], 5, 0, 'L');
        $this->Ln(5);
        $this->SetFont('Arial', '', 12);
        $this->Cell(45, 0, '', 5, 0, 'R');
        $this->Cell(170, 0, $_SESSION['C_SECRETARIA'], 3, 0, 'L');
        $this->Ln(7);

        $this->Cell(0, 0, "", 1, 0, 'L');
        $this->Ln(5);
        $this->SetFont('Arial', '', 16);
        if($relacao == 1){
        $this->Cell(0, 0, utf8_decode("RELAÇÃO DE DOCARJS PAGOS "), 3, 0, 'C');
        }else{
        $this->Cell(0, 0, utf8_decode("RELAÇÃO DE DOCARJS NÃO PAGOS "), 3, 0, 'C');
            
        }
        $this->Ln(5);
        $this->Cell(0, 0, "", 1, 0, 'L');
        // Line break
        $this->Ln(8);
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(.1);
        $this->SetFont('Arial', '', 10);

        $headertabela = array( 'Num_Dam', 'Ano_Dam', 'Parc', 'Vencimento', 'Valor', 'Dt_Pagto', 'Vlr_Pagto', 'Banco_Pagto');
        // ALIMENTO O CABECALHO DA PAGINA
        $w = array( 30, 30, 30, 30, 30, 30, 30, 50);

        $this->Cell(10);
        for ($i = 0; $i < count($headertabela); $i++)
            $this->Cell($w[$i], 7, utf8_decode($headertabela[$i]), 1, 0, 'CXC', true);
        $this->Ln();
    }

// CRIEI A FUNÇÃO PARA ALIMETAR AS LINHA E DEIXAR COR SIM COR NÃO
    function tablePDF($dt_inicial, $dt_final, $relacao) {

        include_once '../estrutura/conexao/conexao.php';
        // CRIEI ARRAYS PARA SIMULAR DADOS VINDO DO BANCO DE DADOS
        // preparo para realizar o comando sql
        $sql = "SELECT * FROM Financeiro_Dam fd, DAM d ";
        $sql = $sql . " WHERE fd.Num_Dam = d.Num_Dam";
        $sql = $sql . " AND fd.Ano_Dam = d.Ano_Dam";
        if ($relacao == 2) {
            $sql = $sql . " AND fd.Cod_Situacao_divida in (01,02,03)";
        } else {
            $sql = $sql . " AND fd.Cod_Situacao_divida not in (01,02,03)";
        }
        $sql = $sql . " AND fd.Vencimento between '$dt_inicial' AND '$dt_final' ";
        $sql = $sql . " ORDER BY fd.Num_Dam, fd.Ano_Dam";


        $query = $pdo->prepare($sql);
        //executo o comando sql
        $query->execute();
        
        $linha = false;
        
           $soma_valor_a_receber = 0.;
           $soma_valor_pago = 0.;
        
        //loop para listar todos os dados encontrados
        for ($i = 0; $dados = $query->fetch(); $i++) {
            
            // o CÓDIGO ABAIXO É PRA EU PEGAR OS DADOS DO ARRAY E COLOCAR DENTRO DO LOOP PARA CRIAR VÁRIAS PÁGINAS
            $soma_valor_a_receber += $dados['Valor'];
            $soma_valor_pago += $dados['Valor_Pagamento'];


            if ($linha == true)
                $linha = false;
            else
                $linha = true;

            // ALIMENTO A LINHA DA TABELA
            $this->Cell(10);
            $this->Cell(30, 6, $dados['Num_Dam'], 1, 0, 'C', $linha);
            $this->Cell(30, 6, $dados['Ano_Dam'], 1, 0, 'C', $linha);
            $this->Cell(30, 6, $dados['Parcela'], 1, 0, 'C', $linha);
            $this->Cell(30, 6, dataBrasileiro($dados['Vencimento']), 1, 0, 'C', $linha);
            $this->Cell(30, 6, mostrarDinheiro($dados['Valor']), 1, 0, 'R', $linha);
            $this->Cell(30, 6, dataBrasileiro($dados['Data_Pagamento']), 1, 0, 'R', $linha);
            $this->Cell(30, 6, mostrarDinheiro($dados['Valor_Pagamento']), 1, 0, 'R', $linha);
            $this->Cell(50, 6, fun_retorna_descricao_cod_banco($pdo, $dados['Cod_Banco']), 1, 0, 'C', $linha);

            $this->Ln();
            
        }
        $this->Ln();
         $this->Cell(11);
         $this->Cell(50, 6, "TOTAL DE REGISTROS", 1, 0, 'L', $linha);
         $this->Cell(36, 6, $i, 1, 0, 'C', $linha);
           
         $this->Cell(50, 6, "TOTAL VALOR A RECEBER", 1, 0, 'L', $linha);
         $this->Cell(36, 6, "R$ : " . mostrarDinheiro($soma_valor_a_receber), 1, 0, 'C', $linha);
           
         $this->Cell(50, 6, "TOTAL DE VALOR PAGOS", 1, 0, 'L', $linha);
         $this->Cell(36, 6, "R$ : " . mostrarDinheiro($soma_valor_pago), 1, 0, 'C', $linha);
           
    }

}

?>
<?php

$dt_inicial = dataAmericano($_POST['txt_dt_inicial']);
$dt_final = dataAmericano($_POST['txt_dt_final']);
$relacao = $_POST['txt_relacao_docarj'];
global $relacao;

// INSTANCIO O OBJETO E PASSO L PARA QUE SEJA A FOLHA DEITADA
$pdf = new PDF('L'); // P = Portrait, em milimetros, e A4 (297x210)
// UTILIZO O MÉTODO PARA CALCULAR O NUMERO DE PAGINAS
$pdf->AliasNbPages();

// ESPECIFICO O TAMANHO DAS MARGINS
$pdf->SetMargins(5, 15, 5, 5);

// Color and font restoration
$pdf->SetFillColor(224, 235, 255);


// ADICIONO A PAGINA EM BRANCO
$pdf->AddPage('L', 'A4');



// PREENCHO A PAGINA EM BRANCO COM O MÉTODO QUE EU CRIE ACIMA
$pdf->tablePDF($dt_inicial, $dt_final, $relacao);

// FECHO E GERO O ARQUIVO NA TELA
$pdf->Output();
?>