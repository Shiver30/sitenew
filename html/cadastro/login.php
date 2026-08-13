<?php
session_start();
require_once "../funcoes/funcoes.php";

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
    <form method= "POST">
        <h1>Loguin</h1>

        <p>Email:</p> <br>
        <input type="text" name = "email" required >

        <p>senha:</p>
        <input type="password" name = "senha" required >

        <button type = "submit" name= "enviar">Enviar</button>
    </form>
</body>
</html>