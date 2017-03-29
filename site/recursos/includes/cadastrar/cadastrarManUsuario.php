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
//    aplica filtro na string enviada (LetraMaiuscula)

    if (isset($_POST['txt_informar_gratuidades]'])) {
        $man_informar_gratuidades = 'S';
    } else {
        $man_informar_gratuidades = 'N';
    }

    if ($_POST['txt_nivel_permissao'] === 'A') {
        $man_nivel = 'A';
    } else {
        $man_nivel = 'O';
    }

    $man_login_letra_maiuscula = letraMaiuscula($_POST['txt_login']);
    $man_matricula_letra_maiuscula = letraMaiuscula($_POST['txt_matricula']);
    $man_nome_completo_letra_maiuscula = letraMaiuscula($_POST['txt_nome_completo']);
    $man_senha_novo_login_letra_maiuscula = letraMaiuscula($_POST['txt_senha_novo_login']);
    $man_confirma_senha_novo_login_letra_maiuscula = letraMaiuscula($_POST['txt_confirma_senha_novo_login']);


// variaves serão preenchidas por valores do formulario
// valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($man_login_letra_maiuscula) > 1) && (strlen($man_login_letra_maiuscula) < 31)) {
        $man_login = $man_login_letra_maiuscula;
    } else {
        $array_erros['txt_login'] = 'POR FAVOR ENTRE COM UM LOGIN VÁLIDO \n';
    }

    if ((strlen($man_matricula_letra_maiuscula) > 1) && (strlen($man_matricula_letra_maiuscula) < 6)) {
        $man_matricula = $man_matricula_letra_maiuscula;
    } else {
        $array_erros['txt_matricula'] = 'POR FAVOR ENTRE COM A MATRÍCULA VÁLIDA \n';
    }

    if ((strlen($man_nome_completo_letra_maiuscula) > 2) && (strlen($man_nome_completo_letra_maiuscula) < 41)) {
        $man_nome_completo = $man_nome_completo_letra_maiuscula;
    } else {
        $array_erros['txt_nome_completo'] = 'POR FAVOR ENTRE COM O NOME VÁLIDO \n';
    }

    if (strlen($man_senha_novo_login_letra_maiuscula) > 2) {
        $man_senha = $man_senha_novo_login_letra_maiuscula;
    } else {
        $array_erros['txt_senha_novo_login'] = 'POR FAVOR ENTRE COM A SENHA VÁLIDA \n';
    }

    if (strlen($man_confirma_senha_novo_login_letra_maiuscula) > 2) {
        $man_confirma_senha = $man_confirma_senha_novo_login_letra_maiuscula;
    } else {
        $array_erros['txt_confirma_senha_novo_login'] = 'POR FAVOR ENTRE COM A CONFIRMAÇÃO SENHA VÁLIDA \n';
    }

    if ($man_senha !== $man_confirma_senha) {
        $array_erros['txt_Senhas_invalidas'] = 'SENHAS NÃO CONFEREM \n';
    }


// verifico se tem erro na validação
    if (empty($array_erros)) {

//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';


//      Inicio a transação com o banco        
        $pdo->beginTransaction();

//      Comando sql a ser executado  

        $executa = $pdo->query("INSERT INTO usuario " .
                " (usuario, Matricula, Nome_Completo, Nivel_Usuario, Informar_Gratuidade_TJ) " .
                " VALUES ('$man_login', '$man_matricula', '$man_nome_completo', '$man_nivel', '$man_informar_gratuidades')");



//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
            die('<script>window.alert("Erro ao Cadastrar  !!!");location.href = "../../../Man_Usuario.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
        } else {
//          salvo alteração no banco de dados
            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */

//   criar usuário no banco de dados (Usuario sql)
            $sql_1 = "exec sp_addlogin '$man_login', '$man_senha', 'Japeri'";
            $sql_2 = "exec sp_adduser '$man_login'";
            $sql_3 = "exec sp_changegroup 'db_owner','$man_login' ";

            $stmt1 = $pdo->prepare($sql_1);
            $stmt1->execute();
            $stmt2 = $pdo->prepare($sql_1);
            $stmt2->execute();
            $stmt3 = $pdo->prepare($sql_1);
            $stmt3->execute();
        }


//        fecho conexao
        $pdo = null;
        ?>
        <!-- Dispara mensagem de sucesso -->
        <script>
            window.alert("<?php echo "COLABORADOR CADASTRADO COM SUCESSO !!!"; ?> ");
            location.href = "../../../Man_Usuario.php";
        </script>

        <?php
//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
            location.href = "../../../Man_Usuario.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>