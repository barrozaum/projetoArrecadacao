<?php
session_start();
include_once '../estrutura/conexao/conexao.php';
include_once '../funcaoPHP/funcaoData.php';
$query = $pdo->prepare("select * FROM configuracao_sistema");
$query->execute();
$row = $query->fetch();
unset($pdo); 
unset($query);
set_time_limit(0);

include_once('class/tcpdf/tcpdf.php');
include_once("class/PHPJasperXML.inc.php");
include_once ('setting.php');

$estado= $_SESSION['C_ESTADO']; //recebendo o parâmetro descrição
$prefeitura= $_SESSION['C_PREFEITURA']; //recebendo o parâmetro descrição
$secretaria= $_SESSION['C_SECRETARIA']; //recebendo o parâmetro descrição
$dt_inicial= $_POST['txt_dt_inicial'];
$dt_final  = $_POST['txt_dt_final'];
$inscricao_inicial = $_POST['txt_inscricao_inicial'];
$inscricao_final = $_POST['txt_inscricao_final'];
          
$sqlDataInicial = dataAmericano($dt_inicial);         
$sqlDataFinal = dataAmericano($dt_final);         

$titulo="Relação de Cancelamentos - Periodo: $dt_inicial à $dt_final "; //recebendo o parâmetro descrição
$titulo2="Da Inscrição $inscricao_inicial à $inscricao_final"; //recebendo o parâmetro descrição



$PHPJasperXML = new PHPJasperXML();


$PHPJasperXML->arrayParameter=array("Estado"=>$estado,
                                    "Prefeitura"=>$prefeitura,
                                    "Secretaria"=>$secretaria,
                                    "Titulo"=>$titulo,
                                    "Titulo2"=>$titulo2,
                                    "inscricaoInicial"=>$inscricao_inicial,
                                    "inscricaoFinal"=>$inscricao_final, 
                                    "sqlDataInicial"=>$sqlDataInicial, 
                                    "sqlDataFinal"=>$sqlDataFinal 
    
    ); //passa o parâmetro cadastrado no iReport


$PHPJasperXML->load_xml_file("relCancelamentosDividas.jrxml");

$cndriver = "pdosqlsrv";
$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db,$cndriver);
$outpage = $PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file


?>
