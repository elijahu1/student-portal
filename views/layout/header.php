<?php
$user = auth();
$role = $user['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= h($title ?? 'Portal') ?> — EduReg</title>
  <link rel="stylesheet" href="/css/app.css">
</head>
<body>
<nav class="navbar">
  <a class="brand" href="/">EduReg</a>
  <div class="nav-links">
    <?php if ($user): ?>
      <?php if ($role === 'admin'): ?>
        <a href="/admin/dashboard.php">Dashboard</a>
        <a href="/admin/courses.php">Courses</a>
        <a href="/admin/registrations.php">Registrations</a>
        <a href="/admin/users.php">Users</a>
      <?php else: ?>
        <a href="/dashboard.php">Dashboard</a>
        <a href="/courses.php">Browse Courses</a>
      <?php endif; ?>
      <a href="/logout.php" class="btn-nav-logout">Logout</a>
    <?php else: ?>
      <a href="/login.php">Login</a>
      <a href="/register.php" class="btn-nav-primary">Sign Up</a>
    <?php endif; ?>
  </div>
</nav>
<main class="container">
<?php
$err = flash('error');
$ok  = flash('success');
if ($err): ?><div class="alert alert-error"><?= h($err) ?></div><?php endif; ?>
<?php if ($ok):  ?><div class="alert alert-ok"><?= h($ok) ?></div><?php endif; ?>
