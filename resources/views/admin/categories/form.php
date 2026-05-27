<?php $isEdit = $category !== null; ?>
<h1><?= $isEdit ? 'Edit Category' : 'Add Category' ?></h1>

<form class="admin-form" method="POST" action="<?= $isEdit ? url('/admin/categories/' . $category['id']) : url('/admin/categories') ?>">
  <label>Name
    <input name="name" value="<?= e($category['name'] ?? '') ?>" required>
  </label>

  <label>Slug (lowercase, use hyphen)
    <input name="slug" value="<?= e($category['slug'] ?? '') ?>" placeholder="phones" required>
  </label>

  <label>Icon (emoji)
    <input name="icon" value="<?= e($category['icon'] ?? '') ?>" placeholder="📱">
  </label>

  <label>Sort Order
    <input type="number" name="sort_order" value="<?= (int)($category['sort_order'] ?? 0) ?>">
  </label>

  <label>
    <input type="checkbox" name="is_active" <?= !isset($category) || !empty($category['is_active']) ? 'checked' : '' ?>>
    Active (show in shop)
  </label>

  <button type="submit" class="btn-admin">Save</button>
  <a href="<?= url('/admin/categories') ?>" class="btn-admin btn-admin-outline" style="margin-left:8px">Cancel</a>
</form>

