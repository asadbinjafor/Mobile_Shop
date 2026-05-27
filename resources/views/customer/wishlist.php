<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>
<?php require ROOT_PATH . '/resources/views/partials/header.php'; ?>
<section class="section">
  <div class="container dash-layout">
    <?php require ROOT_PATH . '/resources/views/partials/customer-sidebar.php'; ?>
    <div class="dash-main">
      <h1 style="margin:0 0 24px">My Wishlist</h1>
      <div id="wishlistGrid" class="product-grid" style="grid-template-columns:repeat(auto-fill,minmax(200px,1fr))">
        <p style="color:var(--text-muted)">Loading wishlist...</p>
      </div>
    </div>
  </div>
</section>
<script>
(async function() {
  const ids = JSON.parse(localStorage.getItem('mobilehub_wishlist') || '[]');
  const grid = document.getElementById('wishlistGrid');
  if (!ids.length) {
    grid.innerHTML = '<p>No items in wishlist. <a href="' + (window.BASE_URL||'') + '/products">Browse products</a></p>';
    return;
  }
  const cards = [];
  for (const id of ids) {
    try {
      const res = await fetch((window.BASE_URL||'') + '/api/products/' + id);
      if (res.ok) cards.push(await res.json());
    } catch(e) {}
  }
  if (!cards.length) { grid.innerHTML = '<p>Could not load products.</p>'; return; }
  grid.innerHTML = cards.map(p => `
    <div class="product-card-v2">
      <a href="${window.BASE_URL||''}/products/${p.id}" class="pc-img"><img src="${p.image}" alt=""></a>
      <div class="pc-body">
        <h3 class="pc-name">${p.name}</h3>
        <div class="pc-price"><strong>${p.formattedPrice}</strong></div>
        <button class="btn-shop-primary add-cart-btn" data-id="${p.id}" style="width:100%;margin-top:8px">Add to Cart</button>
      </div>
    </div>
  `).join('');
})();
</script>
<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
