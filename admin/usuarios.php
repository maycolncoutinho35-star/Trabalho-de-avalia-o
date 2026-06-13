<?php
require __DIR__ . '/../config/conexao.php';
require_admin();

$acao = $_GET['acao'] ?? 'listar';
$id = (int)($_GET['id'] ?? 0);
$msg = '';
$tipo_msg = '';

// LISTAR
$stmt = $pdo->query('SELECT * FROM usuarios ORDER BY criado_em DESC');
$usuarios = $stmt->fetchAll();

// ADICIONAR
if($_SERVER['REQUEST_METHOD'] === 'POST' && $acao === 'adicionar') {
    $nome = trim($_POST['nome'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $senha = $_POST['senha'] ?? '';
    $telefone = trim($_POST['telefone'] ?? '');
    $nivel = in_array($_POST['nivel'] ?? '', ['admin', 'cliente']) ? $_POST['nivel'] : 'cliente';

    if($nome && $email && $senha) {
        try {
            $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = ?');
            $stmt->execute([$email]);
            if($stmt->fetch()) {
                $msg = 'Este email já está registrado!';
                $tipo_msg = 'erro';
            } else {
                $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha, telefone, nivel_acesso) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([$nome, $email, $senha, $telefone, $nivel]);
                $msg = 'Usuário adicionado com sucesso!';
                $tipo_msg = 'sucesso';
                $acao = 'listar';
            }
        } catch(Exception $e) {
            $msg = 'Erro ao adicionar usuário.';
            $tipo_msg = 'erro';
        }
    } else {
        $msg = 'Preencha todos os campos obrigatórios!';
        $tipo_msg = 'erro';
    }
}

// EDITAR
if($_SERVER['REQUEST_METHOD'] === 'POST' && $acao === 'editar') {
    $nome = trim($_POST['nome'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $telefone = trim($_POST['telefone'] ?? '');
    $nivel = in_array($_POST['nivel'] ?? '', ['admin', 'cliente']) ? $_POST['nivel'] : 'cliente';
    $senha = $_POST['senha'] ?? '';

    if($id && $nome && $email) {
        try {
            if($senha) {
                $stmt = $pdo->prepare('UPDATE usuarios SET nome=?, email=?, telefone=?, nivel_acesso=?, senha=? WHERE id=?');
                $stmt->execute([$nome, $email, $telefone, $nivel, $senha, $id]);
            } else {
                $stmt = $pdo->prepare('UPDATE usuarios SET nome=?, email=?, telefone=?, nivel_acesso=? WHERE id=?');
                $stmt->execute([$nome, $email, $telefone, $nivel, $id]);
            }
            $msg = 'Usuário atualizado com sucesso!';
            $tipo_msg = 'sucesso';
            $acao = 'listar';
        } catch(Exception $e) {
            $msg = 'Erro ao atualizar usuário.';
            $tipo_msg = 'erro';
        }
    }
}

// DELETAR
if($_SERVER['REQUEST_METHOD'] === 'POST' && $acao === 'deletar') {
    if($id) {
        try {
            $stmt = $pdo->prepare('DELETE FROM usuarios WHERE id=?');
            $stmt->execute([$id]);
            $msg = 'Usuário deletado com sucesso!';
            $tipo_msg = 'sucesso';
            $acao = 'listar';
        } catch(Exception $e) {
            $msg = 'Erro ao deletar usuário.';
            $tipo_msg = 'erro';
        }
    }
}

// Buscar usuário para editar
$usuario_editando = null;
if($acao === 'editar' && $id) {
    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE id=?');
    $stmt->execute([$id]);
    $usuario_editando = $stmt->fetch();
    if(!$usuario_editando) {
        $acao = 'listar';
    }
}

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Gerenciar Usuários - AutoMax</title>
  <link rel="stylesheet" href="/projeto-web/css/style.css">
</head>
<body>
  <header class="navbar">
    <div class="container">
      <div class="brand">AutoMax - Admin</div>
      <nav class="nav-links">
        <span style="color:#fff">Olá, <?=e($_SESSION['user']['nome'])?></span>
        <a href="/projeto-web/admin/painel.php">Painel</a>
        <a href="/projeto-web/logout.php" class="btn btn-secondary" style="padding: 8px 16px; font-size: 14px; color: #ffffff; border-color: #ffffff; background: transparent;">Sair</a>
      </nav>
    </div>
  </header>

  <div class="admin-header">
    <div class="container">
      <h1>Gerenciar Usuários</h1>
      <div class="admin-nav">
        <a href="/projeto-web/admin/painel.php">← Voltar ao Painel</a>
        <a href="/projeto-web/admin/usuarios.php?acao=adicionar">+ Adicionar Usuário</a>
      </div>
    </div>
  </div>

  <div class="container">
    <?php if($msg): ?>
      <div class="alert alert-<?=$tipo_msg === 'sucesso' ? 'success' : 'error'?>">
        <?=e($msg)?>
      </div>
    <?php endif; ?>

    <?php if($acao === 'adicionar' || $acao === 'editar'): ?>
      <!-- FORMULÁRIO -->
      <form method="post" style="max-width: 600px; margin: 0 auto;">
        <input type="hidden" name="id" value="<?=$id?>">

        <div>
          <label for="nome">Nome Completo *</label>
          <input id="nome" name="nome" required value="<?=$usuario_editando ? e($usuario_editando['nome']) : ''?>">
        </div>

        <div style="margin-top: 16px;">
          <label for="email">Email *</label>
          <input id="email" name="email" type="email" required value="<?=$usuario_editando ? e($usuario_editando['email']) : ''?>">
        </div>

        <div style="margin-top: 16px;">
          <label for="telefone">Telefone</label>
          <input id="telefone" name="telefone" placeholder="(11) 98765-4321" value="<?=$usuario_editando ? e($usuario_editando['telefone']) : ''?>">
        </div>

        <div style="margin-top: 16px;">
          <label for="senha">Senha <?=$acao === 'editar' ? '(deixe em branco para manter)' : '*'?></label>
          <input id="senha" name="senha" type="password" <?=$acao === 'adicionar' ? 'required' : ''?> placeholder="<?=$acao === 'adicionar' ? 'Mínimo 6 caracteres' : 'Nova senha (opcional)'?>">
        </div>

        <div style="margin-top: 16px;">
          <label for="nivel">👨‍💼 Nível de Acesso</label>
          <select id="nivel" name="nivel">
            <option value="cliente" <?=$usuario_editando && $usuario_editando['nivel_acesso'] === 'cliente' ? 'selected' : ''?>>Cliente</option>
            <option value="admin" <?=$usuario_editando && $usuario_editando['nivel_acesso'] === 'admin' ? 'selected' : ''?>>Administrador</option>
          </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 20px;">
          <a href="/projeto-web/admin/usuarios.php" class="btn btn-secondary" style="text-align: center;">Cancelar</a>
          <button class="btn" type="submit"><?=$acao === 'adicionar' ? 'Criar Usuário' : 'Atualizar Usuário'?></button>
        </div>
      </form>

    <?php else: ?>
      <!-- LISTAGEM -->
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th>Nome</th>
              <th>Email</th>
              <th>Telefone</th>
              <th>Nível</th>
              <th>Data de Registro</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($usuarios as $u): ?>
              <tr>
                <td><?=e($u['nome'])?></td>
                <td><?=e($u['email'])?></td>
                <td><?=e($u['telefone'] ?: '-')?></td>
                <td>
                  <?php if($u['nivel_acesso'] === 'admin'): ?>
                    <span class="badge-admin">Admin</span>
                  <?php else: ?>
                    <span class="badge-client">Cliente</span>
                  <?php endif; ?>
                </td>
                <td><?=date('d/m/Y', strtotime($u['criado_em']))?></td>
                <td>
                  <div style="display: flex; gap: 6px; align-items: center;">
                    <a href="/projeto-web/admin/usuarios.php?acao=editar&id=<?=$u['id']?>" class="btn btn-small">Editar</a>
                    <form method="post" action="/projeto-web/admin/usuarios.php?acao=deletar&id=<?=$u['id']?>"
                          style="margin: 0; padding: 0; background: none; box-shadow: none;"
                          onsubmit="return confirm('Tem certeza que deseja deletar este usuário?');">
                      <button class="btn btn-small btn-delete" type="submit">Deletar</button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <?php if(empty($usuarios)): ?>
        <div style="text-align: center; padding: 40px; background: #fff; border-radius: 8px;">
          <p style="color: #666; font-size: 18px;">Nenhum usuário cadastrado.</p>
          <a href="/projeto-web/admin/usuarios.php?acao=adicionar" class="btn" style="margin-top: 15px;">+ Adicionar Usuário</a>
        </div>
      <?php endif; ?>

    <?php endif; ?>
  </div>

  <script src="/projeto-web/js/main.js"></script>
</body>
</html>
</body>
</html>
