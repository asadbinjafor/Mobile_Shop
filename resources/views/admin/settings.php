<h1>System Settings</h1>
<form class="admin-form" method="POST" action="<?= url('/admin/settings') ?>">
  <label>Site Name<input name="setting_site_name" value="<?= e($settings['site_name'] ?? '') ?>"></label>
  <label>Phone<input name="setting_site_phone" value="<?= e($settings['site_phone'] ?? '') ?>"></label>
  <label>Email<input name="setting_site_email" value="<?= e($settings['site_email'] ?? '') ?>"></label>
  <label>Free Delivery Min Order<input name="setting_free_delivery_min" value="<?= e($settings['free_delivery_min'] ?? '') ?>"></label>
  <button type="submit" class="btn-admin">Save Settings</button>
</form>
