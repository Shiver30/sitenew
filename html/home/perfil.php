<?php
session_start();
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";
verificarLogin();

if (isset($_GET['id'])) {
    $_SESSION['id_2'] = $_GET['id'];
}
$id2 = isset($_GET['id']) ? (int) $_GET['id'] : $_SESSION['usuarios_id'];

$id1 = $_SESSION['usuarios_id'];

$dados = listarPerfil($conexao, $id2);


if (isset($_POST['enviar'])) {

    if (!isset($_POST['notas'])) {

        echo "<script>
            alert('Por favor, selecione uma nota antes de enviar a avaliação.');
        </script>";
    } else {

        $nota = (int) $_POST['notas'];
        $comen = trim($_POST['desc'] ?? '');

        $avaliacao = avaliacao($conexao, $nota, $comen);
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkMatch - Perfil</title>
    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- CSS principal do WorkMatch -->
    <link rel="stylesheet" href="../css/css.css">

</head>


<body>

    <?php


    if (isset($dados) && !empty($dados)) {

        while ($d = $dados->fetch_assoc()) {

            echo "<div class='perfil-container'>";
            echo "<div class='perfil-cabecalho'>";
            echo "<img class='perfil-foto' src='". htmlspecialchars($d['usuario_img']). "' alt='Foto de perfil'>";
            echo "<h1>". htmlspecialchars($d['usuarios_nome']). "</h1>";
            echo "</div>";
            echo "<div class='perfil-dados'>";
            echo "<p><strong>Idade:</strong> ". htmlspecialchars($d['usuarios_idade']). "</p>";
            echo "<p><strong>E-mail:</strong> ". htmlspecialchars($d['usuarios_email']). "</p>";

            if ($d['usuarios_sexo'] == 'm') {
                $sexo = "Masculino";
            } elseif ($d['usuarios_sexo'] == 'f') {
                $sexo = "Feminino";
            } else {
                $sexo = "Não informado";
            }

            echo "<p><strong>Sexo:</strong> ". htmlspecialchars($sexo). "</p>";
            echo "</div>";
            echo "</div>";
        }

        $meu_id = $_SESSION['usuarios_id'];
        $id_conversa = encontrarOuCriarConversa($conexao, $meu_id, $id2);

        if ($id_conversa !== false) {
            echo "<div class='perfil-acoes'>";
            echo "<a class='btn-conversar' href='../chat/chat_fim.php?id_conversa=". (int) $id_conversa. "'>Conversar</a>";
            echo "<a class='btn-voltar-perfil' href='home.php'>Voltar</a>";
            echo "</div>";
        }
    }

    ?>

    <p>
        <?php

        $jaavaliou = jaAvaliou($conexao, $id1, $id2);

        if (!$jaavaliou && $id1 != $id2) {

            echo "<main class='avaliacao-container'>";
            echo "<form action='' method='POST' class='avaliacao-form'>";
            echo "<h2 class='avaliacao-title'>Avalie o usuario</h2>";
            echo "<label class='avaliacao-label'>Nota:</label>";
            echo "<div class='rating'>";
            echo "<input type='radio' id='star5' name='notas' value='5'>";
            echo "<label for='star5' title='5 estrelas'>★</label>";
            echo "<input type='radio' id='star4' name='notas' value='4'>";
            echo "<label for='star3' title='4 estrelas'>★</label>";
            echo "<input type='radio' id='star3' name='notas' value='3'>";
            echo "<label for='star3' title='3 estrelas'>★</label>";
            echo "<input type='radio' id='star2' name='notas' value='2'>";
            echo "<label for='star2' title='2 estrelas'>★</label>";
            echo "<input type='radio' id='star1' name='notas' value='1'>";
            echo "<label for='star1' title='1 estrelas'>★</label>";
            echo "</div>";
            echo "<label for='desc' class='avaliacao-label' name='comentario'>Comentário:</label> <br>";
            echo "<textarea id='desc' name='desc' class='input-desc' placeholder='Escreva aqui sua opinião...'></textarea> <br>";
            echo "<button type='submit' name='enviar' >Enviar Avaliação</button> ";
            echo "</form>";
            echo "</main>";
        } else {
            echo "";
        }


        ?>

    <div class="avaliacoes-lista">

        <h2>Opinião de outros usuários sobre esse usuário</h2>

        <?php
        $avaliacoes = listarAvaliacao($conexao, $id2);

        if (!empty($avaliacoes)) {
            foreach ($avaliacoes as $avaliacao) {

                $nota = (int) $avaliacao['avaliacao_nota'];
                $nota = max(0, min(5, $nota));

                echo "<div class='avaliacao'>";
                echo "<p><strong>Comentário:</strong><br>" . htmlspecialchars($avaliacao['avaliacao_descricao'] ?? 'Sem comentário') . "</p>";
                echo "<div class='nota-estrelas'>";
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $nota ? "★" : "<span style='color:#ccc'>★</span>";
                }

                echo "<span class='nota-texto'>($nota/5)</span>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='sem-avaliacoes'>
            Este usuário ainda não recebeu avaliações.
        </p>";
        }
        ?>
    </div>




    <footer>
        <?php require_once "../include/navegacao.php"; ?>
    </footer>

</body>

</html>