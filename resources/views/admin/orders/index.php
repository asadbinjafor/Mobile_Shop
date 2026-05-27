<h1>Order Management</h1>
<table class="admin-table">
  <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th>Date</th><th></th></tr></thead>
  <tbody>
    <?php foreach ($orders as $o): ?>
    <tr>
      <td><?= e($o['order_number']) ?></td>
      <td><?= e($o['customer_name']) ?><br><small><?= e($o['customer_email']) ?></small></td>
      <td>৳ <?= number_format((int)$o['total']) ?></td>
      <td><?= e($o['status']) ?></td>
      <td><?= e(substr($o['created_at'], 0, 10)) ?></td>
      <td><a href="<?= url('/admin/orders/' . $o['id']) ?>" class="btn-admin btn-sm">View</a></td>
    </tr>
    <?php endforeach; ?>
    <?php if (empty($orders)): ?><tr><td colspan="6">No orders yet</td></tr><?php endif; ?>
  </tbody>
</table>
