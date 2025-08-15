<?php
    session_start();
    require_once 'conexao.php';

    // Verifica se o usuario tem permissao de administrador para excluir o usuario
    if($_SESSION['perfil'] != 1){
        echo"<script>alert('acesso negado');window.location.href='principal.php';</script>";
        exit();
    }

    // Inicializa a varivael para armazenar usuarios
    $usuarios = [];

    // Busca todos os usuarios de em ordem alfabetica
    $sql= "SELECT * FROM usuarios  ORDER BY nome ASC";
    $stmt -> prepare($sql);
    $stmt ->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Se um id for passado via get exclui o usuario

    if(isset($_GET['id'] && is_numeric($_GET['id']))){
        $id_usuario = $_GET['id'];
        // Exclui o usuario do banco de dados
        $sql = "DELETE FROM usuario WHERE id_usuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_usuario', PDO::PARAM_INT);

        if($stmt->execute()){
            echo"<script>alert('Usuario excluido com sucesso');window.location.href='excluir_usuario.php';</script>";
        }else{
            echo"<script>alert('Erro ao excluir o usuario');window.location.href='excluir_usuario.php';</script>";
        }
    }
?>