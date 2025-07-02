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

// Deletar produto garantindo que é do usuário
$sql = "DELETE FROM produtos WHERE id = ? AND funcionario_id = ?";
$stmt = $pdo->prepare($sql);
if ($stmt->execute([$id, $usuario_id])) {
    header("Location: produtos.php?msg=deletado");
    exit;
} else {
    echo "Erro ao deletar produto. <a href='produtos.php'>Voltar</a>.";
}
?>
