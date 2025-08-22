<?php
    require_once 'conexao.php';
    require_once 'dropdown.php';

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
        /* } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
           echo "<script>alert('Digite um e-mail válido.');</script>"; */
        } else {
            // Consulta para saber se há um email igual ja cadastrado
            $sqlVerificaEmail = "SELECT id_cliente FROM cliente WHERE email = :email LIMIT 1";
            $stmt = $pdo->prepare($sqlVerificaEmail); // Prepara a consulta contra ataques SQL Injection
            $stmt->execute(([':email' => $email])); // Execute se o dado pego por POST foi igual a algum email
            if($stmt->rowCount() > 0){ // Se for maior que zero
                echo "<script>alert('Usuario não cadastrado, E-mail ja utilizado!');window.location.href='cadastro_cliente.php';</script>";
            }else{ // Senão, permite o cadastro do usuario
                echo "<script>alert('E-mail livre!');</script>";
                $sql = "INSERT INTO cliente(nome_cliente, endereco, telefone, email)
                VALUES (:nome_cliente, :endereco, :telefone, :email)"; // Insert dos dados pegos por POST no BD
    
                $stmt = $pdo->prepare($sql); // Prepara contra SQL Injection
                $stmt->bindParam(":nome_cliente", $nome);
                $stmt->bindParam(":endereco", $endereco);
                $stmt->bindParam(":telefone", $telefone);
                $stmt->bindParam(":email", $email);
    
                if($stmt->execute()){ // Se executado imprime
                    echo "<script>alert('Usuario cadastrado com sucesso!');</script>";
            }else{ // Senão também imprime
                echo "<script>alert('Erro ao cadastrar usuario');</script>";
            }
        }
    }
}
?>
<!-- Contruindo a pagina HTML -->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="styles.css"><!-- Linkando o CSS para estilização -->
</head>
<body>
    <!-- Formulario de cadastro de cliente -->
    <h2>Cadastrar Cliente</h2>
    <form action="cadastro_cliente.php" method="POST" onsubmit="return validarFormularioCliente()">
        <label>Nome: </label> <!-- Nome -->
        <input type="text" name="nome_cliente" id="nome_cliente" required onblur="validarNomeCliente()">
        <label>Endereço: </label> <!-- Endereço -->
        <input type="text" name="endereco" id="endereco" required>
        <label>Telefone: </label> <!-- Telefone -->
        <input type="text" name="telefone" id="telefone" placeholder="(99)9999-9999" pattern="\(\d{2}\)\d{4,5}-\d{4}" title="Digite no formato: (99)9999-9999" maxlength="14" required>
        <label>E-mail: </label> <!-- E-mail -->
        <input type="email" name="email" id="email" required>
        <button type="submit">Salvar</button>
        <button type="reset">Cancelar</button>
    </form>
<div class="voltar">
    <a href="principal.php">Voltar</a>
</div>

<script src="validacoes.js"></script> <!-- Adicionando JS externo para as validações -->
<!-- Assinatura -->
<center><address>Estudante / Desenvolvimento de Sistemas / Marcos Paulo Fernandes</address></center>
</body>
</html>