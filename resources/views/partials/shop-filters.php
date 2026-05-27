<?php
$brand = $brand ?? '';
$category = $category ?? '';
$minPrice = $minPrice ?? 0;
$maxPrice = $maxPrice ?? 0;
?>
<aside class="shop-sidebar" id="shopSidebar">
  <form method="GET" action="<?= url('/products') ?>">
    <?php if (!empty($query)): ?><input type="hidden" name="q" value="<?= e($query) ?>"><?php endif; ?>

    <div class="filter-card">
      <h3>Categories</h3>
      <ul class="filter-list">
        <li><label><input type="radio" name="category" value="" <?= $category === '' ? 'checked' : '' ?>> All</label></li>
        <?php foreach ($categories as $cat): ?>
        <li><label><input type="radio" name="category" value="<?= e($cat['slug']) ?>" <?= $category === $cat['slug'] ? 'checked' : '' ?>> <?= e($cat['name']) ?></label></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="filter-card">
      <h3>Brand</h3>
      <ul class="filter-list">
        <li><label><input type="radio" name="brand" value="" <?= $brand === '' ? 'checked' : '' ?>> All Brands</label></li>
        <?php foreach ($brands as $b): ?>
        <li><label><input type="radio" name="brand" value="<?= e($b['slug']) ?>" <?= $brand === $b['slug'] ? 'checked' : '' ?>> <?= e($b['name']) ?></label></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="filter-card">
      <h3>Price Range (৳)</h3>
      <label style="display:block;margin-bottom:8px;font-size:.85rem">Min<input type="number" name="min_price" value="<?= $minPrice ?: '' ?>" placeholder="0" style="width:100%;margin-top:4px;padding:8px;border:1px solid var(--border);border-radius:6px"></label>
      <label style="display:block;font-size:.85rem">Max<input type="number" name="max_price" value="<?= $maxPrice ?: '' ?>" placeholder="500000" style="width:100%;margin-top:4px;padding:8px;border:1px solid var(--border);border-radius:6px"></label>
    </div>

    <button type="submit" class="btn-shop-primary" style="width:100%">Apply Filters</button>
    <a href="<?= url('/products') ?>" style="display:block;text-align:center;margin-top:10px;font-size:.85rem;color:var(--secondary)">Clear all</a>
  </form>
</aside>
