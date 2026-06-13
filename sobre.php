<?php
require __DIR__ . '/config/conexao.php';

function e($s) { 
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); 
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Sobre a AutoMax - Concessionária de Carros</title>
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
      <h1>Sobre a AutoMax</h1>
      <p>Conheça nossa história, valores e compromisso com você</p>
    </div>
  </section>

  <main>
    <!-- QUEM SOMOS -->
    <section style="padding: 80px 16px; background: var(--white);">
      <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
          <h2 style="text-align: left; margin-top: 0;">Quem Somos</h2>
          
          <p style="font-size: 16px; color: var(--text-secondary); line-height: 1.8; margin-bottom: 24px;">
            A AutoMax é uma concessionária de referência no mercado automóvel brasileiro, especializada na venda 
            de veículos de qualidade premium com excelentes condições de preço e financiamento. Fundada em 2014, 
            temos nos consolidado como parceira confiável de milhares de clientes em toda a região.
          </p>

          <p style="font-size: 16px; color: var(--text-secondary); line-height: 1.8; margin-bottom: 24px;">
            Nossa missão é proporcionar uma experiência de compra transparente, segura e satisfatória. Cada veículo 
            em nosso catálogo passa por rigorosa inspeção mecânica e documentação verificada, garantindo total segurança 
            na transação.
          </p>

          <p style="font-size: 16px; color: var(--text-secondary); line-height: 1.8;">
            Acreditamos que comprar um carro deve ser uma experiência positiva. Por isso, nosso time de profissionais 
            está preparado para oferecer consultoria especializada, facilidades de financiamento e suporte contínuo 
            aos nossos clientes.
          </p>
        </div>
      </div>
    </section>

    <!-- NÚMEROS -->
    <section class="about-section">
      <div class="about-section-content">
        <h3>Nossa Trajetória</h3>
        <div class="about-grid" style="margin-top: 50px;">
          <div class="about-item">
            <h4>1500+</h4>
            <p>Clientes Satisfeitos</p>
          </div>
          <div class="about-item">
            <h4>800+</h4>
            <p>Veículos Vendidos</p>
          </div>
          <div class="about-item">
            <h4>12</h4>
            <p>Anos de Mercado</p>
          </div>
          <div class="about-item">
            <h4>99%</h4>
            <p>Taxa de Satisfação</p>
          </div>
        </div>
      </div>
    </section>

    <!-- VALORES -->
    <section style="padding: 80px 16px; background: var(--white);">
      <div class="container">
        <div style="max-width: 900px; margin: 0 auto;">
          <h2 style="text-align: left; margin-top: 0;">Nossos Valores</h2>
          
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-top: 40px;">
            
            <div>
              <h4 style="color: var(--accent-red); font-size: 18px; margin-bottom: 12px; font-weight: 700;">Transparência</h4>
              <p style="color: var(--text-secondary); line-height: 1.6;">
                Toda informação sobre nossos veículos é fornecida de forma clara e honesta. Sem surpresas desagradáveis 
                após a compra.
              </p>
            </div>

            <div>
              <h4 style="color: var(--accent-red); font-size: 18px; margin-bottom: 12px; font-weight: 700;">Qualidade</h4>
              <p style="color: var(--text-secondary); line-height: 1.6;">
                Cada carro é cuidadosamente selecionado e avaliado. Garantia e suporte mecânico estão sempre à 
                disposição.
              </p>
            </div>

            <div>
              <h4 style="color: var(--accent-red); font-size: 18px; margin-bottom: 12px; font-weight: 700;">Confiança</h4>
              <p style="color: var(--text-secondary); line-height: 1.6;">
                Somos referência em confiabilidade. Documentação completa e verificada para sua segurança jurídica.
              </p>
            </div>

            <div>
              <h4 style="color: var(--accent-red); font-size: 18px; margin-bottom: 12px; font-weight: 700;">Atendimento</h4>
              <p style="color: var(--text-secondary); line-height: 1.6;">
                Equipe dedicada e experiente pronta para ajudar. Disponibilidade 24 horas para tirar dúvidas.
              </p>
            </div>

            <div>
              <h4 style="color: var(--accent-red); font-size: 18px; margin-bottom: 12px; font-weight: 700;">Responsabilidade</h4>
              <p style="color: var(--text-secondary); line-height: 1.6;">
                Cuidamos de cada detalhe para que sua experiência seja excelente, do início até depois da compra.
              </p>
            </div>

            <div>
              <h4 style="color: var(--accent-red); font-size: 18px; margin-bottom: 12px; font-weight: 700;">Inovação</h4>
              <p style="color: var(--text-secondary); line-height: 1.6;">
                Sempre atualizando nossas ofertas e melhorando serviços para atender melhor nossos clientes.
              </p>
            </div>

          </div>
        </div>
      </div>
    </section>

    <!-- CONTATO -->
    <section style="padding: 60px 16px; background: rgba(255, 255, 255, 0.95); margin: 40px 16px; border-radius: 8px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);">
      <div class="container">
        <h2 style="text-align: center; margin-top: 0;">Entre em Contato</h2>
        
        <div class="contact-content" style="margin-top: 50px;">
          <div class="contact-info">
            <div class="contact-item">
              <h4>Endereço</h4>
              <p>Rua das Flores, 123<br>Bairro Premium<br>São Paulo, SP - 01234-567</p>
            </div>

            <div class="contact-item">
              <h4>Telefone</h4>
              <p>(11) 3000-0000<br>Segunda a Sexta: 9h - 18h<br>Sábado: 9h - 14h</p>
            </div>

            <div class="contact-item">
              <h4>Email</h4>
              <p>contato@automax.com.br<br>vendas@automax.com.br<br>suporte@automax.com.br</p>
            </div>
          </div>

          <div style="background: rgba(255, 255, 255, 0.98); padding: 40px; border-radius: 8px; border: none; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);">
            <h4 style="color: var(--navy); margin-bottom: 20px; font-weight: 700;">Envie uma Mensagem</h4>
            <form style="padding: 0; box-shadow: none; border: none; background: transparent; margin: 0;">
              <div>
                <label>Nome</label>
                <input type="text" placeholder="Seu nome" required>
              </div>
              <div>
                <label>Email</label>
                <input type="email" placeholder="seu@email.com" required>
              </div>
              <div>
                <label>Mensagem</label>
                <textarea placeholder="Como podemos ajudar?" style="min-height: 100px;"></textarea>
              </div>
              <button type="submit" class="btn" style="width: 100%; padding: 12px;">Enviar Mensagem</button>
            </form>
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

  <script>
    document.addEventListener('DOMContentLoaded', function() {
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
