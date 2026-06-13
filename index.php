<?php
require __DIR__ . '/config/conexao.php';

// Buscar alguns produtos em destaque
try {
    $stmt = $pdo->query('SELECT * FROM produtos WHERE disponivel = 1 ORDER BY data_cadastro DESC LIMIT 6');
    $produtos_destaque = $stmt->fetchAll();
} catch(Exception $e) { 
    $produtos_destaque = []; 
}

// Buscar carros para o carrossel (os 5 mais recentes com imagem)
try {
    $stmt = $pdo->query("SELECT * FROM produtos WHERE disponivel = 1 AND imagem_url <> '' ORDER BY data_cadastro DESC LIMIT 5");
    $produtos_carrossel = $stmt->fetchAll();
} catch(Exception $e) {
    $produtos_carrossel = [];
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
  <title>AutoMax - Concessionária de Carros Premium</title>
  <link rel="stylesheet" href="/projeto-web/css/style.css">
</head>
<body>
  <?php
    $feedback = '';
    if(isset($_GET['bemvindo']) && !empty($_SESSION['user'])) {
        $feedback = 'Conta criada com sucesso! Bem-vindo(a), ' . e($_SESSION['user']['nome']) . '!';
    } elseif(isset($_GET['login']) && !empty($_SESSION['user'])) {
        $feedback = 'Login realizado com sucesso! Bem-vindo(a) de volta, ' . e($_SESSION['user']['nome']) . '!';
    }
  ?>
  <?php if($feedback): ?>
    <div class="container" style="padding-top: 16px;">
      <div class="alert alert-success" style="margin-bottom: 0;">
        <?=$feedback?>
      </div>
    </div>
  <?php endif; ?>
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
  <section class="hero">
    <div class="container">
      <h1>Encontre o Carro Perfeito Para Você</h1>
      <p>Seleção exclusiva de veículos premium com as melhores condições do mercado</p>
      <a href="/projeto-web/produtos.php" class="btn">Ver Catálogo Completo</a>
    </div>
  </section>

  <!-- CARROSSEL DE IMAGENS -->
  <div class="container">
    <div class="carousel">
      <?php if(count($produtos_carrossel) > 0): ?>
        <?php foreach($produtos_carrossel as $i => $p): ?>
          <div class="carousel-item">
            <img src="<?=e($p['imagem_url'] ?: 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?w=1200')?>" alt="<?=e($p['nome'])?>">
            <div class="carousel-caption">
              <h3><?=e($p['nome'])?></h3>
              <span class="price">R$ <?=e(number_format((float)$p['preco'], 0, ',', '.'))?></span>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="carousel-item">
          <img src="https://images.unsplash.com/photo-1552820728-8ac41f1ce891?w=1200" alt="AutoMax">
          <div class="carousel-caption">
            <h3>Bem-vindo à AutoMax</h3>
          </div>
        </div>
      <?php endif; ?>

      <div class="controls">
        <button class="carousel-prev" aria-label="Anterior">‹</button>
        <button class="carousel-next" aria-label="Próximo">›</button>
      </div>
    </div>
  </div>

  <main>
    <!-- DESTAQUE DE CARROS -->
    <div class="container">
      <div class="destaques-section" style="background: rgba(255,255,255,0.95); padding: 40px; border-radius: 8px;">
        <h2 style="color: var(--navy);">Destaques da Nossa Frota</h2>
      
      <div class="grid">
        <?php if(count($produtos_destaque) > 0): ?>
          <?php foreach($produtos_destaque as $p): ?>
            <div class="card">
              <img src="<?=e($p['imagem_url'] ?: 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?w=500')?>" alt="<?=e($p['nome'])?>">
              
              <div class="card-body">
                <h3><?=e($p['nome'])?></h3>
                
                <div class="card-specs">
                  <div><span><?=e($p['ano'])?></span></div>
                  <div><span><?=e($p['combustivel'])?></span></div>
                  <div><span><?=e(number_format($p['quilometragem'], 0, ',', '.'))?> km</span></div>
                  <div><span><?=e($p['cambio'])?></span></div>
                </div>
                
                <p><?=e(substr($p['descricao'], 0, 100))?></p>
                
                <div class="card-footer">
                  <span class="price">R$ <?=e(number_format((float)$p['preco'], 0, ',', '.'))?></span>
                  <a href="/projeto-web/produtos.php" class="btn btn-small">Ver Detalhes</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="grid-column: 1/-1; text-align: center; color: #666; padding: 40px;">Nenhum carro disponível no momento.</p>
        <?php endif; ?>
      </div>

      <div style="text-align: center; margin-top: 40px;">
        <a href="/projeto-web/produtos.php" class="btn" style="padding: 14px 40px; font-size: 16px;">Visualizar Mais Veículos</a>
      </div>
    </div>
    </div>
    <!-- ABOUT SECTION -->
    <section class="about-section">
      <div class="about-section-content">
        <h3>Por Que Escolher a AutoMax?</h3>
        <p>
          A AutoMax é referência no mercado automóvel brasileiro, oferecendo uma seleção cuidadosa de veículos de qualidade 
          com as melhores condições de preço e financiamento. Com mais de uma década de experiência, nos comprometemos 
          com a satisfação e confiança de nossos clientes.
        </p>
        
        <div class="about-grid">
          <div class="about-item">
            <h4>1500+</h4>
            <p>Clientes Satisfeitos</p>
          </div>
          <div class="about-item">
            <h4>800+</h4>
            <p>Veículos Vendidos</p>
          </div>
          <div class="about-item">
            <h4>12+</h4>
            <p>Anos de Mercado</p>
          </div>
          <div class="about-item">
            <h4>24h</h4>
            <p>Suporte Disponível</p>
          </div>
        </div>
      </div>
    </section>

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

  <script src="/projeto-web/js/main.js"></script>
</body>
</html>