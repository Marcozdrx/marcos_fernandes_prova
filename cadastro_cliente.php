<?php
    require_once 'conexao.php';
    require_once 'dropdown.php';

// Função para validar e formatar telefone
function formatarTelefone($telefone) {
    // Remove tudo que não for número
    $telefone = preg_replace('/\D/', '', $telefone);

    // Se tiver 10 dígitos (telefone fixo antigo, ex: (47)7778-9901)
    if (strlen($telefone) == 10) {
        return sprintf("(%s)%s-%s",
            substr($telefone, 0, 2),  // DDD
            substr($telefone, 2, 4),  // primeiros 4
            substr($telefone, 6, 4)   // últimos 4
        );
    }

    // Se tiver 11 dígitos (celular com 9, ex: (47)97778-9901)
    if (strlen($telefone) == 11) {
        return sprintf("(%s)%s-%s",
            substr($telefone, 0, 2),  // DDD
            substr($telefone, 2, 5),  // primeiros 5
            substr($telefone, 7, 4)   // últimos 4
        );
    }

    return false; // inválido
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';

    // Valida e formata telefone
    $telefone = formatarTelefone($telefone);
    if ($telefone === false) {
        die("Telefone inválido! Use algo como (47)7778-9901 ou (47)97778-9901.");
    }

    try {
        $sql = "INSERT INTO clientes (nome, email, telefone) VALUES (:nome, :email, :telefone)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);

        $stmt->execute();

        echo "Cadastro realizado com sucesso!";
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}


    // Verifica se o usuario tem permissao sopondo que o perfil 1 seja o administrador e o 2 seja  asecretaria
    if($_SESSION['perfil']!=1 && $_SESSION['perfil']!=2){
        echo "Acesso negado!";
        exit();
    }
    
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $nome = trim($_POST['nome_cliente']);
        $email = trim($_POST['email']);
        $telefone = $_POST['telefone'];
        $endereco = $_POST['endereco'];

        // Validação do nome no servidor
        // Validação de email em comentario para fazer testes com email inexistentes
        // Caso queira testar a validação retire o comentario
        if (empty($nome) || strlen($nome) < 2) {
            echo "<script>alert('O nome deve ter pelo menos 2 caracteres.');</script>";
        } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-\']+$/u', $nome)) {
            echo "<script>alert('O nome não pode conter números ou caracteres especiais.');</script>";
        // } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //    echo "<script>alert('Digite um e-mail válido.');</script>";
        } else {
            $sql = "INSERT INTO cliente(nome_cliente, endereco, telefone, email)
            VALUES (:nome_cliente, :endereco, :telefone, :email)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":nome_cliente", $nome);
            $stmt->bindParam(":endereco", $endereco);
            $stmt->bindParam(":telefone", $telefone);
            $stmt->bindParam(":email", $email);

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
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Cadastrar Cliente</h2>
    <form action="cadastro_cliente.php" method="POST" onsubmit="return validarFormularioCliente()">
        <label>Nome: </label>
        <input type="text" name="nome_cliente" id="nome_cliente" required onblur="validarNomeCliente()">
        <label>Endereço: </label>
        <input type="text" name="endereco" id="endereco" required>
        <label>Telefone: </label>
        <input type="text" name="telefone" id="telefone" required>
        <label>E-mail: </label>
        <input type="email" name="email" id="email" required>
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