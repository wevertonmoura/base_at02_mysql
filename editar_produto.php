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

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID do produto não informado.");
}

// Buscar produto pelo id e funcionario_id para garantir segurança
$sql = "SELECT * FROM produtos WHERE id = ? AND funcionario_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id, $usuario_id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado ou acesso negado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Editar Produto - wm_flash</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body>

<header class="header">
  <div class="logo"><h1>wm_flash</h1></div>
  <nav class="navbar">
    <ul id="nav-menu">
      <li><a href="produtos.php">Produtos</a></li>
      <li><a href="logout.php">Sair</a></li>
    </ul>
  </nav>
</header>

<main class="container mt-4">
  <h2>Editar Produto</h2>

  <form method="post" action="atualizar_produto.php">
    <input type="hidden" name="id" value="<?php echo $produto['id']; ?>" />
    
    <div class="mb-3">
      <label for="nome-produto" class="form-label">Nome do Produto</label>
      <input type="text" id="nome-produto" name="nome-produto" class="form-control" required minlength="2" value="<?php echo htmlspecialchars($produto['nome']); ?>" />
    </div>

    <div class="mb-3">
      <label for="preco-produto" class="form-label">Preço</label>
      <input type="number" id="preco-produto" name="preco-produto" class="form-control" required min="0" step="0.01" value="<?php echo htmlspecialchars($produto['preco']); ?>" />
    </div>

    <div class="mb-3">
      <label for="quantidade-produto" class="form-label">Quantidade</label>
      <input type="number" id="quantidade-produto" name="quantidade-produto" class="form-control" required min="1" value="<?php echo (int)$produto['quantidade']; ?>" />
    </div>

    <div class="mb-3">
      <label for="cor-produto" class="form-label">Cor</label>
      <select id="cor-produto" name="cor-produto" class="form-select" required>
        <option value="">Selecione</option>
        <option value="Azul" <?php if ($produto['cor'] == 'Azul') echo 'selected'; ?>>Azul</option>
        <option value="Preto" <?php if ($produto['cor'] == 'Preto') echo 'selected'; ?>>Preto</option>
        <option value="Branco" <?php if ($produto['cor'] == 'Branco') echo 'selected'; ?>>Branco</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="descricao-produto" class="form-label">Descrição</label>
      <textarea id="descricao-produto" name="descricao-produto" rows="3" class="form-control" required><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Atualizar Produto</button>
  </form>
</main>

<script src="js/bootstrap.min.js"></script>
</body>
</html>
