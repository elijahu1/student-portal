<?php
require_once __DIR__ . '/../../src/config/bootstrap.php';
requireAdmin();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'save') {
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $r  = AdminController::saveCourse($_POST, $id);
        flash($r['ok'] ? 'success' : 'error', $r['msg']);
    } elseif ($action === 'delete') {
        $r = AdminController::deleteCourse((int)($_POST['id'] ?? 0));
        flash($r['ok'] ? 'success' : 'error', $r['msg']);
    }
    header('Location: /admin/courses.php'); exit;
}
$editing = isset($_GET['edit']) ? Course::find((int)$_GET['edit']) : null;
$courses = Course::all();
$title = 'Manage Courses';
include ROOT . '/views/layout/header.php';
?>
<div class="page-header flex-between" style="display:flex">
  <div><h1>Manage Courses</h1><p>Create, edit or remove courses</p></div>
  <a href="/admin/courses.php" class="btn btn-outline btn-sm">+ New Course</a>
</div>
<div class="card">
  <h2 style="margin-bottom:1.25rem"><?= $editing ? 'Edit Course' : 'New Course' ?></h2>
  <form method="POST">
    <input type="hidden" name="action" value="save">
    <?php if ($editing): ?><input type="hidden" name="id" value="<?= $editing['id'] ?>"><?php endif; ?>
    <div class="form-row">
      <div class="form-group"><label>Code</label><input type="text" name="code" required placeholder="CS101" value="<?= h($editing['code'] ?? '') ?>"></div>
      <div class="form-group"><label>Semester</label><input type="text" name="semester" required placeholder="2025/1" value="<?= h($editing['semester'] ?? '') ?>"></div>
    </div>
    <div class="form-group"><label>Title</label><input type="text" name="title" required placeholder="Course title" value="<?= h($editing['title'] ?? '') ?>"></div>
    <div class="form-group"><label>Description</label><textarea name="description"><?= h($editing['description'] ?? '') ?></textarea></div>
    <div class="form-row">
      <div class="form-group"><label>Credits</label><input type="number" name="credits" min="1" max="6" value="<?= $editing['credits'] ?? 3 ?>"></div>
      <div class="form-group"><label>Capacity</label><input type="number" name="capacity" min="1" value="<?= $editing['capacity'] ?? 30 ?>"></div>
    </div>
    <div style="display:flex;gap:.75rem">
      <button class="btn btn-primary" type="submit"><?= $editing ? 'Update' : 'Create Course' ?></button>
      <?php if ($editing): ?><a href="/admin/courses.php" class="btn btn-outline">Cancel</a><?php endif; ?>
    </div>
  </form>
</div>
<div class="card" style="padding:0">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Code</th><th>Title</th><th>Credits</th><th>Enrolled</th><th>Capacity</th><th>Semester</th><th colspan="2"></th></tr></thead>
      <tbody>
        <?php foreach ($courses as $c): ?>
        <tr>
          <td class="mono"><?= h($c['code']) ?></td><td><?= h($c['title']) ?></td>
          <td><?= $c['credits'] ?></td><td><?= $c['enrolled'] ?></td><td><?= $c['capacity'] ?></td><td><?= h($c['semester']) ?></td>
          <td><a href="/admin/courses.php?edit=<?= $c['id'] ?>" class="btn btn-outline btn-sm">Edit</a></td>
          <td>
            <form method="POST" onsubmit="return confirm('Delete?')">
              <input type="hidden" name="action" value="delete">
              <input type="hidden" name="id" value="<?= $c['id'] ?>">
              <button class="btn btn-danger btn-sm" type="submit">Delete</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($courses)): ?><tr><td colspan="8" class="empty">No courses yet.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include ROOT . '/views/layout/footer.php'; ?>
