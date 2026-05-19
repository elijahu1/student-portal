<?php
require_once __DIR__ . '/../src/config/bootstrap.php';
http_response_code(500);
$title = '500 Server Error';
include ROOT . '/views/layout/header.php';
?>
<div style="text-align:center;padding:5rem 1rem">
  <h1 style="font-size:5rem;color:var(--border)">500</h1>
  <h2>Something went wrong</h2>
  <p style="color:var(--muted);margin:.75rem 0 1.5rem">An unexpected error occurred. Please try again.</p>
  <a href="/" class="btn btn-primary">Go Home</a>
</div>
<?php include ROOT . '/views/layout/footer.php'; ?>
