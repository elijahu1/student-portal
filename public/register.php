<?php
require_once __DIR__ . '/../src/config/bootstrap.php';
if (auth()) { header('Location: /dashboard.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $r = AuthController::register(trim($_POST['name'] ?? ''), trim($_POST['email'] ?? ''), $_POST['password'] ?? '');
    if ($r['ok']) { header('Location: /dashboard.php'); exit; }
    flash('error', $r['msg']);
    header('Location: /register.php'); exit;
}
$title = 'Create Account';
include ROOT . '/views/layout/header.php';
?>
<div class="auth-wrap" style="margin-top:-2rem">
  <div class="auth-card">
    <h1>Create account</h1>
    <p class="sub">Join EduReg to register for courses</p>
    <form method="POST">
      <div class="form-group"><label>Full Name</label><input type="text" name="name" required autofocus placeholder="Ada Lovelace"></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" required placeholder="you@example.com"></div>
      <div class="form-group"><label>Password <span style="color:var(--muted);font-weight:400">(min 6 chars)</span></label><input type="password" name="password" required minlength="6" placeholder="••••••••"></div>
      <button class="btn btn-primary" style="width:100%;margin-top:.5rem" type="submit">Create Account</button>
    </form>
    <p class="auth-footer">Have an account? <a href="/login.php">Sign in</a></p>
  </div>
</div>
<?php include ROOT . '/views/layout/footer.php'; ?>
