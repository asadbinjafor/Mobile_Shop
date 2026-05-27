<div class="page-actions">
  <h1>Brand Management</h1>
  <a href="<?= url('/admin/brands/create') ?>" class="btn-admin">+ Add Brand</a>
</div>

<table class="admin-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Slug</th>
      <th>Active</th>
      <th>Sort</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($brands as $b): ?>
    <tr>
      <td><?= (int) $b['id'] ?></td>
      <td><strong><?= e($b['name']) ?></strong></td>
      <td><?= e($b['slug']) ?></td>
      <td><?= !empty($b['is_active']) ? '<span class="status-active">Active</span>' : '<span class="status-blocked">Hidden</span>' ?></td>
      <td><?= (int) ($b['sort_order'] ?? 0) ?></td>
      <td>
        <a class="btn-admin btn-sm btn-admin-outline" href="<?= url('/admin/brands/' . $b['id'] . '/edit') ?>">Edit</a>
        <form method="POST" action="<?= url('/admin/brands/' . $b['id'] . '/delete') ?>" style="display:inline" onsubmit="return confirm('Delete this brand?')">
          <button class="btn-admin btn-sm" style="background:#c62828">Delete</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (empty($brands)): ?><tr><td colspan="6">No brands yet</td></tr><?php endif; ?>
  </tbody>
</table>

