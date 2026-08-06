<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="funcoes/funcoes.php" method="post">

        <h1>Cadastro de Serviço</h1>

        <p>Nome do serviço:</p>
        <input type="text" placeholder="Digite o nome do serviço" name="nome_servico" required><br> 

        <p>classe</p>
        <select name="" id="">
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

        <p>Descrição do serviço:</p>
        <input type="text" placeholder="Digite a descrição do serviço" name="descricao_servico" ><br>


        


    </form>
</body>
</html>