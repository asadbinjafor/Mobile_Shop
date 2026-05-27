<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>
<?php require ROOT_PATH . '/resources/views/partials/header.php'; ?>
<div class="error-page">
  <h1>404</h1>
  <h2 style="margin:0 0 8px;color:var(--primary)">Page Not Found</h2>
  <p>The page you're looking for doesn't exist or has been moved.</p>
  <form action="<?= url('/products') ?>" method="GET" style="max-width:400px;margin:0 auto 24px;display:flex;gap:8px">
    <input type="search" name="q" placeholder="Search products..." style="flex:1;padding:12px;border:2px solid var(--border);border-radius:8px">
    <button type="submit" class="btn-shop-primary" style="border:none;padding:12px 20px;border-radius:8px;color:#fff;cursor:pointer">Search</button>
  </form>
  <a href="<?= url('/') ?>" class="btn-checkout-full" style="display:inline-block;width:auto;padding:12px 28px;text-decoration:none">Go Home</a>
</div>
<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
