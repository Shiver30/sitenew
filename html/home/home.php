<?php

session_start();

require_once "../conexao.php";
require_once "../funcoes/funcoes.php";

// ===============================
// LOGOUT
// ===============================

if (isset($_GET['logout'])) {

    logout();

    header("Location: ../index.php");
    exit;
}

// ===============================
// VERIFICA SE O USUÁRIO ESTÁ LOGADO
// ===============================

verificarLogin();

// ===============================
// DADOS DO USUÁRIO
// ===============================

$nome_usuario = $_SESSION['usuario_nome'] ;
$id_usuario = $_SESSION['usuarios_id'] ;


// ===============================
// FOTO DO USUÁRIO
// ===============================

$caminho_foto = "../imagens/padrao.png";

if ($id_usuario !== null) {

    $id_usuario = (int) $id_usuario;

    $sql = "SELECT usuario_img FROM usuarios WHERE usuarios_id = ?";

    $stmt = $conexao->prepare($sql);

    if ($stmt) {

        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {

            $usuario = $resultado->fetch_assoc();

            if (!empty($usuario['usuario_img'])) {

                $caminho_foto = $usuario['usuario_img'];
            }
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>WorkMatch</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            min-height: 100vh;
        }

        header {
            background-color: #222;
            color: white;
            padding: 20px 40px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .btn-sair {
            background-color: #dc3545;
            color: white;

            padding: 10px 18px;

            border-radius: 5px;

            text-decoration: none;

            font-weight: bold;
        }

        .btn-sair:hover {
            background-color: #c82333;
        }

        main {
            max-width: 900px;

            margin: 40px auto;

            padding: 20px;
        }

        .usuario-area {
            background-color: white;

            padding: 30px;

            border-radius: 10px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);

            display: flex;

            align-items: center;

            gap: 25px;

            margin-bottom: 30px;
        }

        .foto-usuario {
            width: 100px;

            height: 100px;

            object-fit: cover;

            border-radius: 50%;

            border: 3px solid #007bff;
        }

        .usuario-info h1 {
            margin-bottom: 10px;
        }

        .usuario-info p {
            color: #666;
        }

        .menu {
            background-color: white;

            padding: 30px;

            border-radius: 10px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .menu h2 {
            margin-bottom: 20px;
        }

        .menu a {
            display: block;

            background-color: #007bff;

            color: white;

            padding: 14px;

            margin-bottom: 10px;

            border-radius: 5px;

            text-decoration: none;

            text-align: center;

            font-weight: bold;
        }

        .menu a:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;

            padding: 20px;

            color: #777;
        }

        @media (max-width: 600px) {

            header {
                padding: 15px 20px;
            }

            .logo {
                font-size: 20px;
            }

            main {
                margin: 20px auto;
            }

            .usuario-area {
                flex-direction: column;

                text-align: center;
            }

        }
    </style>

</head>

<body>

    <header>
        <div class="logo">WorkMatch</div>
        <a href="../index.php?logout=1" class="btn-sair">Sair</a>
    </header>


    <main>


        <!-- ===============================
         USUÁRIO LOGADO
    ================================ -->
        <section class="usuario-area">
            <img src="<?= htmlspecialchars($caminho_foto) ?>" alt="Foto do usuário" class="foto-usuario">
            <div class="usuario-info">
                <h1>Olá, <?= htmlspecialchars($nome_usuario) ?>!</h1>
                <p>Você está logado no sistema.</p>
            </div>

        </section>


        <!-- ===============================
         MENU
    ================================ -->
        <section class="menu">

            <h2>Menu</h2>
            <a href="pesquisa.php">Pesquisa de usuários</a>
            <a href="../cadastro/cadastro_servico.php">Cadastro de serviços</a>
            <a href="pesquisa_servico.php">Pesquisar Serviços</a>
            <a href="../chat/lista_conversas.php">Lista de conversas</a>

        </section>
        
        <h2>Menu</h2>
        <a href="pesquisa.php">Pesquisa de usuários</a>
        <a href="../cadastro/cadastro_servico.php">Cadastro de serviços</a>
        <a href="pesquisa_servico.php">Pesquisar Serviços</a>
        <a href="../chat/lista_conversas.php">Lista de conversas</a>
        <a href="pefil.php"></a>

    </section>


    </main>


    <footer>
        <?php require_once "include/rodape.php"; ?>
    </footer>


</body>

</html>