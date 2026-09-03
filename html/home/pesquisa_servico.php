<?php
session_start();
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";
verificarLogin();

$categoria = $_POST['categoria'] ?? '';
$servicos = [];
$termo = $_POST['nome'];

if (!empty($categoria)) {
    $servicos = buscarUsuarios($conexao, $categoria, $termo);
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar Serviços</title>
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

        header a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
        }

        header a:hover {
            background-color: #444;
        }

        main {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;

            box-shadow:
                0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-bottom: 10px;
        }

        .descricao {
            color: #666;
            margin-bottom: 25px;
        }

        /* FORMULÁRIO */

        .form-pesquisa {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        .form-pesquisa select {
            flex: 1;

            padding: 12px;

            border: 1px solid #ccc;

            border-radius: 5px;

            font-size: 15px;

            background-color: white;
        }

        .btn-pesquisar {
            padding: 12px 25px;

            border: none;

            border-radius: 5px;

            background-color: #007bff;

            color: white;

            font-weight: bold;

            cursor: pointer;
        }

        .btn-pesquisar:hover {
            background-color: #0056b3;
        }

        /* RESULTADOS */

        .resultado-titulo {
            margin-bottom: 20px;

            border-bottom: 1px solid #ddd;

            padding-bottom: 10px;
        }

        .servico {
            border: 1px solid #ddd;

            border-radius: 8px;

            padding: 20px;

            margin-bottom: 15px;

            background-color: #fafafa;
        }

        .servico h3 {
            color: #007bff;

            margin-bottom: 8px;
        }

        .categoria {
            display: inline-block;

            background-color: #e7f1ff;

            color: #0056b3;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 13px;

            margin-bottom: 12px;
        }

        .descricao-servico {
            color: #555;

            line-height: 1.5;
        }

        /* SEM RESULTADOS */

        .sem-resultados {
            padding: 20px;

            background-color: #fff3cd;

            border: 1px solid #ffeeba;

            color: #856404;

            border-radius: 8px;

            text-align: center;
        }

        footer {
            text-align: center;

            padding: 20px;

            color: #777;
        }

        /* RESPONSIVIDADE */

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

            .form-pesquisa {
                flex-direction: column;
            }

            .btn-pesquisar {
                width: 100%;
            }

        }
    </style>
</head>


<body>
    <header>

        <div class="logo">WorkMatch</div>
        <nav><a href="home.php">Voltar para Home</a></nav>

    </header>


    <main>
        <div class="container">
            <h1>Pesquisar Serviços</h1>
            <p class="descricao">Escolha uma categoria para encontrar serviços disponíveis.</p>

            <!-- FORMULÁRIO -->

            <form method="POST" class="form-pesquisa">


                Nome: <br>
                <input type="text" name = "nome">

                <select name="categoria" required>

                    <option value="">Selecione uma categoria</option>
                    <option value="Aulas Particulares" <?= $categoria === 'Aulas Particulares' ? 'selected' : '' ?>>Aulas Particulares</option>
                    <option value="Reformas e Reparos" <?= $categoria === 'Reformas e Reparos' ? 'selected' : '' ?>>Reformas e Reparos</option>
                    <option value="Cuidados Pessoais" <?= $categoria === 'Cuidados Pessoais' ? 'selected' : '' ?>>Cuidados Pessoais</option>
                    <option value="Eventos e Entretenimento" <?= $categoria === 'Eventos e Entretenimento' ? 'selected' : '' ?>>Eventos e Entretenimento</option>
                    <option value="Serviços Domésticos" <?= $categoria === 'Serviços Domésticos' ? 'selected' : '' ?>>Serviços Domésticos</option>
                    <option value="Tecnologia e Informática" <?= $categoria === 'Tecnologia e Informática' ? 'selected' : '' ?>>Tecnologia e Informática</option>
                    <option value="Saúde e Bem-estar" <?= $categoria === 'Saúde e Bem-estar' ? 'selected' : '' ?>>Saúde e Bem-estar</option>
                    <option value="Transporte e Mudanças" <?= $categoria === 'Transporte e Mudanças' ? 'selected' : '' ?>>Transporte e Mudanças</option>
                    <option value="Consultoria e Negócios" <?= $categoria === 'Consultoria e Negócios' ? 'selected' : '' ?>>Consultoria e Negócios</option>
                    <option value="Outros Serviços" <?= $categoria === 'Outros Serviços' ? 'selected' : '' ?>>Outros Serviços</option>

                </select>


                <button type="submit" class="btn-pesquisar">Pesquisar</button>

            </form>


            <!-- RESULTADOS -->

            <?php if (!empty($categoria)): ?>

                <h2 class="resultado-titulo">Serviços encontrados em: <?= htmlspecialchars($categoria) ?></h2>
                <?php listarServicos($servicos); ?>

            <?php endif; ?>


        </div>

    </main>


    <footer>
        <p>&copy; 2026 - WorkMatch</p>
    </footer>


</body>

</html>