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
    $codigo_Letra_Maiscula = letraMaiuscula($_POST['txt_excluir_codigo']);

// variaves serão preenchidas por valores do formulario
// // valido o tamanho do campo informado pelo usuário
// verifico se o tamanho do campo é correto

    if ((strlen($codigo_Letra_Maiscula) > 0 && strlen($codigo_Letra_Maiscula) < 11) || is_int($codigo_Letra_Maiscula) === TRUE) {
        $codigo = $codigo_Letra_Maiscula;
    } else {
        $array_erros['txt_excluir_codigo'] = 'POR FAVOR ENTRE COM UM CÓDIGO VÁLIDO \n';
    }

// verifico se tem erro na validação
    if (empty($array_erros)) {

//      Conexao com o banco de dados  
        include_once '../estrutura/conexao/conexao.php';

//      Inicio a transação com o banco        
        $pdo->beginTransaction();

//      Comando sql a ser executado 
        $sql = "DELETE  FROM Tipo_Isencao  WHERE codigo = '" . $codigo . "'";

//  execução com comando sql    
        $executa = $pdo->query($sql);

//      Verifico se comando foi realizado      
        if (!$executa) {
//          Caso tenha errro 
//          lanço erro na tela
            die('<script>window.alert("Erro ao TabelaIsencao  !!!");location.href = "../../../TabelaBairro.php";</script>'); /* É disparado em caso de erro na inserção de movimento */
        } else {
//          salvo alteração no banco de dados
            $pdo->commit(); /* Se não houve erro nas querys, confirma os dados no banco */
        }
//        fecho conexao
        $pdo = null;
        ?>
        <!-- Dispara mensagem de sucesso -->
        <script>
            window.alert("<?php echo "Isenção Excluida com Sucesso !!!"; ?> ");
            location.href = "../../../TabelaIsencao.php";
        </script>
        <?php
//  if (empty($array_erros)) {
    } else {
        $msg_erro = '';
        foreach ($array_erros as $msg) {
            $msg_erro = $msg_erro . $msg;
        }

        echo '<script>window.alert("' . $msg_erro . '");
               location.href = "../../../TabelaIsencao.php";
        </script>';
    }



// if($_SERVER['REQUEST_METHOD'] === 'POST'){ 
} else {
    die(header("Location: ../../../logout.php"));
}
?>