<footer class="site-footer">
  <div class="container footer-top">
    <div class="footer-brand">
      <a href="<?= url('/') ?>" class="logo"><div class="logo-mark">M</div><div class="logo-name"><strong>MobileHub</strong><small>Best Price in BD</small></div></a>
      <p>Bangladesh's trusted mobile & gadget shop.</p>
    </div>
    <div class="footer-links"><h4>Quick Links</h4><ul>
      <li><a href="<?= url('/about') ?>">About Us</a></li>
      <li><a href="<?= url('/contact') ?>">Contact</a></li>
      <li><a href="<?= url('/faq') ?>">FAQ</a></li>
      <li><a href="<?= url('/products') ?>">All Products</a></li>
    </ul></div>
    <div class="footer-links"><h4>Categories</h4><ul>
      <li><a href="<?= url('/category/phones') ?>">Phones</a></li>
      <li><a href="<?= url('/category/laptops') ?>">Laptops</a></li>
      <li><a href="<?= url('/category/gadgets') ?>">Gadgets</a></li>
    </ul></div>
    <div class="footer-contact"><h4>Contact</h4>
      <p>📞 <a href="tel:+88<?= e(preg_replace('/^0/', '', config('phone'))) ?>"><?= e(config('phone')) ?></a></p>
      <p>✉ <a href="mailto:<?= e(config('email')) ?>"><?= e(config('email')) ?></a></p>
    </div>
  </div>
  <div class="payment-bar"><div class="container"><span>We Accept:</span>
    <div class="payment-icons"><span class="pay">bKash</span><span class="pay">Nagad</span><span class="pay">COD</span></div>
  </div></div>
  <div class="footer-bottom"><div class="container"><p>© 2026 <?= e(config('site_name')) ?> — PHP MVC (XAMPP)</p></div></div>
</footer>
<a href="https://wa.me/<?= e(config('whatsapp')) ?>" class="whatsapp-float" target="_blank" rel="noopener"><span>Order on WhatsApp</span></a>
<div class="overlay" id="cartOverlay"></div>
<aside class="sidebar cart-sidebar" id="cartSidebar">
  <div class="sidebar-head"><h3>Cart</h3><button class="close-btn" id="cartClose">&times;</button></div>
  <div class="sidebar-body" id="cartItems"><p class="empty-msg">Your cart is empty</p></div>
  <div class="sidebar-foot">
    <div class="cart-sum"><span>Subtotal:</span><strong id="cartTotal">৳ 0</strong></div>
    <button class="btn-checkout" id="checkoutBtn">Checkout</button>
    <a href="https://wa.me/<?= e(config('whatsapp')) ?>" class="btn-whatsapp" target="_blank">WhatsApp Order</a>
  </div>
</aside>
<div class="overlay" id="modalOverlay"></div>
<div class="product-modal" id="productModal"><button class="close-btn modal-close" id="modalClose">&times;</button><div class="modal-body" id="modalBody"></div></div>
<div class="toast toast-v2" id="toast"></div>
<nav class="mobile-bottom-nav">
  <a href="<?= url('/') ?>">🏠 Home</a>
  <a href="<?= url('/products') ?>">📦 Shop</a>
  <a href="<?= url('/cart') ?>">🛒 Cart</a>
  <a href="<?= url('/account') ?>">👤 Account</a>
</nav>
<script src="<?= asset('js/main.js') ?>"></script>
</body></html>
