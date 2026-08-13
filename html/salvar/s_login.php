<?php
session_start();
require_once "../conexao.php";


$email = $_POST['email'];
$senha = $_POST['senha'];


$sql = "SELECT * FROM usuario WHERE usuario_email = ? AND usuario_senha = ?";
$comando = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($comando, "ss", $email, $senha);
mysqli_stmt_execute($comando);

$resultados = mysqli_stmt_get_result($comando);
$quantidade = mysqli_num_rows($resultados);



if ($quantidade == 0) {
    header("Location: ../index.php?msg=erro");
} else {
    $usuario = mysqli_fetch_assoc($resultados);
    $id = $usuario['usuario_id'];
    $_SESSION['id'] = $id;


    //consulta aos dados da pessoa
    if ($tipo == '1') {
        $sql = "SELECT * FROM usuario WHERE usuario_id = ?";
        $comando = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($comando, "i", $id);
        mysqli_stmt_execute($comando);

        $resultados = mysqli_stmt_get_result($comando);
        $set = mysqli_fetch_assoc($resultados);

        $_SESSION['usuario_id'] = $set['usuario_id'];
        $_SESSION['nome'] = $set['usuario_nome'];
        $_SESSION['usuario_idade'] = $set['usuario_idade'];
        $_SESSION['usuario_email'] = $set['usuario_email'];
        $_SESSION['usuario_senha'] = $set['usuario_senha'];
        $_SESSION['usuario_cpf'] = $set['usuario_cpf'];
        $_SESSION['usuario_img'] = $set['usuario_img'];
        $_SESSION['usuario_sexo'] = $set['usuario_sexo'];

        if(!isset($_SESSION['id'])|| $_SESSION['tipo'] != '0'){
            header("Location: ../index.php"); 
        }

    } 

}
?>