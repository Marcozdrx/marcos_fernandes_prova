<?php
    require_once 'conexao.php';
    require_once 'dropdown.php';

    // Verifica se o usuario tem permissao sopondo que o perfil 1 seja o administrador
    if($_SESSION['perfil']!=1){
        echo "Acesso negado!";
        exit();
    }
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $senha = $_POST['senha'];
        $id_perfil = $_POST['id_perfil'];

        // Validação do nome no servidor
        if (empty($nome) || strlen($nome) < 2) {
            echo "<script>alert('O nome deve ter pelo menos 2 caracteres.');</script>";
        } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-\']+$/u', $nome)) {
            echo "<script>alert('O nome não pode conter números ou caracteres especiais.');</script>";
        } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Digite um e-mail válido.');</script>";
        } elseif (strlen($senha) < 6) {
            echo "<script>alert('A senha deve ter pelo menos 6 caracteres.');</script>";
        } else {
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuario(nome, email, senha, id_perfil)
            VALUES (:nome, :email, :senha, :id_perfil)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":senha", $senha_hash);
            $stmt->bindParam(":id_perfil", $id_perfil);

            if($stmt->execute()){
                echo "<script>alert('Usuario cadastrado com sucesso!');</script>";
            }else{
                echo "<script>alert('Erro ao cadastrar usuario');</script>";
            }
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
    <form action="cadastro_usuario.php" method="POST" onsubmit="return validarFormularioUsuario()">
        <label>Nome: </label>
        <input type="text" name="nome" id="nome" required onblur="validarNomeUsuario()">
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
<div class="voltar">
    <a href="principal.php">Voltar</a>
</div>

<script src="validacoes.js"></script>
<center><address>Estudante / Desenvolvimento de Sistemas / Marcos Paulo Fernandes</address></center>
</body>
</html>