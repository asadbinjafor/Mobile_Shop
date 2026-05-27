<?php use App\Core\Auth; use App\Core\Permission; ?>
<div class="page-actions">
  <h1>Product Management</h1>
  <?php if (Permission::can('products.create')): ?>
  <a href="<?= url('/admin/products/create') ?>" class="btn-admin">+ Add Product</a>
  <?php endif; ?>
</div>

<form method="GET" action="<?= url('/admin/products') ?>" class="admin-form" style="max-width:100%;margin-bottom:20px;padding:16px">
  <div style="display:grid;grid-template-columns:2fr 1fr 1fr auto;gap:12px;align-items:end">
    <label style="margin:0">Search
      <input type="search" name="q" value="<?= e($filters['q'] ?? '') ?>" placeholder="Name, brand, category...">
    </label>
    <label style="margin:0">Brand
      <select name="brand">
        <option value="">All brands</option>
        <?php foreach ($brands as $b): ?>
        <option value="<?= e($b['slug']) ?>" <?= ($filters['brand'] ?? '') === $b['slug'] ? 'selected' : '' ?>><?= e($b['name']) ?><?= empty($b['is_active']) ? ' (hidden)' : '' ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <label style="margin:0">Category
      <select name="category">
        <option value="">All categories</option>
        <?php foreach ($categories as $c): ?>
        <option value="<?= e($c['slug']) ?>" <?= ($filters['category'] ?? '') === $c['slug'] ? 'selected' : '' ?>><?= e($c['name']) ?><?= empty($c['is_active']) ? ' (hidden)' : '' ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <div>
      <button type="submit" class="btn-admin">Filter</button>
      <a href="<?= url('/admin/products') ?>" class="btn-admin btn-admin-outline" style="margin-left:6px">Reset</a>
    </div>
  </div>
</form>

<p style="font-size:.88rem;color:#666;margin:-8px 0 16px"><?= count($products) ?> product(s) found</p>

<table class="admin-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Image</th>
      <th>Name</th>
      <th>Brand</th>
      <th>Category</th>
      <th>Section</th>
      <th>Price</th>
      <th>Stock</th>
      <th>Status</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $p): ?>
    <?php
      $brandLabel = $brandNames[$p['brand']] ?? ucfirst($p['brand']);
      $catLabel = $categoryNames[$p['category'] ?? 'phones'] ?? ucfirst($p['category'] ?? 'phones');
    ?>
    <tr>
      <td><?= (int) $p['id'] ?></td>
      <td><img src="<?= e($p['image']) ?>" alt="" style="width:48px;height:48px;object-fit:contain;border-radius:6px;background:#f8fafc"></td>
      <td><strong><?= e($p['name']) ?></strong></td>
      <td><?= e($brandLabel) ?><br><small style="color:#888"><?= e($p['brand']) ?></small></td>
      <td><?= e($catLabel) ?><br><small style="color:#888"><?= e($p['category'] ?? 'phones') ?></small></td>
      <td><?= e($p['section'] ?? 'deals') ?></td>
      <td>৳ <?= number_format($p['price']) ?></td>
      <td><?= (int) ($p['stock'] ?? 0) ?></td>
      <td>
        <?php if (!empty($p['outOfStock']) || (int)($p['stock'] ?? 0) <= 0): ?>
          <span class="status-blocked">Out of stock</span>
        <?php else: ?>
          <span class="status-active">In stock</span>
        <?php endif; ?>
      </td>
      <td>
        <a href="<?= url('/admin/products/' . $p['id'] . '/edit') ?>" class="btn-admin btn-sm btn-admin-outline">Edit</a>
        <?php if (Auth::isAdmin()): ?>
        <form method="POST" action="<?= url('/admin/products/' . $p['id'] . '/delete') ?>" style="display:inline" onsubmit="return confirm('Delete this product?')">
          <button class="btn-admin btn-sm" style="background:#c62828">Delete</button>
        </form>
        <?php endif; ?>
      </td>
    </tr>
    <?php endforeach; ?>
    <?php if (empty($products)): ?>
    <tr><td colspan="10" style="text-align:center;padding:32px">No products match your filters.</td></tr>
    <?php endif; ?>
  </tbody>
</table>
