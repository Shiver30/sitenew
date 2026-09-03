<?php
session_start();
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";
verificarLogin();

$id = $_SESSION['usuarios_id'];

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

if (isset($dados) && !empty($dados)){

    while($d = $dados ->fetch_assoc()){    
        echo "<td>" . htmlspecialchars($d['usuarios_nome']) . "</td>";
        echo "<td>" . htmlspecialchars($d['usuarios_idade']). "</td>";
        echo "<td>" . htmlspecialchars($d['usuarios_sexo']). "</td>";
        echo "<td>" . htmlspecialchars($d['usuarios_email']). "</td>";   
    }
}
?>

</body>
</html>