<?php
require __DIR__ . '/../config/conexao.php';
require_admin();

$acao = $_GET['acao'] ?? 'listar';
$id = (int)($_GET['id'] ?? 0);
$msg = '';
$tipo_msg = '';

// ADICIONAR
if($_SERVER['REQUEST_METHOD'] === 'POST' && $acao === 'adicionar') {
    $nome = trim($_POST['nome'] ?? '');
    $marca = trim($_POST['marca'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $ano = (int)($_POST['ano'] ?? 0);
    $quilometragem = (int)($_POST['quilometragem'] ?? 0);
    $combustivel = $_POST['combustivel'] ?? 'Gasolina';
    $cambio = $_POST['cambio'] ?? 'Automático';
    $cor = trim($_POST['cor'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = (float)($_POST['preco'] ?? 0);
    $imagem_url = trim($_POST['imagem_url'] ?? '');

    if($nome && $marca && $modelo && $ano && $preco) {
        try {
            $stmt = $pdo->prepare('INSERT INTO produtos (nome, marca, modelo, ano, quilometragem, combustivel, cambio, cor, descricao, preco, imagem_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$nome, $marca, $modelo, $ano, $quilometragem, $combustivel, $cambio, $cor, $descricao, $preco, $imagem_url]);
            $msg = 'Carro adicionado com sucesso!';
            $tipo_msg = 'sucesso';
            $acao = 'listar';
        } catch(Exception $e) {
            $msg = 'Erro ao adicionar carro.';
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
    $marca = trim($_POST['marca'] ?? '');
    $modelo = trim($_POST['modelo'] ?? '');
    $ano = (int)($_POST['ano'] ?? 0);
    $quilometragem = (int)($_POST['quilometragem'] ?? 0);
    $combustivel = $_POST['combustivel'] ?? 'Gasolina';
    $cambio = $_POST['cambio'] ?? 'Automático';
    $cor = trim($_POST['cor'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $preco = (float)($_POST['preco'] ?? 0);
    $imagem_url = trim($_POST['imagem_url'] ?? '');
    $disponivel = isset($_POST['disponivel']) ? 1 : 0;

    if($id && $nome && $marca && $modelo && $ano && $preco) {
        try {
            $stmt = $pdo->prepare('UPDATE produtos SET nome=?, marca=?, modelo=?, ano=?, quilometragem=?, combustivel=?, cambio=?, cor=?, descricao=?, preco=?, imagem_url=?, disponivel=? WHERE id=?');
            $stmt->execute([$nome, $marca, $modelo, $ano, $quilometragem, $combustivel, $cambio, $cor, $descricao, $preco, $imagem_url, $disponivel, $id]);
            $msg = 'Carro atualizado com sucesso!';
            $tipo_msg = 'sucesso';
            $acao = 'listar';
        } catch(Exception $e) {
            $msg = 'Erro ao atualizar carro.';
            $tipo_msg = 'erro';
        }
    }
}

// DELETAR
if($_SERVER['REQUEST_METHOD'] === 'POST' && $acao === 'deletar') {
    if($id) {
        try {
            $stmt = $pdo->prepare('DELETE FROM produtos WHERE id=?');
            $stmt->execute([$id]);
            $msg = 'Carro deletado com sucesso!';
            $tipo_msg = 'sucesso';
            $acao = 'listar';
        } catch(Exception $e) {
            $msg = 'Erro ao deletar carro.';
            $tipo_msg = 'erro';
        }
    }
}

// Buscar produto para editar
$produto_editando = null;
if($acao === 'editar' && $id) {
    $stmt = $pdo->prepare('SELECT * FROM produtos WHERE id=?');
    $stmt->execute([$id]);
    $produto_editando = $stmt->fetch();
    if(!$produto_editando) {
        $acao = 'listar';
    }
}

// LISTAR (executado por último, já refletindo qualquer INSERT/UPDATE/DELETE acima)
$stmt = $pdo->query('SELECT * FROM produtos ORDER BY data_cadastro DESC');
$produtos = $stmt->fetchAll();

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Gerenciar Produtos - AutoMax</title>
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
      <h1>Gerenciar Carros</h1>
      <div class="admin-nav">
        <a href="/projeto-web/admin/painel.php">← Voltar ao Painel</a>
        <a href="/projeto-web/admin/produtos.php?acao=adicionar">+ Adicionar Carro</a>
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
          <label for="nome">Nome (ex: Hyundai HB20 2023) *</label>
          <input id="nome" name="nome" required value="<?=$produto_editando ? e($produto_editando['nome']) : ''?>">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
          <div>
            <label for="marca">Marca *</label>
            <input id="marca" name="marca" required value="<?=$produto_editando ? e($produto_editando['marca']) : ''?>">
          </div>
          <div>
            <label for="modelo">Modelo *</label>
            <input id="modelo" name="modelo" required value="<?=$produto_editando ? e($produto_editando['modelo']) : ''?>">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
          <div>
            <label for="ano">Ano *</label>
            <input id="ano" name="ano" type="number" required min="1980" max="<?=date('Y')+1?>" value="<?=$produto_editando ? e($produto_editando['ano']) : ''?>">
          </div>
          <div>
            <label for="quilometragem">Quilometragem (km)</label>
            <input id="quilometragem" name="quilometragem" type="number" min="0" value="<?=$produto_editando ? e($produto_editando['quilometragem']) : '0'?>">
          </div>
          <div>
            <label for="cor">Cor</label>
            <input id="cor" name="cor" value="<?=$produto_editando ? e($produto_editando['cor']) : ''?>">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
          <div>
            <label for="combustivel">Combustível</label>
            <select id="combustivel" name="combustivel">
              <option value="Gasolina" <?=$produto_editando && $produto_editando['combustivel'] === 'Gasolina' ? 'selected' : ''?>>Gasolina</option>
              <option value="Diesel" <?=$produto_editando && $produto_editando['combustivel'] === 'Diesel' ? 'selected' : ''?>>Diesel</option>
              <option value="Flex" <?=$produto_editando && $produto_editando['combustivel'] === 'Flex' ? 'selected' : ''?>>Flex</option>
              <option value="Elétrico" <?=$produto_editando && $produto_editando['combustivel'] === 'Elétrico' ? 'selected' : ''?>>Elétrico</option>
              <option value="Híbrido" <?=$produto_editando && $produto_editando['combustivel'] === 'Híbrido' ? 'selected' : ''?>>Híbrido</option>
            </select>
          </div>
          <div>
            <label for="cambio">Câmbio</label>
            <select id="cambio" name="cambio">
              <option value="Manual" <?=$produto_editando && $produto_editando['cambio'] === 'Manual' ? 'selected' : ''?>>Manual</option>
              <option value="Automático" <?=$produto_editando && $produto_editando['cambio'] === 'Automático' ? 'selected' : ''?>>Automático</option>
            </select>
          </div>
        </div>

        <div>
          <label for="preco">Preço (R$) *</label>
          <input id="preco" name="preco" type="number" required step="0.01" min="0" value="<?=$produto_editando ? e($produto_editando['preco']) : ''?>">
        </div>

        <div>
          <label for="imagem_url">URL da Imagem</label>
          <input id="imagem_url" name="imagem_url" placeholder="https://..." value="<?=$produto_editando ? e($produto_editando['imagem_url']) : ''?>">
        </div>

        <div>
          <label for="descricao">Descrição</label>
          <textarea id="descricao" name="descricao" style="height: 120px;"><?=$produto_editando ? e($produto_editando['descricao']) : ''?></textarea>
        </div>

        <?php if($acao === 'editar'): ?>
          <div style="display: flex; gap: 10px; align-items: center;">
            <input id="disponivel" name="disponivel" type="checkbox" <?=$produto_editando && $produto_editando['disponivel'] ? 'checked' : ''?>>
            <label for="disponivel" style="margin: 0;">Disponível para compra</label>
          </div>
        <?php endif; ?>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 20px;">
          <a href="/projeto-web/admin/produtos.php" class="btn btn-secondary" style="text-align: center;">Cancelar</a>
          <button class="btn" type="submit"><?=$acao === 'adicionar' ? 'Adicionar Carro' : 'Atualizar Carro'?></button>
        </div>
      </form>

    <?php else: ?>
      <!-- LISTAGEM -->
      <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th>Nome</th>
              <th>Marca/Modelo</th>
              <th>Ano</th>
              <th>Preço</th>
              <th>Combustível</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($produtos as $p): ?>
              <tr>
                <td><?=e($p['nome'])?></td>
                <td><?=e($p['marca'])?> / <?=e($p['modelo'])?></td>
                <td><?=e($p['ano'])?></td>
                <td>R$ <?=number_format((float)$p['preco'], 2, ',', '.')?></td>
                <td><?=e($p['combustivel'])?></td>
                <td>
                  <?php if($p['disponivel']): ?>
                    <span style="background: #efe; color: #3c3; padding: 4px 8px; border-radius: 4px; font-weight: 600;">Disponível</span>
                  <?php else: ?>
                    <span style="background: #fee; color: #c33; padding: 4px 8px; border-radius: 4px; font-weight: 600;">Indisponível</span>
                  <?php endif; ?>
                </td>
                <td>
                <div style="display: flex; gap: 6px; align-items: center;">
                  <a href="/projeto-web/admin/produtos.php?acao=editar&id=<?=$p['id']?>" 
                    class="btn btn-small">Editar</a>
                  <form method="post" 
                        action="/projeto-web/admin/produtos.php?acao=deletar&id=<?=$p['id']?>"
                        style="margin: 0; padding: 0; background: none; box-shadow: none;"
                        onsubmit="return confirm('Tem certeza que deseja deletar este carro?');">
                    <button class="btn btn-small btn-delete" type="submit">Deletar</button>
                  </form>
                </div>
              </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <?php if(empty($produtos)): ?>
        <div style="text-align: center; padding: 40px; background: #fff; border-radius: 8px;">
          <p style="color: #666; font-size: 18px;">Nenhum carro cadastrado ainda.</p>
          <a href="/projeto-web/admin/produtos.php?acao=adicionar" class="btn" style="margin-top: 15px;">+ Adicionar o Primeiro Carro</a>
        </div>
      <?php endif; ?>

    <?php endif; ?>
  </div>

  <script src="/projeto-web/js/main.js"></script>
</body>
</html>
