<?php
require_once __DIR__ . '/../src/config/bootstrap.php';
requireAuth();
$user = auth();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $courseId = (int)($_POST['course_id'] ?? 0);
    $r = $action === 'register'
        ? CourseController::register($user['id'], $courseId)
        : CourseController::drop($user['id'], $courseId);
    flash($r['ok'] ? 'success' : 'error', $r['msg']);
    header('Location: /courses.php'); exit;
}
$courses  = Course::all();
$myRegIds = array_map('intval', array_column(Registration::forStudent($user['id']), 'course_id'));
$title = 'Browse Courses';
include ROOT . '/views/layout/header.php';
?>
<div class="page-header">
  <h1>Course Catalogue</h1>
  <p>Register or drop courses for the current semester</p>
</div>
<div class="card-grid">
<?php foreach ($courses as $c):
  $full = $c['enrolled'] >= $c['capacity'];
  $registered = in_array((int)$c['id'], $myRegIds, true);
  $pct = $c['capacity'] > 0 ? min(100, round($c['enrolled']/$c['capacity']*100)) : 0;
?>
  <div class="course-card">
    <div><span class="course-code"><?= h($c['code']) ?></span><?php if ($full): ?> <span class="badge badge-full">Full</span><?php endif; ?></div>
    <div class="course-title"><?= h($c['title']) ?></div>
    <?php if ($c['description']): ?><p style="font-size:.82rem;color:var(--muted)"><?= h(mb_strimwidth($c['description'],0,90,'…')) ?></p><?php endif; ?>
    <div class="course-meta"><span>📚 <?= $c['credits'] ?> cr.</span><span>📅 <?= h($c['semester']) ?></span><span>👥 <?= $c['enrolled'] ?>/<?= $c['capacity'] ?></span></div>
    <div class="capacity-bar"><div class="capacity-bar-fill <?= $full?'full':'' ?>" style="width:<?= $pct ?>%"></div></div>
    <div style="margin-top:.5rem">
      <?php if ($registered): ?>
        <form method="POST" onsubmit="return confirm('Drop this course?')">
          <input type="hidden" name="action" value="drop">
          <input type="hidden" name="course_id" value="<?= $c['id'] ?>">
          <button class="btn btn-danger btn-sm" type="submit">Drop Course</button>
        </form>
      <?php elseif (!$full): ?>
        <form method="POST">
          <input type="hidden" name="action" value="register">
          <input type="hidden" name="course_id" value="<?= $c['id'] ?>">
          <button class="btn btn-primary btn-sm" type="submit">Register</button>
        </form>
      <?php else: ?>
        <button class="btn btn-outline btn-sm" disabled>Course Full</button>
      <?php endif; ?>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php include ROOT . '/views/layout/footer.php'; ?>
