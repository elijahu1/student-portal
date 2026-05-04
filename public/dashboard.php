<?php
require_once __DIR__ . '/../src/config/bootstrap.php';
requireAuth();
$user = auth();
$myRegs = Registration::forStudent($user['id']);
$allCourses = Course::all();
$totalCredits = array_sum(array_column($myRegs, 'credits'));
$title = 'Dashboard';
include ROOT . '/views/layout/header.php';
?>
<div class="page-header">
  <h1>Hello, <?= h($user['name']) ?> 👋</h1>
  <p>Your registered courses this semester</p>
</div>
<div class="stats-grid">
  <div class="stat-card"><div class="stat-num"><?= count($myRegs) ?></div><div class="stat-lbl">Enrolled</div></div>
  <div class="stat-card"><div class="stat-num"><?= $totalCredits ?></div><div class="stat-lbl">Credits</div></div>
  <div class="stat-card"><div class="stat-num"><?= count($allCourses) ?></div><div class="stat-lbl">Available</div></div>
</div>
<div class="flex-between">
  <h2 style="margin:0">My Courses</h2>
  <a href="/courses.php" class="btn btn-primary btn-sm">+ Browse Courses</a>
</div>
<?php if (empty($myRegs)): ?>
  <div class="empty card">No courses yet. <a href="/courses.php">Browse courses →</a></div>
<?php else: ?>
<div class="card" style="padding:0">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Code</th><th>Title</th><th>Credits</th><th>Semester</th><th>Registered</th><th></th></tr></thead>
      <tbody>
        <?php foreach ($myRegs as $r): ?>
        <tr>
          <td class="mono"><?= h($r['code']) ?></td>
          <td><?= h($r['title']) ?></td>
          <td><?= $r['credits'] ?></td>
          <td><?= h($r['semester']) ?></td>
          <td><?= date('M d, Y', strtotime($r['registered_at'])) ?></td>
          <td>
            <form method="POST" action="/courses.php" onsubmit="return confirm('Drop this course?')">
              <input type="hidden" name="action" value="drop">
              <input type="hidden" name="course_id" value="<?= $r['course_id'] ?>">
              <button class="btn btn-danger btn-sm" type="submit">Drop</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>
<?php include ROOT . '/views/layout/footer.php'; ?>
