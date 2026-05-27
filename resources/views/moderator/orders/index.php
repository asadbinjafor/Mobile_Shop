<h1>Orders — Update Delivery Status</h1>
<table class="admin-table">
  <thead><tr><th>Order #</th><th>Customer</th><th>Total</th><th>Status</th><th>Update</th></tr></thead>
  <tbody>
    <?php foreach ($orders as $o): ?>
    <tr>
      <td><?= e($o['order_number']) ?></td>
      <td><?= e($o['customer_name']) ?></td>
      <td>৳ <?= number_format((int)$o['total']) ?></td>
      <td><?= e($o['status']) ?></td>
      <td>
        <form method="POST" action="<?= url('/admin/orders/' . $o['id'] . '/status') ?>" style="display:flex;gap:6px">
          <select name="status">
            <?php foreach (['pending','confirmed','processing','shipped','delivered'] as $s): ?>
            <option value="<?= $s ?>" <?= $o['status']===$s?'selected':'' ?>><?= $s ?></option>
            <?php endforeach; ?>
          </select>
          <button class="btn-admin btn-sm">Save</button>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
