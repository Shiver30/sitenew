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

    $senhaConfirmacao = $_POST['senhaConfirmacao'] ?? '';

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

    $erros = [];

    // E-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "Informe um e-mail válido.";
    }

    // Senha: mínimo de 8 caracteres, número, maiúscula e especial
    if (
        strlen($senha) < 8 ||
        !preg_match('/[0-9]/', $senha) ||
        !preg_match('/[A-Z]/', $senha) ||
        !preg_match('/[^A-Za-z0-9]/', $senha)
    ) {
        $erros[] = "A senha não atende a todos os requisitos.";
    }

    // Confirmação da senha
    if ($senha !== $senhaConfirmacao) {
        $erros[] = "As senhas não coincidem.";
    }

    // Data de nascimento: entre 16 e 120 anos
    try {
        $nascimento = new DateTimeImmutable($data);
        $hoje = new DateTimeImmutable('today');

        if ($nascimento->format('Y-m-d') !== $data) {
            $erros[] = "Data de nascimento inválida.";
        } else {
            $idade = $nascimento->diff($hoje)->y;

            if ($nascimento > $hoje || $idade < 16 || $nascimento < $hoje->modify('-120 years')) {
                $erros[] = "A idade deve estar entre 16 e 120 anos.";
            }
        }
    } catch (Exception $e) {
        $erros[] = "Informe uma data de nascimento válida.";
    }

    if (!empty($erros)) {
        $mensagem = "<div class='mensagem erro'><ul>";

        foreach ($erros as $erro) {
            $mensagem .= "<li>" . htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') . "</li>";
        }
        $mensagem .= "</ul></div>";
    } else {
        if (isset($foto) && !empty($foto['name'])) {
            $upload = uploadCapa($foto);
            if (isset($upload)) {
                $foto_user = $upload;
            } else {
                $mensagem = "<p class='mensagem erro'>Erro ao fazer upload da imagem. O formato pode ser inválido ou o arquivo pode ter mais de 2MB.</p>";
                $foto_user = null;
            }
        } else {
            $foto_user = "../fotos/upadr.jpeg";
        }

        if ($foto_user !== null) {
            $salvar = cadastrarUsuario($conexao, $nome, $email, $senha, $data, $cpf, $sexo, $foto_user);
            if (isset($salvar)) {
                $fim = cadastroEndereco($conexao, $salvar, $cidade);

                if (isset($fim)) {
                    header("Location: ../login.php");
                    exit();
                } else {
                    echo "<p style='color: red;'>Erro ao salvar o endereço.</p>";
                    exit();
                }
            } else {
                $mensagem = "<p class='mensagem erro'>Erro ao salvar no banco de dados.</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>WorkMatch - Cadastro de Usuário</title>
    
    <link rel="stylesheet" href="../css/cadastro.css">
</head>

<body class="pagina-cadastro-usuario">

    <!-- CABEÇALHO -->

    <header class="cadastro-usuario-header">

        <div class="cadastro-usuario-logo">Cadastro de Usuário</div>

        <nav class="cadastro-usuario-nav">
            <a href="../index.php">Início</a>
        </nav>

    </header>

    <!-- CONTEÚDO -->

    <main class="cadastro-usuario-mais">

        <div class="form-container">

            <h1>Cadastro</h1>
            <p class="descricao-formulario">Preencha seus dados para criar sua conta.</p>
            <?php
            if (isset($mensagem)) {
                echo $mensagem;
            }
            ?>


            <form id="cadastro-form" action="" method="post" enctype="multipart/form-data">

                <!-- DADOS DA CONTA -->
                <div class="secao">
                    <h2>Dados da Conta</h2>
                    <div class="linha-secao"></div>

                    <!-- NOME -->
                    <div class="campo">
                        <label for="nome">Nome completo:</label>
                        <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required>
                    </div>


                    <!-- EMAIL -->
                    <div class="campo">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" placeholder="Digite seu email" required>
                        <p id="regra-email" class="invalido" style="display: none;">Email inválido</p>
                    </div>

                    <!-- SENHAS -->
                    <div class="linha">
                        <div class="campo">
                            <label for="senha">Senha:</label>
                            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                            <button type="button" id="btn-mostrarSenha" class="btn">Mostrar</button>
                        </div>


                        <div class="campo">
                            <label for="senhaConfirmacao"> Confirme sua senha: </label>
                            <input type="password" id="senhaConfirmacao" name="senhaConfirmacao" placeholder="Confirme sua senha" required>
                            <p id="mensagem-senha" class="invalido" style="display: none;">As senhas não coincidem</p>
                        </div>

                        <div id="requisitos-senha" style="display: none;">
                            <ul>
                                <li id="regra-quantidade" class="invalido">Ter no mínimo 8 caracteres</li>
                                <li id="regra-numero" class="invalido">Ter pelo menos um número </li>
                                <li id="regra-maiuscula" class="invalido">Ter pelo menos uma letra maiúscula</li>
                                <li id="regra-especial" class="invalido">Ter pelo menos um caractere especial</li>
                            </ul>
                        </div>

                    </div>
                </div>

                <!-- DADOS PESSOAIS -->

                <div class="secao">
                    <h2>Dados Pessoais</h2>
                    <div class="linha-secao"></div>
                    <div class="linha">

                        <!-- DATA -->
                        <div class="campo">
                            <label for="data">Data de nascimento:</label>
                            <input type="date" id="data" name="data" required>
                            <p id="mensagem-data" class="invalido" style="display: none;"></p>
                        </div>


                        <!-- CPF -->
                        <div class="campo">
                            <label for="cpf">CPF:</label>
                            <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" maxlength="14" inputmode="numeric" required>
                        </div>
                    </div>


                    <!-- SEXO -->
                    <div class="campo">
                        <label for="sexo">Sexo:</label>
                        <select name="sexo" id="sexo" required>
                            <option value="o">Prefiro não dizer</option>
                            <option value="m">Masculino</option>
                            <option value="f">Feminino</option>
                        </select>
                    </div>


                    <!-- FOTO -->
                    <div class="campo campo-foto">
                        <label for="foto">Foto de perfil:</label>
                        <input type="file" name="foto" id="foto" accept="image/*">
                        <span class="ajuda">Selecione uma imagem para usar como foto de perfil. Tamanho máximo: 2MB.</span>
                    </div>
                </div>

                <!-- ENDEREÇO -->
                <div class="secao">
                    <h2>Endereço</h2>
                    <div class="linha-secao"></div>

                    <!-- ESTADO -->
                    <div class="campo">
                        <label for="estado">Estado:</label>
                        <select name="estado" id="estado" required>
                            <option value="">Selecione um Estado</option>
                            <?php while ($estado = mysqli_fetch_assoc($resultadoEstados)) { ?>
                                <option value="<?= $estado['estado_id']; ?>">
                                    <?= $estado['estado_nome']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>


                    <!-- CIDADE -->
                    <div class="campo">
                        <label for="cidade">Cidade:</label>
                        <select name="cidade" id="cidade" required>
                            <option value="">Selecione uma Cidade</option>
                        </select>
                    </div>
                </div>

                <!-- BOTÕES -->
                <div class="botoes">
                    <a href="../index.php" class="btn btn-voltar">Voltar</a>
                    <button type="submit" name="enviar" class="btn btn-cadastrar">Prosseguir Cadastro</button>
                </div>

            </form>

            <script>
                // Função de validar senha


                function validarCadastro() {
                    const senha = campoSenha.value;
                    const confirmacao = campoConfirmacao.value;
                    const email = campoEmail.value.trim();
                    const cpf = campoCPF.value.replace(/\D/g, '');

                    let primeiroCampoInvalido = null;

                    function registrarErro(campo, mensagem) {
                        campo.setCustomValidity(mensagem);

                        if (!primeiroCampoInvalido) {
                            primeiroCampoInvalido = campo;
                        }
                    }

                    [campoSenha, campoConfirmacao, campoEmail, campoData, campoCPF].forEach(campo => campo.setCustomValidity(''));

                    // 1. Requisitos da senha
                    const senhaValida = senha.length >= 8 && /[0-9]/.test(senha) && /[A-Z]/.test(senha) && /[^A-Za-z0-9]/.test(senha);

                    if (!senhaValida) {
                        registrarErro(campoSenha, 'A senha precisa ter 8 caracteres, um número, uma letra maiúscula e um caractere especial.');
                    }

                    // 2. Confirmação da senha
                    if (senha !== confirmacao) {
                        registrarErro(campoConfirmacao, 'As senhas não coincidem.');
                    }

                    // 3. E-mail
                    const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

                    if (!emailValido) {
                        registrarErro(campoEmail, 'Digite um e-mail válido.');
                    }

                    // 4. Data de nascimento
                    if (!validarDataNascimento()) {
                        registrarErro(campoData, 'Informe uma data de nascimento válida, entre 16 e 120 anos.');
                    }

                    // 5. CPF: verifica o formato e os dígitos verificadores
                    if (!validarCPF(cpf)) {
                        registrarErro(campoCPF, 'Digite um CPF válido.');
                    }

                    // Se algum campo estiver inválido, bloqueia o envio
                    if (primeiroCampoInvalido) {
                        primeiroCampoInvalido.reportValidity();
                        primeiroCampoInvalido.focus();
                        return false;
                    }

                    return true;
                }

                // Conecta a validação ao formulário
                const formulario = document.getElementById('cadastro-form');

                formulario.addEventListener('submit', function(event) {
                    if (!validarCadastro()) {
                        event.preventDefault();
                    }
                });

                // Validação - Troca de COR
                function validar(regra, valor) {
                    if (valor) {
                        regra.classList.remove('invalido');
                        regra.classList.add('valido');
                    } else {
                        regra.classList.remove('valido');
                        regra.classList.add('invalido');
                    }
                }

                const campoSenha = document.getElementById('senha');
                const campoConfirmacao = document.getElementById('senhaConfirmacao');
                const mensagemSenha = document.getElementById('mensagem-senha');
                const requisitosSenha = document.getElementById('requisitos-senha');


                const quantidade = document.getElementById('regra-quantidade');
                const numero = document.getElementById('regra-numero');
                const maiuscula = document.getElementById('regra-maiuscula');
                const especial = document.getElementById('regra-especial');

                const botaoMostrarSenha = document.getElementById('btn-mostrarSenha');



                campoSenha.addEventListener('input', verificarSenhas);
                campoConfirmacao.addEventListener('input', verificarSenhas);

                campoSenha.addEventListener('focus', () => {
                    requisitosSenha.style.display = 'block';
                });

                campoSenha.addEventListener('blur', () => {
                    requisitosSenha.style.display = 'none';
                });

                campoSenha.addEventListener('input', () => {
                    const tamanhoMinimo = campoSenha.value.length >= 8;
                    const temNumero = /[0-9]/.test(campoSenha.value);
                    const temMaiuscula = /[A-Z]/.test(campoSenha.value);
                    const temEspecial = /[^A-Za-z0-9]/.test(campoSenha.value);

                    validar(quantidade, tamanhoMinimo);
                    validar(numero, temNumero);
                    validar(maiuscula, temMaiuscula);
                    validar(especial, temEspecial);
                })

                botaoMostrarSenha.addEventListener('click', () => {
                    if (campoSenha.type == 'password') {
                        campoSenha.type = 'text';
                        botaoMostrarSenha.textContent = 'Ocultar';
                    } else {
                        campoSenha.type = 'password';
                        botaoMostrarSenha.textContent = 'Mostrar';
                    }
                })

                function verificarSenhas() {
                    if (campoConfirmacao.value === '') {
                        mensagemSenha.style.display = 'none';
                        return;
                    }

                    mensagemSenha.style.display = 'block';

                    if (campoSenha.value === campoConfirmacao.value) {
                        mensagemSenha.textContent = 'As senhas se coincidem';
                        mensagemSenha.classList.remove('invalido');
                        mensagemSenha.classList.add('valido');
                    } else {
                        mensagemSenha.textContent = 'As senhas não coincidem';
                        mensagemSenha.classList.remove('valido');
                        mensagemSenha.classList.add('invalido');
                    }
                }

                const campoEmail = document.getElementById('email');
                const regraEmail = document.getElementById('regra-email');

                campoEmail.addEventListener('focus', () => {
                    regraEmail.style.display = 'block';
                });

                campoEmail.addEventListener('blur', () => {
                    regraEmail.style.display = 'none';
                });

                campoEmail.addEventListener('input', () => {
                    // Verifica se o email possui um formato básico válido
                    const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(campoEmail.value);

                    // Altera a cor da regra de acordo com o resultado
                    validar(regraEmail, emailValido);

                    // Altera o texto exibido para o usuário
                    if (emailValido) {
                        regraEmail.textContent = 'Email válido';
                    } else {
                        regraEmail.textContent = 'Email inválido';
                    }
                });

                // Campo Data de Nascimento

                const campoData = document.getElementById('data');
                const mensagemData = document.getElementById('mensagem-data');

                function validarDataNascimento() {
                    const valor = campoData.value;

                    if (valor === '') {
                        mensagemData.style.display = 'none';
                        campoData.setCustomValidity('');
                        return true;
                    }

                    const hoje = new Date();
                    hoje.setHours(0, 0, 0, 0);

                    const nascimento = new Date(valor + 'T00:00:00');

                    const dataMinima = new Date();
                    dataMinima.setFullYear(hoje.getFullYear() - 120);

                    const dataMaxima = new Date();
                    dataMaxima.setFullYear(hoje.getFullYear() - 16);

                    let erro = '';

                    if (nascimento > hoje) {
                        erro = 'A data de nascimento não pode ser futura.';
                    } else if (nascimento < dataMinima) {
                        erro = 'A data de nascimento não pode ser superior a 120 anos atrás.';
                    } else if (nascimento > dataMaxima) {
                        erro = 'Você precisa ter pelo menos 16 anos.';
                    }

                    if (erro !== '') {
                        mensagemData.textContent = erro;
                        mensagemData.classList.remove('valido');
                        mensagemData.classList.add('invalido');
                        mensagemData.style.display = 'block';

                        campoData.setCustomValidity(erro);
                        return false;
                    }

                    mensagemData.textContent = 'Data de nascimento válida.';
                    mensagemData.classList.remove('invalido');
                    mensagemData.classList.add('valido');
                    mensagemData.style.display = 'block';

                    campoData.setCustomValidity('');
                    return true;
                }

                campoData.addEventListener('change', validarDataNascimento);
                campoData.addEventListener('blur', validarDataNascimento);

                // CAMPO CPF

                const campoCPF = document.getElementById('cpf');
                campoCPF.addEventListener('input', () => {
                    // Remove tudo que não for número
                    let cpf = campoCPF.value.replace(/\D/g, '');

                    // Limita a 11 números
                    cpf = cpf.substring(0, 11);

                    // Adiciona os pontos e o traço automaticamente
                    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
                    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
                    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

                    campoCPF.value = cpf;
                });


                // CAMPO ESTADO E CIDADE

                const cidades = <?= json_encode($cidades); ?>;
                const estado = document.getElementById("estado");
                const cidade = document.getElementById("cidade");
                estado.addEventListener("change", function() {
                    const idEstado = this.value;
                    cidade.innerHTML = '<option value="">Selecione uma cidade</option>';
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


        </div>

    </main>


    <!-- RODAPÉ -->
    <footer class="cadastro-usuario-footer">
        <?php require_once "../include/rodape.php"; ?>
    </footer>