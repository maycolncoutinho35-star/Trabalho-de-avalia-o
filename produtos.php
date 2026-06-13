<?php
require __DIR__ . '/config/conexao.php';

// Buscar todos os produtos
try {
    $stmt = $pdo->query('SELECT * FROM produtos WHERE disponivel = 1 ORDER BY data_cadastro DESC');
    $produtos = $stmt->fetchAll();
} catch(Exception $e) { 
    $produtos = []; 
}

function e($s) { 
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); 
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Nossos Carros - AutoMax</title>
  <link rel="stylesheet" href="/projeto-web/css/style.css">
</head>
<body>
  <!-- NAVBAR -->
  <header class="navbar">
    <div class="container">
      <div class="brand">AutoMax</div>
      <button class="nav-toggle">☰</button>
      <nav class="nav-links">
        <a href="/projeto-web/index.php">Home</a>
        <a href="/projeto-web/produtos.php">Nossos Carros</a>
        <a href="/projeto-web/sobre.php">Sobre</a>
        <?php if(!empty($_SESSION['user'])): ?>
          <span style="background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 4px; font-size: 14px;">
            <?=e($_SESSION['user']['nome'])?>
          </span>
          <?php if($_SESSION['user']['nivel_acesso'] === 'admin'): ?>
            <a href="/projeto-web/admin/painel.php" style="background: rgba(255,255,255,0.3); padding: 8px 16px; border-radius: 4px; font-weight: 600;">Admin</a>
          <?php endif; ?>
          <a href="/projeto-web/logout.php" class="btn btn-secondary" style="padding: 8px 16px; font-size: 14px; color: #ffffff; border-color: #ffffff; background: transparent;">Sair</a>
        <?php else: ?>
          <a href="/projeto-web/login.php" class="btn" style="padding: 8px 16px; font-size: 14px;">Login</a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <!-- HERO SECTION -->
  <section class="hero" style="padding: 80px 16px;">
    <div class="container">
      <h1>Nossos Carros</h1>
      <p>Selecione o veículo ideal entre nossa ampla frota de qualidade</p>
    </div>
  </section>

  <main class="container" style="padding: 60px 0;">
    <!-- FILTRO -->
    <div style="margin-bottom: 40px; text-align: center; background: rgba(255, 255, 255, 0.95); padding: 30px; border-radius: 8px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
      <input type="text" id="search-input" placeholder="Buscar por marca, modelo ou características..." 
             style="width: 100%; max-width: 500px; padding: 14px; border: 1px solid #D0D0D0; border-radius: 4px; font-size: 14px;">
    </div>

    <!-- GRID DE PRODUTOS -->
    <div class="grid">
      <?php if(count($produtos) > 0): ?>
        <?php foreach($produtos as $p): ?>
          <div class="card" data-searchable="<?=e(strtolower($p['nome'] . ' ' . $p['marca'] . ' ' . $p['modelo'] . ' ' . $p['combustivel']))?>">
            <img src="<?=e($p['imagem_url'] ?: 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?w=500')?>" alt="<?=e($p['nome'])?>">
            
            <div class="card-body">
              <h3><?=e($p['nome'])?></h3>
              
              <div class="card-specs">
                <div><strong><?=e($p['ano'])?></strong></div>
                <div><?=e($p['combustivel'])?></div>
                <div><?=e(number_format($p['quilometragem'], 0, ',', '.'))?> km</div>
                <div><?=e($p['cambio'])?></div>
              </div>
              
              <p><?=e($p['descricao'])?></p>
              
              <div class="card-footer">
                <span class="price">R$ <?=e(number_format((float)$p['preco'], 0, ',', '.'))?></span>
                <a href="#" class="btn btn-small" onclick="alert('Entre em contato conosco para mais informações!'); return false;">Detalhes</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="grid-column: 1/-1; text-align: center; color: #666; padding: 60px 20px;">
          Nenhum carro disponível no momento. Volte em breve!
        </p>
      <?php endif; ?>
    </div>

    <!-- AVISO DE BUSCA VAZIA -->
    <div id="no-results" style="display: none; text-align: center; padding: 60px 20px; grid-column: 1/-1;">
      <p style="color: #999; font-size: 16px;">Nenhum carro encontrado com essa busca.</p>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="footer-section">
          <h4>AutoMax</h4>
          <p>Concessionária Premium de Veículos com Excelência em Atendimento e Qualidade.</p>
        </div>
        <div class="footer-section">
          <h4>Links</h4>
          <a href="/projeto-web/index.php">Home</a>
          <a href="/projeto-web/produtos.php">Nossos Carros</a>
          <a href="/projeto-web/sobre.php">Sobre</a>
          <a href="/projeto-web/login.php">Login</a>
        </div>
        <div class="footer-section">
          <h4>Contato</h4>
          <p><strong>Telefone:</strong><br>(11) 3000-0000</p>
          <p><strong>Email:</strong><br>contato@automax.com.br</p>
        </div>
        <div class="footer-section">
          <h4>Horário</h4>
          <p><strong>Segunda a Sexta:</strong><br>9:00 - 18:00</p>
          <p><strong>Sábado:</strong><br>9:00 - 14:00</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; <?=date('Y')?> AutoMax. Todos os direitos reservados.</p>
      </div>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.getElementById('search-input');
      const cards = document.querySelectorAll('.card');
      const noResults = document.getElementById('no-results');

      if(searchInput) {
        searchInput.addEventListener('keyup', function() {
          const term = this.value.toLowerCase();
          let visibleCount = 0;

          cards.forEach(card => {
            const searchable = card.getAttribute('data-searchable');
            if(searchable.includes(term)) {
              card.style.display = 'block';
              visibleCount++;
            } else {
              card.style.display = 'none';
            }
          });

          noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        });
      }

      // Menu toggle mobile
      const toggle = document.querySelector('.nav-toggle');
      const links = document.querySelector('.nav-links');
      
      if(toggle) {
        toggle.addEventListener('click', function() {
          if(links) {
            links.classList.toggle('active');
          }
        });
      }
    });
  </script>
</body>
</html>
