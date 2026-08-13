<?php
require_once "../sitenew/html/conexao.php";
require_once "../sitenew/html/funcoes/funcoes.php";

$sqlEstados = "SELECT * FROM estado ORDER BY estado_nome";
$resultadoEstados = mysqli_query($conexao, $sqlEstados);


$sqlCidades = "SELECT * FROM cidade ORDER BY cidade_nome";
$resultadoCidades = mysqli_query($conexao, $sqlCidades);

$cidades = [];

while ($cidade = mysqli_fetch_assoc($resultadoCidades)) {
    $cidades[] = $cidade;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário</title>
</head>

<body>

    <h1>Cadastro</h1>

    <form action="" method="post" onsubmit="return validarSenha()" enctype="multipart/form-data">

        <p>Nome:</p>
        <input type="text" placeholder="Digite seu nome completo" name="nome" required><br>

        <p>Email:</p>
        <input type="email" placeholder="Digite seu email" name="email" required><br>

        <p>Senha:</p>
        <input type="password" placeholder="Digite sua senha" id="senha" name="senha" required><br>

        <p>Confirme sua senha:</p>
        <input type="password" placeholder="Confirme sua senha" id="senhaConfirmacao" name="senhaConfirmacao" required><br>

        <script>
            function validarSenha() {
                var senha = document.getElementById("senha").value;
                var senhaConfirmacao = document.getElementById("senhaConfirmacao").value;

                if (senha !== senhaConfirmacao) {
                    alert("As senhas não coincidem. Por favor, tente novamente.");
                    return false;
                }
                return true;
            }
        </script>

        <h3>Dados Pessoais:</h3>

        <p>Data de nascimento:</p>
        <input type="date" placeholder="Digite sua data de nascimento" name="dataNascimento" required><br>

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
            <option value="">Selecione um Estado</option>
            </select>

            <br> <br>
            <button type="submit">Prosseguir Cadastro</button>


    </form>

    <script>
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

    <br> <a href="../index.php"><button>Voltar</button></a>
</body>

</html>