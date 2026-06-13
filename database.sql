-- database.sql - Banco de dados para site de venda de carros
CREATE DATABASE IF NOT EXISTS projeto_web CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE projeto_web;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  telefone VARCHAR(20),
  nivel_acesso ENUM('admin','cliente') NOT NULL DEFAULT 'cliente',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de produtos (carros)
CREATE TABLE IF NOT EXISTS produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(200) NOT NULL,
  marca VARCHAR(100) NOT NULL,
  modelo VARCHAR(100) NOT NULL,
  ano INT NOT NULL,
  quilometragem INT NOT NULL DEFAULT 0,
  combustivel ENUM('Gasolina','Diesel','Flex','Elétrico','Híbrido') DEFAULT 'Gasolina',
  cambio ENUM('Manual','Automático') DEFAULT 'Automático',
  cor VARCHAR(50),
  descricao LONGTEXT,
  preco DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  imagem_url VARCHAR(512),
  imagem_url2 VARCHAR(512),
  imagem_url3 VARCHAR(512),
  imagem_url4 VARCHAR(512),
  disponivel BOOLEAN DEFAULT 1,
  data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de carrinhos/pedidos (opcional para futuro)
CREATE TABLE IF NOT EXISTS carrinho (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  produto_id INT NOT NULL,
  quantidade INT DEFAULT 1,
  data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
);

-- Inserir um usuário admin padrão
INSERT INTO usuarios (nome, email, senha, nivel_acesso)
SELECT 'Administrador', 'admin@carros.com', 'admin123', 'admin'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE email='admin@carros.com');

-- Inserir alguns clientes de exemplo
INSERT INTO usuarios (nome, email, senha, nivel_acesso, telefone)
SELECT 'João Silva', 'joao@example.com', 'senha123', 'cliente', '(11) 98765-4321'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE email='joao@example.com');

INSERT INTO usuarios (nome, email, senha, nivel_acesso, telefone)
SELECT 'Maria Santos', 'maria@example.com', 'senha123', 'cliente', '(21) 98765-4321'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE email='maria@example.com');

-- Inserir alguns carros de exemplo
INSERT INTO produtos (nome, marca, modelo, ano, quilometragem, combustivel, cambio, cor, descricao, preco, imagem_url, disponivel)
VALUES 
('Hyundai HB20 2023', 'Hyundai', 'HB20', 2023, 15000, 'Flex', 'Automático', 'Preto', 'Carro compacto econômico, com excelente custo-benefício. Ideal para uso urbano.', 75000.00, 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?w=500', 1),
('Toyota Corolla 2022', 'Toyota', 'Corolla', 2022, 32000, 'Gasolina', 'Automático', 'Branco', 'Sedã confiável e robusto, com ótimo desempenho. Perfeito para quem busca qualidade.', 95000.00, 'https://images.unsplash.com/photo-1542282088-fe8426682b8f?w=500', 1),
('Fiat Argo 2023', 'Fiat', 'Argo', 2023, 8000, 'Flex', 'Manual', 'Vermelho', 'Praticoplay eficiente e moderno. Excelente para primeira compra.', 68000.00, 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?w=500', 1),
('Volkswagen Gol 2021', 'Volkswagen', 'Gol', 2021, 45000, 'Gasolina', 'Manual', 'Cinza', 'Clássico que não sai de moda. Confiável e fácil de manter.', 62000.00, 'https://images.unsplash.com/photo-1553882900-f2b6fc498d9f?w=500', 1),
('Jeep Renegade 2023', 'Jeep', 'Renegade', 2023, 12000, 'Diesel', 'Automático', 'Azul', 'SUV versátil com tração 4x4. Ideal para aventuras e uso diário.', 130000.00, 'https://images.unsplash.com/photo-1533473359331-35b1d92e5f63?w=500', 1),
('Chevrolet Onix 2022', 'Chevrolet', 'Onix', 2022, 38000, 'Flex', 'Automático', 'Prata', 'SUV compacto moderna com tecnologia. Ótimo custo-benefício.', 82000.00, 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?w=500', 1),
('Ford Ka 2023', 'Ford', 'Ka', 2023, 5000, 'Flex', 'Manual', 'Laranja', 'Carro ideal para iniciantes. Ágil e econômico na cidade.', 65000.00, 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500', 1),
('Honda Civic 2021', 'Honda', 'Civic', 2021, 48000, 'Gasolina', 'Automático', 'Preto', 'Sedã esportivo com design moderno. Para quem ama adrenalina.', 110000.00, 'https://images.unsplash.com/photo-1566023967268-70ffc2cea0fc?w=500', 1),
('Nissan March 2022', 'Nissan', 'March', 2022, 28000, 'Gasolina', 'Automático', 'Branco', 'Hatchback compacto e ágil. Perfeito para o dia a dia.', 72000.00, 'https://images.unsplash.com/photo-1549399542-7e3f8b83ad38?w=500', 1),
('Peugeot 3008 2023', 'Peugeot', '3008', 2023, 10000, 'Diesel', 'Automático', 'Cinza', 'SUV premium francesa com conforto de luxo. Tecnologia de ponta.', 150000.00, 'https://images.unsplash.com/photo-1487730116645-74489c95b41b?w=500', 1);
