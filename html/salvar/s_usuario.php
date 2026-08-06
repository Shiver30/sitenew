<?php

require_once "../Site-Trabalho-3-ano/funcoes/funcoes.php";

// INICIO
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

//DADOS PE$SSOAIS
$data = $_POST['data_nascimento'];
$cpf = $_POST['cpf'];
$sexo = $_POST['sexo'];
$foto = $_POST['foto'];

//ENDEREÇO
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];



$cadastro = cadastrarUsuario($conexao)

?>