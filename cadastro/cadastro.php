<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<h1>Cadastro</h1>
<body>
    <form action="">

    <p>Nome:</p>
    <input type="text" placeholder="Digite seu nome"><br>

    <p>Email:</p>
    <input type="text" placeholder="Digite seu email"><br>

    <p>Senha:</p>
    <input type="text" placeholder="Digite sua senha" id="senha"><br>

    <p>Confirme sua senha:</p>
    <input type="text" placeholder="Confirme sua senha" id="senhaConfirmacao"><br>

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
    <input type="text" placeholder="Digite sua data de nascimento"><br>

    <p>CPF:</p>
    <input type="text" placeholder="Digite seu CPF"><br>

    <p>Sexo:</p>
    <select name="sexo" id="sexo">
        <option value="m">Masculino</option>
        <option value="f">Feminino</option>
        <option value="o">Outro</option>
    </select>
    <br>

    <button type="submit">Prosseguir Cadastro</button>
    </form>
</body>
</html>