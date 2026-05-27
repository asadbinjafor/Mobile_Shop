<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>
<div class="auth-page"><div class="auth-box">
  <h1>Install Database</h1>
  <p style="margin-bottom:20px;color:#666">MySQL database তৈরি হবে এবং demo users + products যোগ হবে।</p>
  <?php if ($msg = \App\Core\Session::flash('error')): ?><div class="alert alert-error"><?= e($msg) ?></div><?php endif; ?>
  <form method="POST" action="<?= url('/install') ?>">
    <button type="submit" class="btn-admin" style="width:100%">Install Now</button>
  </form>
  <p style="margin-top:12px;font-size:.85rem">XAMPP MySQL চালু আছে কিনা নিশ্চিত করুন।</p>
</div></div>
<?php require ROOT_PATH . '/resources/views/partials/footer-min.php'; ?>
