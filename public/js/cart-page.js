const API_BASE = window.BASE_URL || "";

function formatPrice(n) {
  return "৳ " + Number(n).toLocaleString("en-IN");
}

function loadCartPage() {
  const cart = JSON.parse(localStorage.getItem("mobilehub_cart") || "[]");
  const tbody = document.getElementById("cartPageBody");
  if (!cart.length) {
    tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;padding:48px"><p>Your cart is empty</p><a href="' + API_BASE + '/products" class="btn-shop-primary" style="display:inline-block;padding:12px 24px;margin-top:12px;color:#fff;text-decoration:none">Shop Now</a></td></tr>';
    updateSummary(0);
    return;
  }

  tbody.innerHTML = cart.map((item, i) => `
    <tr data-id="${item.id}">
      <td><div class="cart-item-product">
        <img src="${item.image}" alt="">
        <div><strong>${item.name}</strong></div>
      </div></td>
      <td>${formatPrice(item.price)}</td>
      <td>
        <div class="qty-selector" style="margin:0">
          <button type="button" onclick="updateQty(${i},-1)">−</button>
          <input type="number" value="${item.qty}" readonly style="width:40px">
          <button type="button" onclick="updateQty(${i},1)">+</button>
        </div>
      </td>
      <td><strong>${formatPrice(item.price * item.qty)}</strong></td>
      <td><button type="button" onclick="removeItem(${i})" style="background:none;border:none;color:var(--danger);cursor:pointer;font-size:1.2rem">×</button></td>
    </tr>
  `).join("");

  const subtotal = cart.reduce((s, i) => s + i.price * i.qty, 0);
  updateSummary(subtotal);
}

function updateSummary(subtotal) {
  const delivery = subtotal > 5000 ? 0 : (subtotal > 0 ? 100 : 0);
  const discount = 0;
  const grand = subtotal + delivery - discount;
  document.getElementById("sumSubtotal").textContent = formatPrice(subtotal);
  document.getElementById("sumDelivery").textContent = delivery === 0 && subtotal > 0 ? "FREE" : formatPrice(delivery);
  document.getElementById("sumDiscount").textContent = formatPrice(discount);
  document.getElementById("sumGrand").textContent = formatPrice(grand);
}

function updateQty(index, delta) {
  const cart = JSON.parse(localStorage.getItem("mobilehub_cart") || "[]");
  cart[index].qty = Math.min(10, Math.max(1, cart[index].qty + delta));
  localStorage.setItem("mobilehub_cart", JSON.stringify(cart));
  loadCartPage();
  if (typeof updateCartUI === "function") updateCartUI();
}

function removeItem(index) {
  const cart = JSON.parse(localStorage.getItem("mobilehub_cart") || "[]");
  cart.splice(index, 1);
  localStorage.setItem("mobilehub_cart", JSON.stringify(cart));
  loadCartPage();
  if (typeof updateCartUI === "function") updateCartUI();
}

function applyCoupon() {
  const code = document.getElementById("couponCode").value.trim().toUpperCase();
  if (code === "MOBILE10") {
    alert("Coupon applied! 10% discount (demo)");
  } else {
    alert("Invalid coupon code");
  }
}

document.addEventListener("DOMContentLoaded", loadCartPage);
