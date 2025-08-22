<?php
require_once 'conexao.php';
require_once 'dropdown.php';

// Verifica o perfil logado, se for cliente o acesso sera negado
if ($_SESSION['perfil'] == 4) {
    echo "<script>alert('Acesso negado');window.location.href='principal.php';</script>";
    exit();
}

$clientes = []; // Inicializa a variável

    // Verifica se o metodo do formulario usado é POST, para inserir dados com segurança
if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST["busca"])) {
    $busca = trim($_POST['busca']);

    // Verifica se a busca de um cliente é um numero ou nome
    if (is_numeric($busca)) {
        $sql = "SELECT * FROM cliente WHERE id_cliente = :busca ORDER BY nome_cliente ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM cliente WHERE nome_cliente LIKE :busca_nome ORDER BY nome_cliente ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca_nome', "$busca%", PDO::PARAM_STR);
    }
} else {
    // Se não for feita nenhuma busca, trará todos os dados em tabela
    $sql = "SELECT * FROM cliente ORDER BY nome_cliente ASC";
    $stmt = $pdo->prepare($sql);
}

$stmt->execute(); // Executa o SQL
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Criação do HTML -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Buscar Clientes</title>
    <link rel="stylesheet" href="styles.css"> <!-- Linkando o CSS para a estilização -->
</head>
<body>
    <h2>Buscar Clientes</h2>
    <form action="buscar_cliente.php" method="POST">
        <!-- Campo para buscar por Nome ou ID -->
        <label for="busca">Digite o ID ou nome (opcional): </label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Buscar</button>
    </form>

    <!-- Se o campo array nao for nulo trazer a tabela-->
    <?php if (!empty($clientes)): ?>
        <table>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($clientes as $cliente): ?> <!-- Criação do foreach -->
                <tr>
                    <!-- Trazendo os dados nos campos designados -->
                    <td><?= htmlspecialchars($cliente['nome_cliente']) ?></td> 
                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                    <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                    <td><?= htmlspecialchars($cliente['endereco']) ?></td>
                    <td class="acoes">
                        <!-- Atalho de ações na pagina de busca: Alterar/Exluir -->
                        <a href="alterar_cliente.php?id=<?=htmlspecialchars($cliente['id_cliente'])?>">Alterar</a> |   
                        <a href="excluir_cliente.php?id=<?=htmlspecialchars($cliente['id_cliente'])?>"onclick="return confirm('Tem Certeza Que deseja excluir o cliente?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <!-- Caso não tenha nenhuma valor no Array Cliente, apenas aparecerá o aviso abaixo -->
        <p>Nenhum cliente encontrado.</p>
    <?php endif; ?>
    <div class="voltar">
    <a href="principal.php">Voltar</a>
</div>
<center><address>Estudante / Desenvolvimento de Sistemas / Marcos Paulo Fernandes</address></center>
</body>
</html>