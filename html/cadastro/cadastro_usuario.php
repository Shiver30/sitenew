<?php
    require_once "../conexao.php";

    $sql = "SELECT * FROM estado ORDER BY estado_nome";
    $resultado = mysqli_query($conexao, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1>Cadastro</h1>

    <form action="salvar/s_usuario.php" method="post" onsubmit="return validarSenha()" enctype="multipart/form-data">

        <p>Nome:</p>
        <input type="text" placeholder="Digite seu nome completo" name="nome" required><br>

        <p>Email:</p>
        <input type="email" placeholder="Digite seu email" name="email" required><br>

        <p>Senha:</p>
        <input type="text" placeholder="Digite sua senha" id="senha" name="senha" required><br>

        <p>Confirme sua senha:</p>
        <input type="text" placeholder="Confirme sua senha" id="senhaConfirmacao" name="senhaConfirmacao" required><br>

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
        <input type="text" placeholder="Digite sua data de nascimento" name="data_nascimento" required><br>

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
        <select name="estado" id="estado" required>
            <option value="">Selecione um estado</option>

            <script>
                function listar($conexao) {
                    $sql = "SELECT * FROM estado ORDER BY estado_nome";
                    $comando = mysqli_prepare($conexao, $sql);
                    mysqli_stmt_execute($comando);
                    $resultado = mysqli_stmt_get_result($comando);
                    $lista_estados = [];
                    while ($estado = mysqli_fetch_assoc($resultado)) {
                        $lista_estados[] = $estado;
                    }
                    mysqli_stmt_close($comando);
                    return $lista_estados;
                }
            </script>

        </select>
        <br><br>

        <p>Cidade:</p>
        <select name="cidade" id="cidade" required> <br>
            <option value="">Selecione uma cidade</option> 


            <script>
                function listarCidades($conexao, $estado_id) {
                    $sql = "SELECT * FROM cidade WHERE estado_id = ? ORDER BY cidade_nome";
                    $comando = mysqli_prepare($conexao, $sql);
                    mysqli_stmt_bind_param($comando, 'i', $estado_id);
                    mysqli_stmt_execute($comando);
                    $resultado = mysqli_stmt_get_result($comando);
                    $lista_cidades = [];
                    while ($cidade = mysqli_fetch_assoc($resultado)) {
                        $lista_cidades[] = $cidade;
                    }
                    mysqli_stmt_close($comando);
                    return $lista_cidades;
                }
            </script>
        </select>

         <br> <br>
        <button type="submit">Prosseguir Cadastro</button>


    </form>

    <br> <a href="../index.php"><button>Voltar</button></a>
</body>

</html>