<?php
    session_start();
    require_once 'conexao.php'

    // Verifica se o usuario tem permissao de ADM
    if ($_SESSION['perfil'] != 1) {
        echo "<script>alert('Acesso negado');window.location.href='principal.php';</script>";
        exit();
    }

    // Inicializa variaveis

    $usuario = null
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        if(!empty($_POST['busca_usuario'])){
            $busca = trim($_POST['busca_usuario']);

            // Verifica se a busca de um usuario é um numero ou nome
            if(is_numeric($busca)){
                $sql = "SELECT * FROM usuario WHERE id_usuario = :busca";
                $stmt = $pdo->prepare($sql)
                $stmt->bindParam(':busca'. $busca, PDO::PARAM_INT);
            }else{
                $sql = "SELECT * FROM usuario WHERE nome LIKE :busca_nome";
                $stmt = $pdo->prepare($sql)
                $stmt->bindParam(':busca_nome'. "%$busca%", PDO::PARAM_INT);
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar o usuario</title>
    <linl rel="stylesheet" href="styles.css">
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
         <form action="processa_alteraca_usuario.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?=htmlspecialchars($usuario['nome'])?>" required>

            <label for="email">Nome:</label>
            <input type="text" id="email" name="email" value="<?=htmlspecialchars($usuario['email'])?>" required>

            <label for="id_perfil">Perfil:</label>
            <select id=
         </form>
</body>
</html>