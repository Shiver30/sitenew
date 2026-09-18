<?php
session_start();
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";
verificarLogin();

if (isset($_GET['id'])){
    $_SESSION['id_2'] = $_GET['id'];
}
$id = isset($_GET['id']) ? (int) $_GET['id'] : $_SESSION['usuarios_id'];

$dados = listarPerfil($conexao, $id);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php

    if (isset($dados) && !empty($dados)) {

        while ($d = $dados->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($d['usuarios_nome']) . "</td> <br>";
            echo "<td>" . htmlspecialchars($d['usuarios_idade']) . "</td> <br>";
            echo "<td>" . htmlspecialchars($d['usuarios_email']) . "</td> <br>";
            echo "<td>" . htmlspecialchars($d['usuario_img']) . "</td> <br>";        
            if ($d['usuarios_sexo'] == 'm') {
                echo "<td>" . htmlspecialchars("masculino") . "</td> <br>";
            } elseif ($d['usuarios_sexo'] == 'f') {
                echo "<td>" . htmlspecialchars("feminino") . "</td> <br>";
            } else {
                echo "<td>" . htmlspecialchars("Não informado") . "</td> <br>";
            }
            echo "</tr>";
        }




        $meu_id = $_SESSION['usuarios_id'];
        $id_conversa = encontrarOuCriarConversa($conexao, $meu_id, $id);

        if ($id_conversa !== false) {
            echo "<a href='../chat/chat_fim.php?id_conversa={$id_conversa}'>Conversar</a>";
        }

        echo "<br>";
        echo " <a href='home.php'>voltar</a> ";
    }
    ?>

<p>

      <!-- CONTEÚDO  -->
  <main class="avaliacao-container">
    <form action="../saves/save_avaliacao.php" method="POST" class="avaliacao-form">
      <h2 class="titulo-avaliacao">Avalie o usuario</h2>

      <label class="label-nota">Nota:</label>
      <div class="rating">
        <input type="radio" id="star5" name="nota" value="5">
        <label for="star5" title="5 estrelas">★</label>
        <input type="radio" id="star4" name="nota" value="4">
        <label for="star4" title="4 estrelas">★</label>
        <input type="radio" id="star3" name="nota" value="3">
        <label for="star3" title="3 estrelas">★</label>
        <input type="radio" id="star2" name="nota" value="2">
        <label for="star2" title="2 estrelas">★</label>
        <input type="radio" id="star1" name="nota" value="1">
        <label for="star1" title="1 estrela">★</label>
      </div>

      <label for="desc" class="label-desc">Comentário:</label> <br>
      <textarea id="desc" name="desc" class="input-desc" placeholder="Escreva aqui sua opinião..."></textarea> <br>


      <input type="hidden" name="user" value="<?php echo $nota; ?>">
      <input type="hidden" name="film" value="<?php echo $descrição; ?>">

      <button type="submit" class="btn-enviar">Enviar Avaliação</button> não esta funcionado
  </main>
    
</p>

<footer>
   <?php require_once "../include/navegacao.php"; ?>
</footer>

</body>

</html>