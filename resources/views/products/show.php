<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>
<?php require ROOT_PATH . '/resources/views/partials/header.php'; ?>

<section class="section">
  <div class="container">
    <div class="pd-layout">
      <div class="pd-gallery">
        <img src="<?= e($product['image']) ?>" alt="<?= e($product['name']) ?>" id="mainProductImg">
        <div class="pd-thumbs">
          <img src="<?= e($product['image']) ?>" class="active" onclick="document.getElementById('mainProductImg').src=this.src">
        </div>
      </div>
      <div class="pd-info">
        <div class="pd-meta">
          <span>★ <?= $product['rating'] ?> (<?= (int)$product['reviewCount'] ?> reviews)</span>
          <span>Brand: <strong><?= e(ucfirst($product['brand'])) ?></strong></span>
          <span><?= $product['inStock'] ? '<span style="color:var(--success)">● In Stock</span>' : '<span style="color:var(--danger)">● Out of Stock</span>' ?></span>
        </div>
        <h1><?= e($product['name']) ?></h1>
        <?php if ($product['hasEmi']): ?><span class="emi-tag" style="display:inline-block;margin-bottom:16px">0% EMI Available</span><?php endif; ?>
        <div class="pd-price-box">
          <span class="price-main"><?= e($product['formattedPrice']) ?></span>
          <?php if ($product['discount'] > 0): ?>
          <span class="price-old"><?= e($product['formattedOldPrice']) ?></span>
          <span style="background:#FEF3C7;color:#B45309;padding:4px 10px;border-radius:6px;font-size:.85rem;font-weight:700;margin-left:8px"><?= $product['discount'] ?>% OFF</span>
          <?php endif; ?>
        </div>
        <div class="pd-variants">
          <label>Storage</label>
          <div class="variant-pills">
            <button type="button" class="active">128GB</button>
            <button type="button">256GB</button>
            <button type="button">512GB</button>
          </div>
        </div>
        <div class="pd-variants">
          <label>Color</label>
          <div class="variant-pills">
            <button type="button" class="active">Black</button>
            <button type="button">Blue</button>
            <button type="button">Silver</button>
          </div>
        </div>
        <label style="font-weight:600;font-size:.85rem;display:block;margin-bottom:8px">Quantity</label>
        <div class="qty-selector">
          <button type="button" onclick="changeQty(-1)">−</button>
          <input type="number" id="qty" value="1" min="1" max="10" readonly>
          <button type="button" onclick="changeQty(1)">+</button>
        </div>
        <div class="pd-actions">
          <button class="btn-shop-primary add-cart-btn" data-id="<?= (int)$product['id'] ?>" style="flex:1;padding:14px" <?= !$product['inStock'] ? 'disabled' : '' ?>>Add to Cart</button>
          <button class="btn-buy" onclick="buyNow(<?= (int)$product['id'] ?>)">Buy Now</button>
          <button class="wish-btn btn-shop-outline" data-id="<?= (int)$product['id'] ?>" style="padding:14px 20px">♡ Wishlist</button>
        </div>
      </div>
    </div>

    <div class="pd-tabs">
      <div class="tab-nav">
        <button type="button" class="active" data-tab="desc">Description</button>
        <button type="button" data-tab="spec">Specification</button>
        <button type="button" data-tab="reviews">Reviews</button>
        <button type="button" data-tab="warranty">Warranty</button>
      </div>
      <div class="tab-panel active" id="tab-desc">
        <p><?= e($product['name']) ?> — 100% genuine product with official brand warranty. Free delivery available in Dhaka. Cash on delivery supported nationwide.</p>
      </div>
      <div class="tab-panel" id="tab-spec">
        <table class="admin-table"><tbody>
          <tr><td>Brand</td><td><?= e(ucfirst($product['brand'])) ?></td></tr>
          <tr><td>Category</td><td><?= e($product['category'] ?? 'phones') ?></td></tr>
          <tr><td>Warranty</td><td>Official 1 Year</td></tr>
        </tbody></table>
      </div>
      <div class="tab-panel" id="tab-reviews">
        <p>★ <?= $product['rating'] ?> average from <?= (int)$product['reviewCount'] ?> reviews</p>
      </div>
      <div class="tab-panel" id="tab-warranty">
        <p>Official brand warranty. 7 days easy return policy. Genuine product guarantee.</p>
      </div>
    </div>

    <?php if (!empty($related)): ?>
    <h2 class="sec-heading" style="margin-top:48px">Related Products</h2>
    <div class="product-grid" style="grid-template-columns:repeat(auto-fill,minmax(220px,1fr))">
      <?php foreach ($related as $p) { require ROOT_PATH . '/resources/views/partials/product-card-v2.php'; } ?>
    </div>
    <?php endif; ?>
  </div>
</section>

<script>
function changeQty(d) {
  const el = document.getElementById('qty');
  el.value = Math.min(10, Math.max(1, parseInt(el.value) + d));
}
function buyNow(id) {
  const btn = document.querySelector('.add-cart-btn');
  if (btn) btn.click();
  setTimeout(() => location.href = (window.BASE_URL||'') + '/checkout', 500);
}
document.querySelectorAll('.tab-nav button').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.tab-nav button').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
  });
});
document.querySelectorAll('.variant-pills').forEach(group => {
  group.querySelectorAll('button').forEach(b => {
    b.addEventListener('click', () => {
      group.querySelectorAll('button').forEach(x => x.classList.remove('active'));
      b.classList.add('active');
    });
  });
});
</script>

<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
