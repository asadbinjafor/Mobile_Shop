const { ProductModel } = require("../models/ProductModel");
const { enrichProduct } = require("../helpers/viewHelpers");

class ProductController {
  static index(req, res) {
    const { q, brand } = req.query;
    let list = q ? ProductModel.search(q) : ProductModel.getAll();
    if (brand) list = list.filter((p) => p.brand === brand.toLowerCase());

    res.render("products/index", {
      title: q ? `Search: ${q}` : brand ? `Brand: ${brand}` : "All Products",
      products: list.map(enrichProduct),
      query: q || "",
      brand: brand || "",
      brands: ProductModel.getBrands()
    });
  }

  static show(req, res) {
    const product = ProductModel.getById(req.params.id);
    if (!product) return res.status(404).render("errors/404", { title: "Product Not Found" });

    const related = ProductModel.getByBrand(product.brand)
      .filter((p) => p.id !== product.id)
      .slice(0, 4)
      .map(enrichProduct);

    res.render("products/show", {
      title: product.name,
      product: enrichProduct(product),
      related
    });
  }

  static category(req, res) {
    const { slug } = req.params;
    const cat = ProductModel.getCategories().find((c) => c.slug === slug);
    if (!cat) return res.status(404).render("errors/404", { title: "Category Not Found" });

    res.render("products/category", {
      title: cat.name,
      category: cat,
      products: ProductModel.getByCategory(slug).map(enrichProduct)
    });
  }

  static apiShow(req, res) {
    const product = ProductModel.getById(req.params.id);
    if (!product) return res.status(404).json({ error: "Not found" });
    res.json(enrichProduct(product));
  }
}

module.exports = ProductController;
