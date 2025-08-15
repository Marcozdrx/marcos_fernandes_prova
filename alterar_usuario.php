<?php
    session_start();
    require_once 'conexao.php';

    // Verifica se o usuario tem permissao de ADM
    if ($_SESSION['perfil'] != 1) {
        echo "<script>alert('Acesso negado');window.location.href='principal.php';</script>";
        exit();
    }

    // Inicializa variaveis

    $usuario = null;
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(!empty($_POST['busca_usuario'])){
            $busca = trim($_POST['busca_usuario']);

            // Verifica se a busca de um usuario é um numero ou nome
            if (is_numeric($busca)) {
                $sql = "SELECT * FROM usuario WHERE id_usuario = :busca";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
            } else {
                $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome";
                $stmt = $pdo->prepare($sql);
                $busca_nome = "%$busca%";
                $stmt->bindParam(':busca_nome', $busca_nome, PDO::PARAM_STR);
            }
            
            $stmt->execute();
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Se o usuario nao for encontrado, exibe um alerta
            if(!$usuario){
                echo "<script>alert('Usuario não encontrado');</script>";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar o usuario</title>
    <link rel="stylesheet" href="styles.css">
        <!-- Certifique-se de que o java script esteja sendo carregafo corretamente-->
    <script src="scripts.js"></script>
</head>
<body>
    <h2>Alterar o Usuario</h2>
    <form action="alterar_usuario.php" method="POST">
        <label for="busca_usuario">Digite o ID ou nome do usuario</label>
        <input type="text" name="busca_usuario" id="busca_usuario" required onkeyup="BuscarSugestoes()">

        <!-- Div para exibir sugestões de usuarios-->
         <div id="sugestoes"></div>
         <button type="submit">Buscar</button>
    </form>
    <?php  if($usuario): ?>
        <!-- Formulario para alterar usuarios-->
         <form action="processar_alteracao_usuario.php" method="POST">
            
            <input type="hidden" name="id_usuario" value="<?=htmlspecialchars($usuario['id_usuario'])?>">

            <input type="text" id="nome" name="nome" value="<?=htmlspecialchars($usuario['nome'])?>" required>

            <label for="email">Nome:</label>
            <input type="text" id="email" name="email" value="<?=htmlspecialchars($usuario['email'])?>" required>

            <label for="id_perfil">Perfil:</label>
            <select id="id_perfil" name="id_perfil">
                <option value="1" <?= $usuario['id_perfil'] == 1 ? 'selected' : '' ?>>Administrador</option>
                <option value="2" <?= $usuario['id_perfil'] == 2 ? 'selected' : '' ?>>Secretaria</option>
                <option value="3" <?= $usuario['id_perfil'] == 3 ? 'selected' : '' ?>>Almoxarife</option>
                <option value="4" <?= $usuario['id_perfil'] == 4 ? 'selected' : '' ?>>Cliente</option>
            </select>

            <!-- Se o usuario logado for ADM exibir opcao de alterar senha -->
             <?php if ($_SESSION['perfil'] == 1):?>
                <label for="nova_senha">Nova senha:</label>
                <input type="password" id="nova_senha" name="nova_senha">
                <?php endif; ?>
                <button type="submit">Alterar</button>
                <button type="reset">Cancelar</button>
         </form>
        <?php endif; ?>
        <div class="voltar">
    <a href="principal.php">Voltar</a>
</div>
</body>
</html>