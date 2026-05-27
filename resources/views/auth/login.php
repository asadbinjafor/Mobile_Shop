<?php
$title = 'Login';
$authHeroTitle = 'Welcome Back!';
$authHeroText = 'Sign in to shop, track orders, and get exclusive offers.';
require ROOT_PATH . '/resources/views/partials/auth-layout-start.php';
?>

<div class="auth-card-header">
  <h1>Sign In</h1>
  <p>Log in to your account</p>
</div>

<?php if ($msg = \App\Core\Session::flash('error')): ?>
  <div class="auth-alert auth-alert-error">⚠ <?= e($msg) ?></div>
<?php endif; ?>
<?php if ($msg = \App\Core\Session::flash('success')): ?>
  <div class="auth-alert auth-alert-success">✓ <?= e($msg) ?></div>
<?php endif; ?>

<form method="POST" action="<?= url('/login') ?>" class="auth-form" autocomplete="on">
  <div class="form-group">
    <label for="email">Email Address</label>
    <div class="auth-input-wrap">
      <span class="input-icon">✉</span>
      <input type="email" id="email" name="email" placeholder="you@example.com" required autofocus
             value="<?= e($_POST['email'] ?? '') ?>">
    </div>
  </div>

  <div class="form-group">
    <label for="password">Password</label>
    <div class="auth-input-wrap">
      <span class="input-icon">🔒</span>
      <input type="password" id="password" name="password" placeholder="Enter your password" required>
    </div>
  </div>

  <div class="auth-form-row">
    <label><input type="checkbox" name="remember"> Remember me</label>
    <a href="<?= url('/forgot-password') ?>">Forgot password?</a>
  </div>

  <button type="submit" class="btn-auth-primary">Sign In</button>
</form>

<div class="auth-divider">or</div>

<p class="auth-footer-text">
  New customer? <a href="<?= url('/register') ?>">Create a free account</a>
</p>

<a href="<?= url('/') ?>" class="auth-back-shop">← Back to Shop</a>

<div class="auth-staff-note">
  <strong>Admin / Moderator?</strong>
  Staff accounts are created by an administrator only. Registration is for customers only.
</div>

<?php require ROOT_PATH . '/resources/views/partials/auth-layout-end.php'; ?>
