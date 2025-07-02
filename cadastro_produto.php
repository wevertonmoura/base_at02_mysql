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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modelo = $_POST['modelo-produto'] ?? '';
    $nome = ucfirst($modelo);
    $preco = floatval($_POST['preco-produto'] ?? 0);
    $quantidade = intval($_POST['quantidade-produto'] ?? 0);
    $cor = trim($_POST['cor-produto'] ?? '');
    $descricao = trim($_POST['descricao-produto'] ?? '');
    $usuario_id = $_SESSION['usuario_id'];

    if (empty($modelo) || $preco <= 0 || $quantidade <= 0 || empty($cor) || empty($descricao)) {
        $erro = "Preencha todos os campos corretamente.";
    } else {
        $sql = "INSERT INTO produtos (nome, preco, quantidade, cor, descricao, funcionario_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $preco, $quantidade, $cor, $descricao, $usuario_id])) {
            header("Location: produtos.php?msg=cadastrado");
            exit;
        } else {
            $erro = "Erro ao cadastrar produto.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cadastrar Produto</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body>

<main class="container mt-4">
  <h2>Cadastrar Novo Produto</h2>

  <?php if (!empty($erro)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
  <?php endif; ?>

  <form method="post" action="">
    <div class="mb-3">
      <label for="modelo-produto" class="form-label">Modelo do iPhone</label>
      <select id="modelo-produto" name="modelo-produto" class="form-select" required>
        <option value="">Selecione o modelo</option>
        <option value="iPhone 12" data-preco="3500">iPhone 12</option>
        <option value="iPhone 13" data-preco="4500">iPhone 13</option>
        <option value="iPhone 14" data-preco="5500">iPhone 14</option>
        <option value="iPhone 15" data-preco="7000">iPhone 15</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="preco-produto" class="form-label">Preço</label>
      <input type="number" id="preco-produto" name="preco-produto" class="form-control" required min="0" step="0.01" />
    </div>

    <div class="mb-3">
      <label for="quantidade-produto" class="form-label">Quantidade</label>
      <input type="number" id="quantidade-produto" name="quantidade-produto" class="form-control" required min="1" />
    </div>

    <div class="mb-3">
      <label for="cor-produto" class="form-label">Cor</label>
      <select id="cor-produto" name="cor-produto" class="form-select" required>
        <option value="">Selecione</option>
        <option value="Azul">Azul</option>
        <option value="Preto">Preto</option>
        <option value="Branco">Branco</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="descricao-produto" class="form-label">Descrição</label>
      <textarea id="descricao-produto" name="descricao-produto" rows="3" class="form-control" required></textarea>
    </div>

    <button type="submit" class="btn btn-success">Cadastrar Produto</button>
  </form>
</main>

<script>
  const selectModelo = document.getElementById('modelo-produto');
  const inputPreco = document.getElementById('preco-produto');

  selectModelo.addEventListener('change', function() {
    const optionSelecionada = this.options[this.selectedIndex];
    const precoPadrao = optionSelecionada.getAttribute('data-preco');
    inputPreco.value = precoPadrao || '';
  });
</script>

<script src="js/bootstrap.min.js"></script>
</body>
</html>
