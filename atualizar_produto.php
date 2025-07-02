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

$id = $_POST['id'] ?? null;
$nome = trim($_POST['nome-produto'] ?? '');
$preco = floatval($_POST['preco-produto'] ?? 0);
$quantidade = intval($_POST['quantidade-produto'] ?? 0);
$cor = trim($_POST['cor-produto'] ?? '');
$descricao = trim($_POST['descricao-produto'] ?? '');

if (!$id) {
    die("ID do produto não informado.");
}

if (strlen($nome) < 2 || $preco <= 0 || $quantidade <= 0 || empty($cor) || empty($descricao)) {
    die("Dados inválidos. <a href='editar_produto.php?id=$id'>Voltar</a>");
}

// Atualizar produto garantindo que é do usuário
$sql = "UPDATE produtos SET nome = ?, preco = ?, quantidade = ?, cor = ?, descricao = ? WHERE id = ? AND funcionario_id = ?";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$nome, $preco, $quantidade, $cor, $descricao, $id, $usuario_id])) {
    header("Location: produtos.php?msg=atualizado");
    exit;
} else {
    echo "Erro ao atualizar produto. <a href='editar_produto.php?id=$id'>Tente novamente</a>.";
}
