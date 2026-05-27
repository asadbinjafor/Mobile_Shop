<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>
<?php require ROOT_PATH . '/resources/views/partials/header.php'; ?>

<section class="hero-section"><div class="container hero-layout">
  <div class="hero-main">
    <div class="hero-slider">
      <div class="hero-slide active"><img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=900&q=80" alt=""><div class="hero-overlay"><span class="tag">Flash Sale</span><h2>Latest Smartphones<br>Up to 40% OFF</h2><a href="#flash-sale" class="btn-shop">Shop Now →</a></div></div>
      <div class="hero-slide"><img src="https://images.unsplash.com/photo-1611186871348-b1ce18000c9f?w=900&q=80" alt=""><div class="hero-overlay"><span class="tag">Apple</span><h2>iPhone 17 Series</h2><a href="<?= url('/category/phones') ?>" class="btn-shop">Explore →</a></div></div>
    </div>
    <div class="hero-nav"><button class="hero-arrow prev" id="heroPrev">‹</button><div class="hero-dots" id="heroDots"></div><button class="hero-arrow next" id="heroNext">›</button></div>
  </div>
  <div class="hero-side">
    <a href="#flash-sale" class="side-banner banner-1"><span>0% EMI</span><strong>36 Months Installment</strong></a>
    <a href="#" class="side-banner banner-2"><span>Free Delivery</span><strong>Order Today</strong></a>
  </div>
</div></section>

<section class="features-bar"><div class="container features-grid">
  <div class="feature-box"><div class="f-icon fi-green">✓</div><div><strong>100% Genuine</strong></div></div>
  <div class="feature-box"><div class="f-icon fi-blue">🚀</div><div><strong>Fast Delivery</strong></div></div>
  <div class="feature-box"><div class="f-icon fi-orange">💳</div><div><strong>36 Months EMI</strong></div></div>
  <div class="feature-box"><div class="f-icon fi-purple">🔄</div><div><strong>2 Years Replacement</strong></div></div>
  <div class="feature-box"><div class="f-icon fi-red">💰</div><div><strong>Best Price in BD</strong></div></div>
</div></section>

<section class="section"><div class="container"><h2 class="sec-heading">Shop by Categories</h2><div class="cat-grid">
  <?php foreach ($categories as $cat): ?>
  <a href="<?= url('/category/' . $cat['slug']) ?>" class="cat-item"><div class="cat-img"><?= $cat['icon'] ?></div><span><?= e($cat['name']) ?></span></a>
  <?php endforeach; ?>
</div></div></section>

<section class="flash-section" id="flash-sale"><div class="container">
  <div class="flash-banner"><div class="flash-title-wrap"><span class="fire">🔥</span><h2>Flash Sale ~ Mega EID Fest | 0% EMI | Free Delivery</h2></div>
  <div class="flash-timer"><span class="timer-label">Ends in:</span><div class="timer-boxes">
    <div><b id="hours">00</b><small>Hrs</small></div><span>:</span>
    <div><b id="minutes">00</b><small>Min</small></div><span>:</span>
    <div><b id="seconds">00</b><small>Sec</small></div>
  </div></div></div>
  <div class="carousel-wrap">
    <button class="carousel-btn prev" data-target="flashCarousel">‹</button>
    <div class="product-carousel" id="flashCarousel">
        <?php foreach ($flashProducts as $p) { require ROOT_PATH . '/resources/views/partials/product-card-v2.php'; } ?>
    </div>
    <button class="carousel-btn next" data-target="flashCarousel">›</button>
  </div>
</div></section>

<section class="section"><div class="container"><div class="sec-header"><h2 class="sec-heading">Best Deal Products</h2><a href="<?= url('/products') ?>" class="view-all">View All →</a></div>
<div class="product-grid"><?php foreach ($dealProducts as $p) { require ROOT_PATH . '/resources/views/partials/product-card-v2.php'; } ?></div></div></section>

<section class="section bg-gray"><div class="container"><div class="sec-header"><h2 class="sec-heading">Recently Added</h2><a href="<?= url('/products') ?>" class="view-all">View All →</a></div>
<div class="product-grid"><?php foreach ($recentProducts as $p) { require ROOT_PATH . '/resources/views/partials/product-card-v2.php'; } ?></div></div></section>

<section class="section"><div class="container"><div class="sec-header"><h2 class="sec-heading">Trending Products</h2></div>
<div class="product-grid"><?php foreach ($trendingProducts as $p) { require ROOT_PATH . '/resources/views/partials/product-card-v2.php'; } ?></div></div></section>

<section class="brand-section"><div class="container"><h2 class="sec-heading center">Shop by Brand</h2><div class="brand-logos">
  <?php foreach ($brands as $b): ?><a href="<?= url('/products?brand=' . $b['slug']) ?>" class="brand-logo"><?= e($b['name']) ?></a><?php endforeach; ?>
</div></div></section>

<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
