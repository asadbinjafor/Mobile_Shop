const { ProductModel } = require("../models/ProductModel");

class CartController {
  static page(req, res) {
    res.render("cart/index", { title: "Shopping Cart" });
  }

  static validate(req, res) {
    const { items } = req.body;
    if (!Array.isArray(items)) {
      return res.status(400).json({ error: "Invalid cart data" });
    }

    const validated = items
      .map((item) => {
        const product = ProductModel.getById(item.id);
        if (!product || product.outOfStock) return null;
        return {
          id: product.id,
          name: product.name,
          price: product.price,
          image: product.image,
          qty: Math.min(Math.max(1, item.qty || 1), 10)
        };
      })
      .filter(Boolean);

    const total = validated.reduce((s, i) => s + i.price * i.qty, 0);
    res.json({ items: validated, total });
  }
}

module.exports = CartController;
