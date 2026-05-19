<?php
session_start();

define('ROOT', dirname(__DIR__, 2));

require ROOT . '/src/config/db.php';
require ROOT . '/src/models/User.php';
require ROOT . '/src/models/Course.php';
require ROOT . '/src/models/Registration.php';
require ROOT . '/src/controllers/AuthController.php';
require ROOT . '/src/controllers/CourseController.php';
require ROOT . '/src/controllers/AdminController.php';

set_exception_handler(function(Throwable $e) {
    http_response_code(500);
    if (file_exists(ROOT . '/public/500.php')) {
        include ROOT . '/public/500.php';
    } else {
        echo '<h1>500 — Server Error</h1>';
    }
    exit;
});

function auth(): ?array {
    return $_SESSION['user'] ?? null;
}

function requireAuth(): void {
    if (!auth()) {
        header('Location: /login.php');
        exit;
    }
}

function requireAdmin(): void {
    requireAuth();
    if (auth()['role'] !== 'admin') {
        header('Location: /dashboard.php');
        exit;
    }
}

function flash(string $key, string $msg = ''): string {
    if ($msg) {
        $_SESSION['flash'][$key] = $msg;
        return '';
    }
    $val = $_SESSION['flash'][$key] ?? '';
    unset($_SESSION['flash'][$key]);
    return $val;
}

function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
