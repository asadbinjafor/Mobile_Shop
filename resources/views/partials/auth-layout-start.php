<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($title ?? 'Account') ?> — <?= e(config('site_name')) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= asset('css/auth.css') ?>">
</head>
<body class="auth-body">
<script>window.BASE_URL = <?= json_encode(base_url()) ?>;</script>
<div class="auth-shell">
  <div class="auth-brand-panel">
    <div class="auth-brand-top">
      <a href="<?= url('/') ?>" class="auth-logo">
        <div class="auth-logo-mark">M</div>
        <div class="auth-logo-text">
          <strong>MobileHub</strong>
          <small>Best Price in BD</small>
        </div>
      </a>
      <div class="auth-hero">
        <?php if (!empty($authHeroTitle)): ?>
          <h2><?= e($authHeroTitle) ?></h2>
          <p><?= e($authHeroText ?? '') ?></p>
        <?php else: ?>
          <h2>Bangladesh's Trusted Mobile Shop</h2>
          <p>100% genuine products, best price, fast delivery & 0% EMI available.</p>
        <?php endif; ?>
        <ul class="auth-features">
          <li><span>✓</span> 100% Genuine Products</li>
          <li><span>🚀</span> Super Fast Delivery</li>
          <li><span>💳</span> 0% EMI — 36 Months</li>
          <li><span>🔄</span> Easy Return & Warranty</li>
        </ul>
      </div>
    </div>
    <div class="auth-brand-footer">© <?= date('Y') ?> <?= e(config('site_name')) ?></div>
  </div>
  <div class="auth-form-panel">
    <div class="auth-card">
