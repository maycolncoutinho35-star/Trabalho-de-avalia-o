<?php
require __DIR__ . '/config/conexao.php';
if(!empty($_SESSION['user'])){ header('Location: /projeto-web/index.php'); exit; }

$erro = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirma_senha = $_POST['confirma_senha'] ?? '';
    $telefone = trim($_POST['telefone'] ?? '');

    if(!$nome || !$email || !$senha) {
        $erro = 'Preencha todos os campos obrigatórios.';
    } elseif($senha !== $confirma_senha) {
        $erro = 'As senhas não conferem.';
    } elseif(strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } else {
        try {
            $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
            $stmt->execute([$email]);
            if($stmt->fetch()) {
                $erro = 'Este email já está registrado.';
            } else {
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha, telefone, nivel_acesso) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([$nome, $email, $senha_hash, $telefone, 'cliente']);

                $novo_id = (int)$pdo->lastInsertId();

                // Login automático após cadastro
                $_SESSION['user'] = [
                    'id' => $novo_id,
                    'nome' => $nome,
                    'email' => $email,
                    'nivel_acesso' => 'cliente',
                ];

                header('Location: /projeto-web/index.php?bemvindo=1');
                exit;
            }
        } catch(Exception $e) {
            $erro = 'Erro ao registrar. Tente novamente.';
        }
    }
}

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Criar Conta - AutoMax</title>
  <link rel="stylesheet" href="/projeto-web/css/style.css">
</head>
<body style="background: linear-gradient(135deg, var(--navy) 0%, #00254D 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center;">
  
  <div style="background: var(--white); padding: 50px; border-radius: 4px; width: 100%; max-width: 450px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
    <div style="text-align: center; margin-bottom: 40px;">
      <h1 style="font-size: 32px; margin-bottom: 10px; color: var(--navy); font-weight: 800;">AutoMax</h1>
      <p style="color: var(--text-secondary); margin: 0; font-size: 14px;">Concessionária de Carros Premium</p>
    </div>

    <h2 style="text-align: center; margin-bottom: 30px; font-size: 24px; color: var(--navy);">Criar Conta</h2>

    <?php if($erro): ?>
      <div class="alert alert-error">
        <?=e($erro)?>
      </div>
    <?php endif; ?>

    <form action="registrar.php" method="post">
      <div>
        <label for="nome">Nome Completo</label>
        <input id="nome" name="nome" type="text" required placeholder="Seu nome" value="<?=e($_POST['nome'] ?? '')?>">
      </div>

      <div style="margin-top: 16px;">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required placeholder="seu@email.com" value="<?=e($_POST['email'] ?? '')?>">
      </div>

      <div style="margin-top: 16px;">
        <label for="telefone">Telefone (Opcional)</label>
        <input id="telefone" name="telefone" type="tel" placeholder="(11) 98765-4321" value="<?=e($_POST['telefone'] ?? '')?>">
      </div>

      <div style="margin-top: 16px;">
        <label for="senha">Senha</label>
        <input id="senha" name="senha" type="password" required placeholder="Mínimo 6 caracteres">
      </div>

      <div style="margin-top: 16px;">
        <label for="confirma_senha">Confirmar Senha</label>
        <input id="confirma_senha" name="confirma_senha" type="password" required placeholder="Repita sua senha">
      </div>

      <button class="btn" type="submit" style="width: 100%; margin-top: 30px; padding: 12px; font-size: 16px; font-weight: 700;">
        Criar Conta
      </button>
    </form>

    <div style="text-align: center; margin-top: 30px; padding-top: 30px; border-top: 1px solid var(--border-gray);">
      <p style="color: var(--text-secondary); font-size: 14px;">
        Já tem conta? <a href="login.php" style="color: var(--accent-red); font-weight: 700;">Fazer login</a>
      </p>
    </div>
  </div>

</body>
</html>