<?php
use App\Core\Auth;
require ROOT_PATH . '/resources/views/partials/head.php';
require ROOT_PATH . '/resources/views/partials/header.php';
?>
<section class="section">
  <div class="container dash-layout">
    <?php require ROOT_PATH . '/resources/views/partials/customer-sidebar.php'; ?>
    <div class="dash-main">
      <h1 style="margin:0 0 24px;font-size:1.5rem">Dashboard</h1>
      <?php if ($msg = \App\Core\Session::flash('success')): ?><div class="alert alert-success" style="background:#DCFCE7;color:#15803D;padding:12px;border-radius:8px;margin-bottom:16px"><?= e($msg) ?></div><?php endif; ?>
      <div class="stat-cards">
        <div class="stat-card-v2"><strong><?= (int)$orderCount ?></strong><span>Total Orders</span></div>
        <div class="stat-card-v2" style="border-left-color:var(--accent)"><strong>0</strong><span>Wishlist Items</span></div>
        <div class="stat-card-v2" style="border-left-color:var(--success)"><strong>Active</strong><span>Account Status</span></div>
      </div>
      <h2 style="font-size:1.1rem;margin-bottom:16px">Recent Orders</h2>
      <?php if (empty($orders)): ?>
        <p style="color:var(--text-muted)">No orders yet. <a href="<?= url('/products') ?>" style="color:var(--secondary)">Start shopping</a></p>
      <?php else: ?>
      <table class="admin-table">
        <thead><tr><th>Order #</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
        <tbody>
          <?php foreach (array_slice($orders, 0, 5) as $o): ?>
          <tr>
            <td><?= e($o['order_number']) ?></td>
            <td>৳ <?= number_format((int)$o['total']) ?></td>
            <td><?= e($o['status']) ?></td>
            <td><?= e(substr($o['created_at'], 0, 10)) ?></td>
            <td><a href="<?= url('/account/orders/' . $o['id']) ?>">Track</a></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
