<?php
session_start();
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";
verificarLogin();

$id = $_SESSION['usuarios_id'];

$dados = listarConversas($conexao, $id);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Conversas</title>
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
        }

        header {
            background-color: #222;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        header a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
        }

        header a:hover {
            background-color: #444;
        }

        main {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-bottom: 10px;
        }

        .descricao {
            color: #666;
            margin-bottom: 25px;
        }

        /* LISTA DE CHATS */
        .chat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            background-color: #fafafa;
        }

        .chat-info h3 {
            color: #333;
            margin-bottom: 5px;
        }

        /* BOTÃO ABRIR CHAT */
        .btn-chat {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-chat:hover {
            background-color: #0056b3;
        }

        /* SEM RESULTADOS */
        .sem-resultados {
            padding: 20px;
            background-color: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            border-radius: 8px;
            text-align: center;
        }

        footer {
            text-align: center;
            padding: 20px;
            color: #777;
        }

        @media (max-width: 600px) {
            header {
                padding: 15px 20px;
            }

            .logo {
                font-size: 20px;
            }

            main {
                margin: 20px auto;
            }

            .chat-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .btn-chat {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <main>
        <div class="container">
            <h1>Minhas Conversas</h1>
            <p class="descricao">Selecione um chat para continuar conversando.</p>

            <?php
            if (count($dados) > 0) {
                foreach ($dados as $chat) {
                    // Tratamento das variáveis antes de imprimir
                    $nome = htmlspecialchars($chat['usuarios_nome']);
                    $id = htmlspecialchars($chat['conversa_id']);

                    echo "<div class='chat-item'>
                        <div class='chat-info'>
                            <h3>{$nome}</h3>
                        </div>
                        <a href='chat_fim.php?id_conversa={$id}' class='btn-chat'>Abrir Conversa</a>

        <a href='../home/home.php'>Voltar</a>
      </div>";
                }
            } else {
                echo "<div class='sem-resultados'>
                        Você ainda não iniciou nenhuma conversa. Pesquise por serviços para começar a conversar!
                        <a href='../home/home.php'>Voltar</a>
                      </div>";
            }
            ?>
        </div>
    </main>
    
    <footer>
        <?php require_once "../include/navegacao.php"; ?>
    </footer>

    <footer>
        <p>&copy; 2026 - WorkMatch</p>
    </footer>

</body>

</html>