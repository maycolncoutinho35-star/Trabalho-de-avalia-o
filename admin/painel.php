<?php
require __DIR__ . '/../config/conexao.php';
require_admin();

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

// contagens
$uCount = $pdo->query('SELECT COUNT(*) AS c FROM usuarios')->fetchColumn();
$pCount = $pdo->query('SELECT COUNT(*) AS c FROM produtos')->fetchColumn();
$uAdmin = $pdo->query('SELECT COUNT(*) AS c FROM usuarios WHERE nivel_acesso = "admin"')->fetchColumn();
$dCount = $pdo->query('SELECT COUNT(*) AS c FROM produtos WHERE disponivel = 1')->fetchColumn();
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Painel Administrativo - AutoMax</title>
  <link rel="stylesheet" href="/projeto-web/css/style.css">
</head>
<body>
  <header class="navbar">
    <div class="container">
      <div class="brand">AutoMax - Admin</div>
      <nav class="nav-links">
        <span style="color:#fff; font-size: 14px;">
          <?=e($_SESSION['user']['nome'])?>
        </span>
        <a href="/projeto-web/index.php" style="font-size: 14px;">Voltar ao Site</a>
        <a href="/projeto-web/logout.php" class="btn btn-secondary" style="padding: 8px 16px; font-size: 14px; color: #ffffff; border-color: #ffffff; background: transparent;">Sair</a>
      </nav>
    </div>
  </header>

  <div class="admin-header">
    <div class="container">
      <h1>Painel Administrativo</h1>
      <p style="color: rgba(255,255,255,0.8); margin: 10px 0 0 0; font-size: 16px;">Bem-vindo, <?=e($_SESSION['user']['nome'])?>!</p>
    </div>
  </div>

  <div class="container" style="padding-top: 40px; padding-bottom: 40px;">
    <!-- ESTATÍSTICAS -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 50px;">
      
      <div style="background: rgba(255, 255, 255, 0.95); padding: 25px; border-radius: 8px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); border-left: 4px solid var(--accent-red);">
        <div style="font-size: 14px; color: var(--text-secondary); margin-bottom: 10px;">Total de Carros</div>
        <div style="font-size: 36px; font-weight: 800; color: var(--accent-red);"><?=$pCount?></div>
        <a href="/projeto-web/admin/produtos.php" style="color: var(--accent-red); font-size: 13px; margin-top: 10px; display: block; font-weight: 600;">Gerenciar carros →</a>
      </div>

      <div style="background: rgba(255, 255, 255, 0.95); padding: 25px; border-radius: 8px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); border-left: 4px solid var(--accent-blue);">
        <div style="font-size: 14px; color: var(--text-secondary); margin-bottom: 10px;">Total de Usuários</div>
        <div style="font-size: 36px; font-weight: 800; color: var(--accent-blue);"><?=$uCount?></div>
        <a href="/projeto-web/admin/usuarios.php" style="color: var(--accent-blue); font-size: 13px; margin-top: 10px; display: block; font-weight: 600;">Gerenciar usuários →</a>
      </div>

      <div style="background: rgba(255, 255, 255, 0.95); padding: 25px; border-radius: 8px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); border-left: 4px solid #FF9800;">
        <div style="font-size: 14px; color: var(--text-secondary); margin-bottom: 10px;">Administradores</div>
        <div style="font-size: 36px; font-weight: 800; color: #FF9800;"><?=$uAdmin?></div>
        <p style="font-size: 12px; color: var(--text-secondary); margin-top: 10px;">Contas admin ativas</p>
      </div>

      <div style="background: rgba(255, 255, 255, 0.95); padding: 25px; border-radius: 8px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); border-left: 4px solid #4CAF50;">
        <div style="font-size: 14px; color: var(--text-secondary); margin-bottom: 10px;">Carros Disponíveis</div>
        <div style="font-size: 36px; font-weight: 800; color: #4CAF50;"><?=$dCount?></div>
        <p style="font-size: 12px; color: var(--text-secondary); margin-top: 10px;">Prontos para venda</p>
      </div>

    </div>

    <!-- AÇÕES RÁPIDAS -->
    <h2 class="section-title-light" style="margin-top: 0; margin-bottom: 24px; text-align: center;">Ações Rápidas</h2>
    
    <div class="admin-nav" style="margin-bottom: 50px; justify-content: center;">
      <a href="/projeto-web/admin/produtos.php?acao=adicionar">Adicionar Novo Carro</a>
      <a href="/projeto-web/admin/usuarios.php?acao=adicionar">Novo Usuário</a>
      <a href="/projeto-web/admin/produtos.php">Gerenciar Carros</a>
      <a href="/projeto-web/admin/usuarios.php">Gerenciar Usuários</a>
    </div>

    <!-- INFORMAÇÕES -->
    <div style="background: rgba(255, 255, 255, 0.95); padding: 25px; border-radius: 8px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2); margin-bottom: 50px; border: none;">
      <h3 style="margin-top: 0; margin-bottom: 20px;">Informações do Sistema</h3>
      <ul style="list-style: none; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <li style="padding: 0;">
          <strong style="color: var(--navy);">Versão PHP:</strong>
          <p style="margin: 5px 0 0 0; color: var(--text-secondary);"><?=phpversion()?></p>
        </li>
        <li style="padding: 0;">
          <strong style="color: var(--navy);">Banco de Dados:</strong>
          <p style="margin: 5px 0 0 0; color: var(--text-secondary);">projeto_web (MySQL)</p>
        </li>
        <li style="padding: 0;">
          <strong style="color: var(--navy);">Data/Hora:</strong>
          <p style="margin: 5px 0 0 0; color: var(--text-secondary);"><?=date('d/m/Y H:i:s')?></p>
        </li>
        <li style="padding: 0;">
          <strong style="color: var(--navy);">URL do Site:</strong>
          <p style="margin: 5px 0 0 0; color: var(--text-secondary);">/projeto-web/</p>
        </li>
      </ul>
    </div>

    <!-- TABELA RECENTES -->
    <h2 class="section-title-light" style="margin: 50px 0 24px 0; text-align: center;">Carros Adicionados Recentemente</h2>
    
    <div class="table-responsive">
      <table>
        <thead>
          <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Adicionado em</th>
            <th>Status</th>
            <th>Ação</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $recentStmt = $pdo->query('SELECT * FROM produtos ORDER BY data_cadastro DESC LIMIT 5');
            $recentes = $recentStmt->fetchAll();
            if(count($recentes) > 0):
              foreach($recentes as $p): 
          ?>
            <tr>
              <td><?=e($p['nome'])?></td>
              <td>R$ <?=number_format((float)$p['preco'], 2, ',', '.')?></td>
              <td><?=date('d/m/Y H:i', strtotime($p['data_cadastro']))?></td>
              <td>
                <?php if($p['disponivel']): ?>
                  <span class="badge-success">Disponível</span>
                <?php else: ?>
                  <span class="badge-danger">Indisponível</span>
                <?php endif; ?>
              </td>
              <td><a href="/projeto-web/admin/produtos.php?acao=editar&id=<?=$p['id']?>" class="btn btn-small">Editar</a></td>
            </tr>
          <?php 
              endforeach;
            else:
          ?>
            <tr><td colspan="5" style="text-align: center; padding: 20px;">Nenhum carro cadastrado</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </div>

  <script src="/projeto-web/js/main.js"></script>
</body>
</html>
