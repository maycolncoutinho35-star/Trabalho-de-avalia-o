// js/main.js - Lógica do site de venda de carros

document.addEventListener('DOMContentLoaded', function() {
  
  // ========== MENU TOGGLE MOBILE ==========
  const toggle = document.querySelector('.nav-toggle');
  const links = document.querySelector('.nav-links');
  
  if (toggle) {
    toggle.addEventListener('click', function() {
      if (links) {
        links.classList.toggle('active');
      }
    });
  }

  // ========== CAROUSEL AUTOMÁTICO ==========
  const slides = document.querySelectorAll('.carousel-item');
  
  if (slides.length > 0) {
    let currentSlide = 0;
    
    function showSlide(n) {
      slides.forEach(slide => slide.style.display = 'none');
      slides[n].style.display = 'block';
    }
    
    function nextSlide() {
      currentSlide = (currentSlide + 1) % slides.length;
      showSlide(currentSlide);
    }
    
    function prevSlide() {
      currentSlide = (currentSlide - 1 + slides.length) % slides.length;
      showSlide(currentSlide);
    }
    
    // Mostrar primeiro slide
    showSlide(0);
    
    // Auto-avançar a cada 5 segundos
    setInterval(nextSlide, 5000);
    
    // Botões de controle
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
  }

  // ========== FILTROS DE PRODUTOS ==========
  const filterBtns = document.querySelectorAll('.filter-btn');
  const filterCards = document.querySelectorAll('[data-category]');
  
  filterBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      const category = this.getAttribute('data-filter');
      
      // Ativar botão
      filterBtns.forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      
      // Filtrar cards
      filterCards.forEach(card => {
        if (category === 'all' || card.getAttribute('data-category') === category) {
          card.style.display = 'block';
          card.style.animation = 'fadeIn 0.3s';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  // ========== BUSCA EM TEMPO REAL ==========
  const searchInput = document.getElementById('search-input');
  if (searchInput) {
    searchInput.addEventListener('keyup', function() {
      const searchTerm = this.value.toLowerCase();
      const products = document.querySelectorAll('.card');
      
      products.forEach(product => {
        const title = product.querySelector('h3')?.textContent.toLowerCase();
        const description = product.querySelector('p')?.textContent.toLowerCase();
        
        if (!title || !description) return;
        
        if (title.includes(searchTerm) || description.includes(searchTerm)) {
          product.style.display = 'block';
        } else {
          product.style.display = 'none';
        }
      });
    });
  }

  // ========== MODAL DE DETALHES DO CARRO ==========
  const viewDetailsButtons = document.querySelectorAll('.view-details');
  const modal = document.getElementById('car-modal');
  const closeBtn = document.querySelector('.close-modal');
  
  if (viewDetailsButtons.length > 0 && modal) {
    viewDetailsButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        const carData = this.getAttribute('data-car');
        if (carData) {
          const car = JSON.parse(carData);
          document.getElementById('modal-title').textContent = car.nome;
          document.getElementById('modal-image').src = car.imagem_url;
          document.getElementById('modal-specs').innerHTML = `
            <p><strong>Marca:</strong> ${car.marca}</p>
            <p><strong>Modelo:</strong> ${car.modelo}</p>
            <p><strong>Ano:</strong> ${car.ano}</p>
            <p><strong>Quilometragem:</strong> ${car.quilometragem.toLocaleString('pt-BR')} km</p>
            <p><strong>Combustível:</strong> ${car.combustivel}</p>
            <p><strong>Câmbio:</strong> ${car.cambio}</p>
            <p><strong>Cor:</strong> ${car.cor}</p>
            <p><strong>Preço:</strong> <span style="color: #D92A2A; font-weight: bold; font-size: 20px;">R$ ${parseFloat(car.preco).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</span></p>
          `;
          document.getElementById('modal-description').textContent = car.descricao;
          modal.style.display = 'flex';
        }
      });
    });
    
    if (closeBtn) {
      closeBtn.addEventListener('click', function() {
        modal.style.display = 'none';
      });
    }
    
    window.addEventListener('click', function(event) {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    });
  }

  // ========== ANIMAÇÃO DE FADE IN ==========
  const style = document.createElement('style');
  style.innerHTML = `
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    
    .filter-btn {
      cursor: pointer;
      transition: all 0.3s;
    }
    
    .filter-btn.active {
      background: var(--primary) !important;
      color: white !important;
    }
  `;
  document.head.appendChild(style);

  // ========== SCROLL SUAVE PARA ÂNCORAS ==========
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      if (href !== '#') {
        e.preventDefault();
        const target = document.querySelector(href);
        if (target) {
          target.scrollIntoView({ behavior: 'smooth' });
        }
      }
    });
  });

});
