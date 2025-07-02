<?php
session_start();

$host = 'localhost';
$dbname = 'wm_flash';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

$sql = "SELECT id, nome, senha FROM funcionarios WHERE email = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

if ($funcionario && password_verify($senha, $funcionario['senha'])) {
    // Login válido, criar sessão
    $_SESSION['usuario_id'] = $funcionario['id'];
    $_SESSION['usuario_nome'] = $funcionario['nome'];
    header("Location: produtos.php");
    exit;
} else {
    echo "Email ou senha incorretos. <a href='login_funcionario.html'>Tente novamente</a>.";
}
?>
