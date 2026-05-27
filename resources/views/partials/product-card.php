<?php /** @var array $p */ ?>
<article class="product-card" data-id="<?= (int)$p['id'] ?>" data-name="<?= e(strtolower($p['name'])) ?>" data-brand="<?= e($p['brand']) ?>">
  <div class="p-badges">
    <span class="discount-badge"><?= (int)$p['discount'] ?>%</span>
    <span class="label-badge <?= e($p['labelClass']) ?>"><?= e($p['labelText']) ?></span>
  </div>
  <button class="wish-btn" data-id="<?= (int)$p['id'] ?>">♡</button>
  <a href="<?= url('/products/' . $p['id']) ?>" class="product-img-wrap<?= !empty($p['outOfStock']) ? ' sold-out' : '' ?>">
    <img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>" loading="lazy">
  </a>
  <div class="product-body">
    <div class="product-brand"><?= e($p['brand']) ?></div>
    <h3 class="product-name"><a href="<?= url('/products/' . $p['id']) ?>"><?= e($p['name']) ?></a></h3>
    <?php if ($p['hasEmi']): ?><span class="emi-tag">0% EMI Available</span><?php endif; ?>
    <div class="price-row">
      <span class="price-now"><?= e($p['formattedPrice']) ?></span>
      <span class="price-was"><?= e($p['formattedOldPrice']) ?></span>
      <?php if ($p['discount'] >= 20): ?><span class="save-tag">Save <?= (int)$p['discount'] ?>%</span><?php endif; ?>
    </div>
    <div class="product-btns">
      <a href="<?= url('/products/' . $p['id']) ?>" class="btn-view">VIEW</a>
      <button class="btn-cart add-cart-btn" data-id="<?= (int)$p['id'] ?>" <?= !empty($p['outOfStock']) ? 'disabled' : '' ?>>
        <?= !empty($p['outOfStock']) ? 'Out of Stock' : 'Add to Cart' ?>
      </button>
    </div>
  </div>
</article>
