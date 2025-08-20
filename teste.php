<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
/* Container do menu */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Botão do dropdown */
.dropdown button {
  padding: 10px 20px;
  cursor: pointer;
}

/* Conteúdo do dropdown */
.dropdown-content {
  position: absolute;
  top: 100%;
  left: 0;
  background-color: #f1f1f1;
  min-width: 160px;
  overflow: hidden;

  /* Inicialmente escondido com animação */
  opacity: 0;
  transform: translateY(-10px);
  transition: opacity 0.3s ease, transform 0.3s ease;
  pointer-events: none; /* impede clicar enquanto invisível */
}

/* Itens do dropdown */
.dropdown-content a {
  display: block;
  padding: 10px;
  text-decoration: none;
  color: black;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

/* Ao passar o mouse no container, mostrar o dropdown */
.dropdown:hover .dropdown-content {
  opacity: 1;
  transform: translateY(0);
  pointer-events: auto; /* agora é clicável */
}
</style>
</head>
<body>

<div class="dropdown">
  <button>Menu</button>
  <div class="dropdown-content">
    <a href="#">Opção 1</a>
    <a href="#">Opção 2</a>
    <a href="#">Opção 3</a>
  </div>
</div>
<?php
    session_start();
    require_once 'conexao.php';

    if(!isset($_SESSION['usuario'])){
        header("Location: index.php");
        exit();
    }

    // Obtendo o nome do perfil do usuario logado
    $id_perfil = $_SESSION['perfil'];
    $sqlPerfil = "SELECT nome_perfil FROM perfil WHERE id_perfil = :id_perfil";
    $stmtPerfil = $pdo->prepare($sqlPerfil);
    $stmtPerfil->bindParam(':id_perfil', $id_perfil);
    $stmtPerfil->execute();
    $perfil = $stmtPerfil->fetch(PDO::FETCH_ASSOC);
    $nome_perfil = $perfil['nome_perfil'];

    /// Definição das permissoes por perfil

    $permissoes = [
        1 =>["Cadastrar"=>["cadastro_usuario.php", "cadastro_perfil.php", "cadastro_cliente.php", "cadastro_forncedor.php", "cadastro_produto.php", "cadastro_funcionario.php"],
        "Buscar"=>["buscar_usuario.php", "buscar_perfil.php", "buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php", "buscar_funcionario.php"],
        "Alterar"=>["alterar_usuario.php", "alterar_perfil.php", "alterar_cliente.php", "alterar_fornecedor.php", "alterar_produto.php", "alterar_funcionario.php"],
        "Excluir"=>["excluir_usuario.php", "excluir_perfil.php", "excluir_cliente.php", "excluir_fornecedor.php", "excluir_produto.php", "excluir_funcionario.php"]
        ],

        2 =>["Cadastrar"=>["cadastro_cliente.php"],
        "Buscar"=>["buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php"],
        "Alterar"=>["alterar_fornecedor.php", "alterar_produto.php"],
        "Excluir"=>["excluir_produto.php"]
        ],

        3 =>["Cadastrar"=>["cadastro_forncedor.php", "cadastro_produto.php"],
        "Buscar"=>["buscar_cliente.php", "buscar_fornecedor.php", "buscar_produto.php"],
        "Alterar"=>["alterar_fornecedor.php", "alterar_produto.php"],
        "Excluir"=>["excluir_produto.php"]
        ],

        4 =>["Cadastrar"=>["cadastro_cliente.php"],
        "Buscar"=>["buscar_produto.php"],
        "Alterar"=>["alterar_cliente.php"]
        ]
    ];

    // Obtendo as opcoes disponiveis para o perfil logado

    $opcoes_menu = $permissoes["$id_perfil"];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Principal</title>
    <link rel="stylesheet" href="styles.css">
    <script src="srcipts.js"></script>
</head>
<body>
    <nav class="navbar">
        <!-- Menu da esquerda -->
        <div class="dropdown">
          <div class="dropdown-content">
            <ul class="menu">
                <?php foreach($opcoes_menu as $categoria => $arquivos): ?>
                    <li class="dropdown">
                        <a href="#"><?=$categoria?></a>
                        <ul class="dropdown-menu">
                            <?php foreach($arquivos as $arquivo): ?>
                                <li>
                                    <a href="<?=$arquivo?>"><?=ucfirst(str_replace("_", " ",basename($arquivo,".php")))?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <!-- Saudação -->
        <div class="saudacaodrop">
            <h2><?php echo $_SESSION['usuario']; ?>! Perfil: <?php echo $nome_perfil; ?></h2>
            
        </div>

        <!-- Botão logout -->
        <div class="logoutdropdown">
            <form action="logout.php" method="POST" class="formdrop">
                <button type="submit" class="buttondrop">Logout</button>
            </form>
        </div>
      </nav>
</body>
</html>
</body>
</html>
