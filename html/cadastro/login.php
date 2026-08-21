<?php
session_start();

require_once "../conexao.php";
require_once "../funcoes/funcoes.php";

if (isset($_POST['enviar'])) {

    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $sucesso = login($conexao, $email, $senha);

    if ($sucesso) {
        header("Location: ../index.php");
        exit;
    } else {
        $mensagem = "Erro no login.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <style>
        /* =========================
           CONFIGURAÇÕES GERAIS
        ========================= */

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

        /* =========================
           CONTEÚDO
        ========================= */

        main {
            max-width: 550px;
            margin: 60px auto;
            padding: 0 20px;
        }

        /* =========================
           FORMULÁRIO
        ========================= */

        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }

        .descricao-formulario {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }


        /* =========================
           CAMPOS
        ========================= */

        .campo {
            margin-bottom: 20px;
        }

        .campo label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .campo input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 15px;
            color: #333;
            background-color: white;
        }

        .campo input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow:
                0 0 0 2px rgba(0, 123, 255, 0.1);
        }

        /* =========================
           BOTÕES
        ========================= */

        .botoes {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
        }

        .btn-entrar {
            background-color: #28a745;
            color: white;
            flex: 1;
        }

        .btn-entrar:hover {
            background-color: #218838;
        }

        .btn-voltar {
            background-color: #6c757d;
            color: white;
            flex: 1;
        }

        .btn-voltar:hover {
            background-color: #5a6268;
        }


        /* =========================
           MENSAGENS
        ========================= */

        .mensagem {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .erro {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }


        /* =========================
           RODAPÉ
        ========================= */

        footer {
            margin-top: 50px;
            background-color: #222;
            color: white;
            text-align: center;
            padding: 20px;
        }


        /* =========================
           RESPONSIVIDADE
        ========================= */

        @media (max-width: 600px) {

            header {
                padding: 15px 20px;
            }

            .logo {
                font-size: 20px;
            }

            main {
                margin: 25px auto;
            }

            .form-container {
                padding: 25px;
            }

            .botoes {
                flex-direction: column;
            }
        }
    </style>

</head>

<body>

    <!-- CABEÇALHO -->

    <header>

        <div class="logo">Sistema de Serviços</div>
        <nav>
            <a href="../index.php">Início</a>
        </nav>

    </header>

    <!-- CONTEÚDO -->

    <main>

        <div class="form-container">
            <h1>Login</h1>
            <p class="descricao-formulario">Entre com seus dados para acessar sua conta.</p>
            <?php
            if (isset($mensagem)) {
                echo "<p class='mensagem erro'>$mensagem</p>";
            }
            ?>

            <form method="POST">

                <!-- EMAIL -->
                <div class="campo">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu email" required>
                </div>


                <!-- SENHA -->
                <div class="campo">
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                </div>


                <!-- BOTÕES -->
                <div class="botoes">
                    <a href="../index.php" class="btn btn-voltar">Voltar</a>
                    <button type="submit" name="enviar" class="btn btn-entrar">
                        Entrar
                    </button>
                </div>
            </form>
        </div>

    </main>


    <!-- RODAPÉ -->

    <footer>

        <p>
            &copy; 2026 - Sistema de Serviços
        </p>

    </footer>

</body>

</html>