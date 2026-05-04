<?php
require_once __DIR__ . '/../src/config/bootstrap.php';
AuthController::logout();
header('Location: /login.php'); exit;
