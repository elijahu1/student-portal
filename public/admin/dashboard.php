<?php
require_once __DIR__ . '/../../src/config/bootstrap.php';
requireAdmin();
$users   = User::all();
$courses = Course::all();
$regs    = Registration::allWithDetails();
$students = array_filter($users, fn($u) => $u['role'] === 'student');
$title = 'Admin Dashboard';
include ROOT . '/views/layout/header.php';
?>
<div class="page-header"><h1>Admin Dashboard</h1><p>Portal overview</p></div>
<div class="stats-grid">
  <div class="stat-card"><div class="stat-num"><?= count($students) ?></div><div class="stat-lbl">Students</div></div>
  <div class="stat-card"><div class="stat-num"><?= count($courses) ?></div><div class="stat-lbl">Courses</div></div>
  <div class="stat-card"><div class="stat-num"><?= count($regs) ?></div><div class="stat-lbl">Registrations</div></div>
  <div class="stat-card"><div class="stat-num"><?= array_sum(array_column($courses,'enrolled')) ?></div><div class="stat-lbl">Seats Taken</div></div>
</div>
<h2>Recent Registrations</h2>
<div class="card" style="padding:0">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Student</th><th>Email</th><th>Course</th><th>Date</th></tr></thead>
      <tbody>
        <?php foreach (array_slice($regs,0,10) as $r): ?>
        <tr>
          <td><?= h($r['student']) ?></td><td><?= h($r['email']) ?></td>
          <td><span class="mono"><?= h($r['code']) ?></span> — <?= h($r['title']) ?></td>
          <td><?= date('M d, Y H:i', strtotime($r['registered_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($regs)): ?><tr><td colspan="4" class="empty">No registrations yet.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include ROOT . '/views/layout/footer.php'; ?>
