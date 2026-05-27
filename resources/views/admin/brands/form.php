<?php $isEdit = $brand !== null; ?>
<h1><?= $isEdit ? 'Edit Brand' : 'Add Brand' ?></h1>

<form class="admin-form" method="POST" action="<?= $isEdit ? url('/admin/brands/' . $brand['id']) : url('/admin/brands') ?>">
  <label>Name
    <input name="name" value="<?= e($brand['name'] ?? '') ?>" required>
  </label>

  <label>Slug (lowercase, use hyphen)
    <input name="slug" value="<?= e($brand['slug'] ?? '') ?>" placeholder="samsung" required>
  </label>

  <label>Sort Order
    <input type="number" name="sort_order" value="<?= (int)($brand['sort_order'] ?? 0) ?>">
  </label>

  <label>
    <input type="checkbox" name="is_active" <?= !isset($brand) || !empty($brand['is_active']) ? 'checked' : '' ?>>
    Active (show in shop)
  </label>

  <button type="submit" class="btn-admin">Save</button>
  <a href="<?= url('/admin/brands') ?>" class="btn-admin btn-admin-outline" style="margin-left:8px">Cancel</a>
</form>

