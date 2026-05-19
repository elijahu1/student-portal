<?php
require_once __DIR__ . '/../../src/config/bootstrap.php';
requireAdmin();
$regs = Registration::allWithDetails();

if (isset($_GET['export'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="registrations.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['#', 'Student', 'Email', 'Course Code', 'Course Title', 'Date']);
    foreach ($regs as $i => $r) {
        fputcsv($out, [$i+1, $r['student'], $r['email'], $r['code'], $r['title'], $r['registered_at']]);
    }
    fclose($out);
    exit;
}

$title = 'All Registrations';
include ROOT . '/views/layout/header.php';
?>
<div class="page-header flex-between" style="display:flex">
  <div><h1>All Registrations</h1><p>Every student–course registration</p></div>
  <a href="/admin/registrations.php?export=1" class="btn btn-primary btn-sm">Export CSV</a>
</div>
<div class="card" style="padding:0">
  <div class="table-wrap">
    <table>
      <thead><tr><th>#</th><th>Student</th><th>Email</th><th>Course</th><th>Date</th></tr></thead>
      <tbody>
        <?php foreach ($regs as $i => $r): ?>
        <tr>
          <td class="mono" style="color:var(--muted)"><?= $i+1 ?></td>
          <td><?= h($r['student']) ?></td><td><?= h($r['email']) ?></td>
          <td><span class="mono"><?= h($r['code']) ?></span> — <?= h($r['title']) ?></td>
          <td><?= date('M d, Y H:i', strtotime($r['registered_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($regs)): ?><tr><td colspan="5" class="empty">No registrations yet.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include ROOT . '/views/layout/footer.php'; ?>
