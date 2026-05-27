<div class="page-actions">
  <h1>User Management</h1>
  <a href="<?= url('/admin/users/create') ?>" class="btn-admin">+ Add User</a>
</div>
<table class="admin-table">
  <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr></thead>
  <tbody>
    <?php foreach ($users as $u): ?>
    <tr>
      <td><?= (int)$u['id'] ?></td>
      <td><?= e($u['name']) ?></td>
      <td><?= e($u['email']) ?></td>
      <td><span class="role-badge role-<?= e($u['role']) ?>"><?= e($u['role']) ?></span></td>
      <td class="status-<?= e($u['status']) ?>"><?= e($u['status']) ?></td>
      <td>
        <a href="<?= url('/admin/users/' . $u['id'] . '/edit') ?>" class="btn-admin btn-sm btn-admin-outline">Edit</a>
        <?php if ($u['role'] !== 'admin'): ?>
        <form method="POST" action="<?= url('/admin/users/' . $u['id'] . '/delete') ?>" style="display:inline" onsubmit="return confirm('Delete user?')">
          <button type="submit" class="btn-admin btn-sm" style="background:#c62828">Delete</button>
        </form>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
