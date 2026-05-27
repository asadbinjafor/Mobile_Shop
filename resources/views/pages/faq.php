<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>
<?php require ROOT_PATH . '/resources/views/partials/header.php'; ?>
<div class="page-hero"><div class="container"><h1>FAQ</h1></div></div>
<section class="section"><div class="container content-page">
  <?php
  $faqs = [
    ['Delivery', 'Dhaka তে ১-২ দিন, অন্যান্য area তে ৩-৫ দিন। ৳5000+ order এ free delivery।'],
    ['Warranty', 'সব product official brand warranty সহ আসে।'],
    ['Return', '৭ দিনের মধ্যে unopened product return করা যায়।'],
    ['Payment', 'COD, bKash, Nagad, Visa/Mastercard supported।'],
  ];
  foreach ($faqs as $faq):
  ?>
  <div class="faq-item">
    <button type="button" class="faq-q" onclick="this.parentElement.classList.toggle('open')"><?= e($faq[0]) ?> <span>+</span></button>
    <div class="faq-a"><?= e($faq[1]) ?></div>
  </div>
  <?php endforeach; ?>
</div></section>
<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
