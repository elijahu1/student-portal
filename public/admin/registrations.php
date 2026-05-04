<?php
require_once __DIR__ . '/../../src/config/bootstrap.php';
requireAdmin();
$regs = Registration::allWithDetails();
$title = 'All Registrations';
include ROOT . '/views/layout/header.php';
?>
<div class="page-header"><h1>All Registrations</h1><p>Every student–course registration</p></div>
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
