<?php
$title = 'Sign Up';
$authHeroTitle = 'Join MobileHub';
$authHeroText = 'Create a free customer account — shop, track orders, save wishlists, and get exclusive deals.';
require ROOT_PATH . '/resources/views/partials/auth-layout-start.php';
?>

<span class="auth-badge-customer">🛍️ Customer Registration Only</span>

<div class="auth-card-header">
  <h1>Sign Up</h1>
  <p>Create your customer account to start shopping</p>
</div>

<?php if ($msg = \App\Core\Session::flash('error')): ?>
  <div class="auth-alert auth-alert-error">⚠ <?= e($msg) ?></div>
<?php endif; ?>

<form method="POST" action="<?= url('/register') ?>" class="auth-form" id="registerForm" autocomplete="on">
  <input type="hidden" name="role" value="customer">

  <div class="form-group">
    <label for="name">Full Name <span class="required">*</span></label>
    <div class="auth-input-wrap">
      <span class="input-icon">👤</span>
      <input type="text" id="name" name="name" placeholder="Your full name" required minlength="2"
             value="<?= e($_POST['name'] ?? '') ?>">
    </div>
  </div>

  <div class="form-group">
    <label for="email">Email Address <span class="required">*</span></label>
    <div class="auth-input-wrap">
      <span class="input-icon">✉</span>
      <input type="email" id="email" name="email" placeholder="you@example.com" required
             value="<?= e($_POST['email'] ?? '') ?>">
    </div>
  </div>

  <div class="form-group">
    <label for="phone">Mobile Number</label>
    <div class="auth-input-wrap">
      <span class="input-icon">📱</span>
      <input type="tel" id="phone" name="phone" placeholder="01XXXXXXXXX" pattern="01[0-9]{9}"
             value="<?= e($_POST['phone'] ?? '') ?>">
    </div>
    <p class="form-hint">Optional — for delivery updates</p>
  </div>

  <div class="form-group">
    <label for="password">Password <span class="required">*</span></label>
    <div class="auth-input-wrap">
      <span class="input-icon">🔒</span>
      <input type="password" id="password" name="password" placeholder="Minimum 6 characters" required minlength="6">
    </div>
    <div class="auth-password-strength"><span id="pwdStrength"></span></div>
    <p class="form-hint">Use at least 6 characters</p>
  </div>

  <div class="form-group">
    <label for="password_confirm">Confirm Password <span class="required">*</span></label>
    <div class="auth-input-wrap">
      <span class="input-icon">🔒</span>
      <input type="password" id="password_confirm" name="password_confirm" placeholder="Re-enter password" required minlength="6">
    </div>
  </div>

  <div class="auth-form-row" style="margin-bottom:20px">
    <label style="font-size:.82rem;line-height:1.4">
      <input type="checkbox" name="terms" required>
      I agree to the <a href="#" style="color:#2563EB">Terms &amp; Conditions</a>
    </label>
  </div>

  <button type="submit" class="btn-auth-primary">Create Account</button>
</form>

<div class="auth-divider">or</div>

<p class="auth-footer-text">
  Already have an account? <a href="<?= url('/login') ?>">Sign in here</a>
</p>

<a href="<?= url('/') ?>" class="auth-back-shop">← Back to Shop</a>

<script>
(function() {
  const pwd = document.getElementById('password');
  const bar = document.getElementById('pwdStrength');
  const form = document.getElementById('registerForm');
  const confirm = document.getElementById('password_confirm');

  pwd?.addEventListener('input', function() {
    const len = this.value.length;
    bar.style.width = Math.min(100, len * 12) + '%';
    bar.style.background = len >= 8 ? '#22C55E' : len >= 6 ? '#2563EB' : '#e5e7eb';
  });

  form?.addEventListener('submit', function(e) {
    if (pwd.value !== confirm.value) {
      e.preventDefault();
      alert('Password and Confirm Password do not match.');
      confirm.focus();
    }
  });
})();
</script>

<?php require ROOT_PATH . '/resources/views/partials/auth-layout-end.php'; ?>
