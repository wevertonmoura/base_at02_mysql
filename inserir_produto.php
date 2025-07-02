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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome-produto'] ?? '');
    $preco = floatval($_POST['preco-produto'] ?? 0);
    $quantidade = intval($_POST['quantidade-produto'] ?? 0);
    $cor = trim($_POST['cor-produto'] ?? '');
    $descricao = trim($_POST['descricao-produto'] ?? '');

    if (strlen($nome) < 2 || $preco <= 0 || $quantidade <= 0) {
        header("Location: produtos.php?erro=1");
        exit;
    }

    $sql = "INSERT INTO produtos (nome, preco, quantidade, cor, descricao, funcionario_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$nome, $preco, $quantidade, $cor, $descricao, $usuario_id])) {
        header("Location: produtos.php?msg=cadastrado");
        exit;
    } else {
        header("Location: produtos.php?erro=2");
        exit;
    }
}
?>
