# AutoMax - Plataforma de Venda de Carros

Site desenvolvido com PHP, MySQL, HTML, CSS e JavaScript.

## Tecnologias

- Backend: PHP 7.4+ com PDO
- Banco de Dados: MySQL 5.7+ / MariaDB
- Frontend: HTML5, CSS3, JavaScript Vanilla

## Requisitos Atendidos

- Menu de navegação responsivo
- Carrossel de imagens com os carros cadastrados no banco
- Lista de cards de produtos com especificações
- Rodape com informacoes sobre a empresa
- Tela de login com mensagens de erro especificas
- CRUD completo de usuarios e produtos
- Painel administrativo

## Como Instalar

1. Copie a pasta para o diretorio publico do servidor (ex: `C:\xampp\htdocs\projeto-web`)
2. Importe o arquivo `database.sql` no phpMyAdmin
3. Acesse `http://localhost/projeto-web/`

## Acesso Admin

- Email: admin@carros.com
- Senha: admin123
- Painel: `http://localhost/projeto-web/admin/painel.php`

## Estrutura

```
projeto-web/
├── index.php
├── login.php
├── registrar.php
├── produtos.php
├── database.sql
├── config/conexao.php
├── admin/
│   ├── painel.php
│   ├── produtos.php
│   └── usuarios.php
├── css/style.css
└── js/main.js
```