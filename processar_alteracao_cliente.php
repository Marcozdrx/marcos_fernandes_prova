<?php
    session_start();
    require_once 'conexao.php';
    
    // Verifica se o perfil logado é de Adm
    if($_SESSION['perfil'] != 1){
        echo"<script>alert('acesso negado');window.location.href='principal.php';</script>";
        exit();
    }

    // Verifica se o metodo do formulario usado é POST, para inserir dados com segurança
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Define os valores das variaveis com os valores dados no formulario
        $id_cliente = $_POST['id_cliente'];
        $nome = trim($_POST['nome_cliente']);
        $email = trim($_POST['email']);
        $telefone = $_POST['telefone'];
        $endereco = $_POST['endereco'];

        // Validação de nome e email
        if (empty($nome) || strlen($nome) < 2) {
            echo "<script>alert('O nome deve ter pelo menos 2 caracteres.');window.location.href='alterar_cliente.php';</script>";
            exit();
        }

        if (empty($email)) {
            echo "<script>alert('O e-mail não pode estar vazio.');window.location.href='alterar_cliente.php';</script>";
            exit();
        }

        try {
                // Codigo que realiza a atualização/update no banco de dados
                $sql = "UPDATE cliente SET nome_cliente = :nome_cliente, email = :email, telefone = :telefone, endereco = :endereco WHERE id_cliente = :id";
                $stmt = $pdo->prepare($sql); // Prepara a consulta contra ataque SQL Injection
                $stmt->bindParam(":nome_cliente", $nome);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":telefone", $telefone);
                $stmt->bindParam(":endereco", $endereco);
                $stmt->bindParam(":id", $id_cliente);

            if($stmt->execute()){
                echo "<script>alert('Cliente atualizado com sucesso');window.location.href='alterar_cliente.php';</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Erro no banco de dados: " . addslashes($e->getMessage()) . "');window.location.href='alterar_cliente.php';</script>";
        }
    } else {
        // Se não for POST, redireciona
        header("Location: alterar_cliente.php");
        exit();
    }
?>