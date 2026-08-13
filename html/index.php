<?php
session_start();

$id = null; // 🔹 Evita erro de variável indefinida

if (!isset($_SESSION['id'])) {
    $nome = "Visitante";
} else {
    $nome = $_SESSION['nome'];
    $id = $_SESSION['id'];
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

    <div class="user-area">
        <?php
         if (!$id) {
            echo '<a href="forms/form_login.php" class="login-btn">Entrar</a>';
        } else {
            echo "<span class='user-name'>Olá, <strong>$nome</strong></span>
              <a href='saves/save_deslogado.php' class='logout-btn'>Sair</a>";
        }
        ?>
     </div>

    <a href="cadastro/cadastro_usuario.php">Página Cadastro</a> <br>
    <a href="cadastro/cadastro_servico.php">Página Endereço</a> <br>
    <a href="cadastro/login.php">Página de Login</a> <br>


</body>
</html>