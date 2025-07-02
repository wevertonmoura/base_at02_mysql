<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_funcionario.html");
    exit;
}

$host = 'localhost';
$dbname = 'wm_flash';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

$usuario_id = $_SESSION['usuario_id'];

// Buscar produtos do usuário logado
$sql = "SELECT * FROM produtos WHERE funcionario_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id]);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Produtos - wm_flash</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body>

<header class="header">
  <div class="logo"><h1>wm_flash</h1></div>
  <nav class="navbar">
    <ul id="nav-menu">
      
      <li><a href="logout.php">Sair</a></li>
    </ul>
  </nav>
</header>

<main class="container mt-4">
  <h2>Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h2>

  <a href="cadastro_produto.php" class="btn btn-success mb-3">Cadastrar Novo Produto</a>

  <h3>Produtos Cadastrados</h3>
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Preço</th>
        <th>Quantidade</th>
        <th>Cor</th>
        <th>Descrição</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($produtos): ?>
        <?php foreach ($produtos as $produto): ?>
          <tr>
            <td><?php echo htmlspecialchars($produto['nome']); ?></td>
            <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
            <td><?php echo (int)$produto['quantidade']; ?></td>
            <td><?php echo htmlspecialchars($produto['cor']); ?></td>
            <td><?php echo htmlspecialchars($produto['descricao']); ?></td>
            <td>
              <a href="editar_produto.php?id=<?php echo $produto['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
              <a href="deletar_produto.php?id=<?php echo $produto['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja deletar este produto?');">Excluir</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="6" class="text-center">Nenhum produto cadastrado.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>

<script src="js/bootstrap.min.js"></script>
</body>
</html>
