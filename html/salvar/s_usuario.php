<?php
require_once "../sitenew/html/conexao.php";
require_once "../sitenew/html/salvar/funcoes/funcoes.php";

// INICIO
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

//DADOS PE$SSOAIS
$idade = $_POST['dataNascimento'];
$cpf = $_POST['cpf'];
$sexo = $_POST['sexo'];
$foto = $_POST['foto'];

//ENDEREÇO
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];



$cadastro = cadastrarUsuario($conexao)

?>