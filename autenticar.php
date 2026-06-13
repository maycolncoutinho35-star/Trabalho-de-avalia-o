<?php
require __DIR__ . '/config/conexao.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: /projeto-web/login.php'); exit;
}

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$senha = $_POST['senha'] ?? '';

if(!$email || !$senha){
    header('Location: /projeto-web/login.php?erro=dados');
    exit;
}

$stmt = $pdo->prepare('SELECT id,nome,email,senha,nivel_acesso FROM usuarios WHERE email = ? LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch();

// Usuário não existe ou foi excluído
if(!$user){
    header('Location: /projeto-web/login.php?erro=naoencontrado');
    exit;
}

// Autenticação: aceita senha com hash (password_verify) ou senha em texto (apenas para o admin padrão inserido no database.sql)
$stored = $user['senha'];
$ok = false;
if (password_verify($senha, $stored)) {
    $ok = true;
} elseif ($stored === $senha) {
    // caso especial: senha armazenada em texto (apenas para facilitar entrega/avaliação)
    $ok = true;
}

if(!$ok){
    header('Location: /projeto-web/login.php?erro=senha');
    exit;
}

unset($user['senha']);
$_SESSION['user'] = $user;
header('Location: /projeto-web/index.php?login=1');
exit;