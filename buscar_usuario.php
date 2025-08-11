<?php

require_once 'conexao.php';

if ($_SESSION['perfil'] != 1 && $_SESSION['perfil']!=2){
    echo "<script>alert('acesso negado');window.location.href='principal.php';</script>";
    exit();
}

$usuario = []; //Inicializa a variavel para evitar erros

if($_SERVER['REQUEST_METHOD']=="POST" && !empty($_POST["busca"])){
    $busca = trim($_POST['busca']);

    //Verifica se a busca é um numero ou nome
    if(is_numeric($busca)){
        $sql="SELECT * FROM usuario WHERE id_usuario = :busca ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    }else{
        $sql="SELECT * FROM usuario WHERE nome LIKE ;busca_nome ORDER BY nome ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValueParam(':busca_nome', "%$busca%", PDO::PARAM_STR);
    }
}else{
    $sql="SELECT * FROM usuario ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
}
$stmt->execute();
$usuarios = $stmt->fetchALL(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Buscar Usuarios</h2>
    <form action="buscar_usuario.php" method="POST">
        <label for="busca">Difite o ID ou nome(opcional): </label>
        <input type="text" id="busca" name="busca">
    </form>
    <?php if(!empty($usuarios)): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Ações</th>
            </tr>
            <?php foreach($usuarios as $usuario): ?>
                <tr>
                <td><?=htmlspeacialchars($usuario['id_usuario'])?></td>
                <td><?=htmlspeacialchars($usuario['nome'])?></td>
                <td><?=htmlspeacialchars($usuario['email'])?></td>
                <td><?=htmlspeacialchars($usuario['id_perfil'])?></td>
            </tr>
        </table>
</body>
</html>