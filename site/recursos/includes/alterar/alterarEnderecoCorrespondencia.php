<?php
//valido a sessão do usuário 
include_once '../estrutura/controle/validarSessao.php';

//verifico se a página está sendo chamada pelo méthod POST
// Se sim executa escript
// Senao dispara Erro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//ARRAY PARA ARMAZENAR ERROS
    $array_erros = array();

// biblioteca para validar string informada    
    include ('../funcaoPHP/function_letraMaiscula.php');

// aplica filtro na string enviada (LetraMaiuscula)
    $inscricao_Letra_Maiscula = letraMaiuscula($_POST['txt_inscricao']);
    $proprietario_Letra_Maiscula = letraMaiuscula($_POST['txt_proprietario']);
    $nome_completo_Letra_Maiscula = letraMaiuscula($_POST['txt_nome_completo']);
    $cep_completo_Letra_Maiscula = letraMaiuscula($_POST['txt_cep']);
    $telefone_completo_Letra_Maiscula = letraMaiuscula($_POST['txt_telefone']);
    $rua_completo_Letra_Maiscula = letraMaiuscula($_POST['txt_rua']);
    $numero_completo_Letra_Maiscula = letraMaiuscula($_POST['txt_numero']);
    $complemento_completo_Letra_Maiscula = letraMaiuscula($_POST['txt_complemento']);
    $bairro_completo_Letra_Maiscula = letraMaiuscula(substr($_REQUEST['txt_bairro'], 0, 19));
    $cidade_completo_Letra_Maiscula = letraMaiuscula($_POST['txt_cidade']);
    $uf_completo_Letra_Maiscula = letraMaiuscula($_POST['txt_uf']);

    
// variaves serão preenchidas por valores do formulario
// valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto
    if ((strlen($inscricao_Letra_Maiscula) == 6) || is_int($inscricao_Letra_Maiscula) === TRUE) {
        $inscricao = $inscricao_Letra_Maiscula;
    } else {
        $array_erros['txt_inscricao'] = 'POR FAVOR ENTRE COM UMA INSCRIÇÃO VÁLIDA \n';
    }

// filtro pra validar 
    if (strlen($proprietario_Letra_Maiscula) > 2 && strlen($proprietario_Letra_Maiscula) < 51) {
        $prorietario = $proprietario_Letra_Maiscula;
    } else {
        $array_erros['txt_proprietario'] = 'POR FAVOR ENTRE COM O PROPRIETARIO VÁLIDO \n';
    }

// filtro pra validar 
    if (strlen($nome_completo_Letra_Maiscula) > 2 && strlen($nome_completo_Letra_Maiscula) < 51) {
        $nome_completo = $nome_completo_Letra_Maiscula;
    } else {
        $array_erros['txt_nome_completo'] = 'POR FAVOR ENTRE COM O NOME COMPLETO VÁLIDO \n';
    }

// filtro pra validar 
    if (strlen($cep_completo_Letra_Maiscula) == 8) {
        $cep = $cep_completo_Letra_Maiscula;
    } else {
        $array_erros['txt_cep'] = 'POR FAVOR ENTRE COM O CEP VÁLIDO \n';
    }

// filtro pra validar 
    if (strlen($telefone_completo_Letra_Maiscula) > 9 && strlen($telefone_completo_Letra_Maiscula) < 12) {
        $telefone = $telefone_completo_Letra_Maiscula;
    } else {
        $array_erros['txt_telefone'] = 'POR FAVOR ENTRE COM O TELEFONE VÁLIDO \n';
    }

// filtro pra validar 
    if (strlen($rua_completo_Letra_Maiscula) > 2 && strlen($rua_completo_Letra_Maiscula) < 51) {
        $rua = $rua_completo_Letra_Maiscula;
    } else {
        $array_erros['txt_rua'] = 'POR FAVOR ENTRE COM A RUA VÁLIDA \n';
    }

// filtro pra validar 
    if (strlen($numero_completo_Letra_Maiscula) > 0 && strlen($numero_completo_Letra_Maiscula) < 6) {
        $numero = $numero_completo_Letra_Maiscula;
    } else {
        $array_erros['txt_numero'] = 'POR FAVOR ENTRE COM O NUMERO VÁLIDO \n';
    }

// filtro pra validar 
    if (strlen($complemento_completo_Letra_Maiscula) < 31) {
        $complemento = $complemento_completo_Letra_Maiscula;
    } else {
        $array_erros['txt_complemento'] = 'POR FAVOR ENTRE COM O COMPLEMENTO VÁLIDO \n';
    }

// filtro pra validar 
    if (strlen($bairro_completo_Letra_Maiscula) > 2 && strlen($bairro_completo_Letra_Maiscula) < 21) {
        $bairro = $bairro_completo_Letra_Maiscula;
    } else {
        $array_erros['txt_bairro'] = 'POR FAVOR ENTRE COM O BAIRRO VÁLIDO \n';
    }

// filtro pra validar 
    if (strlen($cidade_completo_Letra_Maiscula) > 2 && strlen($cidade_completo_Letra_Maiscula) < 21) {
        $cidade = $cidade_completo_Letra_Maiscula;
    } else {
        $array_erros['txt_cidade'] = 'POR FAVOR ENTRE COM A CIDADE VÁLIDA \n';
    }

// filtro pra validar 
    if (strlen($uf_completo_Letra_Maiscula) == 2) {
        $uf = $uf_completo_Letra_Maiscula;
    } else {
        $array_erros['txt_uf'] = 'POR FAVOR ENTRE COM A UF VÁLIDA \n';
    }



// verifico se tem erro na validação
    if (empty($array_erros)) {

//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
        $pdo->beginTransaction();

//      Comando sql a ser executado 
       $sql = "UPDATE Cad_Imobiliario "
        . "SET Nome_Corr = '".$nome_completo. "',"
        . "Rua_Corr = '".$rua."',"
        . "Numero_Corr = '".$numero."',"
        . "Complemento_Corr = '".$complemento."',"
        . "Bairro_Corr = '".$bairro."',"
        . "Cidade_Corr = '".$cidade."',"
        . "Uf_Corr = '".$uf."',"
        . "Cep_Corr = '".$cep."',"
        . "Telefone = '".$telefone."'"
        . "WHERE Inscricao_Imob = '".$inscricao. "'";
//  execução com comando sql    
        $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
            die('<script>window.alert("Erro ao Alterar  !!!");location.href = "../../../cadastroEnderecoCorrespondencia.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
        } else {
//          salvo alteração no banco de dados
            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
        }
//        fecho conexao
        $pdo = null;
        ?>
        <!-- Dispara mensagem de sucesso -->
        <script>
            window.alert("<?php echo "Endereço Correspondência Alterado com Sucesso !!!"; ?> ");
            location.href = "../../../cadastroEnderecoCorrespondencia.php";
        </script>
        <?php
//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../cadastroEnderecoCorrespondencia.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>