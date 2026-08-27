<?php

require_once __DIR__ . '/../conexao.php';

// Cadastro e Login

function login($conexao, $email, $senha)
{
    $sql = "SELECT * FROM usuarios WHERE usuarios_email = ? AND usuarios_senha = ?";
    $stmt = $conexao->prepare($sql);
    
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        $_SESSION['usuario_nome'] = $usuario['usuarios_nome'];
        $_SESSION['usuarios_id'] = $usuario['usuarios_id'];
        $stmt->close();
        
        return true;
    }
    $stmt->close();

    return false;
}

// vereficar loguin

function verificarLogin(){
    // return isset($_SESSION['usuario']);
    if (!isset($_SESSION['usuarios_id'])) {
        header("Location: ../login.php");
    exit;
    }
}

// Logout

function logout()
{
    session_unset();
    session_destroy();

    header("Location: login.php");
    exit;
}

// CADASTRO
function cadastrarUsuario($conexao, $nome, $email, $senha, $data, $cpf, $sexo, $foto_user)
{
    $sql = "INSERT INTO usuarios (usuarios_nome, usuarios_email, usuarios_senha, usuarios_idade, usuarios_cpf, usuarios_sexo, usuario_img) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, "sssssss", $nome, $email, $senha, $data, $cpf, $sexo, $foto_user);

    if (mysqli_stmt_execute($comando)) {
        $idCriado = mysqli_stmt_insert_id($comando); // Pega o ID da sessão atual
        mysqli_stmt_close($comando);
        return $idCriado; // Retorna o ID do usuário inserido
    }
    mysqli_stmt_close($comando);
    return false;
}

// Cadastro endereço

function cadastroEndereco($conexao, $salvar, $cidade) {
    $sql = "INSERT INTO endereco (endereco_usuarios_id, endereco_cidade_id) VALUES (?, ?)";

    $comando = mysqli_prepare($conexao, $sql);
    // Alterado para "is" para aceitar o ID do usuário (int) e a Cidade (int)
    mysqli_stmt_bind_param($comando, "ii", $salvar, $cidade); 
    $resultado = mysqli_stmt_execute($comando);
    mysqli_stmt_close($comando);
    
    return $resultado;
}

// UPLOAD FOTO 

function uploadCapa($foto)
{
    $diretorio = '../fotos/';
    $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png'];

    if (!in_array($extensao, $permitidas)) {
        return false;
    }

    if ($foto['size'] > 1024 * 1024 * 2) { // permite até 2MB
        return false;
    }

    $nomeArquivo = uniqid() . "_" . $foto['name'];
    $caminho = $diretorio . $nomeArquivo; // uploads/capas/13516516has5_arvore.png

    if (move_uploaded_file($foto['tmp_name'], $caminho)) {
        return $caminho;
    }

    return false;
}

function cadastroServico($conexao, $idUsuario, $nomeServico, $tipoServico, $descricaoServico)
{
    $sqlServico = "INSERT INTO servico (servico_nome, servico_descricao, servico_classe) VALUES (?, ?, ?)";
    $stmtServico = mysqli_prepare($conexao, $sqlServico);
    
    if (!$stmtServico) {
        return false;
    }

    mysqli_stmt_bind_param($stmtServico, "sss", $nomeServico, $descricaoServico, $tipoServico);
    
    if (mysqli_stmt_execute($stmtServico)) {
        // 2. Pega o ID gerado para o novo serviço
        $idServicoCriado = mysqli_insert_id($conexao);
        mysqli_stmt_close($stmtServico);

        // 3. Vincula o novo serviço ao usuário na tabela 'usn'
        $sqlUsn = "INSERT INTO usn (usn_servico_id, usn_usuarios_id) VALUES (?, ?)";
        $stmtUsn = mysqli_prepare($conexao, $sqlUsn);

        if ($stmtUsn) {
            mysqli_stmt_bind_param($stmtUsn, "ii", $idServicoCriado, $idUsuario);
            $sucesso = mysqli_stmt_execute($stmtUsn);
            mysqli_stmt_close($stmtUsn);

            return $sucesso; // Retorna true se salvou na tabela usn
        }
    } else {
        mysqli_stmt_close($stmtServico);
    }

    return false;
}

//////////////////////////////////////////////////////////////////////////////////////////////////

// FUNÇÕES DA PÁGINA

// Função para pesquisar

function pesquisarNome($conexao, $termo)
{
    $sql = "SELECT * FROM usuarios WHERE usuarios_nome LIKE ? ";
    $comando = mysqli_prepare($conexao, $sql);
    $termo = "%" . $termo . "%";
    mysqli_stmt_bind_param($comando, "s", $termo);
    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);
    return $resultado;
}

// Função para listar os estados e cidades do banco de dados

function listarEstados($conexao)
{
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

function listarCidades($conexao, $estado_id)
{
    $sql = "SELECT * FROM cidade WHERE estado_id = ? ORDER BY cidade_nome";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, 'i', $estado_id);
    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);
    $lista_cidades = [];
    $lista_cidades = [];
    while ($cidade = mysqli_fetch_assoc($resultado)) {
        $lista_cidades[] = $cidade;
    }
    mysqli_stmt_close($comando);
    return $lista_cidades;
}

?>
