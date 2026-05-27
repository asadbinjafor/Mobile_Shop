<?php use App\Core\Auth; use App\Core\Permission; ?>
<div class="page-actions">
  <h1>Product Management</h1>
  <?php if (Permission::can('products.create')): ?>
  <a href="<?= url('/admin/products/create') ?>" class="btn-admin">+ Add Product</a>
  <?php endif; ?>
</div>
<table class="admin-table">
  <thead><tr><th>ID</th><th>Name</th><th>Brand</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead>
  <tbody>
    <?php foreach ($products as $p): ?>
    <tr>
      <td><?= (int)$p['id'] ?></td>
      <td><?= e($p['name']) ?></td>
      <td><?= e($p['brand']) ?></td>
      <td>৳ <?= number_format($p['price']) ?></td>
      <td><?= (int)($p['stock'] ?? 50) ?></td>
      <td>
        <a href="<?= url('/admin/products/' . $p['id'] . '/edit') ?>" class="btn-admin btn-sm btn-admin-outline">Edit</a>
        <?php if (Auth::isAdmin()): ?>
        <form method="POST" action="<?= url('/admin/products/' . $p['id'] . '/delete') ?>" style="display:inline" onsubmit="return confirm('Delete?')">
          <button class="btn-admin btn-sm" style="background:#c62828">Delete</button>
        </form>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
