<?php
session_start();

require_once "../conexao.php";
require_once "../funcoes/funcoes.php";


if (isset($_POST['cadastro'])) {

    $id = $_SESSION['id'] ?? null;
    $nomeServico = $_POST['nome_servico'];
    $tipoServico = $_POST['tipoServico'];
    $descricaoServico = $_POST['descricao_servico'];

    $salvar = cadastroServico($conexao, $id, $nomeServico, $tipoServico, $descricaoServico);

        if (isset($salvar)) {
              header("Location: ../index.php");
        } else {
            echo "<script>alert('Erro ao cadastrar serviço.');</script>";
        }

    exit;
}


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Serviço</title>

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
        }

        /* =========================
           CABEÇALHO
        ========================= */

        header {
            background-color: #222;
            color: white;
            padding: 15px 40px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
        }

        nav a:hover {
            background-color: #444;
        }

        /* =========================
           CONTEÚDO
        ========================= */

        main {
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* =========================
           FORMULÁRIO
        ========================= */

        .form-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .campo {
            margin-bottom: 20px;
        }

        .campo label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .campo input,
        .campo select,
        .campo textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 15px;
            color: #333;
            background-color: white;
        }

        .campo input:focus,
        .campo select:focus,
        .campo textarea:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
        }

        .campo textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* =========================
           BOTÕES
        ========================= */

        .botoes {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 15px;
            cursor: pointer;
            text-align: center;
        }

        .btn-cadastrar {
            background-color: #28a745;
            color: white;
            flex: 1;
        }

        .btn-cadastrar:hover {
            background-color: #218838;
        }

        .btn-voltar {
            background-color: #6c757d;
            color: white;
            flex: 1;
        }

        .btn-voltar:hover {
            background-color: #5a6268;
        }

        /* =========================
           RODAPÉ
        ========================= */

        footer {
            margin-top: 50px;
            background-color: #222;
            color: white;
            text-align: center;
            padding: 20px;
        }

        /* =========================
           RESPONSIVIDADE
        ========================= */

        @media (max-width: 600px) {

            header {
                padding: 15px 20px;
            }

            main {
                margin: 25px auto;
            }

            .form-container {
                padding: 25px;
            }

            .botoes {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

    <!-- CABEÇALHO -->
    <header>
        <div class="logo">
            Cadastro de Serviço
        </div>

        <nav>
            <a href="../index.php">Início</a>
        </nav>
    </header>


    <!-- CONTEÚDO -->
    <main>

        <div class="form-container">

            <h1>Cadastro de Serviço</h1>

            <form action="" method="post">

                <!-- NOME DO SERVIÇO -->
                <div class="campo">
                    <label for="nome_servico">
                        Nome do serviço:
                    </label>

                    <input
                        type="text"
                        id="nome_servico"
                        name="nome_servico"
                        placeholder="Digite o nome do serviço"
                        required>
                </div>


                <!-- TIPO DO SERVIÇO -->
                <div class="campo">
                    <label for="tipoServico">
                        Classe do serviço:
                    </label>

                    <select name="tipoServico" id="tipoServico" required>

                        <option value="Aulas Particulares">
                            Aulas Particulares
                        </option>

                        <option value="Reformas e Reparos">
                            Reformas e Reparos
                        </option>

                        <option value="Cuidados Pessoais">
                            Cuidados Pessoais
                        </option>

                        <option value="Eventos e Entretenimento">
                            Eventos e Entretenimento
                        </option>

                        <option value="Serviços Domésticos">
                            Serviços Domésticos
                        </option>

                        <option value="Tecnologia e Informática">
                            Tecnologia e Informática
                        </option>

                        <option value="Saúde e Bem-estar">
                            Saúde e Bem-estar
                        </option>

                        <option value="Transporte e Mudanças">
                            Transporte e Mudanças
                        </option>

                        <option value="Consultoria e Negócios">
                            Consultoria e Negócios
                        </option>

                        <option value="Outros Serviços">
                            Outros Serviços
                        </option>

                    </select>
                </div>


                <!-- DESCRIÇÃO -->
                <div class="campo">
                    <label for="descricao_servico">
                        Descrição do serviço:
                    </label>

                    <textarea
                        id="descricao_servico"
                        name="descricao_servico"
                        placeholder="Digite a descrição do serviço"></textarea>
                </div>


                <!-- BOTÕES -->
                <div class="botoes">

                    <a
                        href="../home/home.php"
                        class="btn btn-voltar">
                        Voltar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-cadastrar"
                        name = "cadastro">
                        Cadastrar Serviço
                    </button>

                </div>

            </form>

        </div>

    </main>


    <!-- RODAPÉ -->
    <footer>
        <p>&copy; 2026 - Sistema de Serviços</p>
    </footer>

</body>

</html>
