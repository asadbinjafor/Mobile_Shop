<?php $isEdit = $product !== null; ?>
<h1><?= $isEdit ? 'Edit Product' : 'Add Product' ?></h1>
<form class="admin-form" method="POST" action="<?= $isEdit ? url('/admin/products/' . $product['id']) : url('/admin/products') ?>">
  <label>Name<input name="name" value="<?= e($product['name'] ?? '') ?>" required></label>
  <label>Brand
    <select name="brand" required>
      <?php foreach ($brands as $b): ?>
        <option value="<?= e($b['slug']) ?>" <?= ($product['brand'] ?? '') === $b['slug'] ? 'selected' : '' ?>>
          <?= e($b['name']) ?><?= empty($b['is_active']) ? ' (hidden)' : '' ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Category
    <select name="category" required>
      <?php foreach ($categories as $c): ?>
        <option value="<?= e($c['slug']) ?>" <?= ($product['category'] ?? 'phones') === $c['slug'] ? 'selected' : '' ?>>
          <?= e($c['name']) ?><?= empty($c['is_active']) ? ' (hidden)' : '' ?>
        </option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Section
    <select name="section">
      <?php foreach (['flash', 'deals', 'recent', 'trending'] as $sec): ?>
        <option value="<?= $sec ?>" <?= ($product['section'] ?? 'deals') === $sec ? 'selected' : '' ?>><?= ucfirst($sec) ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Price<input type="number" name="price" value="<?= (int)($product['price'] ?? 0) ?>" required></label>
  <label>Old Price<input type="number" name="old_price" value="<?= (int)($product['oldPrice'] ?? $product['old_price'] ?? 0) ?>"></label>
  <label>Stock<input type="number" name="stock" value="<?= (int)($product['stock'] ?? 50) ?>"></label>
  <label>Image URL<input name="image" value="<?= e($product['image'] ?? '') ?>" required></label>
  <label>Label
    <select name="label">
      <?php foreach (['hot', 'top', 'demand', 'choice', 'popular', 'best', 'discount1'] as $lbl): ?>
        <option value="<?= $lbl ?>" <?= ($product['label'] ?? 'hot') === $lbl ? 'selected' : '' ?>><?= $lbl ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label><input type="checkbox" name="out_of_stock" <?= !empty($product['outOfStock']) ? 'checked' : '' ?>> Out of Stock</label>
  <button type="submit" class="btn-admin">Save Product</button>
  <a href="<?= url('/admin/products') ?>" class="btn-admin btn-admin-outline" style="margin-left:8px">Cancel</a>
</form>
