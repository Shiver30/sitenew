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

if (isset($_POST['enviar'])){
        if (!isset($_POST['notas'])) {
            echo "<script>alert('Por favor, selecione uma nota antes de enviar a avaliação.');</script>";
        } else {
            $nota = $_POST['notas'];
            $comen = $_POST['desc'] ?? '';

            $avaliacao = avaliacao($conexao, $nota, $comen);
        }

    $nota = $_POST['notas'];
    $comen = $_POST['desc'] ?? '';

    $avaliacao = avaliacao( $conexao, $nota, $comen );
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

<?php

if ( $_SESSION['usuarios_id'] != $id ) {

  echo "<main class='avaliacao-container'>";
    echo "<form action='' method='POST' class='avaliacao-form'>";
      echo "<h2 class='avaliacao-title'>Avalie o usuario</h2>";

      echo "<label class='avaliacao-label'>Nota:</label>";
      echo "<div class='rating'>";
        echo "<input type='radio' id='star5' name='notas' value='5'>";
        echo "<label for='star5' title='5 estrelas'>★</label>";
        echo "<input type='radio' id='star4' name='notas' value='4'>";
        echo "<label for='star4' title='4 estrelas'>★</label>";
        echo "<input type='radio' id='star3' name='notas' value='3'>";
        echo "<label for='star3' title='3 estrelas'>★</label>";
        echo "<input type='radio' id='star2' name='notas' value='2'>";
        echo "<label for='star2' title='2 estrelas'>★</label>";
        echo "<input type='radio' id='star1' name='notas' value='1'>";
        echo "<label for='star1' title='1 estrela'>★</label>";
      echo "</div>";

      echo "<label for='desc' class='avaliacao-label' name='comentario'>Comentário:</label> <br>";
      echo "<textarea id='desc' name='desc' class='input-desc' placeholder='Escreva aqui sua opinião...'></textarea> <br>";
        echo "<button type='submit' name='enviar' >Enviar Avaliação</button> ";
    echo "</form>";

  echo "</main>"; 

}
?>


Avaliações recebidas:
<?php
$avaliacoes = listarAvaliacao($conexao, $id);
if ($avaliacoes && $avaliacoes->num_rows > 0) {
    while ($avaliacao = $avaliacoes->fetch_assoc()) {
        echo "<div class='avaliacao'>";
        echo "<p><strong>Nota:</strong> " . htmlspecialchars($avaliacao['nota']) . "</p>";
        echo "<p><strong>Comentário:</strong> " . htmlspecialchars($avaliacao['comentario']) . "</p>";
        echo "</div>";
    }
} 
?>



<footer>
   <?php require_once "../include/navegacao.php"; ?>
</footer>

</body>

</html>