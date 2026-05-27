<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>
<?php require ROOT_PATH . '/resources/views/partials/header.php'; ?>
<section class="section">
  <div class="container dash-layout">
    <?php require ROOT_PATH . '/resources/views/partials/customer-sidebar.php'; ?>
    <div class="dash-main">
      <?php if ($msg = \App\Core\Session::flash('success')): ?>
      <div class="alert alert-success" style="background:#DCFCE7;color:#15803D;padding:12px;border-radius:8px;margin-bottom:16px"><?= e($msg) ?></div>
      <script>localStorage.removeItem('mobilehub_cart');</script>
      <?php endif; ?>
      <h1 style="margin:0 0 24px">My Orders</h1>
      <table class="admin-table">
        <thead><tr><th>Order #</th><th>Total</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($orders as $o): ?>
          <tr>
            <td><?= e($o['order_number']) ?></td>
            <td>৳ <?= number_format((int)$o['total']) ?></td>
            <td><span style="text-transform:capitalize"><?= e($o['status']) ?></span></td>
            <td><?= e(substr($o['created_at'], 0, 10)) ?></td>
            <td>
              <a href="<?= url('/account/orders/' . $o['id']) ?>" class="btn-shop-outline" style="padding:6px 12px;font-size:.8rem">Track</a>
              <?php if ($o['status'] === 'pending'): ?>
              <form method="POST" action="<?= url('/account/orders/' . $o['id'] . '/cancel') ?>" style="display:inline">
                <button type="submit" style="background:none;border:none;color:var(--danger);cursor:pointer;font-size:.85rem">Cancel</button>
              </form>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (empty($orders)): ?><tr><td colspan="5" style="text-align:center;padding:32px">No orders yet. <a href="<?= url('/products') ?>">Start shopping</a></td></tr><?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
