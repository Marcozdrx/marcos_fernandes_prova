<?php
    require_once 'conexao.php';
    require_once 'dropdown.php';

    // Verifica se o usuario tem permissao de administrador para excluir o usuario
    if($_SESSION['perfil'] != 1){
        echo"<script>alert('acesso negado');window.location.href='principal.php';</script>";
        exit();
    }

    // Inicializa a varivael para armazenar usuarios
    $usuarios = [];

    // Busca todos os usuarios de em ordem alfabetica
    $sql= "SELECT * FROM usuario ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
    $stmt ->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Se um id for passado via get exclui o usuario

    if(isset($_GET['id']) && is_numeric($_GET['id'])){
        $id_usuario = $_GET['id'];
        // Exclui o usuario do banco de dados
        $sql = "DELETE FROM usuario WHERE id_usuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', PDO::PARAM_INT);

        if($stmt->execute()){
            echo"<script>alert('Usuario excluido com sucesso');window.location.href='excluir_usuario.php';</script>";
        }else{
            echo"<script>alert('Erro ao excluir o usuario');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Excluir usuario</h2>
    <?php if(!empty($usuarios)): ?>
        <div class="tabela">
        <table border="2">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Perfil</th>
                <th>Ações</th>
            </tr>
            <?php foreach($usuarios as $usuario): ?>
                <tr>
                    <td><?=htmlspecialchars($usuario['id_usuario'])?></td>
                    <td><?=htmlspecialchars($usuario['nome'])?></td>
                    <td><?=htmlspecialchars($usuario['email'])?></td>
                    <td><?=htmlspecialchars($usuario['id_perfil'])?></td>
                    <td class="acoes"><a href="excluir_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>" onclick="return confirm('tem certeza que deseja excluir este usuario')"> 🗑️</a></td>
                </tr>
                <?php endforeach; ?>
        </table>
            </div>
    <?php else: ?>
        <p>Nenhum usuario encontrado</p>
        <?php endif?>
        <div class="voltar">
    <a href="principal.php">Voltar</a>
</div>
</body>
</html>