<?php
session_start();
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";
verificarLogin(); // Garante que ninguém acesse sem estar logado

$meu_id = $_SESSION['usuarios_id'];

// Verifica se o ID da conversa foi passado na URL
if (!isset($_GET['id_conversa']) || empty($_GET['id_conversa'])) {
    header("Location: lista_chats.php"); // Se não tem ID, manda de volta pra lista
    exit;
}

$id_conversa = (int)$_GET['id_conversa'];

// LÓGICA DE ENVIAR MENSAGEM
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $texto_mensagem = trim($_POST['mensagem_texto']);
    
    if (!empty($texto_mensagem)) {
        enviarMensagem($conexao, $id_conversa, $meu_id, $texto_mensagem);
        
        // Redireciona para a mesma página para evitar envio duplicado ao atualizar a tela (F5)
        header("Location: chat.php?id_conversa=" . $id_conversa);
        exit;
    }
}

// LÓGICA DE LISTAR MENSAGENS
$mensagens = listarMensagens($conexao, $id_conversa);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - WorkMatch</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; color: #333; height: 100vh; display: flex; flex-direction: column; }
        
        header { background-color: #222; color: white; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 20px; font-weight: bold; }
        header a { color: white; text-decoration: none; padding: 8px 12px; border-radius: 5px; font-size: 14px; background-color: #444; }
        header a:hover { background-color: #555; }

        main { flex: 1; display: flex; justify-content: center; padding: 20px; overflow: hidden; }
        
        /* JANELA DO CHAT */
        .chat-container { 
            width: 100%; 
            max-width: 800px; 
            background-color: white; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            display: flex; 
            flex-direction: column; 
            overflow: hidden;
        }

        /* ÁREA DAS MENSAGENS (Onde rola a tela) */
        .area-mensagens {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background-color: #e9ecef;
        }

        /* BALÕES DE MENSAGEM */
        .balao {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 15px;
            font-size: 15px;
            line-height: 1.4;
            position: relative;
        }

        .balao .hora {
            display: block;
            font-size: 10px;
            color: rgba(0,0,0,0.5);
            margin-top: 5px;
            text-align: right;
        }

        /* Mensagem enviada pelo usuário logado (Direita) */
        .minha-mensagem {
            align-self: flex-end;
            background-color: #dcf8c6; /* Cor verde estilo WhatsApp */
            border-bottom-right-radius: 2px;
        }

        /* Mensagem recebida da outra pessoa (Esquerda) */
        .outra-mensagem {
            align-self: flex-start;
            background-color: #ffffff;
            border-bottom-left-radius: 2px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        /* FORMULÁRIO DE ENVIO */
        .area-envio {
            padding: 15px;
            background-color: white;
            border-top: 1px solid #ddd;
            display: flex;
            gap: 10px;
        }

        .area-envio input[type="text"] {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 25px;
            font-size: 15px;
            outline: none;
        }
        
        .area-envio input[type="text"]:focus {
            border-color: #007bff;
        }

        .btn-enviar {
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 0 20px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-enviar:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <header>
        <div class="logo">WorkMatch - Chat</div>
        <nav><a href="lista_chats.php">Voltar para Conversas</a></nav>
    </header>

    <main>
        <div class="chat-container">
            
            <!-- EXIBIÇÃO DAS MENSAGENS -->
            <div class="area-mensagens" id="areaMensagens">
                
                <?php if (count($mensagens) > 0): ?>
                    <?php foreach ($mensagens as $msg): ?>
                        
                        <!-- Verifica se a mensagem é sua ou da outra pessoa -->
                        <?php $classe_balao = ($msg['mensagem_usuarios_id'] == $meu_id) ? 'minha-mensagem' : 'outra-mensagem'; ?>
                        
                        <div class="balao <?= $classe_balao ?>">
                            <?= htmlspecialchars($msg['mensagem_texto']) ?>
                            <!-- Formata a hora para mostrar no cantinho do balão -->
                            <span class="hora"><?= date('H:i', strtotime($msg['mensagem_hora'])) ?></span>
                        </div>
                        
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: #888; margin-top: 20px;">Nenhuma mensagem ainda. Envie um "Olá" para começar!</p>
                <?php endif; ?>

            </div>

            <!-- FORMULÁRIO DE DIGITAÇÃO -->
            <form class="area-envio" method="POST" action="chat.php?id_conversa=<?= $id_conversa ?>">
                <!-- autofocus faz o cursor já nascer piscando no campo de texto -->
                <input type="text" name="mensagem_texto" placeholder="Digite sua mensagem..." required autofocus autocomplete="off">
                <button type="submit" class="btn-enviar">Enviar</button>
            </form>

        </div>
    </main>

    <!-- Script simples para garantir que a barra de rolagem desça para a última mensagem -->
    <script>
        const areaMensagens = document.getElementById('areaMensagens');
        areaMensagens.scrollTop = areaMensagens.scrollHeight;
    </script>

</body>
</html>