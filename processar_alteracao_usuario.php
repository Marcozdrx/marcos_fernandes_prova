<?php
    session_start();
    require_once 'conexao.php';

    if($_SESSION['perfil'] != 1){
        echo"<script>alert('acesso negado');window.location.href='principal.php';</script>";
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id_usuario = $_POST['id_usuario'];
        $nome = trim($_POST['nome']);
        $email = trim($_POST['email']);
        $id_perfil = $_POST['id_perfil'];
        $nova_senha = !empty($_POST['nova_senha']) ? $_POST['nova_senha'] : null;

        // Validações básicas
        if (empty($nome) || strlen($nome) < 2) {
            echo "<script>alert('O nome deve ter pelo menos 2 caracteres.');window.location.href='alterar_usuario.php';</script>";
            exit();
        }

        if (empty($email)) {
            echo "<script>alert('O e-mail não pode estar vazio.');window.location.href='alterar_usuario.php';</script>";
            exit();
        }

        if ($nova_senha && strlen($nova_senha) < 6) {
            echo "<script>alert('A senha deve ter pelo menos 6 caracteres.');window.location.href='alterar_usuario.php';</script>";
            exit();
        }

        try {
            // Atualiza os dados do usuario
            if($nova_senha){
                // Query com senha
                $sql = "UPDATE usuario SET nome = :nome, email = :email, id_perfil = :id_perfil, senha = :senha WHERE id_usuario = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":nome", $nome);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":id_perfil", $id_perfil);
                $stmt->bindParam(":senha", password_hash($nova_senha, PASSWORD_DEFAULT));
                $stmt->bindParam(":id", $id_usuario);
            } else {
                // Query sem senha
                $sql = "UPDATE usuario SET nome = :nome, email = :email, id_perfil = :id_perfil WHERE id_usuario = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":nome", $nome);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":id_perfil", $id_perfil);
                $stmt->bindParam(":id", $id_usuario);
            }

            if($stmt->execute()){
                $mensagem = $nova_senha ? 'Usuario atualizado com sucesso (incluindo nova senha)' : 'Usuario atualizado com sucesso';
                echo "<script>alert('$mensagem');window.location.href='alterar_usuario.php';</script>";
            } else {
                echo "<script>alert('Erro ao atualizar o usuario');window.location.href='alterar_usuario.php';</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Erro no banco de dados: " . addslashes($e->getMessage()) . "');window.location.href='alterar_usuario.php';</script>";
        }
    } else {
        // Se não for POST, redireciona
        header("Location: alterar_usuario.php");
        exit();
    }
?>