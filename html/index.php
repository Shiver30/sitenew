<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div style="
    padding: 15px;
    background-color: #f2f2f2;
    border-bottom: 1px solid #ccc;
">

        <?php if (isset($_SESSION['usuario'])): ?>

            <strong>Olá,<?= htmlspecialchars($_SESSION['usuario']) ?>!</strong>
            <span>Você está logado.</span>
            <a href="logout.php" style="margin-left: 20px;">Sair</a>

        <?php else: ?>

            <strong>Olá, visitante!</strong>
            <span>Você não está logado.</span>

            <a href="cadastro/login.php" style="margin-left: 20px;">Entrar</a>
            <a href="cadastro/cadastro_usuario.php" style="margin-left: 10px;">Criar conta</a>

        <?php endif; ?>

    </div>


    <a href="cadastro/cadastro_usuario.php">Página Cadastro</a> <br>
    <a href="cadastro/cadastro_servico.php">Página Endereço</a> <br>
    <a href="cadastro/login.php">Página de Login</a> <br>


</body>

</html>