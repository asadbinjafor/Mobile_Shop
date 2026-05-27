<div class="page-actions">
  <h1>Category Management</h1>
  <a href="<?= url('/admin/categories/create') ?>" class="btn-admin">+ Add Category</a>
</div>

<table class="admin-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Icon</th>
      <th>Name</th>
      <th>Slug</th>
      <th>Active</th>
      <th>Sort</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($categories as $c): ?>
    <tr>
      <td><?= (int) $c['id'] ?></td>
      <td><?= e($c['icon'] ?: '📦') ?></td>
      <td><strong><?= e($c['name']) ?></strong></td>
      <td><?= e($c['slug']) ?></td>
      <td><?= !empty($c['is_active']) ? '<span class="status-active">Active</span>' : '<span class="status-blocked">Hidden</span>' ?></td>
      <td><?= (int) ($c['sort_order'] ?? 0) ?></td>
      <td>
        <a class="btn-admin btn-sm btn-admin-outline" href="<?= url('/admin/categories/' . $c['id'] . '/edit') ?>">Edit</a>
        <form method="POST" action="<?= url('/admin/categories/' . $c['id'] . '/delete') ?>" style="display:inline" onsubmit="return confirm('Delete this category?')">
          <button class="btn-admin btn-sm" style="background:#c62828">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (empty($categories)): ?><tr><td colspan="7">No categories yet</td></tr><?php endif; ?>
  </tbody>
</table>

