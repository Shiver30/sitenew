<?php
session_start();

require_once "../conexao.php";
require_once "../funcoes/funcoes.php";

if (isset($_GET['logout'])) {

    logout();

    header("Location: ../index.php");
    exit;
}

verificarLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home WorkMach</title>
    
</head>
<body>

    <section class="usuario-area">

        <?php if (isset($_SESSION['usuario'])): ?>

            <div class="usuario-logado">
                <strong>Olá,<?= htmlspecialchars($_SESSION['usuario']) ?>!</strong>
                <p>Você está logado no sistema.</p>
                <a href="../index.php?logout=1" class="btn-sair">Sair</a>
            </div>

<?php

// Substitua 'id' pelo nome correto do índice da sessão do seu usuário (ex: 'usuario_id')
if (isset($_SESSION['usuarios_id'])) {
    $id_usuario = $_SESSION['usuarios_id'];

    // 1. Consulta o banco buscando o caminho da foto
    $sql = "SELECT usuario_img FROM usuarios WHERE usuario_img = $id_usuario";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        $caminho_banco = $usuario['usuarios_foto']; // Ex: "imagens/usuarios/foto.jpg"

        // 2. O IF verifica se o campo NÃO está vazio
        if (!empty($caminho_banco)) {
            // Se tem caminho no banco, mostra a foto do usuário
            echo "<img src='{$caminho_banco}' alt='Foto do usuário' width='100'>";
        } else {
            // Se o campo estiver vazio, mostra a foto padrão
            echo "<img src='../caminho/das/fotos/padrao.png' alt='Foto padrão' width='100'>";
        }
    } else {
        // Se não encontrar o registro do usuário
        echo "<img src='../caminho/das/fotos/padrao.png' alt='Foto padrão' width='100'>";
    }
} else {
    // Se o usuário não estiver logado
    echo "<img src='../caminho/das/fotos/padrao.png' alt='Foto padrão' width='100'>";
}
?>
    <?php endif;?>
    </section>


    <h1>Home</h1>
    <a href="pesquisa.php">Pesquisa de usuarios</a></A> <br>
    <a href="../cadastro/cadastro_servico.php">Cadastro de serviços</a> <br>
    <a href="../logout.php">Deslogar</a>

    

</body>
</html>