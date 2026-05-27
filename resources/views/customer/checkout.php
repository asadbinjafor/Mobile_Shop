<?php
use App\Core\Auth;
require ROOT_PATH . '/resources/views/partials/head.php';
require ROOT_PATH . '/resources/views/partials/header.php';
?>
<div class="page-hero"><div class="container"><h1>Checkout</h1><p>Complete your order</p></div></div>
<section class="section" style="padding-top:0">
  <div class="container cart-layout">
    <div>
      <form method="POST" action="<?= url('/checkout') ?>" id="checkoutForm" class="dash-main" style="border:1px solid var(--border)">
        <input type="hidden" name="cart_json" id="cartJson">
        <h2 style="font-size:1.1rem;margin:0 0 20px">Customer Information</h2>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
          <label style="display:block">Full Name<input name="name" value="<?= e(Auth::user()['name']) ?>" required style="width:100%;margin-top:6px;padding:10px;border:1px solid var(--border);border-radius:8px"></label>
          <label style="display:block">Phone<input name="phone" value="<?= e(Auth::user()['phone'] ?? '') ?>" required style="width:100%;margin-top:6px;padding:10px;border:1px solid var(--border);border-radius:8px"></label>
        </div>
        <label style="display:block;margin:16px 0">Address<textarea name="address" rows="3" required style="width:100%;margin-top:6px;padding:10px;border:1px solid var(--border);border-radius:8px"></textarea></label>
        <label style="display:block;margin-bottom:16px">City<input name="city" value="Dhaka" style="width:100%;margin-top:6px;padding:10px;border:1px solid var(--border);border-radius:8px"></label>

        <h2 style="font-size:1.1rem;margin:24px 0 16px">Delivery</h2>
        <label style="display:block;margin-bottom:8px"><input type="radio" name="delivery" value="home" checked> Home Delivery</label>
        <label style="display:block;margin-bottom:20px"><input type="radio" name="delivery" value="pickup"> Store Pickup</label>

        <h2 style="font-size:1.1rem;margin:0 0 16px">Payment Method</h2>
        <label style="display:block;margin-bottom:8px"><input type="radio" name="payment" value="cod" checked> Cash on Delivery</label>
        <label style="display:block;margin-bottom:8px"><input type="radio" name="payment" value="bkash"> bKash</label>
        <label style="display:block;margin-bottom:8px"><input type="radio" name="payment" value="nagad"> Nagad</label>
        <label style="display:block"><input type="radio" name="payment" value="card"> Card Payment</label>
      </form>
    </div>
    <div class="summary-card">
      <h3>Order Summary</h3>
      <div id="checkoutSummary"><p>Loading...</p></div>
      <button type="submit" form="checkoutForm" class="btn-checkout-full">Place Order</button>
    </div>
  </div>
</section>
<script>
document.getElementById('checkoutForm').addEventListener('submit', function() {
  document.getElementById('cartJson').value = localStorage.getItem('mobilehub_cart') || '[]';
});
const cart = JSON.parse(localStorage.getItem('mobilehub_cart') || '[]');
const total = cart.reduce((s,i) => s + i.price * i.qty, 0);
document.getElementById('checkoutSummary').innerHTML = `
  <div class="summary-row"><span>Items (${cart.length})</span><span>৳ ${total.toLocaleString()}</span></div>
  <div class="summary-row"><span>Delivery</span><span>${total > 5000 ? 'FREE' : '৳ 100'}</span></div>
  <div class="summary-row total"><span>Total</span><span>৳ ${(total + (total > 5000 ? 0 : 100)).toLocaleString()}</span></div>
`;
</script>
<?php require ROOT_PATH . '/resources/views/partials/footer.php'; ?>
