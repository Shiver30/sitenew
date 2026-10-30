<?php
session_start();

require_once "../conexao.php";
require_once "../funcoes/funcoes.php";

verificarLogin();


if (isset($_POST['cadastro'])) {

    $idUsuario = $_SESSION['usuarios_id'] ?? null;
    $nomeServico = $_POST['nome_servico'];
    $tipoServico = $_POST['tipoServico'];
    $descricaoServico = $_POST['descricao_servico'];

    $salvar = cadastroServico($conexao, $idUsuario, $nomeServico, $tipoServico, $descricaoServico);

        if (isset($salvar)) {
              header("Location: ../home/home.php");
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
    <title>WorkMatch - Cadastro de Serviço</title>
    <link rel="stylesheet" href="../css/css.css">
</head>

<body class="pagina-logada pagina-cadastro-servico">
    
    <?php include("../include/navegacao.php"); ?>

    <!-- CABEÇALHO -->
    <header class="cadastro-servico-header">
        <div class="cadastro-servico-logo">
            Cadastro de Serviço
        </div>

        <nav class="cadastro-servico-nav">
            <a href="../home/home.php">Início</a>
        </nav>
    </header>


    <!-- CONTEÚDO -->
    <main class="cadastro-servico-main">

        <div class="form-container">

            <h1>Cadastro de Serviço</h1>

            <form action="" method="post">

                <!-- NOME DO SERVIÇO -->
                <div class="campo">
                    <label for="nome_servico">Nome do serviço:</label>
                    <input type="text" id="nome_servico" name="nome_servico" placeholder="Digite o nome do serviço" required>
                </div>


                <!-- TIPO DO SERVIÇO -->
                <div class="campo">
                    <label for="tipoServico">Classe do serviço:</label>

                    <select name="tipoServico" id="tipoServico" required>

                        <option value="Aulas Particulares">Aulas Particulares</option>
                        <option value="Reformas e Reparos">Reformas e Reparos</option>
                        <option value="Cuidados Pessoais">Cuidados Pessoais</option>
                        <option value="Eventos e Entretenimento">Eventos e Entretenimento</option>
                        <option value="Serviços Domésticos">Serviços Domésticos</option>
                        <option value="Tecnologia e Informática">Tecnologia e Informática</option>
                        <option value="Saúde e Bem-estar">Saúde e Bem-estar</option>
                        <option value="Transporte e Mudanças">Transporte e Mudanças</option>
                        <option value="Consultoria e Negócios">Consultoria e Negócios</option>
                        <option value="Outros Serviços">Outros Serviços</option>

                    </select>
                </div>


                <!-- DESCRIÇÃO -->
                <div class="campo">
                    <label for="descricao_servico">Descrição do serviço:</label>
                    <textarea id="descricao_servico" name="descricao_servico" placeholder="Digite a descrição do serviço"></textarea>
                </div>


                <!-- BOTÕES -->
                <div class="botoes">
                    <a href="../home/home.php" class="btn btn-voltar">Voltar</a>
                    <button type="submit" class="btn btn-cadastrar" name = "cadastro">Cadastrar Serviço</button>
                </div>

            </form>

        </div>

    </main>


    <!-- RODAPÉ -->
    <footer class="cadastro-servico-footer">
        <?php  require_once "../include/rodape.php"; ?>
    </footer>

</body>

</html>
