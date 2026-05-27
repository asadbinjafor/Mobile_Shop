<?php
use App\Core\Auth;
use App\Core\Permission;
$query = $query ?? '';
$selectedCategory = $category ?? ($_GET['category'] ?? '');
$phone = config('phone');
$phoneTel = preg_replace('/^0/', '', $phone);
?>
<div class="marquee-bar"><div class="marquee-track">
  <span>🔥 Mega EID Fest — 0% EMI | Upto ৳25,000 Cashback | Free Delivery</span>
  <span>📱 Latest iPhone, Samsung, Xiaomi at Best Price in BD</span>
</div></div>
<div class="top-bar"><div class="container top-bar-inner">
  <div class="top-left">
    <a href="tel:+88<?= e($phoneTel) ?>">📞 Hotline: <?= e($phone) ?></a>
    <a href="#">📍 Store Locator</a>
    <a href="<?= url('/account/orders') ?>">🚚 Track Order</a>
  </div>
  <div class="top-right">
    <?php if (Auth::check()): ?>
      <a href="<?= url(Permission::dashboardUrl()) ?>">Dashboard (<?= e(Auth::role()) ?>)</a><span>|</span>
      <a href="<?= url('/logout') ?>">Logout</a>
    <?php else: ?>
      <a href="<?= url('/login') ?>">Sign In</a><span>|</span><a href="<?= url('/register') ?>">Sign Up</a>
    <?php endif; ?>
    <span>|</span><a href="<?= url('/#flash-sale') ?>">Offers</a>
  </div>
</div></div>
<header class="header">
  <div class="container header-main">
    <button class="hamburger" id="hamburger" aria-label="Menu"><span></span><span></span><span></span></button>
    <a href="<?= url('/') ?>" class="logo"><div class="logo-mark">M</div><div class="logo-name"><strong>MobileHub</strong><small>Best Price in BD</small></div></a>
    <form class="search-wrap" action="<?= url('/products') ?>" method="GET" autocomplete="off">
      <select class="search-cat" name="category">
        <option value="">All Categories</option>
        <?php foreach ($categories as $cat): ?>
        <option value="<?= e($cat['slug']) ?>" <?= $selectedCategory === $cat['slug'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
        <?php endforeach; ?>
      </select>
      <input type="search" name="q" id="searchInput" placeholder="Search phones, laptops..." value="<?= e($query ?? '') ?>">
      <button class="search-btn" type="submit" aria-label="Search"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg></button>
      <div class="search-suggest" id="searchSuggest"></div>
    </form>
    <div class="header-icons">
      <a href="<?= url('/products') ?>" class="h-icon"><span>Shop</span></a>
      <a href="<?= url('/account/wishlist') ?>" class="h-icon" id="wishlistBtn"><span>Wishlist</span><em class="badge-sm" id="wishCount">0</em></a>
      <a href="#" class="h-icon cart-icon" id="cartBtn"><span>Cart</span><em class="badge-sm cart-badge" id="cartCount">0</em></a>
    </div>
  </div>
  <nav class="main-nav" id="mainNav"><div class="container nav-wrap">
    <div class="nav-item"><a href="<?= url('/#flash-sale') ?>" class="nav-link offer-tab">🔥 OFFER</a></div>
    <div class="nav-item has-mega">
      <a href="<?= url('/category/phones') ?>" class="nav-link">Phones <span class="arrow">▾</span></a>
      <div class="mega-menu"><div class="mega-col">
        <?php foreach ($brands as $b): ?><a href="<?= url('/products?brand=' . $b['slug']) ?>"><?= e($b['name']) ?></a><?php endforeach; ?>
      </div></div>
    </div>
    <?php foreach ($categories as $cat): if ($cat['slug'] === 'phones') continue; ?>
    <div class="nav-item"><a href="<?= url('/category/' . $cat['slug']) ?>" class="nav-link"><?= e($cat['name']) ?></a></div>
    <?php endforeach; ?>
  </div></nav>
</header>
