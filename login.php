<?php
require __DIR__ . '/config/conexao.php';
if(!empty($_SESSION['user'])){ header('Location: /projeto-web/index.php'); exit; }

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

// Mensagens de erro de login
$erro = '';
switch($_GET['erro'] ?? '') {
    case 'naoencontrado':
        $erro = 'Usuário não encontrado. Verifique o email digitado ou crie uma conta.';
        break;
    case 'senha':
        $erro = 'Senha incorreta. Tente novamente.';
        break;
    case 'dados':
        $erro = 'Preencha um email válido e a senha.';
        break;
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login - AutoMax</title>
  <link rel="stylesheet" href="/projeto-web/css/style.css">
</head>
<body style="background: linear-gradient(135deg, var(--navy) 0%, #00254D 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center;">
  
  <div style="background: var(--white); padding: 50px; border-radius: 4px; width: 100%; max-width: 420px; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
    <div style="text-align: center; margin-bottom: 40px;">
      <h1 style="font-size: 32px; margin-bottom: 10px; color: var(--navy); font-weight: 800;">AutoMax</h1>
      <p style="color: var(--text-secondary); margin: 0; font-size: 14px;">Concessionária de Carros Premium</p>
    </div>

    <h2 style="text-align: center; margin-bottom: 30px; font-size: 24px; color: var(--navy);">Entrar na Conta</h2>

    <?php if($erro): ?>
      <div class="alert alert-error">
        <?=e($erro)?>
      </div>
    <?php endif; ?>

    <form action="autenticar.php" method="post">
      <div>
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required placeholder="seu@email.com" value="<?=e($_GET['email'] ?? '')?>">
      </div>

      <div style="margin-top: 20px;">
        <label for="senha">Senha</label>
        <input id="senha" name="senha" type="password" required placeholder="Sua senha">
      </div>

      <button class="btn" type="submit" style="width: 100%; margin-top: 30px; padding: 12px; font-size: 16px; font-weight: 700;">
        Entrar
      </button>
    </form>

    <div style="text-align: center; margin-top: 30px; padding-top: 30px; border-top: 1px solid var(--border-gray);">
      <p style="color: var(--text-secondary); margin-bottom: 15px; font-size: 14px;">Não tem conta?</p>
      <a href="registrar.php" class="btn btn-secondary" style="width: 100%; padding: 12px; display: block;">
        Criar Conta
      </a>
    </div>

    <div style="background: var(--light-gray); padding: 16px; border-radius: 4px; margin-top: 25px; font-size: 13px; color: var(--text-secondary);">
      <strong>Teste com:</strong><br>
      Email: admin@carros.com<br>
      Senha: admin123
    </div>
  </div>

</body>
</html>