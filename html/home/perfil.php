<?php
session_start();
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";
verificarLogin();


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

</body>

</html>