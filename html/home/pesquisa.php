<?php
session_start();
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";

$resultado ="SN";

if (isser($_POST['enviar'])){

    $termo = $_POST['pesquisa']?? = '';

    if ($termo != ''){
        $resultado = pesquisar($conaxao, $termo);

    }else{
        echo "Você não escreveu nada";
    }

    $resultado = pesquisar($conexao, )
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

<h1>Pesquisar usuario por nome</h1>
<form action="" method = "POST">

<input type="text" name = "pesquisa">

<button type = "submit" name = "enviar">enviar</button>

</form>


<?php

if ($resultado != "termo"){

    while()
}
?>


    
</body>
</html>