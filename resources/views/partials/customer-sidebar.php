<?php
use App\Core\Auth;
$path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
?>
<aside class="dash-sidebar">
  <div style="padding:8px 14px 16px;border-bottom:1px solid var(--border);margin-bottom:12px">
    <strong><?= e(Auth::user()['name']) ?></strong>
    <div style="font-size:.8rem;color:var(--text-muted)"><?= e(Auth::user()['email']) ?></div>
  </div>
  <a href="<?= url('/account') ?>" class="<?= str_contains($path, '/account') && !str_contains($path, 'orders') && !str_contains($path, 'wishlist') && !str_contains($path, 'profile') ? 'active' : '' ?>">📊 Dashboard</a>
  <a href="<?= url('/account/orders') ?>" class="<?= str_contains($path, '/orders') ? 'active' : '' ?>">📦 My Orders</a>
  <a href="<?= url('/account/wishlist') ?>" class="<?= str_contains($path, 'wishlist') ? 'active' : '' ?>">♡ Wishlist</a>
  <a href="<?= url('/account/profile') ?>" class="<?= str_contains($path, 'profile') ? 'active' : '' ?>">👤 Profile</a>
  <a href="<?= url('/cart') ?>">🛒 Cart</a>
  <hr style="margin:12px 0;border:none;border-top:1px solid var(--border)">
  <a href="<?= url('/') ?>">🌐 Continue Shopping</a>
  <a href="<?= url('/logout') ?>">🚪 Logout</a>
</aside>
