<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>
<?php require ROOT_PATH . '/resources/views/partials/header.php'; ?>
<section class="section"><div class="container" style="max-width:600px">
  <h1 class="sec-heading">My Account</h1>
  <?php if ($msg = \App\Core\Session::flash('success')): ?><div class="alert alert-success"><?= e($msg) ?></div><?php endif; ?>
  <form class="admin-form" method="POST" action="<?= url('/account') ?>">
    <label>Name<input name="name" value="<?= e($user['name']) ?>" required></label>
    <label>Email<input value="<?= e($user['email']) ?>" disabled></label>
    <label>Phone<input name="phone" value="<?= e($user['phone'] ?? '') ?>"></label>
    <label>New Password<input type="password" name="password" placeholder="Optional"></label>
    <button type="submit" class="btn-admin">Update Profile</button>
  </form>
  <p style="margin-top:20px"><a href="<?= url('/account/orders') ?>">📦 My Orders</a></p>
</div></section>
<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
