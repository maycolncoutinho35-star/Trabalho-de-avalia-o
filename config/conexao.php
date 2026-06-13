<?php
// config/conexao.php - Conexão PDO segura
declare(strict_types=1);
session_start();

define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'projeto_web');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo 'Erro na conexão com o banco de dados.';
    exit;
}

function require_login(): void
{
    if (empty($_SESSION['user'])) {
        header('Location: /projeto-web/login.php');
        exit;
    }
}

function require_admin(): void
{
    if (empty($_SESSION['user'])) {
        header('Location: /projeto-web/login.php');
        exit;
    }

    if (($_SESSION['user']['nivel_acesso'] ?? '') !== 'admin') {
        http_response_code(403);
        echo 'Acesso restrito apenas para administradores.';
        exit;
    }
}
