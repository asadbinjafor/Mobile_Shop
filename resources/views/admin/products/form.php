<?php
use App\Models\ProductModel;
$isEdit = $product !== null;
$brands = ProductModel::getBrands();
$categories = ProductModel::getCategories();
?>
<h1><?= $isEdit ? 'Edit Product' : 'Add Product' ?></h1>
<form class="admin-form" method="POST" action="<?= $isEdit ? url('/admin/products/' . $product['id']) : url('/admin/products') ?>">
  <label>Name<input name="name" value="<?= e($product['name'] ?? '') ?>" required></label>
  <label>Brand
    <select name="brand" required>
      <?php foreach ($brands as $b): ?>
        <option value="<?= e($b['slug']) ?>" <?= ($product['brand'] ?? '') === $b['slug'] ? 'selected' : '' ?>><?= e($b['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Category
    <select name="category">
      <?php foreach ($categories as $c): ?>
        <option value="<?= e($c['slug']) ?>" <?= ($product['category'] ?? 'phones') === $c['slug'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Section<input name="section" value="<?= e($product['section'] ?? 'deals') ?>"></label>
  <label>Price<input type="number" name="price" value="<?= (int)($product['price'] ?? 0) ?>" required></label>
  <label>Old Price<input type="number" name="old_price" value="<?= (int)($product['oldPrice'] ?? $product['old_price'] ?? 0) ?>"></label>
  <label>Stock<input type="number" name="stock" value="<?= (int)($product['stock'] ?? 50) ?>"></label>
  <label>Image URL<input name="image" value="<?= e($product['image'] ?? '') ?>" required></label>
  <label>Label<input name="label" value="<?= e($product['label'] ?? 'hot') ?>"></label>
  <label><input type="checkbox" name="out_of_stock" <?= !empty($product['outOfStock']) ? 'checked' : '' ?>> Out of Stock</label>
  <button type="submit" class="btn-admin">Save Product</button>
</form>
