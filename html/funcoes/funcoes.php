<?php
require_once "../conexao.php";

// Cadastro e Login

//LOGUIN
function login($conexao, $email, $senha) {
    $sql = "SELECT * FROM usuarios WHERE usuarios_email = ? AND usuarios_senha = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
        $_SESSION['usuario'] = $usuario['nome'];
        $_SESSION['id'] = $usuario['id'];
        
        return true;
    }
        
    return false;
}
// CADASTRO
    function cadastrarUsuario($conexao, $nome, $idade, $cpf, $sexo, $email, $senha, $foto) {
        $sql = "INSERT INTO usuarios ( usuarios_nome, usuarios_idade, usuarios_cpf, usuarios_sexo, usuarios_email, usuarios_senha, usuarios_img ) VALUES (?, ?, ?, ?, ?, ?, ? )";
        $comando = mysqli_prepare($conexao, $sql);
        mysqli_stmt_bind_param($comando, "sssssss", $nome, $idade, $cpf, $sexo, $email, $senha, $foto );
        mysqli_stmt_execute($comando);
        mysqli_stmt_close($comando);


    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Funcões da Pagina

//     Função para pesquisar 

    function pesquisar($conexao, $termo){
        $sql = "SELECT FROM usuarios WHERE usuarios_nome LIKE ? ";
        $comando = mysqli_prepare($conexao, $sql);
        $termo = "%termo%";
        mysqli_stmt_bind_param($comando, "s", $termo);
        mysqli_stmt_execute($comando);
        $resultado = mysqli_stmt_get_result($comando);
        $usuarios = [];
        while ($usuarios = mysqli_fetch_assoc($resultado)) {
            $usuarios = $usuarios_dados;
        }
        mysqli_stmt_close($comando);
        return $usuarios;
    }

    // Função para listar os estados e cidades do banco de dados

    function listarEstados($conexao) {
    $sql = "SELECT * FROM estado ORDER BY estado_nome";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);
    $lista_estados = [];
    while ($estado = mysqli_fetch_assoc($resultado)) {
        $lista_estados = $estado_dados;
    }
    mysqli_stmt_close($comando);
    return $lista_estados;
    }

    function listarCidades($conexao, $estado_id) {
    $sql = "SELECT * FROM cidade WHERE estado_id = ? ORDER BY cidade_nome";
    $comando = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($comando, 'i', $estado_id);
    mysqli_stmt_execute($comando);
    $resultado = mysqli_stmt_get_result($comando);
    $lista_cidades = [];
    while ($cidade = mysqli_fetch_assoc($resultado)) {
        $lista_cidades = $cidade_dados;
    }
    mysqli_stmt_close($comando);
    return $lista_cidades;
    }


?>