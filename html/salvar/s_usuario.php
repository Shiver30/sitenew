<?php
require_once "../sitenew/html/conexao.php";
require_once "../sitenew/html/funcoes/funcoes.php";


// INICIO
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

//DADOS PESSOAIS
$idade = $_POST['dataNascimento'];
$cpf = $_POST['cpf'];
$sexo = $_POST['sexo'];
$foto = $_FILES['foto'];

//ENDEREÇO
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];


function uploadCapa ($foto){
    $diretorio = '';
    $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png'];
    if(!in_array($extensao, $permitidas)){ 
        return false;
    }
    if($foto['size']> 1024 * 1024 * 2){ // permite até 2MB
        return false;
    }
    $nomeArquivo = uniqid() . "_" . $foto['name'];
    $caminho = $diretorio . $nomeArquivo; // uploads/capas/13516516has5_arvore.png
    if (move_uploaded_file($foto['tmp_name'], $caminho)){
        return $caminho;
    }
    return false;
}




$cadastro = cadastrarUsuario($conexao, $nome, $email, $senha, $idade, $cpf, $sexo, $foto, $estado, $cidade);

?>