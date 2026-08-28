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
    min-height: 100vh;
    display: flex;
    flex-direction: column;
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


/* =========================
   ÁREA DO USUÁRIO
========================= */

.usuario-area {
    background-color: white;
    padding: 25px 40px;
    border-bottom: 1px solid #ddd;
}

.usuario-logado,
.usuario-visitante {
    max-width: 1100px;
    margin: 0 auto;
    padding: 15px;
    border-radius: 8px;
}

.usuario-logado {
    color: #155724;
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
}

.usuario-visitante {
    color: #856404;
    background-color: #fff3cd;
    border: 1px solid #ffeeba;
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


/* =========================
   CONTEÚDO
========================= */

main {
    width: 100%;
    max-width: 1100px;
    margin: auto;
    padding: 40px 20px;
}


/* =========================
   BEM-VINDO
========================= */

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


/* =========================
   CARDS
========================= */

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

.card a {
    color: #333;
    text-decoration: none;
}

.card a:hover {
    color: #007bff;
}


/* =========================
   RODAPÉ
========================= */

footer {
    margin-top: auto;
    background-color: #222;
    color: white;
    text-align: center;
    padding: 20px;
}


/* =========================
   RESPONSIVIDADE
========================= */

@media (max-width: 700px) {

    header {
        padding: 15px 20px;
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .logo {
        font-size: 20px;
    }

    nav {
        width: 100%;
        justify-content: center;
    }

    .usuario-area {
        padding: 20px;
    }

    .usuario-logado,
    .usuario-visitante {
        padding: 15px;
    }

    main {
        padding: 25px 15px;
    }

    .bem-vindo {
        padding: 25px 20px;
    }

    .bem-vindo h1 {
        font-size: 24px;
    }

    .cards {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    .card {
        padding: 20px;
    }

    .usuario-area a {
        margin-right: 5px;
    }
}


@media (max-width: 450px) {

    header {
        padding: 15px;
    }

    nav {
        flex-direction: column;
        gap: 5px;
        width: 100%;
    }

    nav a {
        width: 100%;
        text-align: center;
    }

    .usuario-area {
        padding: 15px;
    }

    .usuario-area a {
        display: block;
        width: 100%;
        text-align: center;
        margin-right: 0;
    }

    .bem-vindo {
        padding: 20px 15px;
    }

    .bem-vindo h1 {
        font-size: 21px;
    }

    .bem-vindo p {
        font-size: 14px;
    }

    .card {
        padding: 20px 15px;
    }
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
                <a href="login.php">Login</a>
            <?php endif; ?>
        </nav>

    </header>

    <!-- ÁREA DE LOGIN -->

    <section class="usuario-area">

        <?php if (isset($_SESSION['usuario'])): ?>

            <!-- <div class="usuario-logado">
                <strong>Olá,<?= htmlspecialchars($_SESSION['usuario']) ?>!</strong>
                <p>Você está logado no sistema.</p>
                <a href="index.php?logout=1" class="btn-sair">Sair</a>
            </div> -->

        <?php else: ?>

            <div class="usuario-visitante">
                <strong>Olá, visitante!</strong>
                <p>Você está navegando como visitante.</p>
                <a href="login.php" class="btn-login">Entrar</a>
                <a href="cadastro/cadastro_usuario.php" class="btn-cadastro">Criar conta</a>
            </div>

        <?php endif; ?>

    </section>

    <!-- CONTEÚDO PRINCIPAL -->

    <main>
<!-- 
        <section class="bem-vindo">

            <?php if (isset($_SESSION['usuario'])): ?>
                <h1>Seja bem-vindo,<?= htmlspecialchars($_SESSION['usuario']) ?>!</h1>
                <p>É bom ter você de volta.Você está conectado ao sistema.</p>
            <?php else: ?>
                <h1>Bem-vindo ao WorkMatch!</h1>
                <p>Você está acessando como visitante.Faça login ou crie uma conta para acessartodos os recursos disponíveis.</p>
            <?php endif; ?>

        </section> -->

         <!-- CARDS -->

        <section class="cards">

            <div class="card">
                <h3>👤 Usuários</h3>
                <p>Área destinada ao gerenciamento dos usuários cadastrados.</p>
            </div>

            <div class="card">
               <h3>📋 Cadastro de serviços</h3>
                <p>Adicione sua área de atuação.</p>
            </div>
            
            <div class="card">
                <h3>🔐 Segurança</h3>
                <p>Faça login para acessar recursos exclusivos.</p>
            </div>

            <div class="card">
                <h3>🏠 Início</h3>
                <p>Esta é a página inicial do sistema.</p>
            </div>

        </section>

    </main>

     <!-- RODAPÉ -->

    <footer>

        <p>&copy; <?= date('Y') ?> - WorkMatch</p>

    </footer>


</body>

</html>