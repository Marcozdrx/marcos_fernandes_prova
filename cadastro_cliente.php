<?php
require_once 'conexao.php';
require_once 'dropdown.php';
session_start();

// Verifica permissão (perfil 1 = admin, 2 = secretaria)
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2) {
    echo "Acesso negado!";
    exit();
}

// Função para validar telefone no servidor
function validarTelefone($telefone) {
    // Remove tudo que não for número
    $telefone = preg_replace('/\D/', '', $telefone);

    // Verifica se tem 10 ou 11 dígitos
    if (preg_match('/^\d{10,11}$/', $telefone)) {
        return $telefone;
    }

    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome_cliente'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = $_POST['telefone'] ?? '';
    $endereco = trim($_POST['endereco'] ?? '');

    // Validação no servidor
    if (empty($nome) || strlen($nome) < 2 || !preg_match('/^[a-zA-ZÀ-ÿ\s\-\']+$/u', $nome)) {
        echo "<script>alert('Nome inválido. Use apenas letras, espaços e hífens.');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Digite um e-mail válido.');</script>";
    } elseif (!$telefone = validarTelefone($telefone)) {
        echo "<script>alert('Telefone inválido. Use somente números (10 ou 11 dígitos).');</script>";
    } else {
        try {
            $sql = "INSERT INTO cliente (nome_cliente, endereco, telefone, email)
                    VALUES (:nome_cliente, :endereco, :telefone, :email)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":nome_cliente", $nome);
            $stmt->bindParam(":endereco", $endereco);
            $stmt->bindParam(":telefone", $telefone);
            $stmt->bindParam(":email", $email);

            if ($stmt->execute()) {
                echo "<script>alert('Cliente cadastrado com sucesso!');</script>";
            } else {
                echo "<script>alert('Erro ao cadastrar cliente.');</script>";
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
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
        <input type="text" name="telefone" id="telefone" required onblur="formatarTelefone()">

        <label>E-mail: </label>
        <input type="email" name="email" id="email" required>

        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
    </form>

    <div class="voltar">
        <a href="principal.php">Voltar</a>
    </div>
    <script>
// Validação do nome
function validarNomeCliente() {
    let nome = document.getElementById("nome_cliente").value.trim();
    let regex = /^[a-zA-ZÀ-ÿ\s\-']+$/;

    if (nome.length < 2) {
        alert("O nome deve ter pelo menos 2 caracteres.");
        return false;
    }
    if (!regex.test(nome)) {
        alert("Nome inválido. Use apenas letras, espaços, hífens e apóstrofos.");
        return false;
    }
    return true;
}

// Validação e formatação do telefone
function formatarTelefone() {
    let campo = document.getElementById("telefone");
    let numero = campo.value.replace(/\D/g, '');

    if (numero.length === 10) {
        campo.value = `(${numero.substring(0,2)})${numero.substring(2,6)}-${numero.substring(6,10)}`;
    } else if (numero.length === 11) {
        campo.value = `(${numero.substring(0,2)})${numero.substring(2,7)}-${numero.substring(7,11)}`;
    } else {
        alert("Telefone inválido. Use 10 ou 11 dígitos numéricos.");
        campo.focus();
        return false;
    }
    return true;
}

// Validação do formulário completo
function validarFormularioCliente() {
    let nomeValido = validarNomeCliente();
    let email = document.getElementById("email").value.trim();
    let telefone = document.getElementById("telefone").value.replace(/\D/g, '');
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!nomeValido) return false;

    if (!emailRegex.test(email)) {
        alert("Digite um e-mail válido.");
        return false;
    }

    if (telefone.length !== 10 && telefone.length !== 11) {
        alert("Telefone inválido. Deve conter 10 ou 11 dígitos.");
        return false;
    }

    return true;
}
</script>
<center><address>Estudante / Desenvolvimento de Sistemas / Marcos Paulo Fernandes</address></center>
</body>
</html>