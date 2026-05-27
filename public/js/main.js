let cart = JSON.parse(localStorage.getItem("mobilehub_cart") || "[]");
let wishlist = JSON.parse(localStorage.getItem("mobilehub_wishlist") || "[]");
const API_BASE = window.BASE_URL || "";

const $ = (sel) => document.querySelector(sel);
const $$ = (sel) => document.querySelectorAll(sel);

document.addEventListener("DOMContentLoaded", () => {
  initHero();
  initCountdown();
  updateCartUI();
  updateWishUI();
  restoreWishButtons();
  bindEvents();
  initLiveSearch();
});

function bindEvents() {
  $("#cartBtn")?.addEventListener("click", (e) => { e.preventDefault(); openCart(); });
  $("#cartClose")?.addEventListener("click", closeCart);
  $("#cartOverlay")?.addEventListener("click", closeCart);
  $("#modalOverlay")?.addEventListener("click", closeModal);
  $("#modalClose")?.addEventListener("click", closeModal);

  $("#hamburger")?.addEventListener("click", () => {
    $("#mainNav")?.classList.toggle("open");
  });

  $$(".nav-item.has-mega").forEach((item) => {
    item.querySelector(".nav-link")?.addEventListener("click", (e) => {
      if (window.innerWidth <= 992) {
        e.preventDefault();
        item.classList.toggle("open");
      }
    });
  });

  $("#searchInput")?.addEventListener("keypress", (e) => {
    if (e.key === "Enter") {
      // allow native form submit
      $("#searchSuggest")?.classList.remove("open");
    }
  });

  $("#checkoutBtn")?.addEventListener("click", () => {
    if (!cart.length) return toast("Cart is empty!");
    closeCart();
    window.location.href = `${API_BASE}/cart`;
  });

  $("#heroPrev")?.addEventListener("click", () => heroGo(-1));
  $("#heroNext")?.addEventListener("click", () => heroGo(1));

  $$(".carousel-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const target = document.getElementById(btn.dataset.target);
      if (!target) return;
      const amount = 240;
      if (btn.classList.contains("prev")) target.scrollLeft -= amount;
      else target.scrollLeft += amount;
    });
  });

  document.addEventListener("click", (e) => {
    const viewId = e.target.closest("[data-view]")?.dataset?.view;
    if (viewId) {
      e.preventDefault();
      openModal(parseInt(viewId));
      return;
    }

    if (e.target.classList.contains("add-cart-btn") || e.target.closest(".add-cart-btn")) {
      const btn = e.target.closest(".add-cart-btn");
      addToCart(parseInt(btn.dataset.id));
    }

    if (e.target.classList.contains("wish-btn")) {
      toggleWish(parseInt(e.target.dataset.id));
    }

    if (e.target.classList.contains("cart-item-remove")) {
      removeFromCart(parseInt(e.target.dataset.id));
    }

    if (e.target.classList.contains("modal-add")) {
      addToCart(parseInt(e.target.dataset.id));
      closeModal();
    }
  });
}

function formatPrice(n) {
  try {
    return new Intl.NumberFormat("en-BD").format(Number(n || 0));
  } catch {
    return String(n || 0);
  }
}

function getDiscount(price, oldPrice) {
  const p = Number(price || 0);
  const o = Number(oldPrice || 0);
  if (!o || o <= p) return 0;
  return Math.round(((o - p) / o) * 100);
}

const productCache = new Map();
async function getProduct(id) {
  const key = String(id);
  if (productCache.has(key)) return productCache.get(key);
  const res = await fetch(`${API_BASE}/api/products/${encodeURIComponent(key)}`);
  if (!res.ok) throw new Error("Product not found");
  const p = await res.json();
  productCache.set(key, p);
  return p;
}

/* Hero Slider */
let heroIndex = 0;
let heroTimer;

function initHero() {
  const slides = $$(".hero-slide");
  const dotsEl = $("#heroDots");
  if (!slides.length) return;

  slides.forEach((_, i) => {
    const d = document.createElement("button");
    d.className = "hero-dot" + (i === 0 ? " active" : "");
    d.addEventListener("click", () => { heroIndex = i; heroUpdate(); });
    dotsEl?.appendChild(d);
  });

  heroTimer = setInterval(() => heroGo(1), 5000);
  heroUpdate();
}

function heroGo(dir) {
  const slides = $$(".hero-slide");
  heroIndex = (heroIndex + dir + slides.length) % slides.length;
  heroUpdate();
}

function heroUpdate() {
  const slides = $$(".hero-slide");
  const dots = $$(".hero-dot");
  slides.forEach((s, i) => s.classList.toggle("active", i === heroIndex));
  dots.forEach((d, i) => d.classList.toggle("active", i === heroIndex));
}

/* Countdown */
function initCountdown() {
  const h = $("#hours"), m = $("#minutes"), s = $("#seconds");
  if (!h) return;

  function tick() {
    const now = new Date();
    const end = new Date();
    end.setHours(23, 59, 59, 999);
    const diff = Math.max(0, end - now);
    h.textContent = String(Math.floor(diff / 3600000)).padStart(2, "0");
    m.textContent = String(Math.floor((diff % 3600000) / 60000)).padStart(2, "0");
    s.textContent = String(Math.floor((diff % 60000) / 1000)).padStart(2, "0");
  }
  tick();
  setInterval(tick, 1000);
}

/* Cart */
async function addToCart(id) {
  try {
    const p = await getProduct(id);
    const inStock = !!(p.inStock ?? (!p.out_of_stock && (p.stock ?? 0) > 0));
    if (!inStock) return toast("Out of stock");

    const item = cart.find((c) => c.id === id);
    if (item) item.qty++;
    else cart.push({
      id,
      name: p.name,
      price: Number(p.price || 0),
      image: p.image,
      qty: 1,
    });

    saveCart();
    updateCartUI();
    toast(`${p.name} added to cart!`);
  } catch {
    toast("Couldn't add to cart");
  }
}

function removeFromCart(id) {
  cart = cart.filter((c) => c.id !== id);
  saveCart();
  updateCartUI();
}

function saveCart() {
  localStorage.setItem("mobilehub_cart", JSON.stringify(cart));
}

function updateCartUI() {
  const count = cart.reduce((s, i) => s + i.qty, 0);
  const total = cart.reduce((s, i) => s + i.price * i.qty, 0);
  $("#cartCount").textContent = count;
  $("#cartTotal").textContent = "৳ " + formatPrice(total);

  const el = $("#cartItems");
  if (!cart.length) {
    el.innerHTML = '<p class="empty-msg">Your cart is empty</p>';
    return;
  }

  el.innerHTML = cart.map((item) => `
    <div class="cart-item">
      <img src="${item.image}" alt="">
      <div class="cart-item-info">
        <div class="cart-item-name">${item.name}</div>
        <div class="cart-item-price">৳ ${formatPrice(item.price)} × ${item.qty}</div>
      </div>
      <button class="cart-item-remove" data-id="${item.id}">&times;</button>
    </div>
  `).join("");
}

function openCart() {
  $("#cartSidebar")?.classList.add("open");
  $("#cartOverlay")?.classList.add("open");
  document.body.style.overflow = "hidden";
}

function closeCart() {
  $("#cartSidebar")?.classList.remove("open");
  $("#cartOverlay")?.classList.remove("open");
  document.body.style.overflow = "";
}

/* Wishlist */
function toggleWish(id) {
  const idx = wishlist.indexOf(id);
  if (idx >= 0) wishlist.splice(idx, 1);
  else wishlist.push(id);
  localStorage.setItem("mobilehub_wishlist", JSON.stringify(wishlist));
  updateWishUI();
  restoreWishButtons();
  toast(idx >= 0 ? "Removed from wishlist" : "Added to wishlist ♥");
}

function updateWishUI() {
  $("#wishCount").textContent = wishlist.length;
}

function restoreWishButtons() {
  $$(".wish-btn").forEach((btn) => {
    const active = wishlist.includes(parseInt(btn.dataset.id));
    btn.textContent = active ? "♥" : "♡";
    btn.classList.toggle("active", active);
  });
}

/* Modal */
async function openModal(id) {
  try {
    const p = await getProduct(id);
    const oldPrice = Number(p.old_price || 0);
    const disc = getDiscount(p.price, oldPrice);
    const inStock = !!(p.inStock ?? (!p.out_of_stock && (p.stock ?? 0) > 0));

    $("#modalBody").innerHTML = `
      <div class="modal-img"><img src="${p.image}" alt="${p.name}"></div>
      <div class="modal-info">
        <div class="product-brand">${String(p.brand || "").toUpperCase()}</div>
        <h2>${p.name}</h2>
        <div class="price-row">
          <span class="price-now">৳ ${formatPrice(p.price)}</span>
          ${oldPrice ? `<span class="price-was">৳ ${formatPrice(oldPrice)}</span>` : ""}
          ${disc ? `<span class="save-tag">${disc}% OFF</span>` : ""}
        </div>
        <span class="emi-tag">0% EMI | Free Delivery | Official Warranty</span>
        <ul class="modal-features">
          <li>100% Genuine Product</li>
          <li>Official Brand Warranty</li>
          <li>Fast delivery in Bangladesh</li>
          <li>Easy return within 7 days</li>
          <li>Cash on delivery available</li>
        </ul>
        <div class="modal-btns">
          <button class="modal-add" data-id="${p.id}" ${!inStock ? "disabled" : ""}>
            ${!inStock ? "Out of Stock" : "Add to Cart"}
          </button>
          <a class="btn-shop-outline" href="${API_BASE}/products/${p.id}" style="display:inline-flex;align-items:center;justify-content:center;padding:10px 14px">View Details</a>
        </div>
      </div>
    `;
    $("#productModal")?.classList.add("open");
    $("#modalOverlay")?.classList.add("open");
    document.body.style.overflow = "hidden";
  } catch {
    toast("Couldn't open product");
  }
}

function closeModal() {
  $("#productModal")?.classList.remove("open");
  $("#modalOverlay")?.classList.remove("open");
  document.body.style.overflow = "";
}

/* Search & Filter */
let searchTimer;
function initLiveSearch() {
  const input = $("#searchInput");
  const box = $("#searchSuggest");
  if (!input || !box) return;

  input.addEventListener("input", () => {
    clearTimeout(searchTimer);
    const q = input.value.trim();
    if (q.length < 2) {
      box.classList.remove("open");
      box.innerHTML = "";
      return;
    }
    searchTimer = setTimeout(async () => {
      try {
        const res = await fetch(`${API_BASE}/api/search?q=${encodeURIComponent(q)}`);
        const items = await res.json();
        if (!items.length) {
          box.innerHTML = '<div class="search-suggest-empty">No products found</div>';
        } else {
          box.innerHTML = items.map((p) => `
            <a class="search-suggest-item" href="${API_BASE}/products/${p.id}">
              <img src="${p.image}" alt="">
              <div><strong>${p.name}</strong><span>${formatPrice(p.price)}</span></div>
            </a>
          `).join("");
        }
        box.classList.add("open");
      } catch {
        box.classList.remove("open");
      }
    }, 280);
  });

  document.addEventListener("click", (e) => {
    if (!e.target.closest(".search-wrap")) box.classList.remove("open");
  });
}

function handleSearch() {
  // Search results are served by /products?q=...
  const form = document.querySelector(".search-wrap");
  if (form) form.submit();
}

function toast(msg) {
  const t = $("#toast");
  if (!t) return;
  t.textContent = msg;
  t.classList.add("show");
  setTimeout(() => t.classList.remove("show"), 2800);
}
