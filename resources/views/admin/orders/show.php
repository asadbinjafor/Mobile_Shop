<?php use App\Core\Auth; ?>
<h1>Order <?= e($order['order_number']) ?></h1>
<p><strong>Status:</strong> <?= e($order['status']) ?> | <strong>Total:</strong> ৳ <?= number_format((int)$order['total']) ?></p>
<p><strong>Ship to:</strong> <?= e($order['shipping_name']) ?>, <?= e($order['shipping_phone']) ?><br><?= e($order['shipping_address']) ?></p>
<table class="admin-table"><thead><tr><th>Product</th><th>Qty</th><th>Price</th></tr></thead><tbody>
  <?php foreach ($items as $i): ?>
  <tr><td><?= e($i['product_name']) ?></td><td><?= (int)$i['qty'] ?></td><td>৳ <?= number_format((int)$i['price']) ?></td></tr>
  <?php endforeach; ?>
</tbody></table>
<form method="POST" action="<?= url('/admin/orders/' . $order['id'] . '/status') ?>" style="margin-top:20px">
  <label>Change Status
    <select name="status">
      <?php foreach (['pending','confirmed','processing','shipped','delivered','cancelled'] as $s): ?>
      <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
      <?php endforeach; ?>
    </select>
  </label>
  <button type="submit" class="btn-admin">Update Status</button>
</form>
<?php if (Auth::isAdmin() && $order['status'] !== 'cancelled'): ?>
<form method="POST" action="<?= url('/admin/orders/' . $order['id'] . '/cancel') ?>" style="margin-top:10px">
  <button class="btn-admin" style="background:#c62828">Cancel Order</button>
</form>
<?php endif; ?>
