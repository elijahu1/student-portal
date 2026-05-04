<?php
require_once __DIR__ . '/../src/config/bootstrap.php';
if (auth()) {
    header(auth()['role'] === 'admin' ? 'Location: /admin/dashboard.php' : 'Location: /dashboard.php');
} else {
    header('Location: /login.php');
}
exit;
