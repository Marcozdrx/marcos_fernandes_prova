<?php
    require_once 'conexao.php';
    require_once 'dropdown.php';

    // Verifica se o cliente tem permissao de ADM
    if ($_SESSION['perfil'] != 1) {
        echo "<script>alert('Acesso negado');window.location.href='principal.php';</script>";
        exit();
    }

    // Inicializa variaveis

    $cliente = null;
    // Verifica se o metodo do formulario usado é POST, para inserir dados com segurança
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(!empty($_POST['busca_cliente'])){
            $busca = trim($_POST['busca_cliente']);

            // Verifica se a busca de um cliente é um numero ou nome
            if (is_numeric($busca)) {
                $sql = "SELECT * FROM cliente WHERE id_cliente = :busca";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
            } else {
                $sql = "SELECT * FROM cliente WHERE nome_cliente LIKE :busca_nome";
                $stmt = $pdo->prepare($sql);
                $busca_nome = "$busca%";
                $stmt->bindParam(':busca_nome', $busca_nome, PDO::PARAM_STR);
            }
            
            $stmt->execute(); // Executa o SQL
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

            // Se o cliente nao for encontrado, exibe um alerta
            if(!$cliente){
                echo "<script>alert('cliente não encontrado');</script>";
            }
        }
    }
?>
<!--Crianção do HTML-->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar o cliente</title>
    <link rel="stylesheet" href="styles.css">
        <!-- Certifique-se de que o java script esteja sendo carregado corretamente-->
    <script src="scripts.js"></script>
</head>
<body>
    <h2>Alterar o cliente</h2>
    <form action="alterar_cliente.php" method="POST">
        <label for="busca_cliente">Digite o ID ou nome do cliente</label>
        <input type="text" name="busca_cliente" id="busca_cliente" required onkeyup="BuscarSugestoes()">

        <!-- Div para exibir sugestões de clientes-->
         <div id="sugestoes"></div>
         <button type="submit">Buscar</button>
    </form>
        <?php  if($cliente): ?>
        <!-- Formulario para alterar clientes-->
            <form action="processar_alteracao_cliente.php" method="POST">
                
                <input type="hidden" name="id_cliente" value="<?=htmlspecialchars($cliente['id_cliente'])?>">
                
                <label for="nome">Nome:</label> <!-- Nome -->
                <input type="text" id="nome_cliente" name="nome_cliente" value="<?=htmlspecialchars($cliente['nome_cliente'])?>" required>

                <label for="email">E-mail:</label> <!-- E-mail -->
                <input type="text" id="email" name="email" value="<?=htmlspecialchars($cliente['email'])?>" required>

                <label for="telefone">telefone:</label> <!-- Telefone -->
                <input type="text" id="telefone" name="telefone" value="<?=htmlspecialchars($cliente['telefone'])?>" required>

                <label for="endereco">Endereço:</label> <!-- Endereço -->
                <input type="text" id="endereco" name="endereco" value="<?=htmlspecialchars($cliente['endereco'])?>" required>

                <button type="submit">Alterar</button>
                <button type="reset">Cancelar</button>
         </form>
        <?php endif; ?>
        <div class="voltar">
    <a href="principal.php">Voltar</a>
</div>
<script src="validacoes.js"></script> <!-- JS para a s validações funcionarem corretamente -->
<center><address>Estudante / Desenvolvimento de Sistemas / Marcos Paulo Fernandes</address></center>
</body>
</html>