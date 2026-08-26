<?php
session_start();
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";

$resultado = null;

if (isset($_POST['enviar'])){

    $termo = $_POST['pesquisa']?? '';

    if ($termo != ''){
        $resultado = pesquisarNome($conexao, $termo);

    }else{
        echo "Você não escreveu nada";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Usuario</title>
</head>
<body>

<h1>Pesquisar usuario por nome</h1>
<form action="" method = "POST">

<input type="text" name = "pesquisa">

<button type = "submit" name = "enviar">enviar</button>

</form>

<a href="home.php"> <button>Voltar</button></a>


<?php

if ($resultado !== null && $resultado !== false) {

    if (mysqli_num_rows($resultado) > 0) {

        echo "<table border='1'>";
        echo "<tr><th>Nome</th></tr>";

        while($nome = mysqli_fetch_assoc($resultado)){
            $nome_fim = htmlspecialchars($nome['usuarios_nome']);
            echo "<tr>";
            echo "<td>{$nome_fim}</td>";
            echo "</tr>";
        }
        echo "</table>";

    } else {

        echo "<p>Nenhum usuário encontrado.</p>";
    }
}
?>


    
</body>
</html>