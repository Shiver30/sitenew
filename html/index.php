<?php

session_start();

require_once "conexao.php";
require_once "funcoes/funcoes.php";

if (isset($_GET['logout'])) {

    logout();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Página Inicial</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        /* =========================
           CABEÇALHO
        ========================= */

        header {
            background-color: #222;
            color: white;
            padding: 15px 40px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: #444;
        }

        /* ÁREA DO USUÁRIO */

        .usuario-area {
            background-color: white;
            padding: 25px 40px;
            border-bottom: 1px solid #ddd;
        }

        .usuario-logado {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 8px;
        }

        .usuario-visitante {
            color: #856404;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 15px;
            border-radius: 8px;
        }

        .usuario-area a {
            display: inline-block;
            margin-top: 10px;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .btn-sair {
            background-color: #dc3545;
            color: white;
        }

        .btn-sair:hover {
            background-color: #c82333;
        }

        .btn-login {
            background-color: #007bff;
            color: white;
        }

        .btn-login:hover {
            background-color: #0069d9;
        }

        .btn-cadastro {
            background-color: #28a745;
            color: white;
        }

        .btn-cadastro:hover {
            background-color: #218838;
        }

        /* CONTEÚDO */

        main {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .bem-vindo {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .bem-vindo h1 {
            margin-bottom: 15px;
        }

        .bem-vindo p {
            color: #666;
            line-height: 1.6;
        }

        /* CARDS */

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .card p {
            color: #666;
            line-height: 1.5;
        }

        /* RODAPÉ */

        footer {
            margin-top: 50px;
            background-color: #222;
            color: white;
            text-align: center;
            padding: 20px;
        }
    </style>

</head>

<body>

    <!-- CABEÇALHO -->

    <header>

        <div class="logo">WorkMatch</div>
        <nav>
            <a href="index.php">Início</a>
            <?php if (isset($_SESSION['usuario'])): ?>
                <a href="#">Meu Perfil</a>
            <?php else: ?>
                <a href="cadastro/login.php">Login</a>
            <?php endif; ?>
        </nav>

    </header>

    <!-- ÁREA DE LOGIN -->

    <section class="usuario-area">

        <?php if (isset($_SESSION['usuario'])): ?>

            <div class="usuario-logado">
                <strong>Olá,<?= htmlspecialchars($_SESSION['usuario']) ?>!</strong>
                <p>Você está logado no sistema.</p>
                <a href="index.php?logout=1" class="btn-sair">Sair</a>
            </div>

        <?php else: ?>

            <div class="usuario-visitante">
                <strong>Olá, visitante!</strong>
                <p>Você está navegando como visitante.</p>
                <a href="cadastro/login.php" class="btn-login">Entrar</a>
                <a href="cadastro/cadastro_usuario.php" class="btn-cadastro">Criar conta</a>
            </div>

        <?php endif; ?>

    </section>

    <!-- CONTEÚDO PRINCIPAL -->

    <main>

        <section class="bem-vindo">

            <?php if (isset($_SESSION['usuario'])): ?>
                <h1>Seja bem-vindo,<?= htmlspecialchars($_SESSION['usuario']) ?>!</h1>
                <p>É bom ter você de volta.Você está conectado ao sistema.</p>
            <?php else: ?>
                <h1>Bem-vindo ao nosso site!</h1>
                <p>Você está acessando como visitante.Faça login ou crie uma conta para acessartodos os recursos disponíveis.</p>
            <?php endif; ?>

        </section>

         <!-- CARDS -->

        <section class="cards">

            <div class="card">
                <h3>👤 Usuários</h3>
                <p>Área destinada ao gerenciamento dos usuários cadastrados.</p>
            </div>

            <div class="card">
                <h3>📋 Cadastro</h3>
                <p>Crie sua conta para ter acesso aos recursos do sistema.</p>
            </div>

            <div class="card">
                <h3>🔐 Segurança</h3>
                <p>Faça login para acessar recursos exclusivos.</p>
            </div>

            <div class="card">
                <h3>🏠 Início</h3>
                <p>Esta é a página inicial do sistema.
                </p>
            </div>

        </section>

    </main>

     <!-- RODAPÉ -->

    <footer>

        <p>&copy; <?= date('Y') ?> - WorkMatch</p>

    </footer>


</body>

</html>