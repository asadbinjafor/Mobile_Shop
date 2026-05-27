<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>
<?php require ROOT_PATH . '/resources/views/partials/header.php'; ?>
<section class="section page-header">
  <div class="container">
    <h1 class="sec-heading"><?= $category['icon'] ?? '📱' ?> <?= e($category['name']) ?></h1>
    <p class="page-meta"><?= count($products) ?> product(s) in this category</p>
  </div>
</section>
<section class="section shop-listing">
  <div class="container shop-layout">
    <?php
    $categories = $categories ?? [];
    $brands = $brands ?? [];
    require ROOT_PATH . '/resources/views/partials/shop-filters.php';
    ?>
    <div class="shop-main">
      <div class="shop-toolbar">
        <span><?= count($products) ?> results</span>
      </div>
      <?php if (empty($products)): ?>
        <p class="empty-msg">No products in this category yet.</p>
      <?php else: ?>
        <div class="product-grid product-grid-v2">
          <?php foreach ($products as $p) { require ROOT_PATH . '/resources/views/partials/product-card-v2.php'; } ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
