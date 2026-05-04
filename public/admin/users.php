<?php
require_once __DIR__ . '/../../src/config/bootstrap.php';
requireAdmin();
$users = User::all();
$title = 'All Users';
include ROOT . '/views/layout/header.php';
?>
<div class="page-header"><h1>Users</h1><p>All registered accounts</p></div>
<div class="card" style="padding:0">
  <div class="table-wrap">
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead>
      <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
          <td class="mono" style="color:var(--muted)"><?= $u['id'] ?></td>
          <td><?= h($u['name']) ?></td><td><?= h($u['email']) ?></td>
          <td><span class="badge <?= $u['role']==='admin'?'badge-admin':'badge-student' ?>"><?= h($u['role']) ?></span></td>
          <td><?= date('M d, Y', strtotime($u['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php include ROOT . '/views/layout/footer.php'; ?>
