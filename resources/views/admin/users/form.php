<?php $isEdit = $user !== null; ?>
<h1><?= $isEdit ? 'Edit User' : 'Add User' ?></h1>
<form class="admin-form" method="POST" action="<?= $isEdit ? url('/admin/users/' . $user['id']) : url('/admin/users') ?>">
  <label>Name<input type="text" name="name" value="<?= e($user['name'] ?? '') ?>" required></label>
  <label>Email<input type="email" name="email" value="<?= e($user['email'] ?? '') ?>" required></label>
  <label>Phone<input type="text" name="phone" value="<?= e($user['phone'] ?? '') ?>"></label>
  <label>Password<input type="password" name="password" <?= $isEdit ? '' : 'required' ?> placeholder="<?= $isEdit ? 'Leave blank to keep' : '' ?>"></label>
  <label>Role
    <select name="role">
      <option value="customer" <?= ($user['role'] ?? '') === 'customer' ? 'selected' : '' ?>>Customer</option>
      <option value="moderator" <?= ($user['role'] ?? '') === 'moderator' ? 'selected' : '' ?>>Moderator</option>
      <option value="admin" <?= ($user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>
  </label>
  <?php if ($isEdit): ?>
  <label>Status
    <select name="status">
      <option value="active" <?= ($user['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
      <option value="blocked" <?= ($user['status'] ?? '') === 'blocked' ? 'selected' : '' ?>>Blocked</option>
    </select>
  </label>
  <?php endif; ?>
  <button type="submit" class="btn-admin">Save</button>
</form>
