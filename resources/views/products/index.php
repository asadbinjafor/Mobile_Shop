<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>
<?php require ROOT_PATH . '/resources/views/partials/header.php'; ?>

<div class="page-hero">
  <div class="container">
    <h1><?= e($title) ?></h1>
    <p><?= count($products) ?> products found</p>
  </div>
</div>

<section class="section" style="padding-top:0">
  <div class="container shop-layout">
    <?php require ROOT_PATH . '/resources/views/partials/shop-filters.php'; ?>
    <div>
      <div class="toolbar">
        <button type="button" class="btn-shop-outline" onclick="document.getElementById('shopSidebar').classList.toggle('open')" style="display:none" id="filterToggleBtn">☰ Filters</button>
        <span style="font-size:.9rem;color:var(--text-muted)">Showing <?= count($products) ?> items</span>
        <form method="GET" style="display:flex;gap:8px;align-items:center">
          <?php if ($query): ?><input type="hidden" name="q" value="<?= e($query) ?>"><?php endif; ?>
          <?php if ($brand): ?><input type="hidden" name="brand" value="<?= e($brand) ?>"><?php endif; ?>
          <?php if ($category): ?><input type="hidden" name="category" value="<?= e($category) ?>"><?php endif; ?>
          <label style="font-size:.85rem">Sort:</label>
          <select name="sort" onchange="this.form.submit()">
            <option value="newest" <?= ($sort ?? '') === 'newest' ? 'selected' : '' ?>>Newest</option>
            <option value="price_low" <?= ($sort ?? '') === 'price_low' ? 'selected' : '' ?>>Price: Low to High</option>
            <option value="price_high" <?= ($sort ?? '') === 'price_high' ? 'selected' : '' ?>>Price: High to Low</option>
            <option value="name" <?= ($sort ?? '') === 'name' ? 'selected' : '' ?>>Name A-Z</option>
          </select>
        </form>
      </div>
      <?php if (empty($products)): ?>
        <p style="text-align:center;padding:60px;color:var(--text-muted)">No products found. <a href="<?= url('/products') ?>">Browse all</a></p>
      <?php else: ?>
      <div class="product-grid" style="grid-template-columns:repeat(auto-fill,minmax(220px,1fr))">
        <?php foreach ($products as $p) { require ROOT_PATH . '/resources/views/partials/product-card-v2.php'; } ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
