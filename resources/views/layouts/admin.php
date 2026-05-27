<?php
use App\Core\Auth;
use App\Core\Permission;
$flashSuccess = \App\Core\Session::flash('success');
$flashError = \App\Core\Session::flash('error');
?>
<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($title ?? 'Admin') ?> — Admin Panel</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
  <link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head>
<body class="admin-body">
<script>window.BASE_URL = <?= json_encode(base_url()) ?>;</script>
<div class="admin-wrap">
  <aside class="admin-sidebar">
    <a href="<?= url('/admin') ?>" class="admin-brand">📱 MobileHub <small>Admin</small></a>
    <nav class="admin-nav">
      <a href="<?= url('/admin') ?>">📊 Dashboard</a>
      <?php if (Permission::can('users.view') || Auth::isAdmin()): ?>
      <a href="<?= url('/admin/users') ?>">👥 Users</a>
      <?php endif; ?>
      <a href="<?= url('/admin/products') ?>">📦 Products</a>
      <a href="<?= url('/admin/categories') ?>">🧩 Categories</a>
      <a href="<?= url('/admin/brands') ?>">🏷️ Brands</a>
      <a href="<?= url('/admin/orders') ?>">🛒 Orders</a>
      <?php if (Auth::isAdmin()): ?>
      <a href="<?= url('/admin/settings') ?>">⚙ Settings</a>
      <?php endif; ?>
      <hr>
      <a href="<?= url('/') ?>">🌐 View Shop</a>
      <a href="<?= url('/logout') ?>">🚪 Logout</a>
    </nav>
    <div class="admin-user">
      <strong><?= e(Auth::user()['name']) ?></strong>
      <span><?= e(Permission::roleLabel(Auth::role())) ?></span>
    </div>
  </aside>
  <main class="admin-main">
    <?php if ($flashSuccess): ?><div class="alert alert-success"><?= e($flashSuccess) ?></div><?php endif; ?>
    <?php if ($flashError): ?><div class="alert alert-error"><?= e($flashError) ?></div><?php endif; ?>
    <?php require $contentView; ?>
  </main>
</div>
</body>
</html>
