<?php
$title = 'Forgot Password';
$authHeroTitle = 'Reset Password';
$authHeroText = 'Enter your registered email and we will send reset instructions.';
require ROOT_PATH . '/resources/views/partials/auth-layout-start.php';
?>

<div class="auth-card-header">
  <h1>Forgot Password?</h1>
  <p>Enter your email to receive reset instructions</p>
</div>

<?php if ($msg = \App\Core\Session::flash('success')): ?>
  <div class="auth-alert auth-alert-success">✓ <?= e($msg) ?></div>
<?php endif; ?>

<form method="POST" action="<?= url('/forgot-password') ?>" class="auth-form">
  <div class="form-group">
    <label for="email">Email Address</label>
    <div class="auth-input-wrap">
      <span class="input-icon">✉</span>
      <input type="email" id="email" name="email" placeholder="you@example.com" required autofocus>
    </div>
  </div>
  <button type="submit" class="btn-auth-primary">Send Reset Link</button>
</form>

<p class="auth-footer-text" style="margin-top:20px">
  <a href="<?= url('/login') ?>">← Back to Sign In</a>
</p>

<?php require ROOT_PATH . '/resources/views/partials/auth-layout-end.php'; ?>
