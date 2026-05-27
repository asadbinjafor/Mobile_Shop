<?php require ROOT_PATH . '/resources/views/partials/head.php'; ?>
<?php require ROOT_PATH . '/resources/views/partials/header.php'; ?>

<div class="page-hero">
  <div class="container"><h1>Shopping Cart</h1><p>Review your items before checkout</p></div>
</div>

<section class="section" style="padding-top:0">
  <div class="container cart-layout">
    <div class="cart-table-wrap">
      <table class="cart-table" id="cartPageTable">
        <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th><th></th></tr></thead>
        <tbody id="cartPageBody">
          <tr><td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted)">Loading cart...</td></tr>
        </tbody>
      </table>
    </div>
    <div class="summary-card">
      <h3>Order Summary</h3>
      <div class="summary-row"><span>Subtotal</span><span id="sumSubtotal">৳ 0</span></div>
      <div class="summary-row"><span>Delivery</span><span id="sumDelivery">৳ 100</span></div>
      <div class="summary-row"><span>Discount</span><span id="sumDiscount">৳ 0</span></div>
      <div class="coupon-input">
        <input type="text" id="couponCode" placeholder="Coupon code">
        <button type="button" class="btn-shop-outline" onclick="applyCoupon()">Apply</button>
      </div>
      <div class="summary-row total"><span>Grand Total</span><span id="sumGrand">৳ 0</span></div>
      <a href="<?= url('/checkout') ?>" class="btn-checkout-full" id="checkoutLink" style="display:block;text-align:center;text-decoration:none">Proceed to Checkout</a>
      <a href="<?= url('/products') ?>" style="display:block;text-align:center;margin-top:12px;font-size:.9rem;color:var(--secondary)">← Continue Shopping</a>
    </div>
  </div>
</section>

<script src="<?= asset('js/cart-page.js') ?>"></script>
<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
