<?php
use App\Core\Auth;
$contentView = $contentView ?? '';
$flashSuccess = \App\Core\Session::flash('success');
$flashError = \App\Core\Session::flash('error');
?>
<!DOCTYPE html>
<html lang="bn"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($title ?? 'Moderator') ?></title>
<link rel="stylesheet" href="<?= asset('css/style.css') ?>"><link rel="stylesheet" href="<?= asset('css/admin.css') ?>">
</head><body class="admin-body"><div class="admin-wrap">
<aside class="admin-sidebar moderator-sidebar">
  <a href="<?= url('/moderator') ?>" class="admin-brand">📱 Moderator Panel</a>
  <nav class="admin-nav">
    <a href="<?= url('/moderator') ?>">📊 Dashboard</a>
    <a href="<?= url('/admin/products') ?>">📦 Products</a>
    <a href="<?= url('/moderator/orders') ?>">🛒 Orders</a>
    <hr><a href="<?= url('/') ?>">🌐 Shop</a><a href="<?= url('/logout') ?>">🚪 Logout</a>
  </nav>
  <div class="admin-user"><strong><?= e(Auth::user()['name']) ?></strong><span>Moderator</span></div>
</aside>
<main class="admin-main">
  <?php if ($flashSuccess): ?><div class="alert alert-success"><?= e($flashSuccess) ?></div><?php endif; ?>
  <?php if ($flashError): ?><div class="alert alert-error"><?= e($flashError) ?></div><?php endif; ?>
  <?php require $contentView; ?>
</main></div></body></html>
