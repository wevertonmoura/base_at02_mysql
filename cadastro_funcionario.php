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

// Recebe os dados do formulário
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$senha = $_POST['senha'] ?? '';

// Validações básicas
if (strlen($nome) < 3) {
    die("Nome muito curto. <a href='cadastro_funcionario.html'>Voltar</a>");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Email inválido. <a href='cadastro_funcionario.html'>Voltar</a>");
}

if ($telefone && !preg_match('/^\d{11}$/', $telefone)) {
    die("Telefone inválido. Deve conter 11 dígitos. <a href='cadastro_funcionario.html'>Voltar</a>");
}

if (strlen($senha) < 6) {
    die("Senha muito curta. <a href='cadastro_funcionario.html'>Voltar</a>");
}

// Verificar se o email já existe
$sqlCheck = "SELECT COUNT(*) FROM funcionarios WHERE email = ?";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->execute([$email]);
if ($stmtCheck->fetchColumn() > 0) {
    die("Email já cadastrado. <a href='cadastro_funcionario.html'>Voltar</a>");
}

// Cria hash da senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Inserir no banco
$sql = "INSERT INTO funcionarios (nome, email, telefone, senha) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$nome, $email, $telefone, $senha_hash])) {
    // Cadastro ok, redireciona para login
    header("Location: login_funcionario.html");
    exit;
} else {
    echo "Erro no cadastro. <a href='cadastro_funcionario.html'>Tente novamente</a>.";
}
?>
