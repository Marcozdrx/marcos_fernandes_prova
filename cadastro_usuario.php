<?php
    session_start();
    require_once 'conexao.php';

    // Verifica se o usuario tem permissao sopondo que o perfil 1 seja o administrador

    if($_SESSION['perfil']!=1){
        echo "Acesso negado!";
    }
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash ($_POST['senha'],PASSWORD_DEFAULT);
        $id_perfil = $_POST['id_perfil'];

        $sql = "INSERT INTO usuario(nome, email, senha, id_perfil)
        VALUES (:nome, :email, :senha, :id_perfil)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $senha);
        $stmt->bindParam(":id_perfil", $id_perfil);

        if($stmt->execute()){
            echo "<script>alert('Usuario cadastrado com sucesso!');</script>";
        }else{
            echo "<script>alert('Erro ao cadastrar usuario');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Cadastrar Usuario</h2>
    <form action="cadastro_usuario.php" method="POST">
        <label>Nome: </label>
        <input type="text" name="nome" id="nome" required>
        <label>E-mail: </label>
        <input type="email" name="email" id="email" required>
        <label>Senha: </label>
        <input type="password" name="senha" id="senha" required>
        <label>Identificador do Perfil: </label>
        <select id="id_perfil" name="id_perfil">
            <option value="1">Administrador</option>
            <option value="2">Secretaria</option>
            <option value="3">Amoxerife</option>
            <option value="4">Cliente</option>
        </select>

        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
    </form>

    <a href="principal.php">Voltar</a>
</body>
</html>