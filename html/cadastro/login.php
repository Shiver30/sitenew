<?php
session_start();

require_once "funcoes.php";

    if (isset($_POST['enviar'])) {

        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $sucesso = login($conexao, $email, $senha);

        if ($sucesso) {
            header("Location: ../index.php");
            exit;
        } else {
            echo "Erro no login.";
        }
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="salvar_loguin.php">
        <h1>Loguin</h1>

        <p>Email:</p> <br>
        <input type="text" name = "email">

        <p>senha:</p>
        <input type="password" name = "senha" >

        <button type = "submit">Enviar</button>
    </form>
</body>
</html>