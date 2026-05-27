const IMG = [
  "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&q=80",
  "https://images.unsplash.com/photo-1592899677977-9c10ca588bbd?w=400&q=80",
  "https://images.unsplash.com/photo-1565849907041-7a02fb6cec28?w=400&q=80",
  "https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=400&q=80",
  "https://images.unsplash.com/photo-1616344563602-ae40e0b0a4c3?w=400&q=80",
  "https://images.unsplash.com/photo-1605236453806-6ff368803a40?w=400&q=80",
  "https://images.unsplash.com/photo-1580910051074-3eb694886505?w=400&q=80",
  "https://images.unsplash.com/photo-1611186871348-b1ce18000c9f?w=400&q=80",
  "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400&q=80",
  "https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=400&q=80"
];

const LABELS = {
  hot: { text: "🔥 Hot Product", cls: "label-hot" },
  top: { text: "🛍️ Top Selling", cls: "label-top" },
  demand: { text: "👍 High Demand", cls: "label-demand" },
  choice: { text: "😍 Customers Choice", cls: "label-choice" },
  popular: { text: "Most Popular", cls: "label-popular" },
  best: { text: "🛍️ Best Selling", cls: "label-top" },
  discount1: { text: "Discount ৳ 1", cls: "label-demand" }
};

const products = [
  { id: 1, name: "iPhone 17 Pro Max", brand: "apple", price: 159990, oldPrice: 214990, image: IMG[7], label: "hot", section: "flash", category: "phones" },
  { id: 2, name: "Samsung Galaxy S26 Ultra 5G", brand: "samsung", price: 123989, oldPrice: 175990, image: IMG[0], label: "hot", section: "flash", category: "phones" },
  { id: 3, name: "Redmi Note 15 5G", brand: "xiaomi", price: 20990, oldPrice: 28390, image: IMG[2], label: "hot", section: "flash", category: "phones" },
  { id: 4, name: "Redmi Note 15 Pro 5G", brand: "xiaomi", price: 31981, oldPrice: 34887, image: IMG[3], label: "top", section: "flash", category: "phones" },
  { id: 5, name: "Redmi Note 15 Pro Plus 5G", brand: "xiaomi", price: 35490, oldPrice: 44390, image: IMG[4], label: "hot", section: "flash", category: "phones" },
  { id: 6, name: "Oppo Find X9 Pro", brand: "oppo", price: 94990, oldPrice: 106666, image: IMG[1], label: "demand", section: "flash", category: "phones" },
  { id: 7, name: "Realme GT 7 Pro", brand: "realme", price: 33989, oldPrice: 41990, image: IMG[5], label: "discount1", section: "flash", category: "phones" },
  { id: 8, name: "OnePlus 15 Pro", brand: "oneplus", price: 95490, oldPrice: 109990, image: IMG[6], label: "top", section: "flash", category: "phones" },
  { id: 9, name: "vivo S50 Pro mini", brand: "vivo", price: 62990, oldPrice: 76990, image: IMG[2], label: "hot", section: "flash", category: "phones" },
  { id: 10, name: "Redmi K90 Pro Max", brand: "xiaomi", price: 72490, oldPrice: 79555, image: IMG[3], label: "hot", section: "flash", category: "phones" },
  { id: 11, name: "iQOO Z10 Turbo Pro", brand: "vivo", price: 39990, oldPrice: 43988, image: IMG[4], label: "top", section: "flash", category: "phones" },
  { id: 12, name: "Samsung Galaxy S25 Ultra 5G", brand: "samsung", price: 106989, oldPrice: 189990, image: IMG[0], label: "discount1", section: "flash", category: "phones" },
  { id: 13, name: "Redmi Note 14 5G", brand: "xiaomi", price: 18712, oldPrice: 31990, image: IMG[2], label: "hot", section: "flash", category: "phones" },
  { id: 14, name: "Redmi Turbo 5 Max", brand: "xiaomi", price: 43490, oldPrice: 64990, image: IMG[3], label: "hot", section: "flash", category: "phones" },
  { id: 15, name: "Oppo Find X9 Ultra", brand: "oppo", price: 136989, oldPrice: 146990, image: IMG[1], label: "discount1", section: "flash", category: "phones" },
  { id: 16, name: "Motorola Edge 50 Pro 5G", brand: "motorola", price: 34990, oldPrice: 44490, image: IMG[5], label: "hot", section: "deals", category: "phones" },
  { id: 17, name: "Vivo S30 Pro Mini", brand: "vivo", price: 54490, oldPrice: 88990, image: IMG[2], label: "demand", section: "deals", category: "phones" },
  { id: 18, name: "Redmi Turbo 4 Pro", brand: "xiaomi", price: 37490, oldPrice: 46990, image: IMG[4], label: "choice", section: "deals", category: "phones" },
  { id: 19, name: "Infinix GT 30 Pro", brand: "infinix", price: 29990, oldPrice: 35990, image: IMG[3], label: "best", section: "deals", category: "phones" },
  { id: 20, name: "Tecno Camon 40 Pro", brand: "tecno", price: 24990, oldPrice: 29990, image: IMG[5], label: "top", section: "deals", category: "phones" },
  { id: 21, name: "Google Pixel 10 Pro", brand: "google", price: 89990, oldPrice: 99990, image: IMG[6], label: "demand", section: "deals", category: "phones" },
  { id: 22, name: "Nothing Phone (3a)", brand: "nothing", price: 42990, oldPrice: 49990, image: IMG[7], label: "popular", section: "deals", category: "phones" },
  { id: 23, name: "Redmi Note 14 Pro 5G", brand: "xiaomi", price: 25290, oldPrice: 41990, image: IMG[2], label: "demand", section: "trending", category: "phones" },
  { id: 24, name: "Redmi Turbo 4 5G", brand: "xiaomi", price: 30490, oldPrice: 45990, image: IMG[3], label: "choice", section: "trending", category: "phones" },
  { id: 25, name: "Motorola Edge 50 Fusion 5G", brand: "motorola", price: 26999, oldPrice: 35990, image: IMG[5], label: "hot", section: "trending", category: "phones" },
  { id: 26, name: "Samsung Galaxy A56 5G", brand: "samsung", price: 44990, oldPrice: 52990, image: IMG[0], label: "top", section: "trending", category: "phones" },
  { id: 27, name: "Oppo Reno 14 Pro", brand: "oppo", price: 54990, oldPrice: 64990, image: IMG[1], label: "popular", section: "trending", category: "phones" },
  { id: 28, name: "Realme 15 Pro Plus", brand: "realme", price: 38990, oldPrice: 44990, image: IMG[4], label: "best", section: "trending", category: "phones" },
  { id: 29, name: "Apple Watch SE 3", brand: "apple", price: 34490, oldPrice: 46490, image: IMG[9], label: "choice", section: "recent", category: "smartwatch" },
  { id: 30, name: "Xiaomi Mibro Watch A2", brand: "xiaomi", price: 2999, oldPrice: 4999, image: IMG[9], label: "choice", section: "recent", category: "smartwatch" },
  { id: 31, name: "Nothing CMF Buds Pro", brand: "nothing", price: 4990, oldPrice: 8990, image: IMG[8], label: "popular", section: "recent", category: "gadgets" },
  { id: 32, name: "Apple 30W USB-C Power Adapter", brand: "apple", price: 4990, oldPrice: 8990, image: IMG[8], label: "top", section: "recent", category: "accessories", outOfStock: true },
  { id: 33, name: "Kieslect Lady Smart Watch Pura", brand: "xiaomi", price: 3499, oldPrice: 7999, image: IMG[9], label: "top", section: "recent", category: "smartwatch" },
  { id: 34, name: "Samsung Galaxy Buds 3 Pro", brand: "samsung", price: 12990, oldPrice: 16990, image: IMG[8], label: "hot", section: "recent", category: "gadgets" },
  { id: 35, name: "Anker 20000mAh Power Bank", brand: "xiaomi", price: 3490, oldPrice: 4990, image: IMG[8], label: "demand", section: "recent", category: "accessories" },
  { id: 36, name: "MacBook Air M4", brand: "apple", price: 134990, oldPrice: 149990, image: IMG[6], label: "hot", section: "recent", category: "laptops" }
];

const brands = [
  { slug: "samsung", name: "Samsung" },
  { slug: "apple", name: "Apple" },
  { slug: "xiaomi", name: "Xiaomi" },
  { slug: "oppo", name: "Oppo" },
  { slug: "vivo", name: "Vivo" },
  { slug: "realme", name: "Realme" },
  { slug: "oneplus", name: "OnePlus" },
  { slug: "infinix", name: "Infinix" },
  { slug: "tecno", name: "Tecno" },
  { slug: "motorola", name: "Motorola" },
  { slug: "google", name: "Google" },
  { slug: "nothing", name: "Nothing" }
];

const categories = [
  { slug: "phones", name: "Phones", icon: "📱" },
  { slug: "tablets", name: "Tablet", icon: "📲" },
  { slug: "laptops", name: "Laptop", icon: "💻" },
  { slug: "smartwatch", name: "Smart Watch", icon: "⌚" },
  { slug: "gadgets", name: "Gadget", icon: "🎧" },
  { slug: "accessories", name: "Accessories", icon: "🔌" },
  { slug: "sounds", name: "Sounds", icon: "🔊" },
  { slug: "smarttv", name: "Smart TV", icon: "📺" }
];

class ProductModel {
  static getAll() {
    return [...products];
  }

  static getById(id) {
    return products.find((p) => p.id === Number(id)) || null;
  }

  static getBySection(section) {
    return products.filter((p) => p.section === section);
  }

  static getByBrand(brand) {
    return products.filter((p) => p.brand === brand.toLowerCase());
  }

  static getByCategory(category) {
    return products.filter((p) => (p.category || "phones") === category.toLowerCase());
  }

  static search(query) {
    const q = query.toLowerCase().trim();
    if (!q) return ProductModel.getAll();
    return products.filter(
      (p) =>
        p.name.toLowerCase().includes(q) ||
        p.brand.toLowerCase().includes(q)
    );
  }

  static getBrands() {
    return brands;
  }

  static getCategories() {
    return categories;
  }
}

module.exports = { ProductModel, LABELS, products };
