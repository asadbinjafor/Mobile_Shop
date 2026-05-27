<h1>Admin Dashboard</h1>
<div class="stats-grid">
  <div class="stat-card"><strong>৳ <?= number_format($orderStats['totalRevenue']) ?></strong><span>Total Revenue</span></div>
  <div class="stat-card"><strong><?= (int)$orderStats['totalOrders'] ?></strong><span>Total Orders</span></div>
  <div class="stat-card"><strong><?= (int)$orderStats['pending'] ?></strong><span>Pending Orders</span></div>
  <div class="stat-card"><strong><?= (int)$productCount ?></strong><span>Products</span></div>
  <div class="stat-card"><strong><?= (int)$userCounts['customer'] ?></strong><span>Customers</span></div>
  <div class="stat-card"><strong><?= (int)$userCounts['moderator'] ?></strong><span>Moderators</span></div>
</div>
<h2 style="font-size:1.1rem;margin-bottom:12px">Monthly Report</h2>
<table class="admin-table">
  <thead><tr><th>Month</th><th>Orders</th><th>Revenue</th></tr></thead>
  <tbody>
    <?php foreach ($orderStats['monthly'] as $m): ?>
    <tr><td><?= e($m['month']) ?></td><td><?= (int)$m['orders'] ?></td><td>৳ <?= number_format((int)$m['revenue']) ?></td></tr>
    <?php endforeach; ?>
    <?php if (empty($orderStats['monthly'])): ?><tr><td colspan="3">No sales data yet</td></tr><?php endif; ?>
  </tbody>
</table>
