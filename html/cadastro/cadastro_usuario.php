<?php
require_once "../conexao.php";
require_once "../funcoes/funcoes.php";

$sqlEstados = "SELECT * FROM estado ORDER BY estado_nome";
$resultadoEstados = mysqli_query($conexao, $sqlEstados);

$sqlCidades = "SELECT * FROM cidade ORDER BY cidade_nome";
$resultadoCidades = mysqli_query($conexao, $sqlCidades);

$cidades = [];

while ($cidade = mysqli_fetch_assoc($resultadoCidades)) {
    $cidades[] = $cidade;
}

if (isset($_POST['enviar'])) {

    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Dados do usuário
    $data = $_POST['data'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $foto = $_FILES['foto'] ?? '';

    // Endereço
    $estado = $_POST['estado'] ?? '';
    $cidade = $_POST['cidade'] ?? '';

    if ($foto && $foto['error'] === UPLOAD_ERR_OK) {

        $upload = uploadCapa($foto);

        if (isset($upload)){

            $foto_user = $upload;

            $salvar = cadastrarUsuario(
                $conexao,
                $nome,
                $email,
                $senha,
                $data,
                $cpf,
                $sexo,
                $upload
            );

            if (isset($salvar)){


                // $salvar contém o ID do usuário
                $fim = cadastroEndereco(
                    $conexao,
                    $salvar,
                    $cidade
                );

            } else {

                $mensagem = "<p class='mensagem erro'>
                    Erro ao salvar no banco de dados.
                </p>";

                if (isset($fim)){
                    header ("Location: ../index.php");
                }else{
                    echo"<p style='color: red;'>Erro ao salvar o endereço.</p>";
                    exit();
                }

                
            }
        } else {

            $mensagem = "<p class='mensagem erro'>
                Erro ao fazer upload da imagem.
                O formato pode ser inválido ou o arquivo pode ter mais de 2MB.
            </p>";

        }

    } else {

        $mensagem = "<p class='mensagem erro'>
            Por favor, selecione uma foto de perfil válida.
        </p>";

    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastro de Usuário</title>

    <style>

        /* =========================
           CONFIGURAÇÕES GERAIS
        ========================= */

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
            max-width: 750px;
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

            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 10px;
            color: #333;
        }

        .descricao-formulario {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }


        /* =========================
           SEÇÕES DO FORMULÁRIO
        ========================= */

        .secao {
            margin-top: 30px;
            margin-bottom: 25px;
        }

        .secao:first-of-type {
            margin-top: 0;
        }

        .secao h2 {
            font-size: 20px;
            margin-bottom: 5px;
            color: #333;
        }

        .linha-secao {
            width: 100%;
            height: 2px;
            background-color: #007bff;
            margin-bottom: 20px;
        }


        /* =========================
           CAMPOS
        ========================= */

        .campo {
            margin-bottom: 20px;
        }

        .campo label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .campo input,
        .campo select {
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
        .campo select:focus {
            outline: none;

            border-color: #007bff;

            box-shadow:
                0 0 0 2px rgba(0, 123, 255, 0.1);
        }


        /* =========================
           CAMPOS EM DUAS COLUNAS
        ========================= */

        .linha {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }


        /* =========================
           FOTO
        ========================= */

        .campo-foto {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
        }

        .campo-foto input {
            background-color: white;
            cursor: pointer;
        }

        .ajuda {
            display: block;
            margin-top: 7px;
            color: #777;
            font-size: 13px;
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

            padding: 12px 20px;

            border: none;
            border-radius: 5px;

            text-decoration: none;

            font-size: 15px;
            font-weight: bold;

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
           MENSAGENS
        ========================= */

        .mensagem {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .erro {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
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

            .logo {
                font-size: 20px;
            }

            main {
                margin: 25px auto;
            }

            .form-container {
                padding: 25px;
            }

            .linha {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .botoes {
                flex-direction: column;
            }

        }

    </style>

</head>


<body>


    <!-- =========================
         CABEÇALHO
    ========================= -->

    <header>

    <form action="" method="post" onsubmit="return validarSenha()" enctype="multipart/form-data">

        <div class="logo">
            Cadastro de Usuário
        </div>

        <nav>
            <a href="../index.php">
                Início
            </a>
        </nav>

    </header>



    <!-- =========================
         CONTEÚDO
    ========================= -->

    <main>

        <div class="form-container">

            <h1>Cadastro</h1>

            <p class="descricao-formulario">
                Preencha seus dados para criar sua conta.
            </p>


            <?php

            if (isset($mensagem)) {
                echo $mensagem;
            }

            ?>


            <form
                action=""
                method="post"
                onsubmit="return validarSenha()"
                enctype="multipart/form-data">


                <!-- =========================
                     DADOS DA CONTA
                ========================= -->

                <div class="secao">

                    <h2>Dados da Conta</h2>

                    <div class="linha-secao"></div>


                    <!-- NOME -->

                    <div class="campo">

                        <label for="nome">
                            Nome completo:
                        </label>

                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            placeholder="Digite seu nome completo"
                            required>

                    </div>


                    <!-- EMAIL -->

                    <div class="campo">

                        <label for="email">
                            Email:
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Digite seu email"
                            required>

                    </div>


                    <!-- SENHAS -->

                    <div class="linha">

                        <div class="campo">

                            <label for="senha">
                                Senha:
                            </label>

                            <input
                                type="password"
                                id="senha"
                                name="senha"
                                placeholder="Digite sua senha"
                                required>

                        </div>


                        <div class="campo">

                            <label for="senhaConfirmacao">
                                Confirme sua senha:
                            </label>

                            <input
                                type="password"
                                id="senhaConfirmacao"
                                name="senhaConfirmacao"
                                placeholder="Confirme sua senha"
                                required>

                        </div>

                    </div>

                </div>



                <!-- =========================
                     DADOS PESSOAIS
                ========================= -->

                <div class="secao">

                    <h2>Dados Pessoais</h2>

                    <div class="linha-secao"></div>


                    <div class="linha">

                        <!-- DATA -->

                        <div class="campo">

                            <label for="data">
                                Data de nascimento:
                            </label>

                            <input
                                type="date"
                                id="data"
                                name="data"
                                required>

                        </div>


                        <!-- CPF -->

                        <div class="campo">

                            <label for="cpf">
                                CPF:
                            </label>

                            <input
                                type="text"
                                id="cpf"
                                name="cpf"
                                placeholder="Digite seu CPF"
                                required>

                        </div>

                    </div>


                    <!-- SEXO -->

                    <div class="campo">

                        <label for="sexo">
                            Sexo:
                        </label>

                        <select
                            name="sexo"
                            id="sexo"
                            required>

                            <option value="m">
                                Masculino
                            </option>

                            <option value="f">
                                Feminino
                            </option>

                            <option value="o">
                                Outro
                            </option>

                        </select>

                    </div>


                    <!-- FOTO -->

                    <div class="campo campo-foto">

                        <label for="foto">
                            Foto de perfil:
                        </label>

                        <input
                            type="file"
                            name="foto"
                            id="foto"
                            accept="image/*"
                            required>

                        <span class="ajuda">
                            Selecione uma imagem para usar como foto de perfil.
                            Tamanho máximo: 2MB.
                        </span>

                    </div>

                </div>



                <!-- =========================
                     ENDEREÇO
                ========================= -->

                <div class="secao">

                    <h2>Endereço</h2>

                    <div class="linha-secao"></div>


                    <!-- ESTADO -->

                    <div class="campo">

                        <label for="estado">
                            Estado:
                        </label>

                        <select
                            name="estado"
                            id="estado"
                            required>

                            <option value="">
                                Selecione um Estado
                            </option>

                            <?php while ($estado = mysqli_fetch_assoc($resultadoEstados)) { ?>

                                <option value="<?= $estado['estado_id']; ?>">

                                    <?= $estado['estado_nome']; ?>

                                </option>

                            <?php } ?>

                        </select>

                    </div>


                    <!-- CIDADE -->

                    <div class="campo">

                        <label for="cidade">
                            Cidade:
                        </label>

                        <select
                            name="cidade"
                            id="cidade"
                            required>

                            <option value="">
                                Selecione uma Cidade
                            </option>

                        </select>

                    </div>

                </div>



                <!-- =========================
                     BOTÕES
                ========================= -->

                <div class="botoes">

                    <a
                        href="../index.php"
                        class="btn btn-voltar">

                        Voltar

                    </a>


                    <button
                        type="submit"
                        name="enviar"
                        class="btn btn-cadastrar">

                        Prosseguir Cadastro

                    </button>

                </div>


            </form>

        </div>

    </main>



    <!-- =========================
         RODAPÉ
    ========================= -->

    <footer>

        <p>
            &copy; 2026 - Sistema de Serviços
        </p>

    </footer>

    <!-- =========================
         JAVASCRIPT
    ========================= -->
        <h3>Dados Pessoais:</h3>

        <p>Data de nascimento:</p>
        <input type="date" placeholder="Digite sua data de nascimento" name="data" required><br>

        <p>CPF:</p>
        <input type="text" placeholder="Digite seu CPF" name="cpf" required><br>

        <p>Sexo:</p>
        <select name="sexo" id="sexo" required>
            <option value="m">Masculino</option>
            <option value="f">Feminino</option>
            <option value="o">Outro</option>
        </select>
        <br><br>

        <p>foto de perfil:</p>
        <input type="file" name="foto" id="foto" accept="image/*">
        <br><br>

        <h3>Endereço:</h3>

        <p>Estado:</p>
        <select name="estado" id="estado">
            <option value="">Selecione um Estado</option>

            <?php while ($estado = mysqli_fetch_assoc($resultadoEstados)) { ?>

                <option value="<?= $estado['estado_id']; ?>">
                    <?= $estado['estado_nome']; ?>
                </option>

            <?php } ?>

        </select>

        <br><br>

        <p>Cidade:</p>

        <select name="cidade" id="cidade">
            <option value="">Selecione uma Cidade</option>
            </select>

            <br> <br>

        <button type="submit" name="enviar">Cadastrar</button>;
        
    </form>



    <script>

        /* =========================
           VALIDAÇÃO DAS SENHAS
        ========================= */

        function validarSenha() {

            var senha =
                document.getElementById("senha").value;

            var senhaConfirmacao =
                document.getElementById("senhaConfirmacao").value;


            if (senha !== senhaConfirmacao) {

                alert(
                    "As senhas não coincidem. Por favor, tente novamente."
                );

                return false;
            }


            return true;
        }



        /* =========================
           CIDADES POR ESTADO
        ========================= */

        const cidades =
            <?= json_encode($cidades); ?>;

        const estado =
            document.getElementById("estado");

        const cidade =
            document.getElementById("cidade");


        estado.addEventListener("change", function() {

            const idEstado =
                this.value;


            cidade.innerHTML =
                '<option value="">Selecione uma cidade</option>';


            cidades.forEach(function(item) {

                if (item.cidade_estado_id == idEstado) {

                    cidade.innerHTML +=
                        `<option value="${item.cidade_id}">
                            ${item.cidade_nome}
                        </option>`;

                }

            });

        });

    </script>
</body>

</html>
