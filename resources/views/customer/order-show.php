<?php
$statuses = ['pending','confirmed','processing','shipped','delivered'];
$current = array_search($order['status'], $statuses);
if ($current === false) $current = 0;
require ROOT_PATH . '/resources/views/partials/head.php';
require ROOT_PATH . '/resources/views/partials/header.php';
?>
<section class="section">
  <div class="container dash-layout">
    <?php require ROOT_PATH . '/resources/views/partials/customer-sidebar.php'; ?>
    <div class="dash-main">
      <h1>Order <?= e($order['order_number']) ?></h1>
      <p style="color:var(--text-muted);margin-bottom:24px">Placed on <?= e($order['created_at']) ?></p>

      <h2 style="font-size:1rem;margin-bottom:16px">Order Tracking</h2>
      <div class="tracking-timeline">
        <?php
        $steps = [
          ['Order Placed', 'Your order has been received'],
          ['Processing', 'We are preparing your order'],
          ['Shipped', 'Order handed to courier'],
          ['Out for Delivery', 'Arriving soon'],
          ['Delivered', 'Order completed'],
        ];
        foreach ($steps as $i => $step):
          $cls = $i < $current ? 'done' : ($i === $current ? 'active' : '');
        ?>
        <div class="track-step <?= $cls ?>">
          <h4><?= $step[0] ?></h4>
          <p><?= $step[1] ?></p>
        </div>
        <?php endforeach; ?>
      </div>

      <h2 style="font-size:1rem;margin:28px 0 12px">Items</h2>
      <table class="admin-table">
        <thead><tr><th>Product</th><th>Qty</th><th>Price</th></tr></thead>
        <tbody>
          <?php foreach ($items as $i): ?>
          <tr><td><?= e($i['product_name']) ?></td><td><?= (int)$i['qty'] ?></td><td>৳ <?= number_format((int)$i['price']) ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <p style="margin-top:20px;font-size:1.2rem"><strong>Total: ৳ <?= number_format((int)$order['total']) ?></strong></p>
    </div>
  </div>
</section>
<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
