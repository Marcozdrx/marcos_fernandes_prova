<?php
    require_once 'conexao.php';
    require_once 'dropdown.php';

    // Verifica se o usuario tem permissao de administrador para excluir o cliente
    if($_SESSION['perfil'] != 1){
        echo"<script>alert('acesso negado');window.location.href='principal.php';</script>";
        exit();
    }

    // Inicializa a varivael para armazenar clientes
    $clientes = [];

    // Busca todos os clientes de em ordem alfabetica
    $sql= "SELECT * FROM cliente ORDER BY nome_cliente ASC";
    $stmt = $pdo->prepare($sql);
    $stmt ->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Se um id for passado via get exclui o cliente

    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id_cliente = $_GET['id'];
        // Exclui o cliente do banco de dados
        $sql = "DELETE FROM cliente WHERE id_cliente = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_cliente, PDO::PARAM_INT);

        if($stmt->execute()){
            echo"<script>alert('Cliente excluido com sucesso');window.location.href='excluir_cliente.php';</script>";
        }else{
            echo"<script>alert('Erro ao excluir o cliente');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Excluir cliente</h2>
    <?php if(!empty($clientes)): ?>
        <div class="tabela">
        <table>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>
            <?php foreach($clientes as $cliente): ?>
                <tr>
                    <td><?= htmlspecialchars($cliente['nome_cliente']) ?></td>
                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                    <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                    <td><?= htmlspecialchars($cliente['endereco']) ?></td>
                    <td class="acoes"><a href="excluir_cliente.php?id=<?=htmlspecialchars($cliente['id_cliente'])?>" onclick="return confirm('tem certeza que deseja excluir este cliente')"> 🗑️</a></td>
                </tr>
                <?php endforeach; ?>
        </table>
            </div>
    <?php else: ?>
        <p>Nenhum cliente encontrado</p>
        <?php endif?>
        <div class="voltar">
    <a href="principal.php">Voltar</a>
</div>
<center><address>Estudante / Desenvolvimento de Sistemas / Marcos Paulo Fernandes</address></center>
</body>
</html>