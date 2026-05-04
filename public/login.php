<?php
require_once __DIR__ . '/../src/config/bootstrap.php';
if (auth()) { header('Location: /dashboard.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (AuthController::login(trim($_POST['email'] ?? ''), $_POST['password'] ?? '')) {
        header(auth()['role'] === 'admin' ? 'Location: /admin/dashboard.php' : 'Location: /dashboard.php'); exit;
    }
    flash('error', 'Invalid email or password.');
    header('Location: /login.php'); exit;
}
$title = 'Login';
include ROOT . '/views/layout/header.php';
?>
<div class="auth-wrap" style="margin-top:-2rem">
  <div class="auth-card">
    <h1>Welcome back</h1>
    <p class="sub">Sign in to your EduReg account</p>
    <form method="POST">
      <div class="form-group"><label>Email</label><input type="email" name="email" required autofocus placeholder="you@example.com"></div>
      <div class="form-group"><label>Password</label><input type="password" name="password" required placeholder="••••••••"></div>
      <button class="btn btn-primary" style="width:100%;margin-top:.5rem" type="submit">Sign In</button>
    </form>
    <p class="auth-footer">No account? <a href="/register.php">Create one</a></p>
  </div>
</div>
<?php include ROOT . '/views/layout/footer.php'; ?>
