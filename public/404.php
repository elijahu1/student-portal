<?php
require_once __DIR__ . '/../src/config/bootstrap.php';
http_response_code(404);
$title = '404 Not Found';
include ROOT . '/views/layout/header.php';
?>
<div style="text-align:center;padding:5rem 1rem">
  <h1 style="font-size:5rem;color:var(--border)">404</h1>
  <h2>Page not found</h2>
  <p style="color:var(--muted);margin:.75rem 0 1.5rem">The page you're looking for doesn't exist.</p>
  <a href="/" class="btn btn-primary">Go Home</a>
</div>
<?php include ROOT . '/views/layout/footer.php'; ?>
