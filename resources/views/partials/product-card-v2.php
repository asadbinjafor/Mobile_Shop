<?php /** @var array $p */ ?>
<article class="product-card-v2" data-id="<?= (int)$p['id'] ?>" data-name="<?= e(strtolower($p['name'])) ?>" data-brand="<?= e($p['brand']) ?>">
  <span class="badge-discount"><?= (int)$p['discount'] ?>% OFF</span>
  <?php if ($p['inStock']): ?><span class="badge-stock">In Stock</span><?php else: ?><span class="badge-stock out">Out of Stock</span><?php endif; ?>
  <button class="wish-btn" data-id="<?= (int)$p['id'] ?>" style="position:absolute;top:10px;right:10px;z-index:3">♡</button>
  <a href="<?= url('/products/' . $p['id']) ?>" class="pc-img">
    <img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>" loading="lazy">
  </a>
  <div class="pc-body">
    <div class="pc-rating">★ <?= $p['rating'] ?> (<?= (int)$p['reviewCount'] ?>)</div>
    <h3 class="pc-name"><a href="<?= url('/products/' . $p['id']) ?>"><?= e($p['name']) ?></a></h3>
    <div class="pc-price">
      <strong><?= e($p['formattedPrice']) ?></strong>
      <?php if ($p['discount'] > 0): ?><del><?= e($p['formattedOldPrice']) ?></del><?php endif; ?>
    </div>
    <div class="pc-actions">
      <a href="<?= url('/products/' . $p['id']) ?>" class="btn-shop-outline">Quick View</a>
      <button class="btn-shop-primary add-cart-btn" data-id="<?= (int)$p['id'] ?>" <?= !$p['inStock'] ? 'disabled' : '' ?>>
        <?= $p['inStock'] ? 'Add to Cart' : 'Sold Out' ?>
      </button>
    </div>
  </div>
</article>
