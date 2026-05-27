<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>
<?php require ROOT_PATH . '/resources/views/partials/header.php'; ?>
<div class="page-hero"><div class="container"><h1>Contact Us</h1><p>We're here to help</p></div></div>
<section class="section"><div class="container" style="display:grid;grid-template-columns:1fr 1fr;gap:40px">
  <div class="dash-main">
    <h2 style="margin-top:0">Send Message</h2>
    <form class="admin-form">
      <label>Name<input required style="width:100%;padding:10px;margin-top:6px;border:1px solid var(--border);border-radius:8px"></label>
      <label>Email<input type="email" required style="width:100%;padding:10px;margin-top:6px;border:1px solid var(--border);border-radius:8px"></label>
      <label>Message<textarea rows="4" required style="width:100%;padding:10px;margin-top:6px;border:1px solid var(--border);border-radius:8px"></textarea></label>
      <button type="submit" class="btn-shop-primary" style="padding:12px 24px;border:none;border-radius:8px;color:#fff;cursor:pointer">Send Message</button>
    </form>
  </div>
  <div>
    <h2>Store Info</h2>
    <p>📍 Dhaka, Bangladesh</p>
    <p>📞 <?= e(config('phone')) ?></p>
    <p>✉ <?= e(config('email')) ?></p>
    <p>🕐 Sat–Thu: 10AM – 9PM</p>
    <div style="background:var(--bg);height:200px;border-radius:12px;margin-top:20px;display:flex;align-items:center;justify-content:center;color:var(--text-muted)">Google Map</div>
  </div>
</div></section>
<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
